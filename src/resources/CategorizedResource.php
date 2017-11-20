<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/9/2016
 * Time: 1:42 PM
 */

namespace RemoteStaff\Resources;


use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Exceptions\CandidateDoesNotExistsException;
use RemoteStaff\Exceptions\CategoryAlreadyAddedException;
use RemoteStaff\Exceptions\MissingCategorizationEntriesException;
use RemoteStaff\Entities\CategorizedEntry;
use RemoteStaff\Entities\SubCategory;
use RemoteStaff\Entities\Category;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

class CategorizedResource extends AbstractResource
{

    /**
     * @param $entry_id
     * @return CategorizedEntry
     * @throws \Exception
     */
    public function getJobSubCategoryEntry($entry_id){
        if($entry_id === null){
            throw new \Exception("Job Sub Category Entry ID is required.");
        }

        $entry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\CategorizedEntry')->find($entry_id);

        return $entry;
    }

    /**
     * @param $sub_category_id
     * @return RemoteStaff\Entities\SubCategory
     * @throws \Exception
     */
    public function getSubCategory($sub_category_id){
        if($sub_category_id === null){
            throw new \Exception("Sub Category ID is required.");
        }

        $sub_category = $this->getEntityManager()->getRepository('RemoteStaff\Entities\SubCategory')->find($sub_category_id);

        return $sub_category;
    }


    /**
     * @return mixed
     */
    public function getAllCategories(){


        $em = $this->getEntityManager();

        //$query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Category c WHERE c.status = :category_status ORDER BY c.category_name ASC');
        $query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Category c ORDER BY c.categoryName ASC');

        //$query->setParameter('category_status', "posted");

        $categories = $query->getResult();
        return $categories;
    }


    /**
     * @param $name
     * @return mixed
     */
    public function getCategoryByName($name){
        $em = $this->getEntityManager();

        //$query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Category c WHERE c.status = :category_status ORDER BY c.category_name ASC');
        $query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Category c WHERE c.categoryName = :categoryName ORDER BY c.categoryName ASC');

        $query->setParameter('categoryName', $name);

        $categories = $query->getResult();
        return $categories;
    }


