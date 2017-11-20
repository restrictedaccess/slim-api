<?php
use Slim\Http\Request as Request;
use Slim\Http\Response as Response;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use RemoteStaff\Mongo\Resources\ProductPriceResource;
use RemoteStaff\Resources\CategorizedResource;
use RemoteStaff\Resources\AdminResource;
use Pheanstalk\Pheanstalk;
use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;



$settings = require BASE_DIR . '/../src/settings.php';



$product_price_filter_resource = new ProductPriceResource();


$categories_filter_resource = new CategorizedResource();

$education_filter_resource = new \RemoteStaff\Mongo\Resources\EducationResource();

$admin_filter_resource = new AdminResource();

$app->get("/filter-query/product-price-rate", function(Request $request, Response $response, $args) use ($settings,$product_price_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $full_time = $product_price_filter_resource->getAllFullTimePrice();

    $part_time = $product_price_filter_resource->getAllPartTimePrice();

    foreach ($full_time as $item) {
        /**
         * @var $item \RemoteStaff\Documents\FullTimePrice
         */
        $new_full_time = array();

        $new_full_time["label"] = $item->getLabel();
        $new_full_time["id"] = $item->getPriceId();
        foreach ($item->getDetails() as $detail) {
            /**
             * @var $detail \RemoteStaff\Documents\PriceDetails
             */
            $new_full_time["details"][] = $detail->toArray();
        }

        $new_full_time["php_code"] = str_replace("PHP-FT-", "", $item->getCode());
        $new_full_time["php_code"] = str_replace(",", "", $new_full_time["php_code"]);

        $result["full_time_product_price"][] = $new_full_time;
    }

    foreach ($part_time as $item) {
        $new_part_time = array();

        $new_part_time["label"] = $item->getLabel();
        $new_part_time["id"] = $item->getPriceId();
        foreach ($item->getDetails() as $detail) {
            /**
             * @var $detail \RemoteStaff\Documents\PriceDetails
             */
            $new_part_time["details"][] = $detail->toArray();
        }

        $new_part_time["php_code"] = str_replace("PHP-PT-", "", $item->getCode());
        $new_part_time["php_code"] = str_replace(",", "", $new_part_time["php_code"]);
//        $new_part_time["php_code"] = str_replace(".", "", $new_part_time["php_code"]);

        $result["part_time_product_price"][] = $new_part_time;
    }

    echo json_encode($result);
});



$app->get("/filter-query/all-categories", function(Request $request, Response $response, $args) use ($settings,$categories_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $result["categories"] = array();

    $categories = $categories_filter_resource->getAllCategories();

    foreach ($categories as $category) {

        /**
         * @var \RemoteStaff\Entities\Category $category
         */
        $category = $category;


        $temp_category = array();
        $temp_category["details"] = [
            "category_id" => $category->getId(),
            "category_name" => $category->getCategoryName(),
            "singular_name" => $category->getSingularName(),
            "status" => $category->getStatus()
        ];

        if(isset($request["fetch_all"])){
            $temp_category["complete_details"] = $category->toArray();
        }

        $temp_category["sub_categories"] = [];

        foreach ($category->getSubCategories() as $subCategory) {
            /**
             * @var \RemoteStaff\Entities\SubCategory $subCategory
             */
            $subCategory = $subCategory;
            $temp_sub_category = [
                "category_id" => $category->getId(),
                "singular_name" => $subCategory->getSingularName(),
                "sub_category_name" => $subCategory->getSubCategoryName(),
                "sub_category_id" => $subCategory->getId(),
                "status" => $subCategory->getStatus()
            ];

            if(isset($request["fetch_all"])){
                $temp_sub_category["complete_details"] = $subCategory->toArray();
            }

            $temp_category["sub_categories"][] = $temp_sub_category;
        }


        $result["categories"][] = $temp_category;
    }

    echo json_encode(["result" => $result]);
});


