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



$settings = require BASE_DIR . '/../src/settings.php';

$education_attainment_resource = new \RemoteStaff\Resources\EducationAttainmentResource();


$candidate_resource = new CandidateResource();
$admin_resource = new AdminResource();


$app->options("/candidates/get-education/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/get-education/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource, $admin_resource, $education_attainment_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $success = false;

    if(empty($request["candidate"])){
        throw new \Exception("candidate is required!");
    }

    $request["candidate"] = json_decode($request["candidate"], true);

    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $education = [];

    if(!empty($candidate->getEducation())){
        $education = $candidate->getEducation()->toArray();
        $success = true;
    }


    $result = [
        "success" => $success,
        "education" => $education
    ];

    echo json_encode($result);
});




$app->options("/candidates/update-education/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/update-education/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource, $admin_resource, $education_attainment_resource){
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



    $request["candidate"] = json_decode($request["candidate"], true);

    $request["recruiter"] = json_decode($request["recruiter"], true);



    $admin_resource->setEntityManager($candidate_resource->getEntityManager());


    $education_attainment_resource->setEntityManager($candidate_resource->getEntityManager());

    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $recruiter = $admin_resource->get($request["recruiter"]["id"]);



    $result = $education_attainment_resource->updatedEducationAttainment($candidate, $recruiter, $request["candidate"]["education"]);

    if($result["success"]){
        $worker = new \RemoteStaff\Workers\IndexCandidates();
        $worker->sync(["candidate_id"=>$candidate->getId()]);
        $candidate_resource->getEntityManager()->refresh($candidate);
    }

    echo json_encode($result);
});
