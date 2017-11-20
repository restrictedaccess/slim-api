<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Mongo\Resources\ProductPriceResource;
use RemoteStaff\Resources\CategorizedResource;
use RemoteStaff\Resources\AdminResource;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;




$settings = require BASE_DIR . '/../src/settings.php';


$language_resource = new \RemoteStaff\Resources\LanguageResource();
$candidate_resource = new \RemoteStaff\Resources\CandidateResource();
$admin_resource = new AdminResource();


$app->get("/languages/fetch", function(Request $request, Response $response, $args) use ($settings,$language_resource, $candidate_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $candidate_resource->setEntityManager($language_resource->getEntityManager());


    $request["candidate"] = json_decode($request["candidate"], true);

    $candidate = $candidate_resource->get($request["candidate"]["id"]);


    $languages = $language_resource->fetchAllLanguage($candidate);

    foreach ($languages as $language) {
        $result["languages"][] = $language->toArray();
    }

    $result["success"] = true;



    echo json_encode($result);
});



$app->options("/languages/save/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/languages/save/", function(Request $request, Response $response, $args) use ($settings,$language_resource, $candidate_resource, $admin_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $candidate_resource->setEntityManager($language_resource->getEntityManager());

    $admin_resource->setEntityManager($language_resource->getEntityManager());


    $request["candidate"] = json_decode($request["candidate"], true);
    $request["recruiter"] = json_decode($request["recruiter"], true);

    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $recruiter = $admin_resource->get($request["recruiter"]["id"]);


    $result = $language_resource->saveLanguage($candidate, $recruiter, $request);



    echo json_encode($result);

});





$app->options("/languages/remove/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/languages/remove/", function(Request $request, Response $response, $args) use ($settings,$language_resource, $candidate_resource, $admin_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $candidate_resource->setEntityManager($language_resource->getEntityManager());

    $admin_resource->setEntityManager($language_resource->getEntityManager());


    $request["candidate"] = json_decode($request["candidate"], true);
    $request["recruiter"] = json_decode($request["recruiter"], true);

    $candidate = $candidate_resource->get($request["candidate"]["id"]);

    $recruiter = $admin_resource->get($request["recruiter"]["id"]);


    $result = $language_resource->removeLanguage($candidate, $recruiter, $request);



    echo json_encode($result);

});