<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/11/2016
 * Time: 8:26 AM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use RemoteStaff\Entities\SeoCategoryHistory;
use RemoteStaff\Entities\SubCategory;
use RemoteStaff\Exceptions\CategoryAlreadyAddedException;
use RemoteStaff\Exceptions\InvalidCategoryException;
use RemoteStaff\Exceptions\InvalidSubCategoryException;
use RemoteStaff\Exceptions\SeoCategoryAlreadyAddedException;
use RemoteStaff\Resources\SeoCategoryResource;


class UpdateSeoSubCategoryTest extends \PHPUnit_Framework_TestCase
{

    private $stub;

    private $admin;

    private $existing_sub_categories;


    protected function setUp(){

        $php_dev_sub_category = new SubCategory();

        $category = new Category();

        $category->setCategoryName("Web Development");

        $php_dev_sub_category->setCategory($category);
        $php_dev_sub_category->setId(3);
        $php_dev_sub_category->setSubCategoryName("PHP Development");
        $php_dev_sub_category->setSingularName("PHP Developer");
        $php_dev_sub_category->setUrl("php_development");
        $php_dev_sub_category->setPageHeader("Outsource PHP Developers to the Philippines");
        $php_dev_sub_category->setTitle("Hire PHP Developers | PHP Programmers | Remote Staff");
        $php_dev_sub_category->setStatus("posted");
        $php_dev_sub_category->setKeywords("php development, php developers, php programmers, hire php developers, outsourcing php development, outsource php developers");
        $php_dev_sub_category->setMetaDescription("Remote Staff provides dedicated expert PHP Developers for your PHP Development Projects. Outsource  PHP programmers now and hit the ground running in no time.");




        $this->existing_sub_categories = new ArrayCollection();

        $this->existing_sub_categories->add($php_dev_sub_category);


        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(SeoCategoryResource::class);


        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-20 13:02:00");


        $this->stub
            ->expects($this->any())
            ->method('updateSubCategory')
            ->will($this->returnCallback(function($sub_category_details, $admin) use ($dateCreated){

                if(empty($sub_category_details) || empty($sub_category_details["sub_category_name"])){
                    throw new InvalidSubCategoryException();
                }

                if(empty($admin)){
                    throw new \Exception("Admin is required");
                }


                $criteria = Criteria::create()
                    ->where(Criteria::expr()->eq("id", $sub_category_details["sub_category_id"]));

                $found_sub_categories = $this->existing_sub_categories->matching($criteria);

//                if(count($found_categories) > 0){
//                    throw new SeoCategoryAlreadyAddedException();
//                }

                /**
                 * @var SubCategory $existing_sub_category
                 */
                $existing_sub_category = null;

                foreach ($found_sub_categories as $found_sub_category) {
                    $existing_sub_category = $found_sub_category;
                }



                $old_record = [
                    "status" => $existing_sub_category->getStatus(),
                    "sub_category_name" => $existing_sub_category->getSubCategoryName(),
                    "singular_name" => $existing_sub_category->getSingularName(),
                    "url" => $existing_sub_category->getUrl(),
                    "title" => $existing_sub_category->getTitle(),
                    "meta_description" => $existing_sub_category->getMetaDescription(),
                    "keywords" => $existing_sub_category->getKeywords(),
                    "page_header" => $existing_sub_category->getPageHeader(),
                    "page_description" => $existing_sub_category->getPageDescription(),
                    "asl_h1" => $existing_sub_category->getAslH1(),
                    "asl_h2" => $existing_sub_category->getAslH2(),
                    "category" => $existing_sub_category->getCategory()->getCategoryName()
                ];

                $new_record = [
                    "status" => $sub_category_details["status"],
                    "sub_category_name" => $sub_category_details["sub_category_name"],
                    "singular_name" => $sub_category_details["singular_name"],
                    "url" => $sub_category_details["url"],
                    "title" => $sub_category_details["title"],
                    "meta_description" => $sub_category_details["meta_description"],
                    "keywords" => $sub_category_details["keywords"],
                    "page_header" => $sub_category_details["page_header"],
                    "page_description" => $sub_category_details["page_description"],
                    "asl_h1" => $sub_category_details["asl_h1"],
                    "asl_h2" => $sub_category_details["asl_h2"],
                    "category" => $sub_category_details["category"]["category_name"]
                ];


                $existing_sub_category->setStatus($sub_category_details["status"]);
                $existing_sub_category->setSubCategoryName($sub_category_details["sub_category_name"]);
                $existing_sub_category->setSingularName($sub_category_details["singular_name"]);
                $existing_sub_category->setUrl($sub_category_details["url"]);
                $existing_sub_category->setTitle($sub_category_details["title"]);
                $existing_sub_category->setMetaDescription($sub_category_details["meta_description"]);
                $existing_sub_category->setKeywords($sub_category_details["keywords"]);
                $existing_sub_category->setPageHeader($sub_category_details["page_header"]);
                $existing_sub_category->setPageDescription($sub_category_details["page_description"]);
                $existing_sub_category->setAslH1($sub_category_details["asl_h1"]);
                $existing_sub_category->setAslH2($sub_category_details["asl_h2"]);



                $difference = array_diff_assoc($old_record,$new_record);

                $history_changes = "Updated Sub Category <font color=#FF0000>" . $existing_sub_category->getSubCategoryName() . "</font><br />";

                if( count($difference) > 0) {
                    foreach (array_keys($difference) as $array_key) {
                        if(isset($new_record[$array_key])){
                            $history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old_record[$array_key], $new_record[$array_key]);
                        }
                    }
                }

                //$historyChanges = "added category <font color=#FF0000>[" . $category->getCategoryName() . "]</font>";

                $this->createSeoCategoryHistory($admin, $history_changes, $dateCreated);



                return [
                    "success" => true
                ];
            }));

    }


    public function testUpdatePhpDevSubCategoryEmptyFields(){
        $this->expectException(InvalidSubCategoryException::class);


        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");

        $this->stub->updateSubCategory([], $this->admin);
    }


    public function testUpdatePhpDevSubCategoryDetails(){
        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");

        $sub_category_request = [
            "sub_category_id" => 3,
            "status" => "posted",
            "sub_category_name" => "PHP Development",
            "singular_name" => "PHP Developer",
            "url" => "php_development",
            "title" => "Remotestaff offshore",
            "meta_description" => "Outsourcing services",
            "keywords" => "Virtual Assistant",
            "page_header" => "Outsource PHP Developers to the Philippines",
            "page_description" => "Candidates",
            "asl_h1" => "Interview pre-screened",
            "asl_h2" => "Request an Interview",
            "category" => [
                "category_name" => "Web Development"
            ]
        ];

        $this->stub->updateSubCategory($sub_category_request, $this->admin);

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("id", $sub_category_request["sub_category_id"]));

        $found_sub_categories = $this->existing_sub_categories->matching($criteria);


        /**
         * @var SubCategory $existing_sub_category
         */
        $existing_sub_category = null;

        foreach ($found_sub_categories as $found_sub_category) {
            $existing_sub_category = $found_sub_category;
        }



        $this->assertEquals(
            $sub_category_request["asl_h1"],
            $existing_sub_category->getAslH1()
        );


        return $this->admin;
    }


    /**
     * @depends testUpdatePhpDevSubCategoryDetails
     * @param Admin $admin
     */
    public function testHasSeoHistoryUpdatePhpDevSubCategory(Admin $admin){
        $last_history = $admin->getSeoCategoryHistory()->last();

        $this->assertRegExp(
            '/to Request an Interview/',
            $last_history->getChanges()
        );


        return $admin;

    }



    /**
     * @param Admin $admin
     * @param $historyChanges
     * @param \DateTime $dateCreated
     * @return SeoCategoryHistory
     */
    public function createSeoCategoryHistory(Admin $admin, $historyChanges, \DateTime $dateCreated){

        $seoHistory = new SeoCategoryHistory();
        $seoHistory->setChangedBy($admin);
        $seoHistory->setChanges($historyChanges);
        $admin_type = $admin ->getStatus();
        if($admin_type == "FULL-CONTROL"){
            $admin_type = "ADMIN";
        }

        if($admin_type == null){
            $admin_type = "HR";
        }

        if(isset($dateCreated)){
            $seoHistory->setDateCreated($dateCreated);
        } else{
            $seoHistory->setDateCreated(new \DateTime());
        }


        $seoHistory->setChangedByType($admin_type);

        if($admin->getSeoCategoryHistory() == null){
            $admin->setSeoCategoryHistory(new ArrayCollection());
        }

        $admin->getSeoCategoryHistory()->add($seoHistory);



        return $seoHistory;
    }

}