    /**
     * returns a single object
     * @param $id
     * @return mixed
     */
    public function getCategoryById($id){
//        $em = $this->getEntityManager();
//
//        //$query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Category c WHERE c.status = :category_status ORDER BY c.category_name ASC');
//        $query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Category c WHERE c.id = :categoryId ORDER BY c.categoryName ASC');
//
//        $query->setParameter('categoryId', $id);
//
//        $categories = $query->getResult();
//        return $categories;



        if($id === null){
            throw new \Exception("Category ID is required.");
        }

        $category = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Category')->find($id);

        return $category;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function getSubCategoryByName($name){
        $em = $this->getEntityManager();

        //$query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Category c WHERE c.status = :category_status ORDER BY c.category_name ASC');
        $query = $em->createQuery('SELECT s FROM RemoteStaff\Entities\SubCategory s WHERE s.subCategoryName = :subCategoryName ORDER BY s.subCategoryName ASC');

        $query->setParameter('subCategoryName', $name);

        $subCategories = $query->getResult();
        return $subCategories;
    }




    /**
     * @param $request
     * @return array
     * @throws CandidateDoesNotExistsException
     * @throws MissingCategorizationEntriesException
     * @throws \Exception
     */
    public function proceedToStepThree($request){

        if(!isset($request["candidate_id"])){
            throw new \Exception("candidate_id is requried!");
        }

        if(!isset($request["recruiter_id"])){
            throw new \Exception("recruiter_id is required!");
        }

        if(!isset($request["to_be_deleted"])){
            throw new \Exception("to_be_deleted is required!");
        }


        if(count($request["sub_categories"]) <= 0 || !isset($request["sub_categories"])){
            throw new MissingCategorizationEntriesException();
        }

        $mysql_resource = new CandidateResource();

        $mysql_resource->setEntityManager($this->getEntityManager());

        $candidate_mysql = $mysql_resource->get($request["candidate_id"]);


        if(empty($candidate_mysql)){

            throw new CandidateDoesNotExistsException();
        }




        $admin_resource = new AdminResource();
        $mysql_resource = new CandidateResource();

        $admin_resource->setEntityManager($this->getEntityManager());
        $mysql_resource->setEntityManager($this->getEntityManager());


        $candidate_mysql = $mysql_resource->get($request["candidate_id"]);
        $recruiter_mysql = $admin_resource->get($request["recruiter_id"]);


        $result = array();


        foreach ($request["sub_categories"] as $sub_category) {
            try{
                if($sub_category["id"] === null){
                    $response = $this->addCandidateToCategorized($sub_category, $candidate_mysql, $recruiter_mysql);

                    $result[] = $response;
                } else{
                    $response = $this->updateCategories($sub_category, $candidate_mysql, $recruiter_mysql);

                    $result[] = $response;
                }
            } catch (\Exception $e){
                $result[] = array(
                    "sub_category" => $sub_category,
                    "error" => $e->getMessage(),
                    "success" => false
                );
            }
        }


        foreach ($request["to_be_deleted"] as $item) {
            try{
                if($item["entry_id"] !== null){
                    $result[] = $this->deleteCandidateCategory($item, $candidate_mysql, $recruiter_mysql);
                }
            } catch (\Exception $e){
                $result[] = array(
                    "entry" => $item,
                    "error" => $e->getTraceAsString(),
                    "error_message" => $e->getMessage(),
                    "success" => false
                );
            }
        }

        $this->getEntityManager()->flush();

        $success_found = false;

        foreach ($result as $key => $item) {
            if(isset($item["new_job_sub_category_applicants"])){
                $item["new_job_sub_category_applicants_id"] =  $item["new_job_sub_category_applicants"]->getId();
                $item["new_job_sub_category_id"] = $item["new_job_sub_category_applicants"]->getSubCategory()->getId();
                $result[$key] = $item;
            }

            if($item["success"]){
                if(!$success_found){
                    $success_found = true;
                }
            }

        }

        return array(
            "success" => $success_found,
            "result" => $result
        );
    }


    /**
     * @param $sub_category_info
     * @param Personal $candidate_mysql
     * @param Admin $recruiter_mysql
     * @return array
     * @throws CategoryAlreadyAddedException
     */
    protected function addCandidateToCategorized($sub_category_info, Personal $candidate_mysql, Admin $recruiter_mysql){


        /**
         * @var SubCategory $sub_category_mysql
         */
        $sub_category_mysql = $this->getSubCategory($sub_category_info["sub_category_id"]);

        $new_entry = new CategorizedEntry();

        $new_entry->setCandidate($candidate_mysql);

        if($sub_category_info["to_show_ASL"]){
            $new_entry->setRatings(0);
        } else{
            $new_entry->setRatings(1);
        }

        $new_entry->setDateCreated(new \DateTime());
        $new_entry->setCategorizedBy($recruiter_mysql);
        $new_entry->setSubCategory($sub_category_mysql);

        $new_entry->setCategory($sub_category_mysql->getCategory());

        $added = $candidate_mysql->addCategorizedEntry($new_entry);

        $candidate_mysql->setDateUpdated(new \DateTime());

        if(empty($added)){
            throw new CategoryAlreadyAddedException();
        }

        $this->getEntityManager()->persist($candidate_mysql);

        $this->getEntityManager()->persist($new_entry);

        $this->getEntityManager()->persist($candidate_mysql);

        $historyChanges = "<font color=#FF0000>Added</font> in the ASL List under <font color=#FF0000>" . $sub_category_mysql->getSubCategoryName() . "</font> with display status initially set to <font color=#FF0000>NO</font>";

        $this->createStaffHistory($candidate_mysql, $recruiter_mysql, $historyChanges);

        return array(
            "new_job_sub_category_applicants" => $new_entry,
            "success" => true
        );

    }

    /**
     * @param $entry_info
     * @param Personal $candidate_mysql
     * @param Admin $recruiter_mysql
     * @return array
     * @throws \Exception
     */
    protected function updateCategories($entry_info, Personal $candidate_mysql, Admin $recruiter_mysql){
        /**
         * @var CategorizedEntry $existing_entry
         */
        $existing_entry = $this->getJobSubCategoryEntry($entry_info["id"]);

        $updated_rating = 1;

        $historyChanges = "<font color=#FF0000>Removed</font> in the ASL List under <font color=#FF0000>" . $existing_entry->getSubCategory()->getSubCategoryName() . "</font>";

        if($entry_info["to_show_ASL"]){
            $updated_rating = 0;
            $historyChanges = "<font color=#FF0000>Displayed</font> in the ASL List under <font color=#FF0000>" . $existing_entry->getSubCategory()->getSubCategoryName() . "</font>";
        }

        if($existing_entry->getRatings() == $updated_rating){
            throw new \Exception("No Changes were made");
        }

        $existing_entry->setRatings($updated_rating);


        $candidate_mysql->setDateUpdated(new \DateTime());


        $this->getEntityManager()->persist($existing_entry);



        $this->createStaffHistory($candidate_mysql, $recruiter_mysql, $historyChanges);

        $this->getEntityManager()->persist($candidate_mysql);





        return array(
            "updated_record_id" => $existing_entry->getId(),
            "updated_record_ratings" => $existing_entry->getRatings(),
            "success" => true
        );

    }


    /**
     * @param $entry_info
     * @param Personal $candidate_mysql
     * @param Admin $recruiter_mysql
     * @return array
     * @throws \Exception
     */
    protected function deleteCandidateCategory($entry_info, Personal $candidate_mysql, Admin $recruiter_mysql){

        $criteria = Criteria::create()
            ->where(Criteria::expr()->eq("id", $entry_info["entry_id"]));


        $existing_entries = $candidate_mysql->getCategorizedEntries()->matching(
            $criteria
        );


        if($existing_entries->count() <= 0){
            throw new \Exception("Category Entry does not exist!");
        }

        $existing_entry = null;

        foreach ($existing_entries as $existing_entry_temp) {
            $existing_entry = $existing_entry_temp;
        }

        $historyChanges = '<font color=#FF0000>Removed</font> in the ASL List under <font color=#FF0000>' . $existing_entry->getSubCategory()->getSubCategoryName() . '</font>';


        $this->createStaffHistory($candidate_mysql, $recruiter_mysql, $historyChanges);




        $historyChanges = 'Deleted category under  <font color=#FF0000>' . $existing_entry->getSubCategory()->getSubCategoryName() . '</font>';


        $this->createStaffHistory($candidate_mysql, $recruiter_mysql, $historyChanges);

        $this->getEntityManager()->remove($existing_entry);

        $candidate_mysql->setDateUpdated(new \DateTime());

        $this->getEntityManager()->persist($candidate_mysql);

        return array(
            "deteled_record_id" => $entry_info["entry_id"],
            "deleted_record_rating" => $existing_entry->getRatings(),
            "success" => true
        );



    }






}