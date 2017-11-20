<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 8:14 AM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Education;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Exceptions\NoUpdatesWereMadeException;
use RemoteStaff\Resources\EducationAttainmentResource;

class AddEducationAttainmentTest extends \PHPUnit_Framework_TestCase
{

    private $stub;

    protected function setUp(){
        $this->stub = $this->createMock(EducationAttainmentResource::class);


        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-08-18 14:00:00");

        $this->stub
            ->expects($this->any())
            ->method('updatedEducationAttainment')
            //->will($this->throwException(new \RemoteStaff\Exceptions\InvalidPictureFormatException));
            ->will($this->returnCallback(function(Personal $candidate, Admin $recruiter, $request) use ($dateCreated){

                if(empty($request)){
                    throw new NoUpdatesWereMadeException();
                }


                if(empty($candidate->getEducation())){
                    $new_education = new Education();
                    $candidate->setEducation($new_education);
                }

                $candidate_education = $candidate->getEducation();

                $old_record = [
                    "educationallevel" => $candidate_education->getEducationalLevel(),
                    "fieldstudy" => $candidate_education->getFieldStudy(),
                    "major" => $candidate_education->getMajor(),
                    "college_name" => $candidate_education->getCollegeName(),
                    "college_country" => $candidate_education->getCollegeCountry(),
                    "graduation_date" => date("M Y", strtotime($candidate_education->getGraduateYear() . "-" . $candidate_education->getGraduateMonth() . "-20")),
                    "trainings_seminars" => $candidate_education->getTrainingsSeminar(),
                    "licence_certification" => $candidate_education->getLicenceCertification()
                ];


                $candidate_education->setCandidate($candidate);
                $candidate_education->setGrade("Grade Point Average (GPA)");
                $candidate_education->setGPAScore(0);
                $updates_were_made = false;

                if(!empty($request["educationallevel"]) && isset($request["educationallevel"])){
                    $candidate_education->setEducationalLevel($request["educationallevel"]);
                    $updates_were_made = true;
                }


                if(!empty($request["fieldstudy"]) && isset($request["fieldstudy"])){
                    $candidate_education->setFieldStudy($request["fieldstudy"]);
                    $updates_were_made = true;
                }

                if(!empty($request["major"]) && isset($request["major"])){
                    $candidate_education->setMajor($request["major"]);
                    $updates_were_made = true;
                }

                if(!empty($request["college_name"]) && isset($request["college_name"])){
                    $candidate_education->setCollegeName($request["college_name"]);
                    $updates_were_made = true;
                }

                if(!empty($request["college_country"]) && isset($request["college_country"])){
                    $candidate_education->setCollegeCountry($request["college_country"]);
                    $updates_were_made = true;
                }

                if(!empty($request["graduation_date"]) && isset($request["graduation_date"])){
                    $graduation_month = date('n', strtotime($request["graduation_date"]));
                    $graduation_year = date("Y", strtotime($request["graduation_date"]));

                    $candidate_education->setGraduateMonth($graduation_month);
                    $candidate_education->setGraduateYear($graduation_year);
                    $updates_were_made = true;
                }

                if(!empty($request["trainings_seminars"]) && isset($request["trainings_seminars"])){
                    $candidate_education->setTrainingsSeminar($request["trainings_seminars"]);
                    $updates_were_made = true;
                }

                if(!empty($request["licence_certification"]) && isset($request["licence_certification"])){
                    $candidate_education->setLicenceCertification($request["licence_certification"]);
                    $updates_were_made = true;
                }


                if($updates_were_made){
                    $candidate->setEducation($candidate_education);

                    $difference = array_diff_assoc($old_record,$request);

                    $history_changes = "";
                    if( count($difference) > 0) {
                        foreach (array_keys($difference) as $array_key) {
                            if(isset($request[$array_key])){
                                $history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old_record[$array_key], $request[$array_key]);
                            }

                        }
                    }


                    $this->createStaffHistory($candidate, $candidate->getActiveRecruiter(), $history_changes, $dateCreated);
                } else{
                    throw new NoUpdatesWereMadeException();
                }



                return [
                    "success" => true
                ];
            }));
    }



    public function testRecruiterHasCandidate(){
        $candidate = new Personal();

        $candidate->setUserid(119569);
        $candidate->setFirstName("Jocelyn");
        $candidate->setLastName("Gudmalin");

        $recruiter = new Admin();
        $recruiter->setId(167);

        $recruiter_staff = new RecruiterStaff();
        $recruiter_staff->setCandidate($candidate);
        $recruiter_staff->setRecruiter($recruiter);

        $candidate->getRecruiterStaff()->add($recruiter_staff);
        $recruiter->getRecruiterStaff()->add($recruiter_staff);

        $this->assertEquals(
            $recruiter->getId(),
            $candidate->getActiveRecruiter()->getId()
        );
        return $candidate;
    }

    /**
     * @depends testRecruiterHasCandidate
     * @param Personal $candidate
     * @return Personal
     */
    public function testEducationAttainmentFieldsEmptyButtonClicked(Personal $candidate){

        $request = [];


        $this->expectException(NoUpdatesWereMadeException::class);


        $this->stub->updatedEducationAttainment($candidate, $candidate->getActiveRecruiter(), $request);

        return $candidate;
    }


    /**
     * @depends testRecruiterHasCandidate
     * @param Personal $candidate
     * @return Personal
     */
    public function testRecruiterAddValidEducationRequestButtonClicked(Personal $candidate){
        //grade = "Grade Point Average (GPA)"
        //gpascore = 0

        $request = [
            "educationallevel" => "Bachelor/ College Degree",
            "fieldstudy" => "Computer Science/ Information Technology",
            "major" => "",
            "college_name" => "FEU - Easy Asia College",
            "college_country" => "Philippines",
            "graduation_date" => "May 2010",
            "trainings_seminars" => "Incident, Problem and Change Management 
            Hewlett-Packard Philippines Corporation
            Upper McKinley Road McKinley Hill CyberPark, Fort Bonifacio Taguig City",
            "licence_certification" => ""
        ];


        $this->stub->updatedEducationAttainment($candidate, $candidate->getActiveRecruiter(), $request);


        $this->assertEquals(
            $request["college_name"],
            $candidate->getEducation()->getCollegeName()
        );

        return $candidate;
    }


    /**
     * @depends testRecruiterAddValidEducationRequestButtonClicked
     * @param Personal $candidate
     */
    public function testHasAddingEducationAttainmentHistory(Personal $candidate){

        $last_history = $candidate->getStaffHistory()->last();

        $this->assertRegExp(
            '/Hewlett-Packard/',
            $last_history->getChanges()
        );
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