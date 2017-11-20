<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/7/2016
 * Time: 4:20 PM
 */
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Resources\AvailabilityResource;


$settings = require BASE_DIR . '/../src/settings.php';

$app->options("/candidates/addavailability", function (Request $request, Response $response, $args) use ($settings) {
});

$app->post("/candidates/addavailability", function (Request $request, Response $response, $args) use ($settings) {

    $request = $_REQUEST;

    if (isset($request)) {
        $requestRaw = json_decode(file_get_contents('php://input'), true);

        $availability = new AvailabilityResource();
        $response = $availability->create($requestRaw);

        echo json_encode(array("success"=>true, "params"=>$requestRaw));

    } else {
        echo json_encode(array("success" => false, "msg" => "Unable to move to inactive."));
    }
});

$app->options("/candidates/loadevaluation", function (Request $request, Response $response, $args) use ($settings) {
});

$app->post("/candidates/loadevaluation", function (Request $request, Response $response, $args) use ($settings) {

    $request = $_REQUEST;

    if (isset($request)) {
        $requestRaw = json_decode(file_get_contents('php://input'), true);
        $evaluation = new AvailabilityResource();
        $data = $evaluation->getEvaluation($requestRaw);

        echo json_encode(array("success"=>true, "params"=>$requestRaw, "data" => $data));

    } else {
        echo json_encode(array("success" => false, "msg" => "Unable to move to inactive."));
    }
});