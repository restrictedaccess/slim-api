<?php

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;



$settings = require BASE_DIR . '/../src/settings.php';

$cta_tracker_resource = new \RemoteStaff\Mongo\Resources\CTATrackerResource();




$app->options("/cta-tracker/save", function(Request $request, Response $response, $args) use ($settings) {});
$app->post("/cta-tracker/save", function(Request $request, Response $response, $args) use ($settings ,$cta_tracker_resource) {
    $rootDomain = $request->getHeader('HTTP_REFERER');
    $validDomains = $settings["settings"]["valid_domains"];

    if(in_array($rootDomain[0], $validDomains)){
        $config = $settings["settings"];
        $request = json_decode(file_get_contents('php://input'), true);
        if (!$request) {
            $request = $_REQUEST;
        }
        $result = array();
        $result["success"] = false;
        $result["result"] = array();
        $result = $cta_tracker_resource->save($request);
        echo json_encode($result);
    } else {
        echo json_encode(array("success" => false, "error_msg" => "Request not authorized"));
    }



});