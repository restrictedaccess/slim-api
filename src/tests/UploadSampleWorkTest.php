<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 8:12 PM
 */

namespace RemoteStaff\Tests;


use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\ApplicantFile;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Exceptions\InvalidCharacterReferenceFileFormatException;
use RemoteStaff\Exceptions\InvalidFileSizeException;
use RemoteStaff\Exceptions\InvalidMockCallFileFormatException;
use RemoteStaff\Exceptions\InvalidOthersFileFormatException;
use RemoteStaff\Exceptions\InvalidResumeFileFormatException;
use RemoteStaff\Exceptions\InvalidSampleWorkFileFormatException;
use RemoteStaff\Resources\ApplicantFileResource;

class UploadSampleWorkTest extends \PHPUnit_Framework_TestCase
{
    private $valid_file_formats = [
        "MOCK CALLS" => [
            "mp3",
            "wma",
            "wav",
        ],
        "SAMPLE WORKS" => [
            'doc',
            'docx',
            "pdf",
        ],
        "CHARACTER REFERENCE" => [
            'doc',
            'docx',
            "pdf",
        ],
        "RESUME" => [
            'doc',
            'docx',
            "pdf",
        ],
        "OTHER" => [
            "png",
            "jpeg",
            "jpg"
        ]
    ];

    private $exceptions_to_throw = [];


    private $stub = null;

    protected function setUp(){
        $this->exceptions_to_throw = [
            "MOCK CALLS" => new InvalidMockCallFileFormatException(),
            "SAMPLE WORKS" => new InvalidSampleWorkFileFormatException(),
            "CHARACTER REFERENCE" => new InvalidCharacterReferenceFileFormatException(),
            "RESUME" => new InvalidResumeFileFormatException(),
            "OTHER" => new InvalidOthersFileFormatException()
        ];
        // Create a stub for the SomeClass class.
        $this->stub = $this->createMock(ApplicantFileResource::class);

        $dateCreated = \DateTime::createFromFormat("Y-m-d H:i:s", "2016-09-09 14:00:00");

        $this->stub
            ->expects($this->any())
            ->method('uploadSampleWork')
            //->will($this->throwException(new \RemoteStaff\Exceptions\InvalidPictureFormatException));
            ->will($this->returnCallback(function($candidate, $recruiter, $request, $files, $dir) use ($dateCreated){
                /**
                 * @var Personal $candidate
                 */

                $recruiter = $candidate->getActiveRecruiter();

                foreach ($files["uploadFile"] as $file) {

                    if($file["size"] > 5242880){
                        throw new InvalidFileSizeException();
                    }

                    $exploded_file = explode(".", $file["name"]);

                    $file_ext = array_pop($exploded_file);

                    if(!in_array($file_ext, $this->valid_file_formats[$request["file_description"]])){
                        // Configure the stub.
                        throw $this->exceptions_to_throw[$request["file_description"]];
                    }

                    $file_dir = "applicants_files/" . $candidate->getUserid() . "_" . $file["name"];

                    $new_applicant_file = new ApplicantFile();

                    $new_applicant_file->setCandidate($candidate);
                    $new_applicant_file->setDateCreated($dateCreated);
                    $new_applicant_file->setFileDescription($request['file_description']);
                    $new_applicant_file->setPermission("ALL");
                    $new_applicant_file->setName($candidate->getUserid() . "_" . $file["name"]);

                    $candidate->addApplicantFile($new_applicant_file);


                    $historyChanges = "uploaded a " . $request["file_description"] . " file named <font color=#FF0000>[" . $candidate->getUserid() . "_" . $file["name"] . "]</font>";


                    $this->createStaffHistory($candidate, $recruiter, $historyChanges, $dateCreated);
                }



                return [
                    "success" => true
                ];
            }));
    }


    public function testCandidateHasNoApplicantHistoryFiles(){
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

        $this->assertEmpty($candidate->getApplicantFiles());
        return $candidate;
    }


