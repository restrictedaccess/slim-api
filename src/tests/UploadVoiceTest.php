<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/20/2016
 * Time: 9:37 AM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Exceptions\InvalidVoiceFileSizeException;
use RemoteStaff\Exceptions\InvalidVoiceFormatException;
use RemoteStaff\Resources\ApplicantFileResource;

class UploadVoiceTest extends \PHPUnit_Framework_TestCase
{
    // mp3,wma,wav,mpeg
    private $valid_voice_formats = [
        "mp3",
        "wma",
        "wav",
        "mpeg"
    ];


    private $stub = null;

    private $test_files = null;
    protected function setUp(){
        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(ApplicantFileResource::class);


        $this->stub = $this->createMock(ApplicantFileResource::class);


        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-18 08:39:00");

        $this->stub
            ->expects($this->any())
            ->method('uploadVoice')
            //->will($this->throwException(new \RemoteStaff\Exceptions\InvalidPictureFormatException));
            ->will($this->returnCallback(function($candidate, $recruiter, $request, $file, $dir) use ($dateCreated){

                $recruiter = $candidate->getActiveRecruiter();

                $exploded_file = explode(".", $file);

                $file_ext = array_pop($exploded_file);

                if(!in_array($file_ext, $this->valid_voice_formats)){
                    // Configure the stub.
                    throw new InvalidVoiceFormatException();
                }

                if(!empty($this->test_files)){
                    foreach ($this->test_files as $test_file) {

                        if($test_file["size"] > 5242880){
                            throw new InvalidVoiceFileSizeException();
                        }
                    }
                }

                $file_dir = "uploads/voice/" . $candidate->getUserid() . "." . $file_ext;

                $candidate->setVoice($file_dir);


                $historyChanges = "uploaded a VOICE file named <font color=#FF0000>[" . $file . "]</font>";


                $this->createStaffHistory($candidate, $recruiter, $historyChanges, $dateCreated);

                return [
                    "success" => true
                ];
            }));


    }


    protected function tearDown(){

        unset($_FILES);
    }

    public function testCandidateHasNoVoice(){
        $candidate = new Personal();

        $recruiter = new Admin();

        $recruiter->setId(213);
        $recruiter->setStatus("HR");


        $recruiter_staff = new RecruiterStaff();

        $recruiter_staff->setCandidate($candidate);
        $recruiter_staff->setRecruiter($recruiter);

        $candidate->getRecruiterStaff()->add($recruiter_staff);

        $candidate->setUserid(5455);
        $candidate->setFirstName("Kriza Mae");
        $candidate->setLastName("Pamintuan");

        $this->assertEmpty($candidate->getVoice());
        return $candidate;
    }

    /**
     * @depends testCandidateHasNoVoice
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadJpeg(Personal $candidate){

        $this->expectException(InvalidVoiceFormatException::class);

        $new_voice_to_upload = "new_voice.jpeg";

        $exploded = explode(".", $new_voice_to_upload);

        $ext = $exploded[count($exploded) - 1];



        $this->stub->uploadVoice($candidate, $candidate->getActiveRecruiter(), [], $new_voice_to_upload, "");



        return $candidate;
    }

    /**
     * @depends testCandidateHasNoVoice
     * @param $candidate
     * @return mixed
     */
    public function testUploadMp3(Personal $candidate){


        $this->stub->uploadVoice($candidate, $candidate->getActiveRecruiter(), [], "cute.mp3", "");

        $this->assertEquals($candidate->getVoice(), "uploads/voice/5455.mp3");

        return $candidate;
    }


    /**
     * @depends testUploadMp3
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasMp3UploadHistory(Personal $candidate){

        /**
         * @var StaffHistory $last_history
         */
        $last_history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "uploaded a VOICE file named <font color=#FF0000>[cute.mp3]</font>",
            $last_history->getChanges()
        );

        return $candidate;
    }



    /**
     * @depends testCandidateHasNoVoice
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadWma(Personal $candidate){

        $this->stub->uploadVoice($candidate, $candidate->getActiveRecruiter(), [], "cute.wma", "");

        $this->assertEquals($candidate->getVoice(), "uploads/voice/5455.wma");

        return $candidate;
    }

    /**
     * @depends testUploadWma
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasWmaUploadHistory(Personal $candidate){

        /**
         * @var StaffHistory $last_history
         */
        $last_history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "uploaded a VOICE file named <font color=#FF0000>[cute.wma]</font>",
            $last_history->getChanges()
        );

        return $candidate;
    }


    /**
     * @depends testHasWmaUploadHistory
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadMpeg(Personal $candidate){

        $this->stub->uploadVoice($candidate, $candidate->getActiveRecruiter(), [], "cute.mpeg", "");

        $this->assertEquals($candidate->getVoice(), "uploads/voice/5455.mpeg");

        return $candidate;
    }


    /**
     * @depends testUploadMpeg
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadPng(Personal $candidate){

        $this->expectException(InvalidVoiceFormatException::class);

        $this->stub->uploadVoice($candidate, $candidate->getActiveRecruiter(), [], "cute.png", "");

        //$this->assertEquals($candidate->getVoice(), "uploads/voice/5455.mpeg");

        return $candidate;
    }


    /**
     * @depends testCandidateHasNoVoice
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadMp3Size1GB(Personal $candidate){

        $this->expectException(InvalidVoiceFileSizeException::class);

        $this->test_files = array(
            'test' => array(
                'name' => 'cute.mp3',
                'type' => 'audio/mp3',
                'size' => 1073741824,
                'tmp_name' => '/_files/source-test.mp3',
                'error' => 0
            )
        );

        $this->stub->uploadVoice($candidate, $candidate->getActiveRecruiter(), [], "cute.mp3", "");


        //$this->assertLessThanOrEqual(5242880, $_FILES["test"]["size"]);


        return $candidate;
    }


    /**
     * @depends testCandidateHasNoVoice
     * @param Personal $candidate
     */
    public function testUploadMp3Size5MB(Personal $candidate){

        $this->test_files = array(
            'test' => array(
                'name' => 'cute.mp3',
                'type' => 'audio/mp3',
                'size' => 5242880,
                'tmp_name' => '/_files/source-test.mp3',
                'error' => 0
            )
        );


        $this->stub->uploadVoice($candidate, $candidate->getActiveRecruiter(), [], "cute.mp3", "");


        $this->assertEquals($candidate->getVoice(), "uploads/voice/5455.mp3");
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