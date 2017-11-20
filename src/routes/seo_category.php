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
$admin_resource = new \RemoteStaff\Resources\AdminResource();

$seo_category_resource = new \RemoteStaff\Resources\SeoCategoryResource();


$app->options("/seo/add-category", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/seo/add-category", function(Request $request, Response $response, $args) use ($settings, $seo_category_resource, $admin_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    if(!isset($request["category"])){
        throw new \RemoteStaff\Exceptions\InvalidCategoryException();
    }


    if(!isset($request["admin"])){
        throw new Exception("Admin is required");
    }

    $admin_resource->setEntityManager($seo_category_resource->getEntityManager());

    $admin = $admin_resource->get($request["admin"]["id"]);


    $to_add_category = $request["category"];

    //create new category to pass
    $new_category = new \RemoteStaff\Entities\Category();

    //initialize category
    $new_category->setCategoryName($to_add_category["category_name"]);
    $new_category->setStatus($to_add_category["status"]);
    $new_category->setSingularName($to_add_category["singular_name"]);
    $new_category->setUrl($to_add_category["url"]);
    $new_category->setDescription($to_add_category["description"]);
    $new_category->setTitle($to_add_category["title"]);
    $new_category->setMetaDescription($to_add_category["meta_description"]);
    $new_category->setKeywords($to_add_category["keywords"]);
    $new_category->setPageHeader($to_add_category["page_header"]);
    $new_category->setPageDescription($to_add_category["page_description"]);
    $new_category->setAslH1($to_add_category["asl_h1"]);
    $new_category->setAslH2($to_add_category["asl_h2"]);
    $new_category->setCategoryDateCreated(new DateTime());
    $new_category->setCreatedBy($admin);


    $result = $seo_category_resource->addCategory($new_category, $admin);

    echo json_encode($result);

});




$app->options("/seo/update-category", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/seo/update-category", function(Request $request, Response $response, $args) use ($settings, $seo_category_resource, $admin_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    if(!isset($request["category"])){
        throw new \RemoteStaff\Exceptions\InvalidCategoryException();
    }


    if(!isset($request["admin"])){
        throw new Exception("Admin is required");
    }

    $admin_resource->setEntityManager($seo_category_resource->getEntityManager());

    $admin = $admin_resource->get($request["admin"]["id"]);




    $result = $seo_category_resource->updateCategory($request["category"], $admin);

    echo json_encode($result);

});





$app->options("/seo/add-sub-category", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/seo/add-sub-category", function(Request $request, Response $response, $args) use ($settings, $seo_category_resource, $admin_resource, $categorized_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    if(!isset($request["sub_category"])){
        throw new \RemoteStaff\Exceptions\InvalidSubCategoryException();
    }


    if(!isset($request["admin"])){
        throw new Exception("Admin is required");
    }

    $admin_resource->setEntityManager($seo_category_resource->getEntityManager());

    $categorized_resource->setEntityManager($seo_category_resource->getEntityManager());

    $admin = $admin_resource->get($request["admin"]["id"]);



    $to_add_sub_category = $request["sub_category"];

    $category = $categorized_resource->getCategoryById($to_add_sub_category["category"]["category_id"]);


    //create new subCategory to pass
    $new_sub_category = new \RemoteStaff\Entities\SubCategory();

    //initialize category
    $new_sub_category->setCategory($category);
    $new_sub_category->setSubCategoryName($to_add_sub_category["sub_category_name"]);
    $new_sub_category->setStatus($to_add_sub_category["status"]);
    $new_sub_category->setSingularName($to_add_sub_category["singular_name"]);
    $new_sub_category->setUrl($to_add_sub_category["url"]);
    $new_sub_category->setDescription($to_add_sub_category["description"]);
    $new_sub_category->setTitle($to_add_sub_category["title"]);
    $new_sub_category->setMetaDescription($to_add_sub_category["meta_description"]);
    $new_sub_category->setKeywords($to_add_sub_category["keywords"]);
    $new_sub_category->setPageHeader($to_add_sub_category["page_header"]);
    $new_sub_category->setPageDescription($to_add_sub_category["page_description"]);
    $new_sub_category->setAslH1($to_add_sub_category["asl_h1"]);
    $new_sub_category->setAslH2($to_add_sub_category["asl_h2"]);
    $new_sub_category->setSubCategoryDateCreated(new DateTime());


    $result = $seo_category_resource->addSubCategory($new_sub_category, $admin);

    echo json_encode($result);

});



$app->options("/seo/update-sub-category", function(Request $request, Response $response, $args) use ($settings) {

});



$app->post("/seo/update-sub-category", function(Request $request, Response $response, $args) use ($settings, $seo_category_resource, $admin_resource) {
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }

    if(!isset($request["sub_category"])){
        throw new \RemoteStaff\Exceptions\InvalidSubCategoryException();
    }


    if(!isset($request["admin"])){
        throw new Exception("Admin is required");
    }

    $admin_resource->setEntityManager($seo_category_resource->getEntityManager());

    $admin = $admin_resource->get($request["admin"]["id"]);




    $result = $seo_category_resource->updateSubCategory($request["sub_category"], $admin);

    echo json_encode($result);

});





