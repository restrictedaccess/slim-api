<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use chobie\Jira\Api;
use chobie\Jira\Api\Authentication\Basic;
use chobie\Jira\Issues\Walker;
use chobie\Jira\Issue;
use Mailgun\Mailgun;

use RemoteStaff\Entities\ChangeRequest;
use RemoteStaff\Entities\Personal;


$settings = require BASE_DIR . '/../src/settings.php';

class MyWalker extends chobie\Jira\Issues\Walker
{}

$app->options("/projects/get_issues", function(Request $request, Response $response, $args) use ($settings) {});

$app->post("/projects/get_issues", function(Request $request, Response $response, $args) use ($settings){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);

    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();
    $api = new Api(
        'https://remotestaff.atlassian.net',
        new Basic('remote.dapitan@gmail.com', 'Emerson1993')
    );

    $walker = new MyWalker($api);
    $walker->push('project = SV', '*navigable');
    $issues = array();

    $string = "";
    foreach ( $walker as $object ) {
        $string = $object->getKey() . " " . $object->getFields()['Summary'];
        array_push($issues, $string);
    }

    echo json_encode($issues);
    // print_r($issues); 

    //Display Issues
    // foreach($issues as $issue){
    //     // print_r($issue['Summary'] . "\n");
    // }


    //UPDATING JIRA
    // $key = "SV-70";
    // $update_object = new stdClass();
    // $update_object->labels = array(
    //     array(
    //         "add" => "test" 
    //     ),
    //     array(
    //         "add" => "yorro"
    //     )
    // );
    // $r = $api->editIssue($key, array(
    //     'update' => $update_object,
    // ));
    // print_r($r);
    // exit;


    // $walker = new Walker($api);
    // $walker->push(
    //     'project = "YOURPROJECT" AND (status != "closed" AND status != "resolved") ORDER BY priority DESC'
    // );

    // foreach ( $walker as $issue ) {
    //     var_dump($issue);
    //     // Send custom notification here.
    // }
    // $result = array();
    // $result["data"] = $api;
    // $result["success"] = true;
    // $success = false;
    // $result = [
    //     "success" => $success,
    //     "data" => $walker
    // ];
    // $testData = array("name" => "test name");
    
});

$app->options("/projects/submit_change_request_form", function(Request $request, Response $response, $args) use ($settings) {});

$app->post("/projects/submit_change_request_form", function(Request $request, Response $response, $args) use ($settings){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {$request = $_REQUEST;}
    $api_key = $config['mailgun']['api_key'];
    $domain = $config['mailgun']['domain'];

    $result = array();
    $result["success"] = "Send Email Success!";
    $result["data"] = json_encode($request);

    $changeRequest = createChangeRequest($request);
    echo json_encode($changeRequest);

    $mg = new Mailgun($api_key);

    # Now, compose and send your message.
    // $html  = file_get_contents(BASE_DIR . '/../templates/change_request.html');
    
    // $html  = file_get_contents(BASE_DIR . '/../templates/change_request.html');

    // $email = $this->renderer->fetch('emails/instant_email/custom.phtml', [
    //         "body"=>$emalRaw['body'],
    //         "staff_name"=>$cand->getName(),
    //         "signature_template"=>$admin->getSignatureTemplate()
    //     ]);

    // foreach ($request['boardApproval'] as $item) {
    //     echo json_encode($item);
    // }
    // echo json_encode($request['boardApproval']);

    $devs = [
        "name"=> "Devs",
        "id"=> "No ID",
        "title"=> "test title 1",
        "description"=> "test description 1",
        "story"=> "test story 1",
        "email" => "m.yorro@remotestaff.com.ph"
    ];

    $devs2 = [
        "name"=> "test name 2",
        "id"=> "test id 2",
        "title"=> "test title 2",
        "description"=> "test description 2",
        "story"=> "test story 2",
        "email" => "m.yorro@remotestaff.com.ph"
    ];

    // $testArray = ['m.yorro@remotestaff.com.ph', 'm.yorro@remotestaff.com.ph'];
    
    if (in_array($settings["settings"]["env"], ["dev", "staging"])){
        $recipients = array($devs, $devs2);
    }else{
        $recipients = array("m.yorro@remotestaff.com.ph");
    }

    foreach($recipients as $recipient)
    {
        //SETUP TEMPLATE
        $email = $this->renderer->fetch('emails/change_request_email/email.phtml', [
            "name"=> $recipient['name'],
            "id"=> $recipient["id"],
            "title"=> $recipient["title"],
            "description"=> $recipient["description"],
            "story"=> $recipient["story"],
            "email"=> $recipient["email"]
        ]);
        $mg->sendMessage($domain, array('from'    => 'QC Remote Staff <recruitment@remotestaff.com.au>', 
                                'to'      => $recipient['email'], 
                                'subject' => "Requesting for Approval for Change Request Form.", 
                                'text'    => 'Your mail do not support HTML',
                                'html'    => $email
                                ));
    }
   
});

