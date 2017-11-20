<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 10:28 AM
 */

namespace RemoteStaff\Resources;




use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\SeoCategoryHistory;
use RemoteStaff\Exceptions\CandidateDoesNotExistsException;
use RemoteStaff\Exceptions\CategoryAlreadyAddedException;
use RemoteStaff\Exceptions\InvalidCategoryException;
use RemoteStaff\Exceptions\InvalidSubCategoryException;
use RemoteStaff\Exceptions\MissingCategorizationEntriesException;
use RemoteStaff\Entities\CategorizedEntry;
use RemoteStaff\Entities\SubCategory;
use RemoteStaff\Entities\Category;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use RemoteStaff\Exceptions\SeoSubCategoryAlreadyAddedException;

class SeoCategoryResource extends AbstractResource
{

    /**
     * @param Category $category
     * @param Admin $admin
     * @return array
     * @throws InvalidCategoryException
     * @throws \Exception
     */
    public function addCategory(Category $category, Admin $admin){
        if(empty($category) || empty($category->getCategoryName())){
            throw new InvalidCategoryException();
        }

        if(empty($admin)){
            throw new \Exception("Admin is required");
        }

        $categorizedResource = new CategorizedResource();

        $categorizedResource->setEntityManager($this->getEntityManager());

        $found_categories = $categorizedResource->getCategoryByName($category->getCategoryName());


//        $criteria = Criteria::create()
//            ->where(Criteria::expr()->eq("categoryName", $category->getCategoryName()));
//
//        $found_categories = $this->existing_categories->matching($criteria);

        if(count($found_categories) > 0){
            throw new \Exception("Category already added!");
        }

        //$this->existing_categories->add($category);

        $this->getEntityManager()->persist($category);


        $historyChanges = "added category <font color=#FF0000>[" . $category->getCategoryName() . "]</font>";

        $this->createSeoCategoryHistory($admin, $historyChanges);

        $this->getEntityManager()->persist($admin);


        $this->getEntityManager()->flush();

        return [
            "category_added" => $category->toArray(),
            "success" => true
        ];
    }


    /**
     * @param SubCategory $sub_category
     * @param Admin $admin
     * @return array
     * @throws InvalidSubCategoryException
     * @throws SeoSubCategoryAlreadyAddedException
     * @throws \Exception
     */
    public function addSubCategory(SubCategory $sub_category, Admin $admin){
        if(empty($sub_category) || empty($sub_category->getSubCategoryName())){
            throw new InvalidSubCategoryException();
        }

        if(empty($admin)){
            throw new \Exception("Admin is required");
        }


        $categorizedResource = new CategorizedResource();

        $categorizedResource->setEntityManager($this->getEntityManager());

        $found_sub_categories = $categorizedResource->getSubCategoryByName($sub_category->getSubCategoryName());


//        $criteria = Criteria::create()
//            ->where(Criteria::expr()->eq("subCategoryName", $sub_category->getSubCategoryName()));
//
//        $found_categories = $this->existing_sub_categories->matching($criteria);

        if(count($found_sub_categories) > 0){
            throw new SeoSubCategoryAlreadyAddedException();
        }

        //$this->existing_sub_categories->add($sub_category);

        $this->getEntityManager()->persist($sub_category);


        $historyChanges = "added sub category <font color=#FF0000>[" . $sub_category->getSubCategoryName() . "]</font>";

        $this->createSeoCategoryHistory($admin, $historyChanges, $dateCreated);


        $this->getEntityManager()->persist($admin);

        $this->getEntityManager()->flush();



        return [
            "success" => true,
            "sub_category_added" => $sub_category->toArray()
        ];
    }


    /**
     * @param $category_details
     * @param Admin $admin
     * @return array
     * @throws InvalidCategoryException
     * @throws \Exception
     */
    public function updateCategory($category_details, Admin $admin){
        if(empty($category_details) || empty($category_details["category_name"])){
            throw new InvalidCategoryException();
        }

        if(empty($admin)){
            throw new \Exception("Admin is required");
        }




        $categorizedResource = new CategorizedResource();

        $categorizedResource->setEntityManager($this->getEntityManager());
        /**
            * @var Category $existing_category
         */
        //$existing_category_arrays =

        $existing_category = $categorizedResource->getCategoryById($category_details["category_id"]);

//        foreach ($existing_category_arrays as $existing_category_array) {
//            $existing_category = $existing_category_array;
//        }


        if(empty($existing_category)){
            throw new InvalidCategoryException();
        }

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

        $this->getEntityManager()->persist($existing_category);




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

        $this->getEntityManager()->persist($admin);

        $this->getEntityManager()->flush();

        return [
            "success" => true,
            "updated_category" => $existing_category->toArray()
        ];
    }


    /**
     * @param $sub_category_details
     * @param Admin $admin
     * @return array
     * @throws InvalidSubCategoryException
     * @throws \Exception
     */
    public function updateSubCategory($sub_category_details, Admin $admin){

        if(empty($sub_category_details) || empty($sub_category_details["sub_category_name"])){
            throw new InvalidSubCategoryException();
        }

        if(empty($admin)){
            throw new \Exception("Admin is required");
        }




        $categorizedResource = new CategorizedResource();

        $categorizedResource->setEntityManager($this->getEntityManager());


        /**
         * @var SubCategory $existing_sub_category
         */
        $existing_sub_category = $categorizedResource->getSubCategory($sub_category_details["sub_category_id"]);




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
            "category" => ""
        ];


        if(!empty($existing_sub_category->getCategory())){
            $old_record["category"] = $existing_sub_category->getCategory()->getCategoryName();
        }


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


        $current_category = $categorizedResource->getCategoryById($sub_category_details["category"]["category_id"]);


        $existing_sub_category->setCategory($current_category);
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

        $this->getEntityManager()->persist($existing_sub_category);

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

        $this->getEntityManager()->persist($admin);

        $this->getEntityManager()->flush();

        return [
            "success" => true,
            "updated_sub_category" => $existing_sub_category->toArray()
        ];
    }


    /**
     * @param Admin $admin
     * @param $historyChanges
     * @return SeoCategoryHistory
     */
    public function createSeoCategoryHistory(Admin $admin, $historyChanges){

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

        $seoHistory->setDateCreated(new \DateTime());

        $seoHistory->setChangedByType($admin_type);

        if($admin->getSeoCategoryHistory() == null){
            $admin->setSeoCategoryHistory(new ArrayCollection());
        }

        $admin->getSeoCategoryHistory()->add($seoHistory);



        return $seoHistory;
    }
}