<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/9/2016
 * Time: 9:30 AM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\CategorizedEntry;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Entities\SubCategory;
use RemoteStaff\Exceptions\MissingCategorizationEntriesException;
use RemoteStaff\Resources\CategorizedResource;

class AddCategoryTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Test if Recruiter has candiddate
     * @return Personal
     */
    public function testRecruiterHasCandidate(){
        //Create Candidate
        $candidate = new Personal();

        $candidate->setUserid(82933);
        $candidate->setFirstName("Lara Maricon");
        $candidate->setLastName("Sala");

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

        $this->assertEquals($candidate->getActiveRecruiter()->getId(), $recruiter->getId());
        return $candidate;
    }


    /**
     * @depends testRecruiterHasCandidate
     * @param Personal $candidate
     * @return Personal
     */
    public function testProceedToStepThreeButtonClicked(Personal $candidate){

        $this->expectException(MissingCategorizationEntriesException::class);
        // Create a stub for the SomeClass class.
        $stub = $this->createMock(CategorizedResource::class);

        // Configure the stub.
        $categories = [];

        if(empty($categories)){
            $stub
                ->expects($this->any())
                ->method('proceedToStepThree')
                ->will($this->throwException(new \RemoteStaff\Exceptions\MissingCategorizationEntriesException));

            $stub->proceedToStepThree([]);
        }




        return $candidate;
    }

    /**
     * @depends testRecruiterHasCandidate
     * @param Personal $candidate
     */
    public function testAddThreeCategories(Personal $candidate){
        $recruiter = $candidate->getActiveRecruiter();



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
        $email_categorization->setSubCategory($email_support_category);
        $email_categorization->setRatings(1);
        $email_categorization->setDateCreated($dateCreated);

        $historyChange = "<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>" . $email_support_category->getSubCategoryName() . "</span> with display status initially set to <span style='color:#ff0000'>NO</span>";
        $this->createStaffHistory($candidate, $recruiter, $historyChange, $dateCreated);


        $chat_categorization = new CategorizedEntry();
        $chat_categorization->setSubCategory($chat_support_category);
        $chat_categorization->setRatings(1);
        $chat_categorization->setDateCreated($dateCreated);

        $historyChange = "<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>" . $chat_support_category->getSubCategoryName() . "</span> with display status initially set to <span style='color:#ff0000'>NO</span>";
        $this->createStaffHistory($candidate, $recruiter, $historyChange, $dateCreated);


        $data_entry_categorization = new CategorizedEntry();
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
     * @depends testAddThreeCategories
     * @param Personal $candidate
     * @return Personal
     */
    public function testCandidateHasCategorizedStaffHistory(Personal $candidate){


        $email_history = $candidate->getStaffHistory()->first();
        $this->assertEquals("<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>Email Support</span> with display status initially set to <span style='color:#ff0000'>NO</span>", $email_history->getChanges());

        $chat_history = $candidate->getStaffHistory()->next();
        $this->assertEquals("<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>Chat Support</span> with display status initially set to <span style='color:#ff0000'>NO</span>", $chat_history->getChanges());


        $data_entry_history = $candidate->getStaffHistory()->next();
        $this->assertEquals("<span style='color:#ff0000'>Added</span> in the ASL List under <span style='color:#ff0000'>Data Entry</span> with display status initially set to <span style='color:#ff0000'>NO</span>", $data_entry_history->getChanges());


        return $candidate;
    }


    /**
     * @depends testCandidateHasCategorizedStaffHistory
     * @param Personal $candidate
     */
    public function testDatesCategorized(Personal $candidate){
        $email_category_date_created_str = $candidate->getCategorizedEntries()->first()->getDateCreated()->format("Y-m-d H:i:s");

        $chat_category_date_created_str = $candidate->getCategorizedEntries()->next()->getDateCreated()->format("Y-m-d H:i:s");

        $data_entry_date_created_str = $candidate->getCategorizedEntries()->next()->getDateCreated()->format("Y-m-d H:i:s");


        $date_to_evaluate = "2016-08-18 13:00:00";

        $this->assertEquals($email_category_date_created_str, $date_to_evaluate);

        $this->assertEquals($chat_category_date_created_str, $date_to_evaluate);

        $this->assertEquals($data_entry_date_created_str, $date_to_evaluate);

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