$app->options("/projects/approve", function(Request $request, Response $response, $args) use ($settings) {});
$app->get("/projects/approve", function(Request $request, Response $response, $args) use ($settings){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {$request = $_REQUEST;}
    $message = "Thank you for your approval.";
    echo json_encode($message . " " . $request['name']);
    // echo "<script>setTimeout(\"location.href = 'http://devs.remotestaff.com.au/portal/projects/?slim_url=http://mystic.slim.api.remotestaff.com.au#/projects/change_request';\",1500);</script>";
});



function createChangeRequest($request){

    if ($request == null){
        return false;
    }

    $changeRequest = new ChangeRequest();
    $changeRequest->setId($request['id']);
    $changeRequest->setTitle($request['title']);
    $changeRequest->setRequestBy($request['requestBy']);
    $changeRequest->setDepartment($request['department']);
    $changeRequest->setDateRequested($request['dateRequested']);
    $changeRequest->setDateNeeded($request['dateNeeded']);
    $changeRequest->setPriority($request['priority']);
    $changeRequest->setStatus($request['status']);
    // $changeRequest->setChangeRequestId($request['changeRequestId']);
    $changeRequest->setType($request['type']);
    $changeRequest->setAdditionOrChange($request['additionOrChange']);
    $changeRequest->setSummary($request['summary']);
    $changeRequest->setDescription($request['description']);
    $changeRequest->setSupportingInformation($request['supportingInformation']);
    $changeRequest->setReasonsAndJustification($request['reasonsAndJustification']);
    $changeRequest->setAffectedAreas($request['affectedAreas']);
    $changeRequest->setRiskDescription($request['riskDescription']);
    $changeRequest->setTechnicalChangesDescription($request['technicalChangesDescription']);
    $changeRequest->setResourceStatus($request['resourceStatus']);
    $changeRequest->setAssignee($request['assignee']);
    $changeRequest->setStartDate($request['startDate']);
    $changeRequest->setReleaseDate($request['releaseDate']);
    $changeRequest->setStory($request['story']);
    $changeRequest->setBoardApproval($request['boardApproval']);

    return $changeRequest;
}

// $app->options("/projects/disapproved", function(Request $request, Response $response, $args) use ($settings) {});
// $app->get("/projects/disapproved", function(Request $request, Response $response, $args) use ($settings){
//     $config = $settings["settings"];
//     $request = json_decode(file_get_contents('php://input'), true);
//     if (!$request) {$request = $_REQUEST;}

//     echo json_encode($request['email']);
// });

// function addData()
// {
// // connect
//     $m = new MongoClient();
// // select your database
//     $db = $m->dbname;
// // select your collection
//     $collection = $db->collectionname;
// // add a record
//     $document = array("title" => "title 1", "author" => "author 1");
//     $collection->insert($document);
// // add another record
//     $document = array("title" => "title 2", "author" => "author 2");
//     $collection->insert($document);
// }

// function showData()
// {
// // connect
//     $m = new MongoClient();
// // select your database
//     $db = $m->dbname;
// // select your collection
//     $collection = $db->collectionname;
// // find everything in the collection
//     $cursor = $collection->find();
// // Show the result here
//     foreach ($cursor as $document) {
//         echo $document["title"] . "\n";
//     }
// }