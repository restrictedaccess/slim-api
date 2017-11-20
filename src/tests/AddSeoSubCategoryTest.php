<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 5:13 PM
 */

namespace RemoteStaff\Tests;



use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Category;
use RemoteStaff\Entities\SubCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use RemoteStaff\Entities\SeoCategoryHistory;
use RemoteStaff\Exceptions\CategoryAlreadyAddedException;
use RemoteStaff\Exceptions\InvalidCategoryException;
use RemoteStaff\Exceptions\InvalidSubCategoryException;
use RemoteStaff\Exceptions\SeoCategoryAlreadyAddedException;
use RemoteStaff\Exceptions\SeoSubCategoryAlreadyAddedException;
use RemoteStaff\Resources\SeoCategoryResource;

class AddSeoSubCategoryTest extends \PHPUnit_Framework_TestCase
{

    private $stub;

    private $admin;

    private $existing_sub_categories;

    protected function setUp(){


        $this->existing_sub_categories = new ArrayCollection();


        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(SeoCategoryResource::class);


        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-20 13:02:00");


        $this->stub
            ->expects($this->any())
            ->method('addSubCategory')
            ->will($this->returnCallback(function($sub_category, $admin) use ($dateCreated){
                if(empty($sub_category) || empty($sub_category->getSubCategoryName())){
                    throw new InvalidSubCategoryException();
                }

                if(empty($admin)){
                    throw new \Exception("Admin is required");
                }


                $criteria = Criteria::create()
                    ->where(Criteria::expr()->eq("subCategoryName", $sub_category->getSubCategoryName()));

                $found_categories = $this->existing_sub_categories->matching($criteria);

                if(count($found_categories) > 0){
                    throw new SeoSubCategoryAlreadyAddedException();
                }

                $this->existing_sub_categories->add($sub_category);

                $historyChanges = "added sub category <font color=#FF0000>[" . $sub_category->getSubCategoryName() . "]</font>";

                $this->createSeoCategoryHistory($admin, $historyChanges, $dateCreated);



                return [
                    "success" => true
                ];
            }));
    }




    public function testEmptySubCategoryDetails(){
        $this->expectException(InvalidSubCategoryException::class);


        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");

        $this->stub->addSubCategory(new SubCategory(), $this->admin);
    }



    public function testPhpDevWithDetails(){

        $this->admin = new Admin();

        $this->admin->setId(371);
        $this->admin->setFirstName("David Marlon");
        $this->admin->setLastName("Perez");


        $new_sub_category = new SubCategory();
        $new_sub_category->setSubCategoryName("PHP Development");

        $this->stub->addSubCategory($new_sub_category, $this->admin);


        $last_category = $this->existing_sub_categories->last();

        $this->assertEquals(
            $new_sub_category->getSubCategoryName(),
            $last_category->getSubCategoryName()
        );

        return $this->admin;
    }


    /**
     * @depends testPhpDevWithDetails
     * @param Admin $admin
     * @return Admin
     */
    public function testHasSeoHistoryAddPhpDevSubCategoryAdded(Admin $admin){
        $last_history = $admin->getSeoCategoryHistory()->last();

        $this->assertEquals(
            "added sub category <font color=#FF0000>[PHP Development]</font>",
            $last_history->getChanges()
        );

        return $admin;
    }


    /**
     * @depends testHasSeoHistoryAddPhpDevSubCategoryAdded
     * @param Admin $admin
     */
    public function testPhpDevSubAddedAggain(Admin $admin){

        $this->expectException(SeoSubCategoryAlreadyAddedException::class);

        $existing_sub_category = new SubCategory();
        $existing_sub_category->setSubCategoryName("PHP Development");

        $this->existing_sub_categories->add($existing_sub_category);


        $new_sub_category = new SubCategory();
        $new_sub_category->setSubCategoryName("PHP Development");


        $this->stub->addSubCategory($new_sub_category, $admin);

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