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
use RemoteStaff\Resources\CategorizedResource;




$settings = require BASE_DIR . '/../src/settings.php';


$categorized_resource = new CategorizedResource();
$progress_resource = new IndexCandidates();



$app->options("/candidates/proceed_to_step_three/", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/candidates/proceed_to_step_three/", function(Request $request, Response $response, $args) use ($settings,$progress_resource,$categorized_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }


    try{
        $result = [];

        $result["actual_result"] = $categorized_resource->proceedToStepThree($request);

        $progress_resource->init();
        $result["sync_result"] = $progress_resource->sync($request);

        $errors = [];
        
        if(!$result["actual_result"]["success"]){
            foreach ($result["actual_result"]["result"] as $item) {
                $errors[] = $item["error"];
                break;
            }
        }


        echo json_encode(array("success" => $result["actual_result"]["success"], "result" => $result, "errors" => [$errors[0]]));


    } catch (Exception $e){
        echo json_encode(array("success" => false, "errors" => [$e->getMessage()]));
    }

});



