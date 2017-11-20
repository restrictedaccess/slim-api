<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 2:48 PM
 */

namespace RemoteStaff\Workers;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\SolrSlimCandidate;
use RemoteStaff\Workers\AbstractWorker;
use Solarium\Client;
use RemoteStaff\Resources\CandidateResource as MyCandidateResource;
use RemoteStaff\Mongo\Resources\CandidateResource as MongoCandidateResource;

class IndexCandidates extends AbstractWorker{
    public function init(){
        $this->setLoggerFileName("index_candidates");
    }
    public function sync($data, $candidate_to_sync = null){
        $candidateId = $data["candidate_id"];


        $client = new Client($this->getSolrConfig("candidates"));
        $resumeClient = new Client($this->getSolrConfig("resume"));
        $mysqlResource = new MyCandidateResource();


        $update = $client->createUpdate();
        $doc = $update->createDocument();

        $candidate = $candidate_to_sync;

        if($candidate === null){
            $candidate = $mysqlResource->get($candidateId);
        }

        $content = $candidate->getContent();

        $doc->setField("content", $content);
        $doc->setField("id", $candidate->getUserid());
        $doc->setField("personal_profile_completion", $candidate->getPoints());
        $doc->setField("candidate_progress", $candidate->getProgress());
        $doc->setField("personal_userid", $candidate->getUserid());
        $doc->setField("personal_lname", $candidate->getLastName());
        $doc->setField("personal_fname", $candidate->getFirstName());
        $doc->setField("personal_gender", $candidate->getGender());
        $doc->setField("personal_nationality", $candidate->getNationality());
        $doc->setField("personal_email", $candidate->getEmail());
        if(!empty($candidate->getDateCreated())){
            $doc->setField("personal_datecreated", date_format($candidate->getDateCreated(), "Y-m-d\\Th:m:s\\Z"));
        }

        if(!empty($candidate->getDateUpdated())){
            $doc->setField("personal_dateupdated", date_format($candidate->getDateUpdated(), "Y-m-d\\Th:m:s\\Z"));
        }


        $doc->setField("personal_nick_name", $candidate->getNickName());
        $doc->setField("personal_permanent_residence", $candidate->getPermanentAddress());
        $doc->setField("personal_alt_email", $candidate->getAlternateEmailAddress());
        $doc->setField("personal_handphone_no", $candidate->getMobile());
        $doc->setField("personal_tel_no", $candidate->getTelephone());
        $doc->setField("personal_address1", $candidate->getAddress1());
        $doc->setField("personal_address2", $candidate->getAddress2());
        $doc->setField("personal_postcode", $candidate->getPostcode());
        $doc->setField("personal_home_working_environment", $candidate->getWorkingEnvironment());
        $doc->setField("personal_internet_connection", $candidate->getInternetConnection());
        $doc->setField("personal_skype_id", $candidate->getSkypeId());
        $doc->setField("personal_yahoo_id", $candidate->getYahoo());
        $doc->setField("personal_isp", $candidate->getIsp());
        $doc->setField("personal_computer_hardware", $candidate->getComputerHardware());
        $doc->setField("personal_registered_email", $candidate->getRegisteredEmail());
        $doc->setField("personal_marital_status", $candidate->getMaritalStatus());
        $doc->setField("personal_reason_to_wfh", $candidate->getReasonToWorkFromHome());
        $doc->setField("personal_timespan", $candidate->getTimeSpan());
        $doc->setField("personal_speed_test", $candidate->getSpeedTest());
        $doc->setField("personal_noise_level", $candidate->getNoiseLevel());
        $doc->setField("personal_external_source", $candidate->getExternalSource());
        if ($candidate->getEducation()!=null){
            $doc->setField("education_educationallevel", $candidate->getEducation()->getEducationalLevel());
            $doc->setField("education_fieldstudy", $candidate->getEducation()->getFieldStudy());
            $doc->setField("education_major", $candidate->getEducation()->getMajor());
            $doc->setField("education_college_name", $candidate->getEducation()->getCollegeName());
            $doc->setField("education_college_country", $candidate->getEducation()->getCollegeCountry());
            $doc->setField("education_trainings_seminars", $candidate->getEducation()->getTrainingsSeminar());
            $doc->setField("education_licence_certification", $candidate->getEducation()->getLicenceCertification());
        }
        $activeRecruiter = $candidate->getActiveRecruiter();
        if ($activeRecruiter!=null){
            $doc->setField("recruiter_assigned_id", $activeRecruiter->getId());
            $doc->setField("recruiter_assigned_first_name", $activeRecruiter->getFirstName());
            $doc->setField("recruiter_assigned_last_name", $activeRecruiter->getLastName());
            $doc->setField("recruiter_assigned_full_name", $activeRecruiter->getName());
        }
        if($candidate->getEmployeeCurrentProfile() !== null){
            $doc->setField("currentjob_latest_job_title", $candidate->getEmployeeCurrentProfile()->getLatestJobTitle());
        }

        foreach($candidate->getSkills() as $skill){
            /**
             * @var $skill \RemoteStaff\Entities\Skill
             */
            $doc->addField("skills",trim($skill->getSkill()));
        }
        foreach($candidate->getEvaluationNotes() as $evaluationNote){
            /**
             * @var $evaluationNote \RemoteStaff\Entities\EvaluationComment
             */
            $doc->addField("evaluation_notes", $evaluationNote->getComments());
        }

        $docs[] = $doc;
        $update -> addDocuments($docs);
        $update -> addCommit();

        $result = $client -> update($update);

        return ["success" => true, "result" => $doc];
    }


    public function syncAll(){
        $mysqlResource = new MyCandidateResource();


        while(true){
            $candidates = $mysqlResource->getAllSolrSlimCandidates(1, 200);

            if(empty($candidates)){
                echo "\n\nBreaking no more candidates\n\n";
                break;
            }

            /**
             * @var Personal $candidate
             */
            foreach ($candidates as $candidate) {

                if(
                    !empty($candidate->getFirstName())
                    && !empty($candidate->getEmail())
                    && !empty($candidate->getUserid())
                ){
                    echo "\n\nIndexing candidate " . $candidate->getUserid();
                    $data_to_send = [
                        "candidate_id" => $candidate->getUserid()
                    ];

                    $this->sync($data_to_send, $candidate);
                }


                $new_slim_sync = new SolrSlimCandidate();

                $new_slim_sync->setCandidate($candidate);
                $new_slim_sync->setDateSynced(new \DateTime());


                $mysqlResource->getEntityManager()->persist($new_slim_sync);

                $mysqlResource->getEntityManager()->flush();
                //break;
            }
            //break;
        }
        
        return true;

    }
} 