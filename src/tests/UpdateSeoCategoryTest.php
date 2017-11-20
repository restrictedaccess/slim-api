<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 3:46 PM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Category;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use RemoteStaff\Entities\SeoCategoryHistory;
use RemoteStaff\Exceptions\CategoryAlreadyAddedException;
use RemoteStaff\Exceptions\InvalidCategoryException;
use RemoteStaff\Exceptions\SeoCategoryAlreadyAddedException;
use RemoteStaff\Resources\SeoCategoryResource;
class UpdateSeoCategoryTest extends \PHPUnit_Framework_TestCase
{

    private $stub;

    private $admin;

    private $existing_categories;

    protected function setUp(){

        $web_dev_category = new Category();

        $web_dev_category->setCategoryName("Web Development");
        $web_dev_category->setSingularName("Web Developer");
        $web_dev_category->setUrl("web_development");
        $web_dev_category->setPageHeader("Outsource Web Developers to the Philippines");
        $web_dev_category->setTitle("Hire Web Developers | Web Programmers | Remote Staff");
        $web_dev_category->setStatus("posted");
        $web_dev_category->setKeywords("web development, web developers, web programmers, hire web developers, outsourcing web development, outsource web developers, IT offshore");




        $this->existing_categories = new ArrayCollection();

        $this->existing_categories->add($web_dev_category);


        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(SeoCategoryResource::class);


        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-20 13:02:00");


        $this->stub
            ->expects($this->any())
            ->method('updateCategory')
            ->will($this->returnCallback(function($category_details, $admin) use ($dateCreated){

                if(empty($category_details) || empty($category_details["category_name"])){
                    throw new InvalidCategoryException();
                }

                if(empty($admin)){
                    throw new \Exception("Admin is required");
                }


                $criteria = Criteria::create()
                    ->where(Criteria::expr()->eq("categoryName", $category_details["category_name"]));

                $found_categories = $this->existing_categories->matching($criteria);

//                if(count($found_categories) > 0){
//                    throw new SeoCategoryAlreadyAddedException();
//                }

                /**
                 * @var Category $existing_category
                 */
                $existing_category = null;

                foreach ($found_categories as $found_category) {
                    $existing_category = $found_category;
                }

                //$this->existing_categories->add($category);

                /**
                "status" => $this->getStatus(),
                "category_name" => $this->getCategoryName(),
                "singular_name" => $this->getSingularName(),
                "url" => $this->getUrl(),
                "title" => $this->getTitle(),
                "meta_description" => $this->getMetaDescription(),
                "keywords" => $this->getKeywords(),
                "page_header" => $this->getPageHeader(),
                "page_description" => $this->getPageDescription(),
                "asl_h1" => $this->getAslH1(),
                "asl_h2" => $this->getAslH2()
                 */

                $old_record = [
                    "status" => $existing_category->getStatus(),
                    "category_name" => $existing_category->getCategoryName(),
                    "singular_name" => $existing_category->getSingularName(),
                    "url" => $existing_category->getUrl(),
                    "title" => $existing_category->getTitle(),
                    "meta_description" => $existing_category->getMetaDescription(),
                    "keywords" => $existing_category->getKeywords(),
                    "page_header" => $existing_category->getPageHeader(),
                    "page_description" => $existing_category->getPageDescription(),
                    "asl_h1" => $existing_category->getAslH1(),
                    "asl_h2" => $existing_category->getAslH2()
                ];

                $new_record = [
                    "status" => $category_details["status"],
                    "category_name" => $category_details["category_name"],
                    "singular_name" => $category_details["singular_name"],
                    "url" => $category_details["url"],
                    "title" => $category_details["title"],
                    "meta_description" => $category_details["meta_description"],
                    "keywords" => $category_details["keywords"],
                    "page_header" => $category_details["page_header"],
                    "page_description" => $category_details["page_description"],
                    "asl_h1" => $category_details["asl_h1"],
                    "asl_h2" => $category_details["asl_h2"]
                ];


                $existing_category->setStatus($category_details["status"]);
                $existing_category->setCategoryName($category_details["category_name"]);
                $existing_category->setSingularName($category_details["singular_name"]);
                $existing_category->setUrl($category_details["url"]);
                $existing_category->setTitle($category_details["title"]);
                $existing_category->setMetaDescription($category_details["meta_description"]);
                $existing_category->setKeywords($category_details["keywords"]);
                $existing_category->setPageHeader($category_details["page_header"]);
                $existing_category->setPageDescription($category_details["page_description"]);
                $existing_category->setAslH1($category_details["asl_h1"]);
                $existing_category->setAslH2($category_details["asl_h2"]);



                $difference = array_diff_assoc($old_record,$new_record);

                $history_changes = "Updated Category <font color=#FF0000>" . $existing_category->getCategoryName() . "</font><br />";

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


    public function testClickedSavedEmptyAllFields(){
        $this->expectException(InvalidCategoryException::class);


        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");



        $this->stub->updateCategory([], $this->admin);
    }


    public function testUpdateWebDevCategoryDetails(){

        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");


        //update request array
        $category_request = [
            "status" => "posted",
            "category_name" => "Web Development",
            "singular_name" => "Web Developer",
            "url" => "web_development",
            "title" => "Hire Web Developers | Web Programmers | Remote Staff",
            "meta_description" => "Outsourcing services",
            "keywords" => "Virtual Assistant",
            "page_header" => "Outsource Web Developers to the Philippines",
            "page_description" => "Candidates",
            "asl_h1" => "Interview pre-screened",
            "asl_h2" => "Request an Interview"
        ];

        $this->stub->updateCategory($category_request, $this->admin);


        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("categoryName", $category_request["category_name"]));

        $found_categories = $this->existing_categories->matching($criteria);

        /**
         * @var Category $existing_category
         */
        $existing_category = null;

        foreach ($found_categories as $found_category) {
            $existing_category = $found_category;
        }



        $this->assertEquals(
            $category_request["meta_description"],
            $existing_category->getMetaDescription()
        );


        return $this->admin;

    }


    /**
     * @depends testUpdateWebDevCategoryDetails
     * @param Admin $admin
     */
    public function testHasSeoHistoryUpdateWebDevCategory(Admin $admin){
        $last_history = $admin->getSeoCategoryHistory()->last();

        $this->assertRegExp(
            '/to Request an Interview/',
            $last_history->getChanges()
        );
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