<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 22/08/16
 * Time: 6:57 PM
 */

namespace RemoteStaff\Resources;
use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\ApplicantFile;
use RemoteStaff\Entities\Personal;
use \Doctrine\Common\Collections\ArrayCollection;
use RemoteStaff\Exceptions\InvalidCharacterReferenceFileFormatException;
use RemoteStaff\Exceptions\InvalidFileSizeException;
use RemoteStaff\Exceptions\InvalidMockCallFileFormatException;
use RemoteStaff\Exceptions\InvalidOthersFileFormatException;
use RemoteStaff\Exceptions\InvalidPictureFormatException;
use RemoteStaff\Exceptions\InvalidResumeFileFormatException;
use RemoteStaff\Exceptions\InvalidSampleWorkFileFormatException;
use RemoteStaff\Exceptions\InvalidVoiceFileSizeException;
use RemoteStaff\Exceptions\InvalidVoiceFormatException;
use Doctrine\Common\Collections\Criteria;

/**
 *
 * Resource of Applicant Files
 * Class ApplicantFileResource
 * @package RemoteStaff\Resources
 *
 */
class ApplicantFileResource extends AbstractResource{



    /**
     * @param $candidateId The candidate ID
     * @param $files $_FILES attached
     * @param $dir The directory to upload
     *
     * @return array
     */
    public function attachResume($candidateId, $files, $dir){
        /**
         * @var Personal $candidate
         */
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($candidateId);

        $attachments = [];
        for($i=0;$i<count($files["uploadfile"]["name"]);$i++){
            $tmp_name = $files["uploadfile"]["tmp_name"][$i];
            $filename = $files["uploadfile"]["name"][$i];
            $type = $files["uploadfile"]["type"][$i];
            $data=array(
                'tmp_name' => $tmp_name,
                'filename' => $filename,
                'type' => $type,
            );
            $attachments[] = $data;
        }
        $applicantFiles = [];
        $applicant_files_existing = $candidate->getApplicantFiles();
        if(empty($applicant_files_existing)){
            $candidate->setApplicantFiles(new ArrayCollection());
        }

        $files_uploaded = [];
        foreach($attachments as $attachment){
            $applicantFile = new ApplicantFile();
            $applicantFile->setCandidate($candidate);
            $applicantFile->setFileDescription("RESUME");
            $applicantFile->setPermission("ALL");
            $applicantFile->setDateCreated(new \DateTime());
            $ext = pathinfo($attachment["filename"], PATHINFO_EXTENSION);
            $name = $candidate->getId()."_".$attachment["filename"];
            $applicantFile->setName($name);
            $this->getEntityManager()->persist($applicantFile);

            //make the candidate know of the file that is created
            $candidate->addApplicantFile($applicantFile);


            if (!empty($attachment)) {
//                move_uploaded_file($attachment["tmp_name"],$dir."/".$name);
                $files_uploaded[] = $name;
            }
            $applicantFiles[]  = $applicantFile;
        }

        //persist the candidate
        $this->getEntityManager()->persist($candidate);

        $this->getEntityManager()->flush();

        return $files_uploaded;

    }


    /**
     * @param Personal $candidate
     * @param Admin $recruiter
     * @param $request
     * @param $file
     * @param $dir
     * @return array
     * @throws InvalidPictureFormatException
     * @throws \Exception
     */
    public function uploadImage(Personal $candidate, Admin  $recruiter, $request, $file, $dir){
        
        $valid_extensions = [
            "png",
            "jpeg",
            "jpg"
        ];

        $result = [
            "success" => false,
            "result" => "",
            "error" => "",
            "files_uploaded" => []
        ];

        $exploded_file = explode(".", $file["uploadImage"]["name"]);

        $file_ext = array_pop($exploded_file);

        if(!in_array($file_ext, $valid_extensions)){
            throw new InvalidPictureFormatException();
        }


        $tmp_name = $file["uploadImage"]["tmp_name"];
        $filename = $file["uploadImage"]["name"];
        $type = $file["uploadImage"]["type"];
        $data=array(
            'tmp_name' => $tmp_name,
            'filename' => $filename,
            'type' => $type,
        );



        $ext = pathinfo($data["filename"], PATHINFO_EXTENSION);


        $name = $candidate->getId().".".$ext;


        $upload_successful = false;
        if (!empty($data)) {
            $upload_successful = move_uploaded_file($data["tmp_name"],$dir."/pics/".$name);

        }

        if($upload_successful){
            $result["files_uploaded"][] = $name;
            $candidate->setImage("uploads/pics/" . $name);
            $candidate->setDateUpdated(new \DateTime());



            //"Uploaded PROFILE PICTURE file name <font color=#FF0000>[munoz.jpeg]</font>"

            $historyChanges = "Uploaded PROFILE PICTURE file name <font color=#FF0000>[" . $data["filename"] . "]</font>";


            $this->createStaffHistory($candidate, $recruiter, $historyChanges);


            $this->getEntityManager()->persist($candidate);


            $result["success"] = true;

            $result["result"] = "Image successfully updated!";

            $this->getEntityManager()->flush();

        } else{
            $result["error"] = "Image not uploaded!";
        }

        return $result;
    }


