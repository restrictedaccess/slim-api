<?php


namespace RemoteStaff\Tests;

use RemoteStaff\Entities\Skill;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Exceptions\InvalidArgumentException;


/**
 * This class is used to test adding skill
 * Class SkillTest
 * @package RemoteStaff\Tests
 */
class SkillTest extends \PHPUnit_Framework_TestCase {
    /**
     * @var \RemoteStaff\Entities\Personal
     */
    private $jocelyn;

    /**
     * @var \RemoteStaff\Entities\Admin
     */
    private $honeylyn;

    protected function setUp(){

        //create new candidate
        $candidate = new Personal();
        $candidate->setUserid(119569);
        $candidate->setFirstName("Jocelyn");
        $candidate->setLastName("Gudmalin");
        $candidate->setDateCreated(new \DateTime("2016-08-18 14:00:00"));

        $this->jocelyn = $candidate;//set new candidate to $jocelyn

        $recruiter = new Admin();
        $recruiter->setFirstName("Honeylyn");
        $recruiter->setLastName("Lapidario");

        $this->honeylyn = $recruiter;//set new recruiter to honeylyn

        $recruiterStaff = $this->assignRecruiter($this->jocelyn, $this->honeylyn);//assigning candidate to recruiter

        $skillArray = ["Data Entry", "WebSphere", "Linux Server Administration", "Middleware Support", "Apache Tomcat"];
        for($i = 0; $i < count($skillArray); $i++){
            $skill = new Skill();  
            $skill->setId($i+1);  
            $skill->setCandidate($candidate);
            $skill->setSkill($skillArray[$i]);
            $skill->setExperience(1);
            $skill->setProficiency(1); 
            $this->jocelyn->addSkill($skill);
        }        
    }

    //TEST CASE ADD EMPTY skill name, experience or proficiency
    public function testAddEmpty(){
        $this->expectException(InvalidArgumentException::class);

        $jocelyn = $this->jocelyn;   
        $honeylyn = $this->honeylyn;

        $skill = new Skill();
        $skill->setCandidate($jocelyn);
        $skill->setSkill(null);
        $skill->setExperience(null);
        $skill->setProficiency(null);

        $addedSkill = $jocelyn->addSkill($skill);

        if(!$addedSkill) {
            $historyChanges = "Added new skill" . $addedSkill->getSkill();
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }

        $this->assertEquals(5, count($jocelyn->getSkills()));

        return $jocelyn;
    }

    //TEST CASE ADD EMPTY skill name
    public function testAddEmptySkillName(){
        $this->expectException(InvalidArgumentException::class);
        $jocelyn = $this->jocelyn;   
        $honeylyn = $this->honeylyn;

        $skill = new Skill();
        $skill->setCandidate($jocelyn);
        $skill->setSkill(null);
        $skill->setExperience(2);
        $skill->setProficiency(3);

        $addedSkill = $jocelyn->addSkill($skill);

        if(!$addedSkill) {
            $historyChanges = "Added new skill" . $addedSkill->getSkill();
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }

        $this->assertEquals(5, count($jocelyn->getSkills()));

        return $jocelyn;
    }

    //TEST CASE ADD EMPTY skill Experience
    public function testAddEmptySkillExperience(){
        $this->expectException(InvalidArgumentException::class);
        $jocelyn = $this->jocelyn;   
        $honeylyn = $this->honeylyn;

        $skill = new Skill();
        $skill->setCandidate($jocelyn);
        $skill->setSkill("Test Name");
        $skill->setExperience(null);
        $skill->setProficiency(3);

        $addedSkill = $jocelyn->addSkill($skill);

        if(!$addedSkill) {
            $historyChanges = "Added new skill" . $addedSkill->getSkill();
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }

        $this->assertEquals(5, count($jocelyn->getSkills()));

        return $jocelyn;
    }

