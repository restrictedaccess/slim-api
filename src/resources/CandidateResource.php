<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 09/08/16
 * Time: 8:38 PM
 */

namespace RemoteStaff\Resources;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations\Date;
use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\AssessmentList;
use RemoteStaff\Entities\AssessmentResults;
use RemoteStaff\Entities\EmployeeCurrentProfile;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\MongoCandidate;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\ResumeCreationHistory;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Entities\UnprocessedCandidate;
use RemoteStaff\Resources\AdminResource;
use RemoteStaff\Entities\SolrSlimCandidate;
use RemoteStaff\Entities\Admin;

use RemoteStaff\Entities\Skill;

/**
 * Resource for Candidate Data
 * Class CandidateResource
 * @package RemoteStaff\Resources
 *
 */
class CandidateResource extends AbstractResource {

    /**
     * @param $page
     * @param $limit
     * @return RemoteStaff\Entities\Personal[]
     * @throws Exception
     */
    public function getAll($page, $limit){


        if ($page===null){
            throw new Exception("Page is required!");
        }
        if ($limit===null){
            throw new Exception("Limit is required!");
        }

        $em = $this->getEntityManager();
        $offset = ($page - 1) * $limit;

        $query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Personal c WHERE NOT EXISTS (SELECT mc FROM RemoteStaff\Entities\MongoCandidate mc WHERE mc.candidate = c) ');
        $query->setFirstResult($offset);
        $query->setMaxResults($limit);

        $candidates = $query->getResult();
        return $candidates;
    }

    /**
     * @param $page
     * @param $limit
     * @return mixed
     */
    public function getAllSolrSlimCandidates($page, $limit){


        if ($page===null){
            throw new Exception("Page is required!");
        }
        if ($limit===null){
            throw new Exception("Limit is required!");
        }


        $em = $this->getEntityManager();
        $offset = ($page - 1) * $limit;

        $query = $em->createQuery('SELECT c FROM RemoteStaff\Entities\Personal c WHERE NOT EXISTS (SELECT ssc FROM RemoteStaff\Entities\SolrSlimCandidate ssc WHERE ssc.candidate = c) ORDER BY c.id DESC ');

        $query->setFirstResult($offset);
        $query->setMaxResults($limit);

        $candidates = $query->getResult();
        return $candidates;

    }

    /**
     * @param $id The userid of the Candidate
     * @return \RemoteStaff\Entities\Personal
     * @throws Exception
     */
    public function get($id){
        if ($id===null){
            throw new \Exception("ID is required");
        }
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($id);
        return $candidate;
    }


    public function getByEmail($email){
        if ($email===null){
            throw new \Exception("Email is required");
        }
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->findOneBy(["email"=>$email]);
        return $candidate;
    }


    public function getAdmin($admin_id){
        if ($admin_id===null){
            throw new \Exception("Admin ID is required");
        }
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->findOneBy(["admin_id"=>$admin_id]);
        return $candidate;
    }

    /**
     * @params $candidate_id
     * @return boolean
     * @throws \Exception
     */
    public function hasRecruiter($candidate_id){
        if($candidate_id === null){
            throw new \Exception("Candidate ID is required");
        }

        $candidate = $this->get($candidate_id);

        $recruiter = null;

        if($candidate->getActiveRecruiter() !== null){
            $recruiter = $candidate->getActiveRecruiter()->toArray();
        }
        return $recruiter;
    }

    /**
     * @param $candidateRaw
     * @return Personal
     * @throws Exception
     * @throws \Exception
     */
    public function create($candidateRaw){

        //look for Possible personal account



        $candidate = $this->getByEmail($candidateRaw["email"]);

        $found = true;
        if (!$candidate){
            $found = false;
            $candidate = new Personal();
            $candidate->setDateCreated(new \DateTime());
        }


        $candidate->setFirstName(trim($candidateRaw["first_name"]));
        $candidate->setLastName(trim($candidateRaw["last_name"]));
        $candidate->setEmail(trim($candidateRaw["email"]));
        $candidate->setMobile(trim($candidateRaw["mobile"]));
        $candidate->setRegisteredEmail(trim($candidateRaw["email"]));
        $candidate->setDateUpdated(new \DateTime());

        if (!$found){
            $password = $candidate->generatePassword();
        }
        $this->getEntityManager()->persist($candidate);
        $this->createEmployeeCurrentProfile($candidate, trim($candidateRaw["latest_job_title"]));
        $this->getEntityManager()->persist($candidate->getEmployeeCurrentProfile());


        $recruiter = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find(intval($candidateRaw["recruiter"]["id"]));
        $recruiterStaff = $this->assignRecruiter($candidate, $recruiter);
        $createResumeHistory = $this->createResumeHistory($candidate, $recruiter);
        $historyChanges = "admin created resume for candidate";
        $staffHistory = $this->createStaffHistory($candidate, $recruiter, $historyChanges);
        $this->createUnprocessedEntry($candidate);
        $this->getEntityManager()->persist($candidate->getUnprocessedEntry());
        $this->getEntityManager()->persist($recruiterStaff);
        $this->getEntityManager()->persist($createResumeHistory);
        $this->getEntityManager()->persist($staffHistory);

        $this->getEntityManager()->flush();
        return $candidate;
    }

