<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/19/2016
 * Time: 7:26 AM
 */

namespace RemoteStaff\Tests;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Exceptions\InvalidPictureFormatException;
use RemoteStaff\Resources\ApplicantFileResource;


/**
 * Test Uploading of profile picture
 * @refer https://remotestaff.atlassian.net/browse/PORTAL-237
 * Class UploadProfilePictureTest
 * @package RemoteStaff\Tests
 */
class UploadProfilePictureTest  extends \PHPUnit_Framework_TestCase
{

    private $valid_picture_formats = [
        "png",
        "jpeg",
        "jpg"
    ];

    private $stub = null;


    protected function setUp(){
        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(ApplicantFileResource::class);

        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-18 08:39:00");

        $this->stub
            ->expects($this->any())
            ->method('uploadImage')
            //->will($this->throwException(new \RemoteStaff\Exceptions\InvalidPictureFormatException));
            ->will($this->returnCallback(function($candidate, $recruiter, $request, $file, $dir) use ($dateCreated){

                $recruiter = $candidate->getActiveRecruiter();

                $exploded_file = explode(".", $file);

                $file_ext = array_pop($exploded_file);

                if(!in_array($file_ext, $this->valid_picture_formats)){
                    // Configure the stub.
                    throw new InvalidPictureFormatException();
                }

                $file_dir = "uploads/pics/" . $candidate->getUserid() . "." . $file_ext;

                $candidate->setImage($file_dir);


                $historyChanges = "Uploaded PROFILE PICTURE file name <font color=#FF0000>[" . $file . "]</font>";


                $this->createStaffHistory($candidate, $recruiter, $historyChanges, $dateCreated);

                return [
                    "success" => true
                ];
            }));
    }

    public function testCandidateHasNoPicture(){
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

        $this->assertTrue($candidate->getImage() == "");
        return $candidate;
    }


    /**
     * @depends testCandidateHasNoPicture
     * @param Personal $candidate
     */
    public function testUploadMp3(Personal $candidate){
        $this->expectException(InvalidPictureFormatException::class);

        $file_name = "cute.mp3";

        $this->stub->uploadImage($candidate, $candidate->getActiveRecruiter(), [], $file_name, "");

    }

    /**
     * @depends testCandidateHasNoPicture
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadJpeg(Personal $candidate){


        $this->stub->uploadImage($candidate, $candidate->getActiveRecruiter(), [], "cute.jpeg", "");

        $this->assertEquals($candidate->getImage(), "uploads/pics/5455.jpeg");

        return $candidate;
    }

    /**
     * @depends testUploadJpeg
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasJpegImageUploadHistory(Personal $candidate){

        /**
         * @var StaffHistory $history
         */
        $history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "Uploaded PROFILE PICTURE file name <font color=#FF0000>[cute.jpeg]</font>",
            $history->getChanges()
        );

        return $candidate;
    }


    /**
     * @depends testCandidateHasNoPicture
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadPng(Personal $candidate){

        $this->stub->uploadImage($candidate, $candidate->getActiveRecruiter(), [], "cute.png", "");

        $this->assertEquals($candidate->getImage(), "uploads/pics/5455.png");

        return $candidate;
    }


    /**
     * @depends testUploadPng
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasPngUploadHistory(Personal $candidate){

        /**
         * @var StaffHistory $history
         */
        $history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "Uploaded PROFILE PICTURE file name <font color=#FF0000>[cute.png]</font>",
            $history->getChanges()
        );

        return $candidate;
    }


    /**
     * @depends testCandidateHasNoPicture
     * @param Personal $candidate
     * @return Personal
     */
    public function testReplacePreviousPhotoWithJpeg(Personal $candidate){

        $this->stub->uploadImage($candidate, $candidate->getActiveRecruiter(), [], "cute.jpeg", "");

        $this->assertEquals($candidate->getImage(), "uploads/pics/5455.jpeg");

        return $candidate;
    }


    /**
     * @depends testReplacePreviousPhotoWithJpeg
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasReplacedJpegUploadHistory(Personal $candidate){

        /**
         * @var StaffHistory $history
         */
        $history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "Uploaded PROFILE PICTURE file name <font color=#FF0000>[cute.jpeg]</font>",
            $history->getChanges()
        );

        return $candidate;
    }


    /**
     * @depends testHasReplacedJpegUploadHistory
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadWav(Personal $candidate){

        $this->expectException(InvalidPictureFormatException::class);


        $this->stub->uploadImage($candidate, $candidate->getActiveRecruiter(), [], "cute.wav", "");

        return $candidate;
    }


    /**
     * @depends testCandidateHasNoPicture
     * @param Personal $candidate
     */
    public function testUploadButtonClickedNoFileUploaded(Personal $candidate){

        $this->expectException(InvalidPictureFormatException::class);


        $this->stub->uploadImage($candidate, $candidate->getActiveRecruiter(), [], null, "");
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