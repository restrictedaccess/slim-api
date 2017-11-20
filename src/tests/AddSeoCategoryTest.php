<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 9:21 AM
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

class AddSeoCategoryTest extends \PHPUnit_Framework_TestCase
{

    private $stub;

    private $admin;

    private $existing_categories;

    protected function setUp(){

        $seo_category = new Category();

        $seo_category->setCategoryName("SEO");
        $this->existing_categories = new ArrayCollection();

        $this->existing_categories->add($seo_category);


        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(SeoCategoryResource::class);


        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-20 13:01:00");


        $this->stub
            ->expects($this->any())
            ->method('addCategory')
            ->will($this->returnCallback(function($category, $admin) use ($dateCreated){

                if(empty($category) || empty($category->getCategoryName())){
                    throw new InvalidCategoryException();
                }

                if(empty($admin)){
                    throw new \Exception("Admin is required");
                }


                $criteria = Criteria::create()
                    ->where(Criteria::expr()->eq("categoryName", $category->getCategoryName()));

                $found_categories = $this->existing_categories->matching($criteria);

                if(count($found_categories) > 0){
                    throw new SeoCategoryAlreadyAddedException();
                }

                $this->existing_categories->add($category);

                $historyChanges = "added category <font color=#FF0000>[" . $category->getCategoryName() . "]</font>";

                $this->createSeoCategoryHistory($admin, $historyChanges, $dateCreated);



                return [
                    "success" => true
                ];
            }));

    }


    public function testAddEmptyCategory(){

        $this->expectException(InvalidCategoryException::class);


        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");



        $this->stub->addCategory(new Category(), $this->admin);

    }


    /**
     * @param Admin $admin
     * @return Admin
     */
    public function testAddWebDevelopmentCategory(){


        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");


        $new_web_dev_category = new Category();
        $new_web_dev_category->setCategoryName("Web Development");


        $this->stub->addCategory($new_web_dev_category, $this->admin);

        /**
         * @var Category $added_category
         */
        $added_category = $this->existing_categories->last();

        $this->assertEquals(
            $added_category->getCategoryName(),
            $new_web_dev_category->getCategoryName()
        );

        return $this->admin;

    }

    /**
     * @depends testAddWebDevelopmentCategory
     * @param Admin $admin
     * @return Admin
     */
    public function testHasSeoCategoryHistoryWebDevelopmentCategoryAdded(Admin $admin){


        $this->admin = $admin;

        $last_history = $this->admin->getSeoCategoryHistory()->last();


        $this->assertEquals(
            "added category <font color=#FF0000>[Web Development]</font>",
            $last_history->getChanges()
        );


        return $admin;

    }


    /**
     * @depends testHasSeoCategoryHistoryWebDevelopmentCategoryAdded
     * @param Admin $admin
     * @return Admin
     */
    public function testAddWebDevCategoryAgain(Admin $admin){
        $this->admin = $admin;


        $this->expectException(SeoCategoryAlreadyAddedException::class);


        //mock adding of previous Web Development category
        $category = new Category();
        $category->setCategoryName("Web Development");

        $this->existing_categories->add($category);

        $new_web_dev_category = new Category();
        $new_web_dev_category->setCategoryName("Web Development");



        $this->stub->addCategory($new_web_dev_category, $this->admin);

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