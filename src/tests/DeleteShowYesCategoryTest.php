<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/9/2016
 * Time: 12:47 PM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\CategorizedEntry;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Entities\SubCategory;
use Doctrine\Common\Collections\Criteria;

class DeleteCategoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test if candidate has 3 categories
     * @return Personal
     */
    public function testCandidateHasThreeCategories(){
        //Create Candidate
        $candidate = new Personal();

        $candidate->setUserid(82933);
        $candidate->setFirstName("Lara Maricon");
        $candidate->setLastName("Sala");
        $candidate->setEmail("laramariconsala@yahoo.com");


        //Create Recruiter
        $recruiter = new Admin();

        $recruiter->setStatus("HR");
        $recruiter->setId(167);
        $recruiter->setFirstName("Honeylyn");
        $recruiter->setLastName("Lapidario");

        //Create RecruiterStaff
        $recruiterStaff = new RecruiterStaff();

        $recruiterStaff->setCandidate($candidate);
        $recruiterStaff->setRecruiter($recruiter);




        $candidate->getRecruiterStaff()->add($recruiterStaff);
        $recruiter->getRecruiterStaff()->add($recruiterStaff);


        //Create categories
        $email_support_category = new SubCategory();
        $email_support_category->setId(350);
        $email_support_category->setSubCategoryName("Email Support");

        $chat_support_category = new SubCategory();
        $chat_support_category->setId(179);
        $chat_support_category->setSubCategoryName("Chat Support");

        $data_entry_category = new SubCategory();
        $data_entry_category->setId(178);
        $data_entry_category->setSubCategoryName("Data Entry");

        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-08-18 13:00:00");

        $email_categorization = new CategorizedEntry();
        $email_categorization->setId(1234);
        $email_categorization->setSubCategory($email_support_category);
        $email_categorization->setRatings(1);
        $email_categorization->setDateCreated($dateCreated);

        $historyChange = "<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>" . $email_support_category->getSubCategoryName() . "</span> with display status initially set to <span style='color:#ff0000'>NO</span>";
        $this->createStaffHistory($candidate, $recruiter, $historyChange, $dateCreated);


        $chat_categorization = new CategorizedEntry();
        $chat_categorization->setId(1235);
        $chat_categorization->setSubCategory($chat_support_category);
        $chat_categorization->setRatings(1);
        $chat_categorization->setDateCreated($dateCreated);

        $historyChange = "<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>" . $chat_support_category->getSubCategoryName() . "</span> with display status initially set to <span style='color:#ff0000'>NO</span>";
        $this->createStaffHistory($candidate, $recruiter, $historyChange, $dateCreated);


        $data_entry_categorization = new CategorizedEntry();
        $data_entry_categorization->setId(1236);
        $data_entry_categorization->setSubCategory($data_entry_category);
        $data_entry_categorization->setRatings(1);
        $data_entry_categorization->setDateCreated($dateCreated);

        $historyChange = "<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>" . $data_entry_category->getSubCategoryName() . "</span> with display status initially set to <span style='color:#ff0000'>NO</span>";
        $this->createStaffHistory($candidate, $recruiter, $historyChange, $dateCreated);



        $candidate->addCategorizedEntry($email_categorization);
        $candidate->addCategorizedEntry($chat_categorization);
        $candidate->addCategorizedEntry($data_entry_categorization);



        $this->assertEquals(3, $candidate->getCategorizedEntries()->count());


        return $candidate;
    }


    /**
     * @depends testCandidateHasThreeCategories
     * @param Personal $candidate
     * @return Personal
     */
    public function testRemoveEmailSupport(Personal $candidate){
        $email_support_category = new SubCategory();
        $email_support_category->setId(350);
        $email_support_category->setSubCategoryName("Email Support");


        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-08-19 14:00:00");

        $entry = new CategorizedEntry();
        $entry->setId(1234);
        $entry->setSubCategory($email_support_category);



        $candidate->removeCategorizedEntry($entry);


        $historyChange = "<span style='color:#ff0000'>Removed</span> in the ASL List under <span style='color:#ff0000'>" . $email_support_category->getSubCategoryName() . "</span>";

        $this->createStaffHistory($candidate, $candidate->getActiveRecruiter(), $historyChange, $dateCreated);

        $this->assertEquals(2, $candidate->getCategorizedEntries()->count());

        return $candidate;
    }


    /**
     * @depends testRemoveEmailSupport
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasRemoveEmailSupportHistory(Personal $candidate){

        $last_history = $candidate->getStaffHistory()->last();

        $this->assertEquals("<span style='color:#ff0000'>Removed</span> in the ASL List under <span style='color:#ff0000'>Email Support</span>", $last_history->getChanges());

        return $candidate;
    }


    /**
     * @depends testHasRemoveEmailSupportHistory
     * @param Personal $candidate
     * @return Personal
     */
    public function testSetChatSupportToYesASl(Personal $candidate){

        $categories = $candidate->getCategorizedEntries();

        $entry_id = 1235;
        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-08-19 14:00:00");

        /**
         * @var CategorizedEntry $chat_support_entry
         */
        $chat_support_entry = null;


        foreach ($categories as $category) {
            if($category->getId() === $entry_id){
                $chat_support_entry = $category;
                break;
            }
        }
        $chat_support_entry->setRatings(0);

        //<span style='color:#ff0000'>Displayed</span> in the ASL List under <span style='color:#ff0000'>PHP Developers</span>

        $historyChange = "<span style='color:#ff0000'>Displayed</span> in the ASL List under <span style='color:#ff0000'>" . $chat_support_entry->getSubCategory()->getSubCategoryName() . "</span>";

        $this->createStaffHistory($candidate, $candidate->getActiveRecruiter(), $historyChange, $dateCreated);

        $current_chat_entry = null;

        foreach ($categories as $category) {
            if($category->getId() === $entry_id){
                $current_chat_entry = $category;
            }
        }

        $this->assertEquals(0, $current_chat_entry->getRatings());

        return $candidate;
    }


    /**
     * @depends testSetChatSupportToYesASl
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasASLShownHistory(Personal $candidate){
        $latest_history = $candidate->getStaffHistory()->last();


        $this->assertEquals(
            "<span style='color:#ff0000'>Displayed</span> in the ASL List under <span style='color:#ff0000'>Chat Support</span>",
            $latest_history->getChanges()
        );

        return $candidate;
    }




    /**
     * Create Staff History for created Resume
     * @param Personal $candidate
     * @param Admin $recruiter
     * @return StaffHistory
     */
    public function createStaffHistory(Personal $candidate, Admin $recruiter, $historyChanges, \DateTime $dateCreated){
        $staffHistory = new StaffHistory();
        $staffHistory->setCandidate($candidate);
        $staffHistory->setChangedBy($recruiter);
        $staffHistory->setChanges($historyChanges);
        $admin_status = $recruiter->getStatus();
        $admin_type = $admin_status;
        if($admin_type == "FULL-CONTROL"){
            $admin_type = "ADMIN";
        }

        if($admin_type == null){
            $admin_type = "HR";
        }
        $staffHistory->setType($admin_type);
        if(isset($dateCreated)){
            $staffHistory->setDateCreated($dateCreated);
        } else{
            $staffHistory->setDateCreated(new \DateTime());
        }

        if($candidate->getStaffHistory() == null){
            $candidate->setStaffHistory(new ArrayCollection());
        }

        if($recruiter->getStaffHistory() == null){
            $recruiter->setStaffHistory(new ArrayCollection());
        }

        $candidate->getStaffHistory()->add($staffHistory);
        $recruiter->getStaffHistory()->add($staffHistory);
        return $staffHistory;
    }


}