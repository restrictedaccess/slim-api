<?php

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\EmployeeCurrentProfile;
use RemoteStaff\Resources\ApplicantFileResource;
use RemoteStaff\Solr\Resources\CandidatesResource as SolrCandidateResource;
use RemoteStaff\Resources\PrescreenedResource;
use RemoteStaff\Workers\IndexCandidates;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;


$settings = require BASE_DIR . '/../src/settings.php';


$progress_resource = new IndexCandidates();
$prescreened_resource = new PrescreenedResource();

$app->options("/candidates/move_to_prescreened/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/move_to_prescreened/", function(Request $request, Response $response, $args) use ($settings,$progress_resource, $prescreened_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $prescreened_resource->moveToPrescreened($request);

    $progress_resource->init();
    $result = $progress_resource->sync($request);

    echo json_encode(array("success" => true, "result" => $result));
});


$app->options("/candidates/add_no_show/", function(Request $request, Response $response, $args) use ($settings) {

});


$app->post("/candidates/add_no_show/", function(Request $request, Response $response, $args) use ($settings, $prescreened_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }


    $result = $prescreened_resource->addNoShow($request);


    echo json_encode(array("success" => true, "result" => $result));
});