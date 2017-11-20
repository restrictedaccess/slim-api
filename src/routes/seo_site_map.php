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


require_once dirname(__DIR__) . "/../lib/simple_html_dom.php";




$admin_resource = new \RemoteStaff\Resources\AdminResource();

$seo_tool_resource = new \RemoteStaff\Mongo\Resources\SEOToolsResource();
$settings = require BASE_DIR . '/../src/settings.php';



$app->options("/seo/upload-csv-sitemap", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/seo/upload-csv-sitemap", function(Request $request, Response $response, $args) use ($settings, $admin_resource,$seo_tool_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }


    if(empty($_FILES)){
        throw new Exception("Csv File is required.");
    }

    $admin_data = json_decode($request["admin"], true);

    $admin_details = $admin_resource->get($admin_data["id"]);

    $result = array();
    $result["success"] = false;
    $result["result"] = array();

    if(!empty($_FILES)){

        $tmpName = $_FILES['uploadCsv']['tmp_name'];

        if(($handle = fopen($tmpName, 'r')) !== FALSE) {
            // necessary if a large csv file
            set_time_limit(0);
            $sort_number = 0;
            while(($data = fgetcsv($handle, 0, ",")) !== FALSE) {


                /**
                 * 25Array
                (
                [0] => http://www.remotestaff.com.au/why.php
                [1] => Frequently Asked Questions | Remote Staff
                [2] => Remote Staff offshore outsourcing services let you save 70% on labor cost. Unlike BPO companies, we let you interview prescreened candidates. Call us today!
                [3] => Virtual Assistants, Remote Staff, Virtual Assistant, Oursourcing Philippines, Virtual Personal Assistant, Virtual Assistant Services
                [4] => Doing Business with Remote Staff
                )
                 */

                $url_parts = parse_url($data[0]);
                $new_data = [
                    "link" => "",
                    "uri" => "",
                    "title" => "",
                    "meta_description" => "",
                    "meta_keywords" => "",
                    "page_h1" => "",
                    "page_h2" => "",
                    "page_h3" => "",
                    "redirects_to" => "",
                    "status" => ""
                ];

                if(isset($url_parts["path"])){
                    $new_data["uri"] = trim($url_parts["path"], "/");
                }

                $new_data["link"] = $data[0];
                $new_data["title"] = $data[1];
                $new_data["meta_description"] = $data[2];
                if(isset($data[3])){
                    $new_data["meta_keywords"] = $data[3];
                }

                if(isset($data[4])){
                    $new_data["page_h1"] = $data[4];
                }


                if(isset($data[5])){
                    $new_data["page_h2"] = $data[5];
                }

                if(isset($data[6])){
                    $new_data["page_h3"] = $data[6];
                }


                $new_data["sort_number"] = $sort_number;


                try{
                    $result["result"][] = $seo_tool_resource->saveSite($new_data, $admin_details, true);
                } catch(Exception $e){

                }



                $result["success"] = true;

                ++$sort_number;
            }
        }

    }

    echo json_encode($result);

});




$app->options("/seo/update-seo-sitemap", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/seo/update-seo-sitemap", function(Request $request, Response $response, $args) use ($settings, $admin_resource,$seo_tool_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }


    $admin_data = $request["admin"];

    $admin_details = $admin_resource->get($admin_data["id"]);

    $result = array();
    $result["success"] = false;
    $result["result"] = array();

    if(isset($request["site_to_save"])){
        $site_to_save = $request["site_to_save"];
        $new_data = [
            "link" => $site_to_save["link"],
            "uri" => "",
            "title" => $site_to_save["title"],
            "meta_description" => $site_to_save["meta_description"],
            "meta_keywords" => $site_to_save["meta_keywords"],
            "page_h1" => $site_to_save["page_h1"],
            "page_h2" => $site_to_save["page_h2"],
            "page_h3" => $site_to_save["page_h3"],
            "redirects_to" => $site_to_save["redirects_to"],
            "status" => $site_to_save["status"],
            "sort_number" =>$site_to_save["sort_number"],
            "save_params" => $site_to_save["save_params"]
        ];

        if(!empty($site_to_save["id"])){
            $new_data["id"] = $site_to_save["id"];
        }

        if(isset($site_to_save["link"])){

            $url_parts = parse_url($site_to_save["link"]);


            if(isset($url_parts["path"])){
                $new_data["uri"] = trim($url_parts["path"], "/");
            }

            if(isset($site_to_save["save_params"]) && $site_to_save["save_params"] == "yes"){
                $new_data["uri"] .= "?" . $url_parts["query"];
            }
        }


        $result["result"] = $seo_tool_resource->saveSite($new_data, $admin_details);
        $result["success"] = $result["result"]["success"];
    }


    echo json_encode($result);

});





$app->get("/seo/fetch-sitemap", function(Request $request, Response $response, $args) use ($settings ,$seo_tool_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = array();
    $result["success"] = false;
    $result["result"] = array();

    if(isset($request["uri"])){
        $value = $seo_tool_resource->getSiteMapByUri($request["uri"]);

        /**
         * @var $value \RemoteStaff\Documents\SiteMap
         */
        $result["result"] = $value->toArray();

        $result["success"] = true;

    } else{

        $values = $seo_tool_resource->getSiteMap();

        foreach ($values as $value) {
            /**
             * @var $value \RemoteStaff\Documents\SiteMap
             */
            $result["result"][] = $value->toArray();
        }

        $result["success"] = true;

    }


    echo json_encode($result);

});




$app->get("/seo/clear-sitemap", function(Request $request, Response $response, $args) use ($settings ,$seo_tool_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = array();
    $result["success"] = false;
    $result["result"] = array();

    $seo_tool_resource->clear();

    echo json_encode($result);

});




$app->get("/seo/remove-sitemap", function(Request $request, Response $response, $args) use ($settings ,$seo_tool_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = array();
    $result["success"] = false;
    $result["result"] = array();

    $seo_tool_resource->remove($request["uri"]);

    echo json_encode($result);

});






$app->get("/seo/parse-html", function(Request $request, Response $response, $args) use ($settings ,$seo_tool_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = array();
    $result["success"] = false;
    $result["result"] = array();

    if(!isset($request["url"])){
        throw new Exception("url is required");
    }

    $contents = file_get_contents($request["url"]);
    $html = str_get_html($contents);
    $h1 = $html->find("h1")[0];
    $h2 = $html->find("h2")[0];
    $h3 = $html->find("h3")[0];

    $meta_tags = get_meta_tags($request["url"]);

    $result["result"]["metas"] = $meta_tags;

    $result["result"]["title"] = $html->find('title', 0)->innertext;

    $result["result"]["H1"] = $h1->plaintext;
    $result["result"]["H2"] = $h2->plaintext;
    $result["result"]["H3"] = $h3->plaintext;

    $html->clear();


    $result["success"] = true;


    echo json_encode($result);
});