$app->get("/filter-query/all-recruiters", function(Request $request, Response $response, $args) use ($settings,$admin_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $result["result"] = array();

    $result["result"]["recruiters"] = [];

    $recruiters = $admin_filter_resource->getAllRecruiters();

    foreach ($recruiters as $recruiter) {
        /**
         * @var \RemoteStaff\Entities\Admin $recruiter
         */
        $recruiter = $recruiter;

        $recruiter_temp = [
            "admin_fname" => $recruiter->getFirstName(),
            "admin_lname" => $recruiter->getLastName(),
            "admin_id" => $recruiter->getId(),
            "userid" => $recruiter->getPersonalInformation()->getId(),
            "image" => $recruiter->getPersonalInformation()->getImage()
        ];

        $result["result"]["recruiters"][] = $recruiter_temp;
    }

    echo json_encode($result);
});




$app->get("/filter-query/education-levels", function(Request $request, Response $response, $args) use ($settings,$education_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $result["result"] = array();

    $filter_name = "education";

    $result["result"][$filter_name] = [];

    $levels = $education_filter_resource->getAllLevels();

    foreach ($levels as $value) {
        /**
         * @var \RemoteStaff\Documents\EducationLevels $value
         */
        $value = $value;

        $temp = [
            "id" => $value->getEducationId(),
            "value" => $value->getValue(),
        ];

        $result["result"][$filter_name][] = $temp;
    }

    echo json_encode($result);
});




$app->get("/filter-query/education-field-study", function(Request $request, Response $response, $args) use ($settings,$education_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $result["result"] = array();

    $filter_name = "field_of_studies";

    $result["result"][$filter_name] = [];

    $fields = $education_filter_resource->getAllFieldStudies();

    foreach ($fields as $value) {
        /**
         * @var \RemoteStaff\Documents\FieldStudy $value
         */
        $value = $value;

        $temp = [
            "id" => $value->getFieldId(),
            "value" => $value->getValue(),
        ];

        $result["result"][$filter_name][] = $temp;
    }

    echo json_encode($result);
});



$app->get("/filter-query/education-countries", function(Request $request, Response $response, $args) use ($settings,$education_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $result["result"] = array();

    $filter_name = "countries";

    $result["result"][$filter_name] = [];

    $fields = $education_filter_resource->getAllCountries();

    foreach ($fields as $value) {
        /**
         * @var \RemoteStaff\Documents\Country $value
         */
        $value = $value;

        $temp = [
            "id" => $value->getCountryId(),
            "name" => $value->getName(),
            "sortname" => $value->getSortName()
        ];

        $result["result"][$filter_name][] = $temp;
    }

    echo json_encode($result);
});



$app->get("/filter-query/education-industries", function(Request $request, Response $response, $args) use ($settings,$education_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $result["result"] = array();

    $filter_name = "industries";

    $result["result"][$filter_name] = [];

    $fields = $education_filter_resource->getAllIndustries();

    foreach ($fields as $value) {
        /**
         * @var \RemoteStaff\Documents\Industry $value
         */
        $value = $value;

        $temp = [
            "id" => $value->getIndustryId(),
            "name" => $value->getValue(),
        ];

        $result["result"][$filter_name][] = $temp;
    }

    echo json_encode($result);
});





$app->get("/filter-query/education-languages", function(Request $request, Response $response, $args) use ($settings,$education_filter_resource){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $result = array();

    $result["result"] = array();

    $filter_name = "languages";

    $result["result"][$filter_name] = [];

    $fields = $education_filter_resource->getAllLanguages();

    foreach ($fields as $value) {
        /**
         * @var \RemoteStaff\Documents\Language $value
         */
        $value = $value;

        $temp = [
            "id" => $value->getLanguageId(),
            "name" => $value->getName(),
        ];

        $result["result"][$filter_name][] = $temp;
    }

    echo json_encode($result);
});





$app->get("/filter-query/fetch-skills", function(Request $request, Response $response, $args) use ($settings){
    $config = $settings["settings"];
    $request = json_decode(file_get_contents('php://input'), true);
    if (!$request) {
        $request = $_REQUEST;
    }
    $skills_resource = new \RemoteStaff\Resources\SkillResource();
    $result = array();


    $filter_name = "skills";

    $result[$filter_name] = [];

    $fields = $skills_resource->getDefinedSkillsSearch($request["q"]);


    foreach ($fields as $value) {

        /**
         * @var \RemoteStaff\Entities\DefinedSkill $value
         */

        $temp = [
            "id" => $value->getId(),
            "name" => $value->getSkillName(),
        ];

        $result[$filter_name][] = $temp;

    }


    echo json_encode($result);
});





