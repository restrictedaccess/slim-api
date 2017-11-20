<?php

namespace RemoteStaff\Tests;

use RemoteStaff\Entities\Personal;
use RemoteStaff\Exceptions\InvalidArgumentException;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;

/**
 * This class is used to test adding and updating personal information
 * @refer TC_DISPLAY_OF_ASL_CANDIDATES
 * Class PersonalInformationTest
 * @package RemoteStaff\Tests
 */
class PersonalInformationTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \RemoteStaff\Entities\Personal
     */
    private $jocelyn;
    /**
     * @var \RemoteStaff\Entities\Admin
     */
    private $honeylyn;

    protected function setUp(){

        $candidate = new Personal();
        $candidate->setUserid(119569 );
        $candidate->setFirstName('Jocelyn');
        $candidate->setLastName('Gudmalin');

        $recruiter = new Admin();
        $recruiter->setFirstName("Honeylyn");
        $recruiter->setLastName("Lapidario");

        $this->jocelyn = $candidate;
        $this->honeylyn = $recruiter;
    }

    /**
    * SCENARIO 1
    * TEST STEP 1 add personal information
    */
    public function testAddPersonalInfo(){
        $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn; 

        $jocelyn->setGender("Female");
        $jocelyn->setNationality("Philippines");
        $jocelyn->setPermanentAddress("Philippines");
        $jocelyn->setBirthDateYear(1995);
        $jocelyn->setBirthDateMonth(2);
        $jocelyn->setBirthDateDay(16);
        $jocelyn->setDateUpdated(new \DateTime());

        $historyChanges = "Candidate's Personal Information Saved!";
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);

        $this->assertEquals($jocelyn->getGender(), 'Female');
        $this->assertEquals($jocelyn->getNationality(), 'Philippines');
        $this->assertEquals($jocelyn->getPermanentAddress(), 'Philippines');
        $this->assertEquals($jocelyn->getBirthDateYear(), 1995);
        $this->assertEquals($jocelyn->getBirthDateMonth(), 2);
        $this->assertEquals($jocelyn->getBirthDateDay(), 16);

        return $jocelyn;
    }

    /**
    * SCENARIO 1
    * TEST STEP 2 Remove Candidate personal information and save
    * @depends testAddPersonalInfo
    */
    public function testRemovePersonalInfo(Personal $jocelyn){
        $this->expectException(InvalidArgumentException::class);
        $honeylyn = $this->honeylyn; 

        $jocelyn->setGender("");
        $jocelyn->setNationality("");
        $jocelyn->setPermanentAddress("");
        $jocelyn->setBirthDateYear(null);
        $jocelyn->setBirthDateMonth(null);
        $jocelyn->setBirthDateDay(null);

        $this->assertEquals($jocelyn->getGender(), '');
        $this->assertEquals($jocelyn->getNationality(), '');
        $this->assertEquals($jocelyn->getPermanentAddress(), '');
        $this->assertEquals($jocelyn->getBirthDateYear(), null);
        $this->assertEquals($jocelyn->getBirthDateMonth(), null);
        $this->assertEquals($jocelyn->getBirthDateDay(), null);

        return $jocelyn;
    }
   

   /**
    * SCENARIO 2
    * TEST STEP 3 Add Candidate personal information

    */
    public function testAddPersonalInfoWithGenderNull(){
        // $this->expectException(InvalidArgumentException::class);
        $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn; 

        $jocelyn->setGender(null);
        $jocelyn->setBirthDateYear(1995);
        $jocelyn->setBirthDateMonth(2);
        $jocelyn->setBirthDateDay(16);
        $jocelyn->setNationality("Philippines");
        $jocelyn->setPermanentAddress("Philippines");

        $jocelyn->setDateUpdated(new \DateTime());

        $historyChanges = "Candidate's Personal Information Saved!";
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);

        $this->assertEquals($jocelyn->getGender(), null);
        $this->assertEquals($jocelyn->getBirthDateYear(), 1995);
        $this->assertEquals($jocelyn->getBirthDateMonth(), 2);
        $this->assertEquals($jocelyn->getBirthDateDay(), 16);
        $this->assertEquals($jocelyn->getNationality(), 'Philippines');
        $this->assertEquals($jocelyn->getPermanentAddress(), 'Philippines');

        return $jocelyn;
    }


    /**
    * SCENARIO 2
    * TEST STEP 4 Add Candidate personal information
    */


    /**
    * SCENARIO 3
    * TEST STEP 6 Add Candidate personal information
    */
    public function testAddPersonalInfoStep6(){
        $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn; 

        $jocelyn->setGender("Female");
        $jocelyn->setBirthDateYear(1995);
        $jocelyn->setBirthDateMonth(2);
        $jocelyn->setBirthDateDay(16);
        $jocelyn->setNationality("Philippines");
        $jocelyn->setPermanentAddress("Philippines");

        $jocelyn->setDateUpdated(new \DateTime());

        $historyChanges = "Candidate's Personal Information Saved!";
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);

        $this->assertEquals($jocelyn->getGender(), "Female");
        $this->assertEquals($jocelyn->getBirthDateYear(), 1995);
        $this->assertEquals($jocelyn->getBirthDateMonth(), 2);
        $this->assertEquals($jocelyn->getBirthDateDay(), 16);
        $this->assertEquals($jocelyn->getNationality(), 'Philippines');
        $this->assertEquals($jocelyn->getPermanentAddress(), 'Philippines');

        return $jocelyn;
    }

    /**
    * SCENARIO 3
    * TEST STEP 7 Remove Candidate personal information
    * @depends testAddPersonalInfoStep6
    */
    public function testRemovePersonalInfoStep7(Personal $jocelyn){
        $this->expectException(InvalidArgumentException::class);
        $honeylyn = $this->honeylyn; 

        $jocelyn->setGender("");
        $jocelyn->setNationality("");
        $jocelyn->setPermanentAddress("");
        $jocelyn->setBirthDateYear(null);
        $jocelyn->setBirthDateMonth(null);
        $jocelyn->setBirthDateDay(null);

        $this->assertEquals($jocelyn->getGender(), '');
        $this->assertEquals($jocelyn->getNationality(), '');
        $this->assertEquals($jocelyn->getPermanentAddress(), '');
        $this->assertEquals($jocelyn->getBirthDateYear(), null);
        $this->assertEquals($jocelyn->getBirthDateMonth(), null);
        $this->assertEquals($jocelyn->getBirthDateDay(), null);
    }

    /**
    * SCENARIO 3
    * TEST STEP 8 SKIPPED
    */

    /**
    * SCENARIO 3
    * TEST STEP 9 SKIPPED
    */

    //UPDATING PERSONAL INFORMATION
    /**
    * SCENARIO 1
    * TEST STEP 1 
    */
    public function testAddForUpdatePersonalInfo(){
        $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn; 

        $jocelyn->setGender("Female");
        $jocelyn->setBirthDateYear(1995);
        $jocelyn->setBirthDateMonth(2);
        $jocelyn->setBirthDateDay(16);
        $jocelyn->setNationality("Philippines");
        $jocelyn->setPermanentAddress("Philippines");

        $jocelyn->setDateUpdated(new \DateTime());

        $historyChanges = "Candidate's Personal Information Saved!";
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);

        $this->assertEquals($jocelyn->getGender(), "Female");
        $this->assertEquals($jocelyn->getBirthDateYear(), 1995);
        $this->assertEquals($jocelyn->getBirthDateMonth(), 2);
        $this->assertEquals($jocelyn->getBirthDateDay(), 16);
        $this->assertEquals($jocelyn->getNationality(), 'Philippines');
        $this->assertEquals($jocelyn->getPermanentAddress(), 'Philippines');

        return $jocelyn;
    }

    /**
    * SCENARIO 1
    * TEST STEP 2 Update personal information
    * @depends testAddForUpdatePersonalInfo
    */
    public function testUpdatePersonalInfo(Personal $jocelyn){
        // $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn;
        $personalInfo = [];
        $personalInfoToUpdate = [];
        $key = [
            "gender",
            "nationality",
            "permanentAddress",
            "year",
            "month",
            "day"
        ];

        $personalInfoToUpdate[$key[0]] = "Female";
        $personalInfoToUpdate[$key[1]] = "Philippines";
        $personalInfoToUpdate[$key[2]] = "Philippines";
        $personalInfoToUpdate[$key[3]] = 1993;
        $personalInfoToUpdate[$key[4]] = 10;
        $personalInfoToUpdate[$key[5]] = 10;

        $personalInfo[$key[0]] = $jocelyn->getGender();
        $personalInfo[$key[1]] = $jocelyn->getNationality();
        $personalInfo[$key[2]] = $jocelyn->getPermanentAddress();
        $personalInfo[$key[3]] = $jocelyn->getBirthDateYear();
        $personalInfo[$key[4]] = $jocelyn->getBirthDateMonth();
        $personalInfo[$key[5]] = $jocelyn->getBirthDateDay();

        $length = count($personalInfoToUpdate);
        $condition = null;
        $x = 0;
        while($x < $length) {
            if ($personalInfoToUpdate[$key[$x]] != $personalInfo[$key[$x]]){
                $condition = "update";
            }
            $x++;
        }

        $y = 0;
        while($y < $length) {
            if ($personalInfo[$key[$y]] == null){
                $condition = "add";
            }
            $y++;
        }  

        $jocelyn->setGender($personalInfoToUpdate["gender"]);
        $jocelyn->setNationality($personalInfoToUpdate["nationality"]);
        $jocelyn->setPermanentAddress($personalInfoToUpdate["permanentAddress"]);
        $jocelyn->setBirthDateYear($personalInfoToUpdate["year"]);
        $jocelyn->setBirthDateMonth($personalInfoToUpdate["month"]);
        $jocelyn->setBirthDateDay($personalInfoToUpdate["day"]);
        $jocelyn->setDateUpdated(new \DateTime());
        
        if ($condition == "update"){
            $historyChanges = "Update Candidate's Personal Information!";
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }
        elseif ($condition == "add"){
            $historyChanges = "Candidate's Personal Information Saved!";
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }        

        $this->assertEquals($condition, "update");

        $this->assertEquals($jocelyn->getGender(), $personalInfoToUpdate['gender']);
        $this->assertEquals($jocelyn->getBirthDateYear(), $personalInfoToUpdate['year']);
        $this->assertEquals($jocelyn->getBirthDateMonth(), $personalInfoToUpdate['month']);
        $this->assertEquals($jocelyn->getBirthDateDay(), $personalInfoToUpdate['day']);
        $this->assertEquals($jocelyn->getNationality(), $personalInfoToUpdate['nationality']);
        $this->assertEquals($jocelyn->getPermanentAddress(), $personalInfoToUpdate['permanentAddress']);
        return $jocelyn;
    }


    /**
    * SCENARIO 2
    * TEST STEP 3 Update personal information on OLD portal
    * @depends testUpdatePersonalInfo
    */
    public function testUpdatePersonalInfoOnOLd(Personal $jocelyn){
        // $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn;
        $personalInfo = [];
        $personalInfoToUpdate = [];
        $key = [
            "gender",
            "nationality",
            "permanentAddress",
            "year",
            "month",
            "day"
        ];

        $personalInfoToUpdate[$key[0]] = "Male";
        $personalInfoToUpdate[$key[1]] = "Philippines";
        $personalInfoToUpdate[$key[2]] = "Philippines";
        $personalInfoToUpdate[$key[3]] = 1993;
        $personalInfoToUpdate[$key[4]] = 10;
        $personalInfoToUpdate[$key[5]] = 10;

        $personalInfo[$key[0]] = $jocelyn->getGender();
        $personalInfo[$key[1]] = $jocelyn->getNationality();
        $personalInfo[$key[2]] = $jocelyn->getPermanentAddress();
        $personalInfo[$key[3]] = $jocelyn->getBirthDateYear();
        $personalInfo[$key[4]] = $jocelyn->getBirthDateMonth();
        $personalInfo[$key[5]] = $jocelyn->getBirthDateDay();

        $length = count($personalInfoToUpdate);
        $condition = null;
        $x = 0;
        while($x < $length) {
            if ($personalInfoToUpdate[$key[$x]] != $personalInfo[$key[$x]]){
                $condition = "update";
            }
            $x++;
        }

        $y = 0;
        while($y < $length) {
            if ($personalInfo[$key[$y]] == null){
                $condition = "add";
            }
            $y++;
        }  

        $jocelyn->setGender($personalInfoToUpdate["gender"]);
        $jocelyn->setNationality($personalInfoToUpdate["nationality"]);
        $jocelyn->setPermanentAddress($personalInfoToUpdate["permanentAddress"]);
        $jocelyn->setBirthDateYear($personalInfoToUpdate["year"]);
        $jocelyn->setBirthDateMonth($personalInfoToUpdate["month"]);
        $jocelyn->setBirthDateDay($personalInfoToUpdate["day"]);
        $jocelyn->setDateUpdated(new \DateTime());
        
        if ($condition == "update"){
            $historyChanges = "Update Candidate's Personal Information!";
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }
        elseif ($condition == "add"){
            $historyChanges = "Candidate's Personal Information Saved!";
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }        

        $this->assertEquals($condition, "update");

        $this->assertEquals($jocelyn->getGender(), $personalInfoToUpdate['gender']);
        $this->assertEquals($jocelyn->getBirthDateYear(), $personalInfoToUpdate['year']);
        $this->assertEquals($jocelyn->getBirthDateMonth(), $personalInfoToUpdate['month']);
        $this->assertEquals($jocelyn->getBirthDateDay(), $personalInfoToUpdate['day']);
        $this->assertEquals($jocelyn->getNationality(), $personalInfoToUpdate['nationality']);
        $this->assertEquals($jocelyn->getPermanentAddress(), $personalInfoToUpdate['permanentAddress']);
        return $jocelyn;
    }

    /**
    * SCENARIO 2
    * TEST STEP 4 Update personal information on NEW portal
    * @depends testUpdatePersonalInfo
    */
    public function testUpdatePersonalInfoOnNew(Personal $jocelyn){
        // $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn;
        $personalInfo = [];
        $personalInfoToUpdate = [];
        $key = [
            "gender",
            "nationality",
            "permanentAddress",
            "year",
            "month",
            "day"
        ];

        $personalInfoToUpdate[$key[0]] = "Male";
        $personalInfoToUpdate[$key[1]] = "Philippines";
        $personalInfoToUpdate[$key[2]] = "Philippines";
        $personalInfoToUpdate[$key[3]] = 1993;
        $personalInfoToUpdate[$key[4]] = 10;
        $personalInfoToUpdate[$key[5]] = 10;

        $personalInfo[$key[0]] = $jocelyn->getGender();
        $personalInfo[$key[1]] = $jocelyn->getNationality();
        $personalInfo[$key[2]] = $jocelyn->getPermanentAddress();
        $personalInfo[$key[3]] = $jocelyn->getBirthDateYear();
        $personalInfo[$key[4]] = $jocelyn->getBirthDateMonth();
        $personalInfo[$key[5]] = $jocelyn->getBirthDateDay();

        $length = count($personalInfoToUpdate);
        $condition = null;
        $x = 0;
        while($x < $length) {
            if ($personalInfoToUpdate[$key[$x]] != $personalInfo[$key[$x]]){
                $condition = "update";
            }
            $x++;
        }

        $y = 0;
        while($y < $length) {
            if ($personalInfo[$key[$y]] == null){
                $condition = "add";
            }
            $y++;
        }  

        $jocelyn->setGender($personalInfoToUpdate["gender"]);
        $jocelyn->setNationality($personalInfoToUpdate["nationality"]);
        $jocelyn->setPermanentAddress($personalInfoToUpdate["permanentAddress"]);
        $jocelyn->setBirthDateYear($personalInfoToUpdate["year"]);
        $jocelyn->setBirthDateMonth($personalInfoToUpdate["month"]);
        $jocelyn->setBirthDateDay($personalInfoToUpdate["day"]);
        $jocelyn->setDateUpdated(new \DateTime());
        
        if ($condition == "update"){
            $historyChanges = "Update Candidate's Personal Information!";
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }
        elseif ($condition == "add"){
            $historyChanges = "Candidate's Personal Information Saved!";
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }        

        // $this->assertEquals($condition, "update");
        
        $this->assertEquals($jocelyn->getGender(), $personalInfoToUpdate['gender']);
        $this->assertEquals($jocelyn->getBirthDateYear(), $personalInfoToUpdate['year']);
        $this->assertEquals($jocelyn->getBirthDateMonth(), $personalInfoToUpdate['month']);
        $this->assertEquals($jocelyn->getBirthDateDay(), $personalInfoToUpdate['day']);
        $this->assertEquals($jocelyn->getNationality(), $personalInfoToUpdate['nationality']);
        $this->assertEquals($jocelyn->getPermanentAddress(), $personalInfoToUpdate['permanentAddress']);
        return $jocelyn;
    }

    /**
    * SCENARIO 3
    * TEST STEP 5 
    */
    public function testAddPersonalInfoStep5(){
        $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn;
        
        $jocelyn->setGender("Male");
        $jocelyn->setNationality("Philippines");
        $jocelyn->setPermanentAddress("Philippines");
        $jocelyn->setBirthDateYear(1993);
        $jocelyn->setBirthDateMonth(10);
        $jocelyn->setBirthDateDay(10);
        $jocelyn->setDateUpdated(new \DateTime());

        $historyChanges = "Candidate's Personal Information Saved!";
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);

        $this->assertEquals($jocelyn->getGender(), 'Male');
        $this->assertEquals($jocelyn->getNationality(), 'Philippines');
        $this->assertEquals($jocelyn->getPermanentAddress(), 'Philippines');
        $this->assertEquals($jocelyn->getBirthDateYear(), 1993);
        $this->assertEquals($jocelyn->getBirthDateMonth(), 10);
        $this->assertEquals($jocelyn->getBirthDateDay(), 10);

        return $jocelyn;
    }

    /**
    * SCENARIO 3
    * TEST STEP 6 SKIPPED
    */

     /**
     * @param Personal $candidate
     * @param $recruiter_id
     * @return RecruiterStaff
     * @throws Exception
     */
    public function assignRecruiter(Personal $candidate, Admin $recruiter){

        $recruiterStaff = new RecruiterStaff();
        $recruiterStaff->setRecruiter($recruiter);
        $recruiterStaff->setCandidate($candidate);
        $recruiterStaff->setDate(new \DateTime());
        $list = $recruiter->getRecruiterStaff();
        foreach($list as $recruiterStaffEntry){
            $list->removeElement($recruiterStaffEntry);
            // $this->getEntityManager()->remove($recruiterStaffEntry);
        }
        $list = $candidate->getRecruiterStaff();
        foreach($list as $recruiterStaffEntry){
            $list->removeElement($recruiterStaffEntry);
            // $this->getEntityManager()->remove($recruiterStaffEntry);
        }


        $recruiter->getRecruiterStaff()->add($recruiterStaff);
        $candidate->getRecruiterStaff()->add($recruiterStaff);
        // $this->getEntityManager()->persist($candidate);
        // $this->getEntityManager()->persist($recruiter);
        return $recruiterStaff;
    }

    /**
     * Create Staff History for created Resume
     * @param Personal $candidate
     * @param Admin $recruiter
     */
    public function createStaffHistory(Personal $candidate, Admin $recruiter, $historyChanges){

        $staffHistory = new StaffHistory();
        $staffHistory->setCandidate($candidate);
        $staffHistory->setChangedBy($recruiter);
        $staffHistory->setChanges($historyChanges);
        $staffHistory->setType($recruiter->getStatus());
        $staffHistory->setDateCreated(new \DateTime());
        $candidate->getStaffHistory()->add($staffHistory);
        $recruiter->getStaffHistory()->add($staffHistory);
        return $staffHistory;
    }
    
}