    /**
     * @depends testCandidateHasNoApplicantHistoryFiles
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadMockCallMp3(Personal $candidate){
        $files = [
            "uploadFile" => []
        ];

        $files["uploadFile"][] = [
            "name" => "mockcalls.mp3",
            "size" => 1234
        ];


        $request = [
            "file_description" => "MOCK CALLS"
        ];

        $this->stub->uploadSampleWork($candidate, $candidate->getActiveRecruiter(), $request, $files, "");


        $last_sample_work = $candidate->getApplicantFiles()->last();

        $this->assertEquals(
            $last_sample_work->getName(),
            $candidate->getUserid() . "_mockcalls.mp3"
        );

        return $candidate;
    }

    /**
     * @depends testUploadMockCallMp3
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasMockCallMp3History(Personal $candidate){
        $last_history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "uploaded a MOCK CALLS file named <font color=#FF0000>[" . $candidate->getUserid() . "_mockcalls.mp3]</font>",
            $last_history->getChanges()
        );

        return $candidate;
    }

    /**
     * @depends testHasMockCallMp3History
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadJpeg(Personal $candidate){

        $this->expectException(InvalidFileSizeException::class);

        $files = [
            "uploadFile" => []
        ];

        $files["uploadFile"][] = [
            "name" => "file.jpeg",
            "size" => 17825792
        ];


        $request = [
            "file_description" => "MOCK CALLS"
        ];

        $this->stub->uploadSampleWork($candidate, $candidate->getActiveRecruiter(), $request, $files, "");


        return $candidate;
    }

    /**
     * @depends testHasMockCallMp3History
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadWMA(Personal $candidate){
        $files = [
            "uploadFile" => []
        ];

        $files["uploadFile"][] = [
            "name" => "file2.wma",
            "size" => 4718592
        ];


        $request = [
            "file_description" => "MOCK CALLS"
        ];

        $this->stub->uploadSampleWork($candidate, $candidate->getActiveRecruiter(), $request, $files, "");


        $last_sample_work = $candidate->getApplicantFiles()->last();

        $this->assertEquals(
            $last_sample_work->getName(),
            $candidate->getUserid() . "_file2.wma"
        );
        return $candidate;
    }


    /**
     * @depends testUploadWMA
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasUploadWMAHistory(Personal $candidate){
        $last_history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "uploaded a MOCK CALLS file named <font color=#FF0000>[" . $candidate->getUserid() . "_file2.wma]</font>",
            $last_history->getChanges()
        );
        return $candidate;
    }


    /**
     * @depends testHasUploadWMAHistory
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadDocXSampleWork(Personal $candidate){
        $files = [
            "uploadFile" => []
        ];

        $files["uploadFile"][] = [
            "name" => "file1.docx",
            "size" => 1363148
        ];


        $request = [
            "file_description" => "SAMPLE WORKS"
        ];

        $this->stub->uploadSampleWork($candidate, $candidate->getActiveRecruiter(), $request, $files, "");


        $last_sample_work = $candidate->getApplicantFiles()->last();

        $this->assertEquals(
            $last_sample_work->getName(),
            $candidate->getUserid() . "_file1.docx"
        );
        return $candidate;
    }


    /**
     * @depends testUploadDocXSampleWork
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasUploadDocXSampleWork(Personal $candidate){
        $last_history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "uploaded a SAMPLE WORKS file named <font color=#FF0000>[" . $candidate->getUserid() . "_file1.docx]</font>",
            $last_history->getChanges()
        );
        return $candidate;
    }



    /**
     * @depends testHasUploadDocXSampleWork
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadDocxMockCall(Personal $candidate){

        $this->expectException(InvalidMockCallFileFormatException::class);

        $files = [
            "uploadFile" => []
        ];

        $files["uploadFile"][] = [
            "name" => "file1.docx",
            "size" => 1363148
        ];


        $request = [
            "file_description" => "MOCK CALLS"
        ];

        $this->stub->uploadSampleWork($candidate, $candidate->getActiveRecruiter(), $request, $files, "");



        return $candidate;
    }

    /**
     * @depends testHasUploadDocXSampleWork
     * @param Personal $candidate
     * @return Personal
     */
    public function testUploadJpegOthers(Personal $candidate){

        $files = [
            "uploadFile" => []
        ];

        $files["uploadFile"][] = [
            "name" => "Others.jpeg",
            "size" => 1363148
        ];


        $request = [
            "file_description" => "OTHER"
        ];

        $this->stub->uploadSampleWork($candidate, $candidate->getActiveRecruiter(), $request, $files, "");


        $last_sample_work = $candidate->getApplicantFiles()->last();

        $this->assertEquals(
            $last_sample_work->getName(),
            $candidate->getUserid() . "_Others.jpeg"
        );

        return $candidate;
    }


    /**
     * @depends testUploadJpegOthers
     * @param Personal $candidate
     * @return Personal
     */
    public function testHasUploadJpegOthersHistory(Personal $candidate){
        $last_history = $candidate->getStaffHistory()->last();

        $this->assertEquals(
            "uploaded a OTHER file named <font color=#FF0000>[" . $candidate->getUserid() . "_Others.jpeg]</font>",
            $last_history->getChanges()
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