    /**
     * @param Personal $candidate
     * @param Admin $recruiter
     * @param $request
     * @param $file
     * @param $dir
     */
    public function uploadVoice(Personal $candidate, Admin  $recruiter, $request, $file, $dir){


        $valid_extensions = [
            "mp3",
            "wma",
            "wav",
            "mpeg"
        ];

        $valid_file_size = 5242880;


        $result = [
            "success" => false,
            "result" => "",
            "error" => "",
            "files_uploaded" => []
        ];

        $exploded_file = explode(".", $file["uploadVoice"]["name"]);

        $file_ext = array_pop($exploded_file);

        if(!in_array($file_ext, $valid_extensions)){
            throw new InvalidVoiceFormatException();
        }


        $tmp_name = $file["uploadVoice"]["tmp_name"];
        $filename = $file["uploadVoice"]["name"];
        $type = $file["uploadVoice"]["type"];
        $size = $file["uploadVoice"]["size"];

        if($size > $valid_file_size){
            throw new InvalidVoiceFileSizeException();
        }

        $data=array(
            'tmp_name' => $tmp_name,
            'filename' => $filename,
            'type' => $type,
        );



        $ext = pathinfo($data["filename"], PATHINFO_EXTENSION);


        $name = $candidate->getId().".".$ext;


        $upload_successful = false;
        if (!empty($data)) {
            $upload_successful = move_uploaded_file($data["tmp_name"],$dir."/voice/".$name);

        }

        if($upload_successful){
            $result["files_uploaded"][] = $name;
            $candidate->setVoice("uploads/voice/" . $name);
            $candidate->setDateUpdated(new \DateTime());



            //"uploaded a VOICE file named <font color=#FF0000>[cute.mp3]</font>"

            $historyChanges = "uploaded a VOICE file named <font color=#FF0000>[" . $data["filename"] . "</font>";


            $this->createStaffHistory($candidate, $recruiter, $historyChanges);


            $this->getEntityManager()->persist($candidate);


            $result["success"] = true;

            $result["result"] = "Voice successfully updated!";

            $this->getEntityManager()->flush();

        } else{
            $result["error"] = "Voice not uploaded!";
        }

        return $result;
    }


    /**
     * @param Personal $candidate
     * @param Admin $recruiter
     * @param $request
     * @param $files
     * @param $dir
     * @return array
     */
    public function uploadSampleWork(Personal $candidate, Admin $recruiter, $request, $files, $dir){


        $result = [
            "success" => false,
            "files_uploaded" => [],
            "files_duplicate" => []
        ];

        $valid_file_formats = [
            "MOCK CALLS" => [
                "mp3",
                "wma",
                "wav",
            ],
            "SAMPLE WORK" => [
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

        $exceptions_to_throw = [
            "MOCK CALLS" => new InvalidMockCallFileFormatException(),
            "SAMPLE WORK" => new InvalidSampleWorkFileFormatException(),
            "CHARACTER REFERENCE" => new InvalidCharacterReferenceFileFormatException(),
            "RESUME" => new InvalidResumeFileFormatException(),
            "OTHER" => new InvalidOthersFileFormatException()
        ];


        for($key_file=0;$key_file<count($files["uploadFile"]["name"]);$key_file++){

            if($files["uploadFile"]["size"][$key_file] > 5242880){
                throw new InvalidFileSizeException();
            }

            $exploded_file = explode(".", $files["uploadFile"]["name"][$key_file]);

            $ext = pathinfo($files["uploadFile"]["name"][$key_file], PATHINFO_EXTENSION);

            $file_ext = $ext;



            if(!in_array($file_ext, $valid_file_formats[$request["file_description"]])){
                // Configure the stub.
                throw $exceptions_to_throw[$request["file_description"]];
            }

            $tmp_name = $files["uploadFile"]["tmp_name"][$key_file];
            $filename = $files["uploadFile"]["name"][$key_file];
            $type = $files["uploadFile"]["type"][$key_file];


            $data=array(
                'tmp_name' => $tmp_name,
                'filename' => $filename,
                'type' => $type,
            );





            $name = $candidate->getId()."_".$data["filename"];


            $upload_successful = false;
            if (!empty($data)) {
                //$upload_successful = move_uploaded_file($data["tmp_name"],$dir."/".$name);

                $result['files_uploaded'][] = [
                    "name" => $name,
                    "tmp_name" => $data["tmp_name"]
                ];

            }

        }

        $result["tb_applicant_files"] = [];


        foreach ($result["files_uploaded"] as $data) {
            //When all files pass size and formats proceed to upload
            $upload_successful = move_uploaded_file($data["tmp_name"],$dir."/".$data["name"]);


            if($upload_successful){
                $candidate->setDateUpdated(new \DateTime());
                $new_applicant_file = new ApplicantFile();

                $new_applicant_file->setCandidate($candidate);
                $new_applicant_file->setDateCreated(new \DateTime());
                $new_applicant_file->setFileDescription($request['file_description']);
                $new_applicant_file->setPermission("ALL");
                $new_applicant_file->setLocked(1);
                $new_applicant_file->setName($data["name"]);

                $added = $candidate->addApplicantFile($new_applicant_file);



                if(empty($added)){
                    $criteria = Criteria::create()
                        ->where(Criteria::expr()->eq("name", $data["name"]));


                    $existing_entries = $candidate->getApplicantFiles()->matching(
                        $criteria
                    );

                    //remove previous with file name
                    foreach ($existing_entries as $existing_entry) {
                        $removed = $candidate->removeApplicantFile($existing_entry);
                        $this->getEntityManager()->remove($existing_entry);

                        $result["files_duplicate"][] = $existing_entry->toArray();
                    }

                    $added = $candidate->addApplicantFile($new_applicant_file);
                }

                $historyChanges = "uploaded a " . $request["file_description"] . " file named <font color=#FF0000>[" . $data["name"] . "]</font>";


                $this->createStaffHistory($candidate, $recruiter, $historyChanges, $dateCreated);


                $this->getEntityManager()->persist($candidate);

                $result["tb_applicant_files"][] = $new_applicant_file->toArray();


                $result["success"] = true;

                $result["result"] = "Files successfully uploaded!";





            } else{
                throw new \Exception("Files not uploaded!");
            }
        }


        $this->getEntityManager()->flush();

        return $result;
    }
} 