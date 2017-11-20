<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Mongo\Resources\ProductPriceResource;
use RemoteStaff\Resources\CategorizedResource;
use RemoteStaff\Resources\CandidateResource;
use RemoteStaff\Resources\AdminResource;
use RemoteStaff\Resources\ApplicantFileResource;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;
use Doctrine\Common\Collections\Criteria;


$settings = require BASE_DIR . '/../src/settings.php';

$admin_resource = new AdminResource();

$app->options("/login/check-admin-email-validity", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/login/check-admin-email-validity", function(Request $request, Response $response, $args) use ($settings, $admin_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = [];
    $result["success"] = false;

    $admins = $admin_resource->getByEmail($request["credentials"]["email"]);

    $admin = null;

    if(!empty($admins)){
        foreach ($admins as $admin_temp) {
            $admin = $admin_temp;
        }
    }

    if(!empty($admin)){
        $result["success"] = true;
    } else{
        $result["errors"] = [];

        $result["errors"][] = "Email does not exist.";
    }


    echo json_encode($result);

});




$app->options("/login/attempt", function(Request $request, Response $response, $args) use ($settings) {

});

$app->post("/login/attempt", function(Request $request, Response $response, $args) use ($settings, $admin_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    $result = [];
    $result["success"] = false;

    $email_exists = false;
    $admin = null;

    $admins = $admin_resource->getByEmailPassword($request["credentials"]["email"], $request["credentials"]["password"]);

    $admins_by_email = $admin_resource->getByEmail($request["credentials"]["email"]);


    if(!empty($admins)){
        $result["details"] = [];
        foreach ($admins as $admin_temp) {
            /**
             * @var \RemoteStaff\Entities\Admin $admin_temp
             */
            $admin = $admin_temp;

            $result["details"]["admin_id"] = $admin_temp->getId();
            $result["details"]["status"] = $admin_temp->getStatus();
        }
    }

    if(!empty($admins_by_email)){
        foreach ($admins_by_email as $email_exist) {
            $email_exists = true;
        }
    }

    if(!empty($admin)){
        $result["success"] = true;
    } else{
        $result["errors"] = [];

        if(!$email_exists){
            $result["errors"][] = "Email does not exist.";
        } else{
            $result["errors"][] = "Email and password does not match.";
        }

    }


    echo json_encode($result);
});
