<?php

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\EmployeeCurrentProfile;
use RemoteStaff\Resources\CandidateResource;
use RemoteStaff\Resources\ApplicantFileResource;
use RemoteStaff\Resources\ApplicationHistoryResource;
use RemoteStaff\Resources\AdminResource;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;
use Valitron\Validator;

$settings = require BASE_DIR . '/../src/settings.php';
$candidate_resource = new CandidateResource();
$applicants_file_resource = new ApplicantFileResource();
$call_notes_resource = new ApplicationHistoryResource();
$admin_resource = new AdminResource();

$app->options("/candidates/sync", function(Request $request, Response $response, $args) use ($settings) {

});

$app->get("/candidates/sync", function(Request $request, Response $response, $args) use ($settings){
    $config = $settings["settings"];

    $worker = new \RemoteStaff\Workers\IndexCandidates();
    $worker->sync(["candidate_id"=>$_REQUEST["id"]]);
    echo json_encode(["success"=>true]);
});




$app->get("/candidates/sync-all", function(Request $request, Response $response, $args) use ($settings){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    if(isset($request["sync_all"])){

        $queue = new Pheanstalk($config['beanstalkd']['host'] . ":" . $config['beanstalkd']['port']);
        $job = array("action" => "syncAll");

        $queue->useTube('candidates_progress')->put(json_encode($job));
        echo json_encode(["success"=>true]);
    } else{
        $worker = new \RemoteStaff\Workers\IndexCandidates();
        $worker->syncAll();
        echo json_encode(["success"=>false, "error" => "sync_all is required."]);
    }


});


$app->options("/candidates/check_recruiter_assigned/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/check_recruiter_assigned/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource) {
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $has_recruiter = false;
    $recruiter = $candidate_resource->hasRecruiter($request["candidate_id"]);

    if($recruiter !== null){
        $has_recruiter = true;
    }

    echo json_encode(array("has_recruiter" => $has_recruiter, "recruiter" => $recruiter));

});



$app->options("/candidates/assign/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/assign/", function(Request $request, Response $response, $args) use ($settings, $candidate_resource, $applicants_file_resource, $admin_resource) {
    $candidateRaw = json_decode(file_get_contents('php://input'), true);
    $candidate = $candidate_resource->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($candidateRaw["id"]);
    $recruiter = $candidate_resource->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($candidateRaw["recruiter"]["id"]);
    if (isset($candidateRaw["admin"]["id"])){
        $admin = $candidate_resource->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($candidateRaw["admin"]["id"]);
    }else{
        $admin = $recruiter;
    }

    $recruiterStaff = $candidate_resource->assignRecruiter($candidate, $recruiter);

    $candidate_resource->getEntityManager()->persist($recruiterStaff);
    $candidate_resource->getEntityManager()->persist($candidate);
    $candidate_resource->getEntityManager()->persist($recruiter);

    $historyChanges = "Candidate has been assigned to Recruiter ".$recruiter->getName();
    $history = $candidate_resource->createStaffHistory($candidate, $admin, $historyChanges);
    $candidate_resource->getEntityManager()->persist($history);
    $candidate_resource->getEntityManager()->flush();


    $worker = new \RemoteStaff\Workers\IndexCandidates();
    $worker->sync(["candidate_id"=>$candidate->getId()]);
    echo json_encode(["success"=>true]);

});
$app->options("/candidates/save-personal-information/", function(Request $request, Response $response, $args) use ($settings, $candidate_resource) {

});

$app->post("/candidates/save-personal-information/", function(Request $request, Response $response, $args) use ($settings, $candidate_resource) {
    $candidateRaw = json_decode(file_get_contents('php://input'), true);
    $candidate = $candidate_resource->get($candidateRaw["id"]);
    $candidate_resource->updatePersonalInformationFromStep3($candidate, $candidateRaw);
    $candidate_resource->getEntityManager()->persist($candidate);
    $candidate_resource->getEntityManager()->flush();
    echo json_encode(["success"=>true]);
});






$app->options("/candidates/save/", function(Request $request, Response $response, $args) use ($settings) {

});


$app->post("/candidates/save/", function(Request $request, Response $response, $args) use ($settings, $candidate_resource, $applicants_file_resource) {


    $request = $_REQUEST;
    if (isset($request["candidate"])){
        $candidateRaw = json_decode($_REQUEST["candidate"], true);
    }else{
        $candidateRaw = json_decode(file_get_contents('php://input'), true);
    }
    $v = new Valitron\Validator($candidateRaw);
    $v->rule('required', ['first_name', 'last_name', "email", "latest_job_title", "mobile"]);
    $v->rule('email', 'email');
    $v->rule("regex", ['first_name', 'last_name'], '/^[\w\-\s]+$/');
    if(!$v->validate()) {
        // Errors
        $errors = $v->errors();
        $errorList = [];
        foreach($errors as $key=>$error){
            foreach($error as $errorItem){
                $errorList[] = $errorItem;
            }
        }
        echo json_encode(["success"=>false, "errors"=>$errorList]);
        return;
    }

    $candidate = $candidate_resource->create($candidateRaw);
    $files_uploaded = null;
    if (!empty($_FILES)){
        $files_uploaded = $applicants_file_resource->attachResume($candidate->getId(), $_FILES, $settings["settings"]["files_dir"]);
    } else{
        $files_uploaded = $_FILES;
    }
    $worker = new \RemoteStaff\Workers\IndexCandidates();
    $worker->sync(["candidate_id"=>$candidate->getId()]);
    $candidate_resource->getEntityManager()->refresh($candidate);

    $recruiterStaff = $candidate->getRecruiterStaff();
    /**
     * @var  \RemoteStaff\Entities\Admin $admin
     */
    $admin = null;
    foreach($recruiterStaff as $key=>$staff){
        /**
         * @var  \RemoteStaff\Entities\RecruiterStaff $staff
         */
        $admin = $staff->getRecruiter();
        break;
    }
    $email = $this->renderer->fetch('emails/welcome.phtml', [
        "jobseeker_name"=>$candidate->getName(),
        "email"=>$candidate->getEmail(),
        "password"=>$candidate->getGeneratedPassword(),
        "signature_template"=>$admin->getSignatureTemplate()
    ]);


    $recipients = array();
    if (in_array($settings["settings"]["env"], ["dev", "staging"])){
        $recipients = array('devs@remotestaff.com.au');
    }else{
        $recipients = array($candidate->getEmail());
    }
    $mgClient = new Mailgun($settings["settings"]["mailgun"]["api_key"]);
    $domain = $settings["settings"]["mailgun"]["domain"];

    $result = $mgClient->sendMessage($domain, array(
        'from'    => 'Remote Staff <recruitment@remotestaff.com.au>',
        'to'      => $recipients,
        'subject' => 'Please complete your Remotestaff resume',
        'html'    => $email
    ));

    echo json_encode(["success"=>true, "files_uploaded" => $files_uploaded, "candidate_id" => $candidate->getId()]);
});