    /**
    * Update latest job title of given candidate
    */
    public function updateLatestJobTitle(Personal $candidate, $latestJobTitle){

        //if has current profile

        $currentProfile = $candidate->getEmployeeCurrentProfile();

        if ($currentProfile){
            $candidate->getEmployeeCurrentProfile()->setLatestJobTitle($latestJobTitle);
        }else{
            $currentProfile = new EmployeeCurrentProfile();
            $currentProfile->setCandidate($candidate);
            $currentProfile->setLatestJobTitle($latestJobTitle);
            $candidate->setEmployeeCurrentProfile($currentProfile);
        }

        $this->getEntityManager()->persist($candidate->getEmployeeCurrentProfile());
        $this->getEntityManager()->flush();
    }

    /**
    * Update personal information of given candidate
    * @param Personal $candidate
    * $information - associative array
    */
    public function updatePersonalInformation(Personal $candidate, $information){

        $candidate->setGender(trim($information['gender']));
        $candidate->setNationality(trim($information['nationality']));
        $candidate->setPermanentAddress(trim($information['permanentAddress']));

        //Birth Date
        $candidate->setBirthDateYear($information['birthDateYear']);
        $candidate->setBirthDateMonth($information['birthDateMonth']);
        $candidate->setBirthDateDay($information['birthDateDay']);

        $candidate->setDateUpdated(new \DateTime());

        $this->getEntityManager()->persist($candidate);
        $this->getEntityManager()->flush();
    }

    /**
     * Add Skill for candidate
     * @param Personal $candidate
     * @param Admin $recruiter
     */
    public function addSkill(Personal $candidate, Admin $recruiter, $params){

        $skill = new Skill();
        $skill->setCandidate($candidate);
        $skill->setSkill(trim($params['name']));
        $skill->setProficiency($params['proficiency']);
        $skill->setExperience($params['experience']);
        $skill->setDateCreated(new \DateTime());
        $addedSkill = null;
        $result = [];
        $result["success"] = false;
        try {
            $addedSkill = $candidate->addSkill($skill);
            $result["result"] = $addedSkill->getSkill();
        }catch(\Exception $e){
            $result["error"] = $e;
        }

        if($addedSkill != null) {
            $result["added"] = true;
            $candidate->setDateUpdated(new \DateTime());
            $historyChanges = "Added new skill" . $addedSkill->getSkill();
            $staffHistory = $this->createStaffHistory($candidate, $recruiter, $historyChanges);
            $this->getEntityManager()->persist($addedSkill);
            $this->getEntityManager()->persist($staffHistory);
            $this->getEntityManager()->persist($candidate);

            $this->getEntityManager()->flush();
            $lastId = $addedSkill->getId();
            $result["lastId"] = $lastId;

            $result["success"] = true;
        }
        else{
            $result["success"] = false;
        }
        return $result;
    }

    public function getCandidateSkills($params) {
        $skillArr = [];
        /**
         * @var Personal $candidate
         */
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["userid"]);
        $skills = $candidate->getSkills();

