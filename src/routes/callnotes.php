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
use RemoteStaff\Resources\ApplicationHistoryResource;

$settings = require BASE_DIR . '/../src/settings.php';
$call_notes_resource = new ApplicationHistoryResource();

$app->post("/candidates/addcallnote", function(Request $request, Response $response, $args) use ($settings, $call_notes_resource){
    $request = $_REQUEST;
    if(isset($request)){
      $requestRaw = json_decode(file_get_contents('php://input'), true);

        $call_notes_resource->create($requestRaw);
        echo json_encode(array("success"=>true, "params"=>$requestRaw));
    } else {
        echo json_encode(array("success"=>false, "msg" => "Unable to save call note."));
    }
});

$app->options("/candidates/addcallnote", function(Request $request, Response $response, $args) use ($settings) {});

$app->get("/candidates/getnotes", function(Request $request, Response $response, $args) use ($settings, $call_notes_resource){
    $request = $_REQUEST;

   if(isset($request)){

       $data = $call_notes_resource->getFilteredNotes($request);

       if(count($data) > 0){
           echo json_encode(array("success"=>true, "data" => $data));
       } else {
           echo json_encode(array("success"=>true, "data" => []));
       }

   } else {
       echo json_encode(array("success"=>false, "msg" => "Unable to get call note."));
   }
});