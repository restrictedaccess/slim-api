<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/26/2016
 * Time: 8:07 PM
 */
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Resources\CandidateResource;

$settings = require BASE_DIR . '/../src/settings.php';
$candidate_resource = new CandidateResource();

$app->options("/candidates/getTestTaken", function(Request $request, Response $response, $args) use ($settings) {});
$app->post("/candidates/getTestTaken", function (Request $request, Response $response, $args) use ($settings, $candidate_resource) {

    $request = $_REQUEST;

    if (isset($request)) {
        $requestRaw = json_decode(file_get_contents('php://input'), true);
        $response = $candidate_resource->getTestTaken($requestRaw);
        echo json_encode(["success"=>true , "result"=>$response]);
    } else {
        echo json_encode(array("success" => false, "msg" => "Unable to move to inactive."));
    }
});