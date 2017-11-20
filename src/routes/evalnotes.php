<?php


use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Resources\EvaluationCommentResource;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;

$settings = require BASE_DIR . '/../src/settings.php';
$eval_note = new EvaluationCommentResource();



$app->options("/candidates/addevalnote/", function(Request $request, Response $response, $args) use ($settings) {

});


$app->post("/candidates/addevalnote/", function(Request $request, Response $response, $args) use ($settings,$eval_note){
    $request = $_REQUEST;


    if(isset($request)){

        $evalnoteRaw = json_decode(file_get_contents('php://input'), true);
        $data_id = $eval_note->create($evalnoteRaw);

        echo json_encode(array("success"=>true,"data"=>$data_id));

    } else {

        echo json_encode(array("success"=>false, "msg" => "Unable to save applicant notes."));
    }
});



$app->options("/candidates/getEvalNote/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->get("/candidates/getEvalNote/", function(Request $request, Response $response, $args) use ($settings,$eval_note){
    $request = $_REQUEST;
    if(isset($request)){

//        $requestEvalParams = json_decode(file_get_contents('php://input'), true);
        $evalnoteRaw = $eval_note->getEvaluationNotes($request);

        echo json_encode(array("success"=>true,"data"=>$evalnoteRaw));

    } else {
        echo json_encode(array("success"=>false, "msg" => "Unable to save evaluation notes."));
    }
});

$app->options("/candidates/delEvalNote/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->get("/candidates/delEvalNote/", function(Request $request, Response $response, $args) use ($settings,$eval_note){
    $request = $_REQUEST;
    if(isset($request)){

//        $requestEvalParams = json_decode(file_get_contents('php://input'), true);
        $eval_note->deleteComments($request['id']);
        echo json_encode(array("success"=>true));

    } else {
        echo json_encode(array("success"=>false, "msg" => "Unable to delete evaluation notes."));
    }
});

$app->options("/candidates/updateEvalNote/", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/candidates/updateEvalNote/", function(Request $request, Response $response, $args) use ($settings,$eval_note){
    $request = $_REQUEST;
    if(isset($request)){

        $requestEvalParams = json_decode(file_get_contents('php://input'), true);
        $eval_note->updateEvaluationComments($requestEvalParams);

        echo json_encode(array("success"=>true));

    } else {
        echo json_encode(array("success"=>false, "msg" => "Unable to update evaluation notes."));
    }
});