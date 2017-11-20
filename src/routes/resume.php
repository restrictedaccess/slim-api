<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 26/09/16
 * Time: 2:32 PM
 */
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;



$settings = require BASE_DIR . '/../src/settings.php';

$candidate_resource = new \RemoteStaff\Resources\CandidateResource();
$recruiter_resource = new \RemoteStaff\Resources\AdminResource();

$app->get("/resume/fetch", function (Request $request, Response $response, $args) use ($settings) {
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $request["candidate"] = json_decode($request["candidate"], true);


    $client = new couchClient($settings["settings"]["couchdb"]["host"], "resume");


    $resumeRes = $client->getDoc(strval($request["candidate"]["id"]));

    $resumeRes = json_decode(json_encode($resumeRes), true);

    echo json_encode(["success" => true, "result" => $resumeRes]);
});

$app->options("/resume/save", function (Request $request, Response $response, $args) {

});
$app->post("/resume/save", function (Request $request, Response $response, $args) use ($settings, $candidate_resource, $recruiter_resource) {
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = [
        "success" => false,
        "result" => [],
        "error" => [],
        "result_tb_applicant_files" => [],
        "result_picture_uploaded" => [],
        "result_voice_uploaded" => []
    ];

    if (isset($request)) {
        //$request = json_decode(file_get_contents('php://input'), true);

        $recruiter_resource->setEntityManager($candidate_resource->getEntityManager());



        $client = new couchClient($settings["settings"]["couchdb"]["host"], "resume");
        $resumeRes = null;

        $request["candidate"] = json_decode($request["candidate"], true);

        $request["recruiter"] = json_decode($request["recruiter"], true);

        $request["resume"] = json_decode($request["resume"], true);

        $new_resume = false;



        $candidate = $candidate_resource->get($request["candidate"]["id"]);

        $recruiter = $recruiter_resource->get($request["recruiter"]["id"]);

        try {
            // Update
            $resumeRes = $client->getDoc($request["resume"]["_id"]);
        } catch (Exception $e) {
            // Create new
            $new_resume = true;
            //$resumeRes = new couchDocument($client);

            $resumeRes = new stdClass();


        }


        $md5_file_image = null;

        $md5_file_voice = null;



        foreach($request["resume"] as $key=>$val){
            $resumeRes->$key = $val;
        }



        if(!empty($candidate)){
            $resumeRes->computer_hardware = $candidate->getComputerHardware();
            $resumeRes->headset_quality = $candidate->getHeadsetQuality();
            $resumeRes->home_working_environment = $candidate->getHomeWorkingEnvironment();
            $resumeRes->internet_connection = $candidate->getInternetConnection();
        }




        function generate_resume_history($doc, $admin_details, $changes){
            //HISTORY
            $doc_history = array();

            if(isset($doc->doc_history)){
                $doc_history = $doc->doc_history;
            }

            $new_history = new stdClass();

            $new_history->date = date("Y-m-d h:i:s");

            $new_history->admin = trim($admin_details["admin_fname"]) . " " . trim($admin_details["admin_lname"]);

            $new_history->changes = $changes;

            $doc_history[] = $new_history;


            $doc->doc_history = $doc_history;

            return $doc;
        }

        //create doc_history

        /**
        $doc_history = array();

        if(isset($resumeRes->doc_history)){
        $doc_history = $resumeRes->doc_history;
        }

        $new_history = new stdClass();

        $new_history->date = date("Y-m-d h:i:s");

        $new_history->admin = trim($recruiter->getFirstName()) . " " . trim($recruiter->getLastName());

        $new_history->changes = $changes;

        $doc_history[] = $new_history;


        $resumeRes->doc_history = $doc_history;
         */




        $save_response = $client->storeDoc($resumeRes);

        $result["responses"][] = [];

        $result["responses"][] = $save_response;

        //$resumeRes = $client->getDoc($request["resume"]["_id"]);

        $resumeRes->_rev = $save_response->rev;


        //$response = $resume_client->storeAsAttachment($doc, $new_image, 'picture.jpg', $content_type);

        //$content_type = $image_size["mime"];


        if(!empty($request["resume"]["tb_applicant_files"])){
            foreach ($request["resume"]["tb_applicant_files"] as $key => $tb_applicant_file) {

                //$resumeRes = $client->getDoc($request["resume"]["_id"]);

                foreach ($tb_applicant_file as $key_inner => $item) {
                    $url = $settings["settings"]["files_dir"]."/".$key_inner;
                    if(file_exists($url)){


                        $image_size = getimagesize($url);
                        $content_type = $image_size["mime"];


                        $new_file = file_get_contents($url);
                        //$md5_file = md5_file($url);

                        try{

                            $response = $client->storeAsAttachment($resumeRes, $new_file, $key, $content_type);

                            $result["responses"][] = $response;

                            $resumeRes->_rev = $response->rev;


//
//                            //$resumeRes = $response;
//                            if(!$new_resume){
//                                $resumeRes = $client->getDoc($request["resume"]["_id"]);
//                            } else{
//                                $resumeRes = $response;
//                            }
//

                            //$response->picture_md5 = $md5_file;

                            $result["result_tb_applicant_files"][] = $response;
                            $result["success"] = true;
                        } catch(Exception $e){
                            $result["error"][] = $e->getMessage();
                        }
                    }


                }

            }
        }


        if(isset($_FILES["picture"])){
            $tmp_name = $_FILES["picture"]["tmp_name"];
            $filename = $_FILES["picture"]["name"];
            $content_type = $_FILES["picture"]["type"];
            $image_size = $_FILES["picture"]["size"];

            $ext = pathinfo($filename, PATHINFO_EXTENSION);

            //$url = $settings["settings"]["uploads_dir"]."/voice/".$filename

            //$image_size = getimagesize($url);
            //$content_type = $image_size["mime"];


            $new_file = file_get_contents($tmp_name);

            $md5_file = md5_file($tmp_name);


            try{
                //$resumeRes = $client->getDoc($request["resume"]["_id"]);

                $md5_file_image = $md5_file;
                //$resumeRes = $response;
                if(!empty($md5_file_image)){
                    $resumeRes->picture_md5 = $md5_file_image;
                }


                $response = $client->storeAsAttachment($resumeRes, $new_file, "picture.jpg", $content_type);
                $result["responses"][] = $response;

                $resumeRes->_rev = $response->rev;

//                if(!$new_resume){
//                    $resumeRes = $client->getDoc($request["resume"]["_id"]);
//                } else{
//                    $resumeRes = $response;
//                }




                $result["result_picture_uploaded"][] = $response;
                $result["success"] = true;
            } catch(Exception $e){
                $result["error"][] = $e->getMessage();
            }
        }

        if(isset($_FILES["voice"])){
            $tmp_name = $_FILES["voice"]["tmp_name"];
            $filename = $_FILES["voice"]["name"];
            $content_type = $_FILES["voice"]["type"];
            $image_size = $_FILES["voice"]["size"];

            $ext = pathinfo($filename, PATHINFO_EXTENSION);




            //$url = $settings["settings"]["uploads_dir"]."/voice/".$filename

            //$image_size = getimagesize($url);
            //$content_type = $image_size["mime"];


            $new_file = file_get_contents($tmp_name);
            $md5_file = md5_file($tmp_name);



            try{
                //$resumeRes = $client->getDoc($request["resume"]["_id"]);


                $md5_file_voice = $md5_file;


                if(!empty($md5_file_voice)){
                    $resumeRes->voice_md5 = $md5_file_voice;
                }

                $response = $client->storeAsAttachment($resumeRes, $new_file, "voice.mp3", $content_type);
                $result["responses"][] = $response;

                $resumeRes->_rev = $response->rev;

//                if(!$new_resume){
//                    $resumeRes = $client->getDoc($request["resume"]["_id"]);
//                } else{
//                    $resumeRes = $response;
//                }






                $result["result_voice_uploaded"][] = $response;
                $result["success"] = true;
            } catch(Exception $e){
                $result["error"][] = $e->getMessage();
            }
        }


        //$save_response = $client->storeDoc($resumeRes);
        //$result["responses"][] = $save_response;



        $result["success"] = true;



        echo json_encode($result);

    }


});

