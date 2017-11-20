<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

// use RemoteStaff\Entities\Personal;
use RemoteStaff\Resources\CandidateResource;
use RemoteStaff\Resources\AdminResource;

$settings = require BASE_DIR . '/../src/settings.php';
$candidate_resource = new CandidateResource();
$admin_resource = new AdminResource();

$app->options("/candidates/addSkill", function(Request $request, Response $response, $args) use ($settings) {});

$app->post("/candidates/addSkill", function(Request $request, Response $response, $args) use ($settings, $candidate_resource, $admin_resource){
    $config = $settings["settings"];

    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    
    if(isset($request)){
        $admin_resource->setEntityManager($candidate_resource->getEntityManager());//look up
        $candidate = $candidate_resource->get($request['userid']);
        $admin = $admin_resource->get($request['adminid']);

        $response = $candidate_resource->addSkill($candidate, $admin, $request);

        echo json_encode(["success"=>true , "result"=>$response]);//return to angular
    } else {
        echo json_encode(array("success"=>false, "msg" => "Unable to add Skills!"));
    }
  
    // $worker = new \RemoteStaff\Workers\IndexCandidates();
    // $worker->sync(["candidate_id"=>$request['userid']]);
    // echo json_encode(["success"=>true , "result"=>$response]);//return to angular
});

$app->options("/candidates/getSkills/", function(Request $request, Response $response, $args) use ($settings) {});
$app->post("/candidates/getSkills", function (Request $request, Response $response, $args) use ($settings, $candidate_resource) {

    $request = $_REQUEST;

    if (isset($request)) {
        $requestRaw = json_decode(file_get_contents('php://input'), true);
        $response = $candidate_resource->getCandidateSkills($requestRaw);

        echo json_encode(["success"=>true , "result"=>$response]);
    } else {
        echo json_encode(array("success" => false, "msg" => "Unable to move to inactive."));
    }
});



//$app->get("/candidates/getSkills/", function(Request $request, Response $response, $args) use ($settings, $candidate_resource){
//    $config = $settings["settings"];
//
//    $request = json_decode(file_get_contents('php://input'), true);
//    if (!$request) {
//        $request = $_REQUEST;
//    }
//
//    // $candidate = $candidate_resource->get($request['userid']);
//    // $skills = $candidate->getSkills();
//
//    // $worker = new \RemoteStaff\Workers\IndexCandidates();
//    // $worker->sync(["candidate_id"=>$request['userid']]);
//    // echo json_encode(["success"=>true]);
//
//    if(isset($request)){
//        $candidate = $candidate_resource->get($request['userid']);
//        $skills = $candidate->getSkills();
//
//        echo json_encode(array("success"=>true,"data"=>$skills));
//    } else {
//        echo json_encode(array("success"=>false, "msg" => "Unable to get Skills!"));
//    }
//});

$app->options("/candidates/deleteSkill/", function(Request $request, Response $response, $args) use ($settings) {});
$app->post("/candidates/deleteSkill", function (Request $request, Response $response, $args) use ($settings, $candidate_resource) {

    $request = $_REQUEST;

    if (isset($request)) {
        $requestRaw = json_decode(file_get_contents('php://input'), true);
        $candidate_resource->deleteSkill($requestRaw);

        echo json_encode(array("success"=>true, "params"=>$requestRaw));

    } else {
        echo json_encode(array("success" => false, "msg" => "Unable to move to inactive."));
    }
});