        foreach ($skills as $key => $value) {
            $skillArr[] = [
                "skill" => $value->getSkill(),
                "proficiency" => intval($value->getProficiency()),
                "experience" => intval($value->getExperience()),
                "id" => $value->getId()
            ];
        }
        return $skillArr;
    }

    public function getTestTaken($params){
        $testTakenArr = [];
        /**
         * @var Personal $candidate
         */
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["userid"]);
        $testTaken = $candidate->getAssesmentResult();

        /**
         * @var AssessmentResults $value
         */
        foreach ($testTaken as $key => $value) {
            /**
             * @var AssessmentList $listName
             */
            $listName = $value->getAssementList();
            $testTakenArr[] = [
                "resultType" => $value->getResultType(),
                "resultScore" => $value->getResultScore(),
                "resultPct" => $value->getResultPct(),
                "resultDate" => $value->getResultDate(),
                "name" => $listName->getAssessmentTitle()
            ];
        }

        return $testTakenArr;

    }

    public function deleteSkill($params) {

        /**
         * @var Personal $candidate
         */
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["userId"]);
        /**
         * @var Admin $admin
         */
        $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($params["admin"]);
        /**
         * @var Skill $skill
         */
        $skill = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Skill')->find($params["id"]);

        $historyChanges = "Deleted new skill" . $skill->getSkill();
        $staffHistory = $this->createStaffHistory($candidate, $admin, $historyChanges);

        $this->getEntityManager()->persist($staffHistory);
        $this->getEntityManager()->remove($skill);
        $this->getEntityManager()->flush();

        return true;
    }




    /**
     * Create Resume History for Candidate
     * @param Personal $candidate
     */
    public function createResumeHistory(Personal $candidate, Admin $recruiter){
        $createResumeHistory = new ResumeCreationHistory();
        $createResumeHistory->setCandidate($candidate);
        $createResumeHistory->setRecruiter($recruiter);
        $createResumeHistory->setDateCreated(new \DateTime());
        $candidate->setCreatedResumeHistory($createResumeHistory);
        $recruiter->getCreatedResumeHistory()->add($createResumeHistory);
        return $createResumeHistory;
    }

    /**
     * Mark personal as mongo synced
     * @param Personal $candidate
     */
    public function markSynced(Personal $candidate){
        $mongoCandidate = new MongoCandidate();
        $mongoCandidate->setCandidate($candidate);
        $mongoCandidate->setDate(new \DateTime());
        $candidate->setMongoSynced($mongoCandidate);
    }

    /**
     * Create employee current profile for Candidate
     * @param Personal $candidate
     * @param $latestJobTitle
     */
    public function createEmployeeCurrentProfile(Personal $candidate, $latestJobTitle){
        if (!$candidate->getEmployeeCurrentProfile()){
            $employeeCurrentProfile = new EmployeeCurrentProfile();
            $employeeCurrentProfile->setCandidate($candidate);
            $employeeCurrentProfile->setLatestJobTitle($latestJobTitle);
            $candidate->setEmployeeCurrentProfile($employeeCurrentProfile);
        }
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
//        $list = $recruiter->getRecruiterStaff();
//        foreach($list as $recruiterStaffEntry){
//            $list->removeElement($recruiterStaffEntry);
//            $this->getEntityManager()->remove($recruiterStaffEntry);
//        }
        $list = $candidate->getRecruiterStaff();
        foreach($list as $recruiterStaffEntry){
            /**
             * @var $recruiterStaffEntry RecruiterStaff
             */
            if($recruiterStaffEntry->getCandidate()->getId() == $candidate->getId()){
                $list->removeElement($recruiterStaffEntry);
                $this->getEntityManager()->remove($recruiterStaffEntry);
            }

        }


        $recruiter->getRecruiterStaff()->add($recruiterStaff);
        $candidate->getRecruiterStaff()->add($recruiterStaff);
        $this->getEntityManager()->persist($candidate);
        $this->getEntityManager()->persist($recruiter);
        return $recruiterStaff;
    }

    /**
     * Create Unprocessed Entry for Staff
     * @param Personal $candidate
     */
    public function createUnprocessedEntry(Personal $candidate){
        $unprocessedEntry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\UnprocessedCandidate')
            ->findOneBy(["candidate"=>$candidate]);
        if (!$unprocessedEntry){
            $unprocessedEntry = new UnprocessedCandidate();
            $unprocessedEntry->setCandidate($candidate);
            $unprocessedEntry->setDate(new \DateTime());
            $unprocessedEntry->setAdmin($candidate->getActiveRecruiter());
            $candidate->setUnprocessedEntry($unprocessedEntry);
        }

    }

    /**
     * Update personal Information from Step 3
     * @param Personal $candidate
     * @param $candidateRaw
     */
    public function updatePersonalInformationFromStep3(Personal $candidate, $candidateRaw){
        $candidate->setPermanentAddress($candidateRaw["permanentAddress"]);
        $candidate->setNationality($candidateRaw["nationality"]);
        $candidate->setGender($candidateRaw["gender"]);
        $dateTime = new \DateTime();
        $dateTime->setTimestamp($candidateRaw["birthDate"]);
        $dateTime->setTimezone(new \DateTimeZone("Asia/Manila"));
        $candidate->setBirthDateYear($dateTime->format("Y"));
        $candidate->setBirthDateMonth($dateTime->format("m"));
        $candidate->setBirthDateDay($dateTime->format("d"));

    }


}
