<?php

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;
use RemoteStaff\Resources\InstantEmailResource;
use RemoteStaff\Resources\CandidateResource;
use RemoteStaff\Entities\Personal;



$settings = require BASE_DIR . '/../src/settings.php';

$instantEmail = new InstantEmailResource();
$candidate_resource = new CandidateResource();

$app->options("/candidates/getemailtemp/", function(Request $request, Response $response, $args) use ($settings) {

});



$app->get("/candidates/getemailtemp/", function(Request $request, Response $response, $args) use ($settings,$instantEmail) {

    $request = $_REQUEST;


    if(isset($request)){


        $link = ($request['link'] ? $request['link'] : "");
        $template = ($request['template'] ? $request['template'] : "");

        $cand = $instantEmail->getEmailResource($request);
        $admin =$instantEmail->getAdminData($request);


        $email = $this->renderer->fetch('emails/instant_email/'.$template.'.phtml', [
            "staff_name"=>$cand->getName(),
            "signature_template"=>$admin->getSignatureTemplate(),
            "link"=>$link
        ]);

        echo json_encode(array("success"=>true,"data"=>$email));

    } else {


    }

});

$app->options("/candidates/sendinstantemail/", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/candidates/sendinstantemail/", function(Request $request, Response $response, $args) use ($settings,$instantEmail) {






    $dir = $settings["settings"]["files_dir"];
    $pathsAttach = array();
//    if (isset($request["instantEmail"])){
//        $emalRaw = json_decode($_REQUEST["instantEmail"], true);
//    }else{
//        $emalRaw = json_decode(file_get_contents('php://input'), true);
//    }
    $emalRaw = json_decode(file_get_contents('php://input'), true);
    if (!$emalRaw) {
        $emalRaw = $_REQUEST;
    }




    if(isset($request)){

        $attachments = [];
        if(!empty($_FILES)) {

                for ($i = 0; $i < count($_FILES["uploadfile"]["name"]); $i++) {
                    $tmp_name = $_FILES["uploadfile"]["tmp_name"][$i];
                    $filename = $_FILES["uploadfile"]["name"][$i];
                    $type = $_FILES["uploadfile"]["type"][$i];
                    $data = array(
                        'tmp_name' => $tmp_name,
                        'filename' => $filename,
                        'type' => $type,
                    );
                    $attachments[] = $data;
                }

                if($attachments)
                {
                    foreach($attachments as $attachment){
//                        move_uploaded_file($attachment["tmp_name"],$dir."/".$attachment["filename"]);
//                        $pathsAttach [] = $dir."/".$attachment["filename"];
                        $pathsAttach [] = [
                            "remoteName" => $attachment["filename"],
                            "filePath" => $attachment["tmp_name"]
                        ];
                    }
                }
        }


        $cand =  $instantEmail->getEmailResource($emalRaw);
        $admin =$instantEmail->getAdminData($emalRaw);


        $email = $this->renderer->fetch('emails/instant_email/custom.phtml', [
            "body"=>$emalRaw['body'],
            "staff_name"=>$cand->getName(),
            "signature_template"=>$admin->getSignatureTemplate()
        ]);


        $recipients = array();

        $cc  = array();
        $bcc = array();

        $subject = $emalRaw['subject'];
        if (in_array($settings["settings"]["env"], ["dev", "staging"])){
            $recipients = array('devs@remotestaff.com.au');
        }else{

                $recipients = array($cand->getEmail());
        }

        $cc = (!empty($emalRaw['cc']) && $emalRaw['cc'] != 'undefined' ? array($emalRaw['cc']) : array());
        $bcc = (!empty($emalRaw['bcc']) && $emalRaw['bcc'] != 'undefined' ? array($emalRaw['bcc']) : array());

        $mgClient = new Mailgun($settings["settings"]["mailgun"]["api_key"]);
        $domain = $settings["settings"]["mailgun"]["domain"];

        $result = $mgClient->sendMessage($domain, array(
            'from'    => 'Remote Staff <recruitment@remotestaff.com.au>',
            'to'      => $recipients,
            'cc'      => $cc,
            'bcc'      => $bcc,
            'subject' => $subject,
            'html'    => $email

        ), array(
            'attachment' => $pathsAttach
        ));


        $emalRaw["history"] =  $emalRaw["body"];
        $emalRaw["actions"] = "EMAIL";
        $emalRaw["admin_id"] = $emalRaw['adminid'];
        $emalRaw["user_id"] =  $emalRaw["userid"];
        $emalRaw['subject'] = $emalRaw['subject'];
        $instantEmail->insertToHistory($emalRaw);

        echo json_encode(["success"=>true]);

    } else {


    }

});