    //TEST CASE ADD EMPTY skill Proficiency
    public function testAddEmptySkillProficiency(){
        $this->expectException(InvalidArgumentException::class);
        $jocelyn = $this->jocelyn;   
        $honeylyn = $this->honeylyn;

        $skill = new Skill();
        $skill->setCandidate($jocelyn);
        $skill->setSkill("Test Name");
        $skill->setExperience(2);
        $skill->setProficiency(null);

        $addedSkill = $jocelyn->addSkill($skill);

        if(!$addedSkill) {
            $historyChanges = "Added new skill" . $addedSkill->getSkill();
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }

        $this->assertEquals(5, count($jocelyn->getSkills()));

        return $jocelyn;
    }


    //TEST CASE ADD Identity and Access Management
    public function testAddIdentityAndAccessManagement(){
        $jocelyn = $this->jocelyn;   
        $honeylyn = $this->honeylyn;

        $skill = new Skill();
        $skill->setId(6);  
        $skill->setCandidate($jocelyn);
        $skill->setSkill("Identity and Access Management");
        $skill->setExperience(3);
        $skill->setProficiency(2);

        $addedSkill = $jocelyn->addSkill($skill);

        $historyChanges = "Added new skill" . $addedSkill->getSkill();
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
   
        $this->assertEquals(6, count($jocelyn->getSkills()));

        return $jocelyn;
    }

    /**
    * TEST CASE ADD EXISTING
    * @depends testAddIdentityAndAccessManagement
    */
    public function testAddExistingSkill(Personal $jocelyn){ 
        $jocelyn = $this->jocelyn; 
        $honeylyn = $this->honeylyn;//recruiter

        $skill = new Skill();
        $skill->setId(6);  
        $skill->setCandidate($jocelyn);
        $skill->setSkill("Identity and Access Management");
        $skill->setExperience(3);
        $skill->setProficiency(2);
        
        $addedSkill = $jocelyn->addSkill($skill);
        if(!$addedSkill ) {
            $historyChanges = "Added new skill" . $addedSkill->getSkill();
            $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        }
        
        $this->assertEquals(6, count($jocelyn->getSkills()));

        return $jocelyn;    
    }

    /**
    * TEST CASE DELETE 1
    * @depends testAddIdentityAndAccessManagement
    */
    public function testDeleteWebSphere(Personal $jocelyn){  
        $honeylyn = $this->honeylyn;

        $skill = new Skill();
        $skill->setId(2);  
        $skill->setCandidate($jocelyn);
        $skill->setSkill("WebSphere");
        $skill->setExperience(1);
        $skill->setProficiency(1);

        $removedSkill = $jocelyn->removeSkill($skill);
        $historyChanges = "Removed skill " . $removedSkill->getSkill();
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        
        $this->assertEquals(5, count($jocelyn->getSkills()));

        return $jocelyn;
    }

    /**
    * TEST CASE DELETE 2
    * @depends testDeleteWebSphere
    */
    public function testDeleteLinuxServerAdministrationAndMiddlewareSupport(Personal $jocelyn){  
        $honeylyn = $this->honeylyn;//recruiter

        $skillArray = ["Data Entry", "WebSphere", "Linux Server Administration", "Middleware Support", "Apache Tomcat"];
        $skills = [];

        for($i = 0; $i < count($skillArray); $i++){
            $skill = new Skill();  
            $skill->setId($i+1);  
            $skill->setCandidate($jocelyn);
            $skill->setSkill($skillArray[$i]);
            $skill->setExperience(1);
            $skill->setProficiency(1); 

            $skills[$i] = $skill; 
        }  

        //DELETE "Linux Server Administration"  
        $deleteSkill = $jocelyn->removeSkill($skills[2])->getSkill();       
        $historyChanges = "Removed skill " . $deleteSkill;
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        $this->assertEquals(4, count($jocelyn->getSkills()));
        
        //DELETE "Middleware Support" 
        $deleteSkill = $jocelyn->removeSkill($skills[3])->getSkill();
        $historyChanges = "Removed skill " . $deleteSkill;
        $staffHistory = $this->createStaffHistory($jocelyn, $honeylyn, $historyChanges);
        $this->assertEquals(3, count($jocelyn->getSkills()));
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
}