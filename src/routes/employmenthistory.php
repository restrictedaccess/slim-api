<?php

/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/22/2016
 * Time: 1:09 PM
 */

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Resources\EmploymentHistoryResource;


$settings = require BASE_DIR . '/../src/settings.php';

$app->options("/candidates/employmenthistory", function (Request $request, Response $response, $args) use ($settings) {
});

$app->post("/candidates/employmenthistory", function (Request $request, Response $response, $args) use ($settings) {

    $request = $_REQUEST;

    if (isset($request)) {
        $requestRaw = json_decode(file_get_contents('php://input'), true);
        $employmentHistory = new EmploymentHistoryResource();
        $employmentHistory->create($requestRaw);

        echo json_encode(array("success"=>true, "params"=>$requestRaw));

    } else {
        echo json_encode(array("success" => false, "msg" => "Unable to move to inactive."));
    }
});

$app->options("/candidates/getemploymenthistory", function (Request $request, Response $response, $args) use ($settings) {});

$app->post("/candidates/getemploymenthistory", function (Request $request, Response $response, $args) use ($settings) {

    $request = $_REQUEST;

    if (isset($request)) {
        $requestRaw = json_decode(file_get_contents('php://input'), true);
        $employmentHistory = new EmploymentHistoryResource();
        $data = $employmentHistory->getEmploymentHistory($requestRaw);
        echo json_encode(array("success"=>true, "data"=>$data));

    } else {
        echo json_encode(array("success" => false, "msg" => "Unable to move to inactive."));
    }
});