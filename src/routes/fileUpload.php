<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Mongo\Resources\ProductPriceResource;
use RemoteStaff\Resources\CategorizedResource;
use RemoteStaff\Resources\CandidateResource;
use RemoteStaff\Resources\AdminResource;
use RemoteStaff\Resources\ApplicantFileResource;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;
use Doctrine\Common\Collections\Criteria;



$settings = require BASE_DIR . '/../src/settings.php';


$applicant_files_resource = new ApplicantFileResource();


$candidate_resource = new CandidateResource();
$admin_resource = new AdminResource();



$app->options("/candidates/upload-image/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/upload-image/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource, $admin_resource, $applicant_files_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    if(empty($request["candidate"])){
        throw new \Exception("candidate is required!");
    }

    if(empty($request["recruiter"])){
        throw new \Exception("recruiter is required!");
    }


    if(!isset($_FILES["uploadImage"]["name"])){
        throw new \Exception("No image uploaded.");
    }

    $request["candidate"] = json_decode($request["candidate"], true);

    $request["recruiter"] = json_decode($request["recruiter"], true);



    $admin_resource->setEntityManager($candidate_resource->getEntityManager());

    $applicant_files_resource->setEntityManager($candidate_resource->getEntityManager());


    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $recruiter = $admin_resource->get($request["recruiter"]["id"]);

    $result = $applicant_files_resource->uploadImage($candidate, $recruiter, $request, $_FILES, $settings["settings"]["uploads_dir"]);

    if($result["success"]){
        $worker = new \RemoteStaff\Workers\IndexCandidates();
        $worker->sync(["candidate_id"=>$candidate->getId()]);
        $candidate_resource->getEntityManager()->refresh($candidate);
    }

    echo json_encode($result);
});




$app->options("/candidates/upload-voice/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/upload-voice/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource, $admin_resource, $applicant_files_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }


    if(empty($request["candidate"])){
        throw new \Exception("candidate is required!");
    }

    if(empty($request["recruiter"])){
        throw new \Exception("recruiter is required!");
    }


    if(!isset($_FILES["uploadVoice"]["name"])){
        throw new \Exception("No voice uploaded.");
    }

    $request["candidate"] = json_decode($request["candidate"], true);

    $request["recruiter"] = json_decode($request["recruiter"], true);



    $admin_resource->setEntityManager($candidate_resource->getEntityManager());

    $applicant_files_resource->setEntityManager($candidate_resource->getEntityManager());


    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $recruiter = $admin_resource->get($request["recruiter"]["id"]);

    $result = $applicant_files_resource->uploadVoice($candidate, $recruiter, $request, $_FILES, $settings["settings"]["uploads_dir"]);

    if($result["success"]){
        $worker = new \RemoteStaff\Workers\IndexCandidates();
        $worker->sync(["candidate_id"=>$candidate->getId()]);
        $candidate_resource->getEntityManager()->refresh($candidate);
    }

    echo json_encode($result);
});



$app->options("/candidates/upload-sample-work/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/upload-sample-work/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource, $admin_resource, $applicant_files_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }



    if(empty($request["candidate"])){
        throw new \Exception("candidate is required!");
    }

    if(empty($request["recruiter"])){
        throw new \Exception("recruiter is required!");
    }


    if(!isset($_FILES["uploadFile"])){
        throw new \Exception("No files uploaded.");
    }

    $request["candidate"] = json_decode($request["candidate"], true);

    $request["recruiter"] = json_decode($request["recruiter"], true);



    $admin_resource->setEntityManager($candidate_resource->getEntityManager());

    $applicant_files_resource->setEntityManager($candidate_resource->getEntityManager());


    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $recruiter = $admin_resource->get($request["recruiter"]["id"]);

    $result = $applicant_files_resource->uploadSampleWork($candidate, $recruiter, $request, $_FILES, $settings["settings"]["files_dir"]);

    if($result["success"]){
        $worker = new \RemoteStaff\Workers\IndexCandidates();
        $worker->sync(["candidate_id"=>$candidate->getId()]);
        $candidate_resource->getEntityManager()->refresh($candidate);
    }

    echo json_encode($result);
});




$app->get("/candidates/fetch-applicant-files", function(Request $request, Response $response, $args) use ($settings,$applicant_files_resource, $candidate_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $request["candidate"] = json_decode($request["candidate"], true);


    $result = array();

    $result["success"] = false;

    $result["result"] = array();

    $result["result"]["applicant_files"] = array();


    //$applicant_files_resource->setEntityManager($candidate_resource->getEntityManager());

    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $criteria = Criteria::create()
        ->where(Criteria::expr()->in("fileDescription", [
            "SAMPLE WORK",
            "RESUME",
            "OTHER",
            "MOCK CALLS",
            "CHARACTER REFERENCE",
            "HOME OFFICE PHOTO"
        ]));


    $applicant_files = $candidate->getApplicantFiles()->matching(
        $criteria
    );

    foreach ($applicant_files as $applicant_file) {
        $result["result"]["applicant_files"][] = $applicant_file->toArray();
        $result["success"] = true;
    }


    echo json_encode($result);
});



