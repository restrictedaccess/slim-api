<?php

use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;




$settings = require BASE_DIR . '/../src/settings.php';

$invoice_mongo_resource = new \RemoteStaff\Mongo\Resources\InvoicesResource();




$app->options("/invoices/save-invoice-email", function(Request $request, Response $response, $args) use ($settings) {

});





$app->post("/invoices/save-invoice-email", function(Request $request, Response $response, $args) use ($settings, $invoice_mongo_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $logger = new Logger('name');
    $logger->pushHandler(new StreamHandler("/home/remotestaff/sendgrid.log", Logger::INFO));



    try{
        foreach ($request as $item) {
            if(isset($item["debugging_env"]) && $item["debugging_env"] == "development"){
                continue;
            }

            if($item["event"] == "delivered"){
                $result = $invoice_mongo_resource->updateInvoiceEmailDelivered($item);
            } else if($item["event"] == "open"){
                $result = $invoice_mongo_resource->updateInvoiceEmailOpened($item);


            } else if($item["event"] == "click"){
                $result = $invoice_mongo_resource->updateInvoiceEmailClicked($item);


            } else if(isset($item["type"]) && strtolower($item["type"]) == "blocked"){
                //send via sparkpost
                //$result = $invoice_mongo_resource->updateInvoiceEmailClicked($item);
                if(isset($item["couch_id"])){
                    $post_fields = array("couch_id" => $item["couch_id"]);
                    if(isset($item["reason"])){
                        $post_fields["reason_for_sending"] = $item["reason"];
                    }
                    $this->curl->post($config["njs_url"] . "/send/invoice-email-via-sparkshot", $post_fields);
                }

                $logger->info(print_r($request, true));
                echo json_encode([success => true]);
                exit;

            }

        }
    } catch(Exception $e){
        $logger->info(print_r($e, true));
    }




    $logger->info(print_r($request, true));

    echo json_encode($result->toArray());
    //echo json_encode($request);

});



$app->options("/invoices/delivered-email-reporting", function(Request $request, Response $response, $args) use ($settings) {

});



$app->get("/invoices/delivered-email-reporting", function(Request $request, Response $response, $args) use ($settings, $invoice_mongo_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $date_to_evaluate = "";

    if(isset($request["date_to_evaluate"])){
        $date_to_evaluate = $request["date_to_evaluate"];
    }

    $invoice_mongo_resource->reportDeliveredInvoicesStatus($this->renderer, $date_to_evaluate);


    echo json_encode(array("success" => true));

});




$app->options("/invoices/remove-email-suppression-list", function(Request $request, Response $response, $args) use ($settings) {

});

$app->get("/invoices/remove-email-suppression-list", function(Request $request, Response $response, $args) use ($settings, $invoice_mongo_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }



    if(!isset($request["email"])){
        throw new Exception("email is required");
    }

    $invoice_mongo_resource->removeSuppressionReport($request["email"]);
    $invoice_mongo_resource->getDocumentManager()->flush();

    echo json_encode(array("success" => true));
});





