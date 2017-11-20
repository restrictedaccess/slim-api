<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\EmployeeCurrentProfile;
use RemoteStaff\Resources\ApplicantFileResource;
use RemoteStaff\Solr\Resources\CandidatesResource as SolrCandidateResource;
use RemoteStaff\Solr\Resources\UnprocessedCandidatesResource;
use RemoteStaff\Solr\Resources\RemoteReadyCandidatesResource;
use RemoteStaff\Solr\Resources\PrescreenedCandidatesResource;
use RemoteStaff\Solr\Resources\CategorizeCandidatesResource;
use RemoteStaff\Solr\Resources\InactiveCandidatesResource;
use RemoteStaff\Mongo\Resources\ProductPriceResource;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;


$settings = require BASE_DIR . '/../src/settings.php';


$candidate_resource = new SolrCandidateResource();
$unprocessed_candidates_resource = new UnprocessedCandidatesResource();
$remote_ready_candidates_resource = new RemoteReadyCandidatesResource();
$prescreened_candidates_resource = new PrescreenedCandidatesResource();
$categorized_candidates_resource = new CategorizeCandidatesResource();
$inactive_candidates_resource = new InactiveCandidatesResource();

$filter_default_resource = new ProductPriceResource();


$app->options("/candidates/unprocessed/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/unprocessed/", function(Request $request, Response $response, $args) use ($settings,$unprocessed_candidates_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $unprocessed_candidates_resource->getCandidates($request);
    echo json_encode($result);
});



$app->options("/candidates/remote_ready/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/remote_ready/", function(Request $request, Response $response, $args) use ($settings,$remote_ready_candidates_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $remote_ready_candidates_resource->getCandidates($request);
    echo json_encode($result);
});


$app->options("/candidates/prescreened/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/prescreened/", function(Request $request, Response $response, $args) use ($settings,$prescreened_candidates_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $prescreened_candidates_resource->getCandidates($request);
    echo json_encode($result);
});


$app->options("/candidates/categorized/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/categorized/", function(Request $request, Response $response, $args) use ($settings,$categorized_candidates_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $categorized_candidates_resource->getCandidates($request);
    echo json_encode($result);
});



$app->options("/candidates/inactive/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/inactive/", function(Request $request, Response $response, $args) use ($settings,$inactive_candidates_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $inactive_candidates_resource->getCandidates($request);
    echo json_encode($result);
});




$app->options("/candidates/fetch_categories/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/fetch_categories/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $candidate_resource->getCategoriesCandidates($request);
    echo json_encode($result);
});



$app->options("/candidates/fetch_staff_rate/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/fetch_staff_rate/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $candidate_resource->getStaffRateCandidates($request);
    echo json_encode($result);
});




$app->options("/candidates/fetch_staff_time_zone/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/fetch_staff_time_zone/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $candidate_resource->getStaffTimeZoneCandidates($request);
    echo json_encode($result);
});



$app->options("/candidates/get_skype_ids/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/get_skype_ids/", function(Request $request, Response $response, $args) use ($settings,$candidate_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = $candidate_resource->getSkypeIds($request);
    echo json_encode($result);
});







