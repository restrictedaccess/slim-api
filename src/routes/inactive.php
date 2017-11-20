<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 8/23/2016
 * Time: 10:28 AM
 */
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Resources\InactiveStaffResource;
use RemoteStaff\Workers\IndexCandidates;

$settings = require BASE_DIR . '/../src/settings.php';

$inactive_staff_resource = new InactiveStaffResource();

$app->options("/candidates/addinactivestaff", function(Request $request, Response $response, $args) use ($settings) {});

$app->post("/candidates/addinactivestaff", function(Request $request, Response $response, $args) use ($settings, $inactive_staff_resource){

    $request = $_REQUEST;

    if(isset($request)){
        $requestRaw = json_decode(file_get_contents('php://input'), true);

        $requestRaw["candidate_id"] = $requestRaw["userid"];

        $inactive_staff_resource->create($requestRaw);
        $progress_resource = new IndexCandidates();
        $progress_resource->init();
        $result_sync = $progress_resource->sync($requestRaw);
        $requestRaw["sync"] = $result_sync;

        echo json_encode(array("success"=>true, "params"=>$requestRaw));
    } else {
        echo json_encode(array("success"=>false, "msg" => "Unable to move to inactive."));
    }

});
