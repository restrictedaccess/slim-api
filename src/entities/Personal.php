<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 27/07/16
 * Time: 9:55 AM
 */

namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;
use RemoteStaff\Interfaces\Persistable;
use RemoteStaff\Exceptions\InvalidArgumentException;

/**
 * Class Personal
 * @Entity
 * @Table(name="personal")
 */
class Personal implements Persistable{

    /**
     * @var int
     * @Id @Column(type="integer", name="userid")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="string", name="fname")
     */
    private $firstName = null;

    /**
     * @var string
     * @Column(type="string", name="lname")
     */
    private $lastName = null;

    /**
     * @var string
     * @Column(type="string", name="email")
     */
    private $email = null;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="datecreated")
     */
    private $dateCreated = null;



    /**
     * @var \DateTime
     * @Column(type="datetime", name="dateupdated")
     */
    private $dateUpdated = null;

    /**
     * @var string
     * @Column(type="string", name="postcode")
     */
    private $postcode = "";

    /**
     * @var string
     * @Column(type="string", name="yahoo_id")
     */
    private $yahoo = "";

    /**
     * @var string
     * @Column(type="string", name="skype_id")
     */
    private $skypeId;

    /**
     * @var string
     * @Column(type="string", name="computer_hardware")
     */
    private $computerHardware;

    /**
     * @var string
     * @Column(type="string", name="headset_quality")
     */
    private $headsetQuality;


    /**
     * @var Array
     * @OneToMany(targetEntity="RemoteStaff\Entities\Subcontractor", mappedBy="personal_information")
     *
     */
    private $subcontractors = [];

    /**
     * @var \RemoteStaff\Entities\UnprocessedCandidate
     * @OneToOne(targetEntity="RemoteStaff\Entities\UnprocessedCandidate", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $unprocessedEntry = null;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\ApplicationHistory", mappedBy="candidate")
     *
     */
    private $CallNotes = [];

    /**
     * @var \RemoteStaff\Entities\Evaluation
     * @OneToOne(targetEntity="RemoteStaff\Entities\Evaluation", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $Evaluation;

    /**
     * @var \RemoteStaff\Entities\StaffRate
     * @OneToOne(targetEntity="RemoteStaff\Entities\StaffRate", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $staffRate = null;

    /**
     * @var \RemoteStaff\Entities\StaffTimezone
     * @OneToOne(targetEntity="RemoteStaff\Entities\StaffTimezone", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $staffTimezone = null;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\EvaluationComment", mappedBy="candidate")
     *
     */
    private $evaluationNotes = [];

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\EmploymentHistory", mappedBy="candidate")
     *
     */
    private $employmentHistory = [];

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\AssessmentResults", mappedBy="candidate")
     *
     */
    private $assesmentResult = [];

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\PreviousJobIndustry", mappedBy="candidate")
     *
     */
    private $previousJobIndustry = [];


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\NoShowEntry", mappedBy="candidate")
     *
     */
    private $noShowEntries;


    /**
     * @var \RemoteStaff\Entities\MongoCandidate
     * @OneToOne(targetEntity="RemoteStaff\Entities\MongoCandidate", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $mongoSynced = null;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\RecruiterStaff", mappedBy="candidate", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $recruiterStaff = null;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\ApplicantFile", mappedBy="candidate", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $applicantFiles;

    /**
     * @var \RemoteStaff\Entities\EmployeeCurrentProfile
     * @OneToOne(targetEntity="RemoteStaff\Entities\EmployeeCurrentProfile", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $employeeCurrentProfile = null;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\Skill", mappedBy="candidate", cascade={"remove"})
     */
    private $skills;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\Language", mappedBy="candidate", cascade={"remove", "persist"})
     */
    private $languages;

    /**
     * @return ArrayCollection
     */
    public function getLanguages()
    {
        return $this->languages;
    }

    /**
     * @param ArrayCollection $languages
     */
    public function setLanguages($languages)
    {
        $this->languages = $languages;
    }


    /**
     * @param $language
     * @return null
     * @throws \Exception
     */
    public function addLanguage($language){

        $found = false;
        $added = null;


        //Check if skill already exist
        foreach ($this->getLanguages() as $languageExist) {
            if($language->getLanguage() == $languageExist->getLanguage()){
                $found = true;
            }
        }

        if(!$found){
            $this->getLanguages()->add($language);
            $added = $language;
        }else {
            throw new \Exception("Language is Already Added");
        }

        return $added;
    }

    /**
     * @param \RemoteStaff\Entities\Language $language
     *
     * @return \RemoteStaff\Entities\Language
     */
    public function removeLanguage($language){
        $newArr = new ArrayCollection();

        $deleted = null;

        foreach ($this->getLanguages() as $languageExist) {
            if($language->getLanguage() != $languageExist->getLanguage()){
                $newArr->add($languageExist);
            } else{
                $deleted = $languageExist;
            }
        }

        $this->setLanguages($newArr);

        return $deleted;
    }

    /**
     * @var \RemoteStaff\Entities\ResumeCreationHistory
     * @OneToOne(targetEntity="RemoteStaff\Entities\ResumeCreationHistory", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $createdResumeHistory;

    /**
     * @var string
     * @Column(type="string", name="pregnant")
     */
    private $pregnant;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\ShortlistEntry", mappedBy="candidate", cascade={"remove"})
     */
    private $shortlists;
    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\EndorsementEntry", mappedBy="candidate", cascade={"remove"})
     */
    private $endorsements;

    /**
     * @var \RemoteStaff\Entities\PreScreenedCandidate
     * @OneToOne(targetEntity="RemoteStaff\Entities\PreScreenedCandidate", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $preScreenedEntry;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\InactiveEntry", mappedBy="candidate")
     */
    private $inactiveEntries;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\RemoteReadyEntry", mappedBy="candidate", cascade={"remove"})
     */
    private $remoteReadyEntries;

    /**
     * @var \RemoteStaff\Entities\Education
     * @OneToOne(targetEntity="RemoteStaff\Entities\Education", mappedBy="candidate", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $education;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\CategorizedEntry", mappedBy="candidate", cascade={"remove", "persist"}, orphanRemoval=true)
     */
    private $categorizedEntries;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\RequestForInterview", mappedBy="candidate", cascade={"remove"})
     */
    private $requestForInterviews;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\StaffHistory", mappedBy="candidate", cascade={"all"})
     */
    private $staffHistory;

    /**
     * @var string
     * @Column(type="string", name="voice_path")
     */
    private $voice = null;

    /**
     * @var string
     * @Column(type="string", name="image")
     */
    private $image = null;

    /**
     * @var string
     * @Column(type="string", name="pass")
     */
    private $password = "";

    /**
     * @var string
     */
    private $generatedPassword = "";

    /**
     * @var string
     * @Column(type="string", name="handphone_no")
     */
    private $mobile = "";


    /**
     * @var string
     * @Column(type="string", name="nick_name")
     */
    private $nickName;

    /**
     * @var string
     * @Column(type="string", name="middle_name")
     */
    private $middleName;

    /**
     * @var int
     * @Column(type="integer", name="byear")
     */
    private $birthDateYear;

    /**
     * @var int
     * @Column(type="integer", name="bmonth")
     */
    private $birthDateMonth;

    /**
     * @var int
     * @Column(type="integer", name="bday")
     */
    private $birthDateDay;

    /**
     * @var string
     * @Column(type="string", name="gender")
     */
    private $gender;

    /**
     * @var string
     * @Column(type="string", name="nationality")
     */
    private $nationality;

    /**
     * @var string
     * @Column(type="string", name="permanent_residence")
     */
    private $permanentAddress;

    /**
     * @var string
     * @Column(type="string", name="alt_email")
     */
    private $alternateEmailAddress;

    /**
     * @var string
     * @Column(type="string", name="handphone_country_code")
     */
    private $mobileAreaCode;

    /**
     * @var string
     * @Column(type="string", name="tel_no")
     */
    private $telephone;

    /**
     * @var string
     * @Column(type="string", name="address1")
     */
    private $address1;

    /**
     * @var string
     * @Column(type="string", name="address2")
     */
    private $address2;

    /**
     * @var string
     * @Column(type="string", name="state")
     */
    private $state;
    /**
     * @var string
     * @Column(type="string", name="city")
     */
    private $city;
    /**
     * @var string
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Country", inversedBy="candidates")
     * @JoinColumn(name="country_id", referencedColumnName="iso")
     * @Column(type="string", name="country_id")
     */
    private $country;

    /**
     * @var string
     * @Column(type="string", name="home_working_environment")
     */
    private $workingEnvironment;

    /**
     * @var string
     * @Column(type="string", name="internet_connection")
     */
    private $internetConnection;

    /**
     * @var string
     * @Column(type="string", name="isp")
     */
    private $isp;

    /**
     * @var string
     * @Column(type="string", name="registered_email")
     */
    private $registeredEmail;

    /**
     * @var string
     * @Column(type="string", name="marital_status")
     */
    private $maritalStatus;

    /**
     * @var string
     * @Column(type="string", name="no_of_kids")
     */
    private $numberOfKids;

    /**
     * @var string
     * @Column(type="string", name="internet_consequences")
     */
    private $internetConsequences;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @OneToOne(targetEntity="RemoteStaff\Entities\Admin", mappedBy="personalInformation", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $adminInformation;

    /**
     * @return string
     */
    public function getSkypeId()
    {
        return $this->skypeId;
    }

    /**
     * @param string $skypeId
     */
    public function setSkypeId($skypeId)
    {
        $this->skypeId = $skypeId;
    }

    /**
     * @return boolean
     */
    public function isWorkFromHomeBefore()
    {
        return $this->workFromHomeBefore;
    }

    /**
     * @param boolean $workFromHomeBefore
     */
    public function setWorkFromHomeBefore($workFromHomeBefore)
    {
        $this->workFromHomeBefore = $workFromHomeBefore;
    }

    /**
     * @return int
     */
    public function getEnglishCommunicationSkill()
    {
        return $this->englishCommunicationSkill;
    }

    /**
     * @param int $englishCommunicationSkill
     */
    public function setEnglishCommunicationSkill($englishCommunicationSkill)
    {
        $this->englishCommunicationSkill = $englishCommunicationSkill;
    }

    /**
     * @return mixed
     */
    public function getExternalSource()
    {
        return $this->externalSource;
    }

    /**
     * @param mixed $externalSource
     */
    public function setExternalSource($externalSource)
    {
        $this->externalSource = $externalSource;
    }

    /**
     * @return string
     */
    public function getLinkedIn()
    {
        return $this->linkedIn;
    }

    /**
     * @param string $linkedIn
     */
    public function setLinkedIn($linkedIn)
    {
        $this->linkedIn = $linkedIn;
    }

    /**
     * @return string
     */
    public function getNoiseLevel()
    {
        return $this->noiseLevel;
    }

    /**
     * @param string $noiseLevel
     */
    public function setNoiseLevel($noiseLevel)
    {
        $this->noiseLevel = $noiseLevel;
    }

    /**
     * @return string
     */
    public function getNumberOfKids()
    {
        return $this->numberOfKids;
    }

    /**
     * @param string $numberOfKids
     */
    public function setNumberOfKids($numberOfKids)
    {
        $this->numberOfKids = $numberOfKids;
    }

    /**
     * @return boolean
     */
    public function isPendingVisaApplication()
    {
        return $this->pendingVisaApplication;
    }

    /**
     * @param boolean $pendingVisaApplication
     */
    public function setPendingVisaApplication($pendingVisaApplication)
    {
        $this->pendingVisaApplication = $pendingVisaApplication;
    }

    /**
     * @return string
     */
    public function getPregnant()
    {
        return $this->pregnant;
    }

    /**
     * @param string $pregnant
     */
    public function setPregnant($pregnant)
    {
        $this->pregnant = $pregnant;
    }

    /**
     * @return string
     */
    public function getReasonToWorkFromHome()
    {
        return $this->reasonToWorkFromHome;
    }

    /**
     * @param string $reasonToWorkFromHome
     */
    public function setReasonToWorkFromHome($reasonToWorkFromHome)
    {
        $this->reasonToWorkFromHome = $reasonToWorkFromHome;
    }

    /**
     * @return string
     */
    public function getReferredBy()
    {
        return $this->referredBy;
    }

    /**
     * @param string $referredBy
     */
    public function setReferredBy($referredBy)
    {
        $this->referredBy = $referredBy;
    }

    /**
     * @return string
     */
    public function getSpeedTest()
    {
        return $this->speedTest;
    }

    /**
     * @param string $speedTest
     */
    public function setSpeedTest($speedTest)
    {
        $this->speedTest = $speedTest;
    }

    /**
     * @return Array
     */
    public function getSubcontractors()
    {
        return $this->subcontractors;
    }

    /**
     * @param Array $subcontractors
     */
    public function setSubcontractors($subcontractors)
    {
        $this->subcontractors = $subcontractors;
    }

    /**
     * @return string
     */
    public function getTimeSpan()
    {
        return $this->timeSpan;
    }

    /**
     * @param string $timeSpan
     */
    public function setTimeSpan($timeSpan)
    {
        $this->timeSpan = $timeSpan;
    }

    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->id;
    }

    /**
     * @param int $userid
     */
    public function setUserid($userid)
    {
        $this->id = $userid;
    }

    /**
     * @var boolean
     * @Column(type="boolean", name="pending_visa_application")
     */
    private $pendingVisaApplication;

    /**
     * @var boolean
     * @Column(type="boolean", name="active_visa")
     */
    private $activeVisa;
    /**
     * @var boolean
     * @Column(type="boolean", name="work_from_home_before")
     */
    private $workFromHomeBefore;

    /**
     * @var string
     * @Column(type="string", name="reason_to_wfh")
     */
    private $reasonToWorkFromHome;

    /**
     * @var string
     * @Column(type="string", name="timespan")
     */
    private $timeSpan;

    /**
     * @var string
     * @Column(type="string", name="speed_test")
     */
    private $speedTest;

    /**
     * @var string
     * @Column(type="string", name="noise_level")
     */
    private $noiseLevel;

    /**
     * @var string
     * @Column(type="string", name="referred_by")
     */
    private $referredBy;

    /**
     * @var string
     * @Column(type="string", name="external_source")
     */
    private $externalSource;
    /**
     * @var int
     * @Column(type="integer", name="english_communication_skill")
     */
    private $englishCommunicationSkill;
    /**
     * @var string
     * @Column(type="string", name="linked_in")
     */
    private $linkedIn;
    /**
     * @var string
     * @Column(type="string", name="facebook_id")
     */
    private $facebookId;


    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = sha1($password);
    }



    /**
     * Generate a password for the newly created profile
     */
    public function generatePassword(){
        $password = $this->randomizePassword(10);
        $this->generatedPassword = $password;
        $this->setPassword($password);
        return $password;
    }

    /**
     * Create a string of randomizePassword
     * @param int $length
     * @param string $chars
     * @return string
     */
    private function randomizePassword($length = 12, $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890') {
        // Length of character list
        $chars_length = strlen($chars);
        // Start our string
        $string = $chars{rand(0, $chars_length)};
        // Generate random string
        for ($i = 1; $i < $length; $i++) {
            // Grab a random character from our list
            $r = $chars{rand(0, $chars_length)};
            $string = $string . $r;
        }
        // Return the string
        return $string;
    }




    /**
     * Constructor class
     */
    public function __construct(){
        $this->subcontractors = new ArrayCollection();
        $this->recruiterStaff = new ArrayCollection();
        $this->applicantFiles = new ArrayCollection();
        $this->CallNotes     = new ArrayCollection();
        $this->evaluationNotes  = new ArrayCollection();
        $this->employmentHistory  = new ArrayCollection();
        $this->skills = new ArrayCollection();
        $this->inactiveEntries = new ArrayCollection();
        $this->shortlists = new ArrayCollection();
        $this->endorsements = new ArrayCollection();
        $this->remoteReadyEntries = new ArrayCollection();
        $this->categorizedEntries = new ArrayCollection();
        $this->requestForInterviews = new ArrayCollection();
        $this->staffHistory = new ArrayCollection();
        $this->noShowEntries = new ArrayCollection();
        $this->assesmentResult = new ArrayCollection();
        $this->previousJobIndustry = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param ArrayCollection $skills
     */
    public function setSkills($skills)
    {
        $this->skills = $skills;
    }

    /**
     * @param \RemoteStaff\Entities\Skill $skill
     */
    public function addSkill($skill){

        $found_skill = false;
        $added_skill = null;

        //Check if skill's' fields is null
        if (empty($skill->getSkill()) || empty($skill->getExperience()) || empty($skill->getProficiency()) ) {
            throw new InvalidArgumentException("Skill name, experience or proficiency is null");
        }

        //Check if skill already exist
        foreach ($this->getSkills() as $skillExist) {
            if($skill->getSkill() == $skillExist->getSkill()){
                $found_skill = true;
            }
        }

        if(!$found_skill){
            $this->getSkills()->add($skill);
            $added_skill = $skill;
        }else {
            throw new InvalidArgumentException("Skill is Already Added");
        }

        return $added_skill;
    }

    /**
     * @param \RemoteStaff\Entities\Skill $skill
     *
     * @return \RemoteStaff\Entities\Skill
     */
    public function removeSkill($skill){
        $newSkills = new ArrayCollection();

        $deletedSkill = null;

        foreach ($this->getSkills() as $skillExist) {
            if($skill->getSkill() != $skillExist->getSkill()){
                $newSkills->add($skillExist);
            } else{
                $deletedSkill = $skillExist;
            }
        }

        $this->setSkills($newSkills);

        return $deletedSkill;
    }

    /**
     * Get the First Name of Staff/Candidate
     * @return string
     */
    public function getFirstName(){
        return $this->firstName;
    }

    /**
     * @param $fname First Name of the Staff
     * @return null
     */
    public function setFirstName($firstName){
        $this->firstName = $firstName;
    }

    /**
     * @return int
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Get the basic information of the staff in array form
     * @return array
     */
    public function getBasic(){
        return [
            "fname"=>$this->getFirstName(),
            "lname"=>$this->getLastName()
        ];
    }

    /**
     * Return the Last Name of the Staff
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName Last name of the Staff
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * Return the Name of the Staff
     * @return string
     */
    public function getName(){
        return $this->getFirstName()." ".$this->getLastName();
    }

    /**
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTime $dateUpdated
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return UnprocessedCandidate
     */
    public function getUnprocessedEntry()
    {
        return $this->unprocessedEntry;
    }

    /**
     * @param UnprocessedCandidate $unprocessedEntry
     */
    public function setUnprocessedEntry($unprocessedEntry)
    {
        $this->unprocessedEntry = $unprocessedEntry;
    }



    /**
     * @return MongoCandidate
     */
    public function getMongoSynced()
    {
        return $this->mongoSynced;
    }

    /**
     * @param MongoCandidate $mongoSynced
     */
    public function setMongoSynced($mongoSynced)
    {
        $this->mongoSynced = $mongoSynced;
    }

    /**
     * @return EmployeeCurrentProfile
     */
    public function getEmployeeCurrentProfile()
    {
        return $this->employeeCurrentProfile;
    }

    /**
     * @param EmployeeCurrentProfile $employeeCurrentProfile
     */
    public function setEmployeeCurrentProfile($employeeCurrentProfile)
    {
        $this->employeeCurrentProfile = $employeeCurrentProfile;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }

    /**
     * @return string
     */
    public function getVoice()
    {
        return $this->voice;
    }

    /**
     * @param string $voice
     */
    public function setVoice($voice)
    {
        $this->voice = $voice;
    }

    /**
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param string $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
    }

    /**
     * @return string
     */
    public function getGeneratedPassword()
    {
        return $this->generatedPassword;
    }

    /**
     * @return ArrayCollection
     */
    public function getRecruiterStaff()
    {
        return $this->recruiterStaff;
    }

    /**
     * @param ArrayCollection $recruiterStaff
     */
    public function setRecruiterStaff($recruiterStaff)
    {
        $this->recruiterStaff = $recruiterStaff;
    }

    /**
     * @return ArrayCollection
     */
    public function getApplicantFiles()
    {
        return $this->applicantFiles;
    }

    /**
     * @param ArrayCollection $applicantFiles
     */
    public function setApplicantFiles($applicantFiles)
    {
        $this->applicantFiles = $applicantFiles;
    }

    /**
     * @param \RemoteStaff\Entities\ApplicantFile $applicantFile
     */
    public function addApplicantFile($applicantFile){
        $found_applicant_file = false;

        foreach ($this->getApplicantFiles() as $applicantFileExist) {
            if($applicantFile->getName() == $applicantFileExist->getName()){
                $found_applicant_file = true;
            }
        }

        if(!$found_applicant_file){
            $this->getApplicantFiles()->add($applicantFile);
        }
    }

    /**
     * @param \RemoteStaff\Entities\ApplicantFile $applicantFile
     *
     * @return \RemoteStaff\Entities\ApplicantFile
     */
    public function removeApplicantFile($applicantFile){
        $newApplicantFiles = new ArrayCollection();

        $deletedApplicantFile = null;

        foreach ($this->getApplicantFiles() as $applicantFileExist) {
            if($applicantFile->getName() != $applicantFileExist->getName()){
                $newApplicantFiles->add($applicantFileExist);
            } else{
                $deletedApplicantFile = $applicantFileExist;
            }
        }

        $this->setApplicantFiles($newApplicantFiles);

        return $deletedApplicantFile;
    }


    /**
     * Get the crawlable content of the profile
     * @return string
     */
    public function getContent(){
        $content = [];
        $content[] = $this->getUserid();
        $content[] = $this->getFirstName();
        $content[] = $this->getLastName();
        $content[] = $this->getMiddleName();
        $content[] = $this->getNickName();
        $content[] = $this->getEmail();
        $content[] = $this->getAddress1();
        $content[] = $this->getAddress2();
        $content[] = $this->getRegisteredEmail();
        $content[] = $this->getPermanentAddress();
        $content[] = $this->getCity();
        $content[] = $this->getState();
        $content[] = $this->getCountry();
        $content[] = $this->getReasonToWorkFromHome();
        $content[] = $this->getReferredBy();
        $content[] = $this->getExternalSource();
        $content[] = $this->getFacebookId();
        $content[] = $this->getGender();
        $content[] = $this->getWorkingEnvironment();
        $content[] = $this->getNationality();
        $content[] = $this->getMobile();
        $content[] = $this->getInternetConnection();
        $content[] = $this->getLinkedIn();
        $content[] = $this->getIsp();
        foreach($this->getSkills() as $skill){
            /**
             * @var $skill \RemoteStaff\Entities\Skill
             */
            $content[] = $skill->getSkill();
        }
        foreach($this->getEvaluationNotes() as $evaluationNote){
            /**
             * @var $evaluationNote \RemoteStaff\Entities\EvaluationComment
             */
            $content[] = $evaluationNote->getComments();
        }



        return implode(" ", $content);
    }

    /**
     * Get Points for Profile Completion
     * @return int
     */
    public function getPoints(){
        $points = 0;
        foreach($this->getRemoteReadyEntries() as $remoteReadyEntry){
            /**
             * @var $remoteReadyEntry \RemoteStaff\Entities\RemoteReadyEntry
             */
            $points += $remoteReadyEntry->getRemoteReadyCriteria()->getPoints();
        }
        return $points;
    }

    /**
     * Return progress of candidate
     * @return array
     */
    public function getProgress(){
        $progress = [];
        if ($this->getUnprocessedEntry()){
            $progress[] = "unprocessed";
        }
        if ($this->getPoints()>=70){
            $progress = [];
            $progress[] = "remote_ready";
        }
        if ($this->getPreScreenedEntry()){
            $progress = [];
            $progress[] = "prescreened";
        }
        if ($this->getCategorizedEntries()->count()!=0){
            $progress = [];
            $progress[] = "categorized";
        }

        if ($this->getShortlists()->count()!=0){
            $progress[] = "shortlisted";
        }
        if ($this->getEndorsements()->count()!=0){
            $progress[] = "endorsed";
        }

        if ($this->getRequestForInterviews()->count()!=0){
            $progress[] = "interviewed";
        }
        if ($this->getInactiveEntries()->count()!=0){
            $progress = [];
            $progress[] = "inactive";
        }

        return $progress;
    }

    /**
     * @return string
     */
    public function getNickName()
    {
        return $this->nickName;
    }

    /**
     * @param string $nickName
     */
    public function setNickName($nickName)
    {
        $this->nickName = $nickName;
    }

    /**
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;
    }

    /**
     * @return int
     */
    public function getBirthDateYear()
    {
        return $this->birthDateYear;
    }

    /**
     * @param int $birthDateYear
     */
    public function setBirthDateYear($birthDateYear)
    {
        if (!is_numeric($birthDateYear) || !isset($birthDateYear)) {
            throw new InvalidArgumentException("Birth Date Year is null or not a number");
        }
        $this->birthDateYear = $birthDateYear;
    }

    /**
     * @return int
     */
    public function getBirthDateMonth()
    {
        return $this->birthDateMonth;
    }

    /**
     * @param int $birthDateMonth
     */
    public function setBirthDateMonth($birthDateMonth)
    {
        if (!is_numeric($birthDateMonth) || !isset($birthDateMonth)) {
            throw new InvalidArgumentException("Birth Date Month is null or not a number");
        }
        $this->birthDateMonth = $birthDateMonth;
    }

    /**
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     */
    public function setGender($gender)
    {
        // if (trim($gender) === "" || !isset($gender)) {
        //     throw new InvalidArgumentException("Gender is null or empty");
        // }
        $this->gender = $gender;
    }
    
    /**
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param string $nationality
     */
    public function setNationality($nationality)
    {
        // if (trim($nationality) === "" || !isset($nationality)) {
        //     throw new InvalidArgumentException("Nationality is null or empty");
        // }
        $this->nationality = $nationality;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param mixed $telephone
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }

    /**
     * @return string
     */
    public function getPermanentAddress()
    {
        return $this->permanentAddress;
    }

    /**
     * @param string $permanentAddress
     */
    public function setPermanentAddress($permanentAddress)
    {
        // if (trim($permanentAddress) === "" || !isset($permanentAddress)) {
        //     throw new InvalidArgumentException("PermanentAddress is null or empty");
        // }
        $this->permanentAddress = $permanentAddress;
    }

    /**
     * @return string
     */
    public function getAlternateEmailAddress()
    {
        return $this->alternateEmailAddress;
    }

    /**
     * @param string $alternateEmailAddress
     */
    public function setAlternateEmailAddress($alternateEmailAddress)
    {
        $this->alternateEmailAddress = $alternateEmailAddress;
    }

    /**
     * @return string
     */
    public function getMobileAreaCode()
    {
        return $this->mobileAreaCode;
    }

    /**
     * @param string $mobileAreaCode
     */
    public function setMobileAreaCode($mobileAreaCode)
    {
        $this->mobileAreaCode = $mobileAreaCode;
    }

    /**
     * @return int
     */
    public function getBirthDateDay()
    {
        return $this->birthDateDay;
    }

    /**
     * @param int $birthDateDay
     */
    public function setBirthDateDay($birthDateDay)
    {
        if (!is_numeric($birthDateDay) || !isset($birthDateDay)) {
            throw new InvalidArgumentException("BirthDate Day is null or not a number");
        }
        $this->birthDateDay = $birthDateDay;
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * @param string $address1
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;
    }

    /**
     * @return string
     */
    public function getFacebookId()
    {
        return $this->facebookId;
    }

    /**
     * @param string $facebookId
     */
    public function setFacebookId($facebookId)
    {
        $this->facebookId = $facebookId;
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param string $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return string
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }

    /**
     * @return string
     */
    public function getWorkingEnvironment()
    {
        return $this->workingEnvironment;
    }

    /**
     * @param string $workingEnvironment
     */
    public function setWorkingEnvironment($workingEnvironment)
    {
        $this->workingEnvironment = $workingEnvironment;
    }

    /**
     * @return string
     */
    public function getInternetConnection()
    {
        return $this->internetConnection;
    }

    /**
     * @param string $internetConnection
     */
    public function setInternetConnection($internetConnection)
    {
        $this->internetConnection = $internetConnection;
    }

    /**
     * @return string
     */
    public function getIsp()
    {
        return $this->isp;
    }

    /**
     * @param string $isp
     */
    public function setIsp($isp)
    {
        $this->isp = $isp;
    }

    /**
     * @return string
     */
    public function getRegisteredEmail()
    {
        return $this->registeredEmail;
    }

    /**
     * @param string $registeredEmail
     */
    public function setRegisteredEmail($registeredEmail)
    {
        $this->registeredEmail = $registeredEmail;
    }

    /**
     * @return string
     */
    public function getMaritalStatus()
    {
        return $this->maritalStatus;
    }

    /**
     * @return boolean
     */
    public function isActiveVisa()
    {
        return $this->activeVisa;
    }

    /**
     * @param boolean $activeVisa
     */
    public function setActiveVisa($activeVisa)
    {
        $this->activeVisa = $activeVisa;
    }

    /**
     * @param string $maritalStatus
     */
    public function setMaritalStatus($maritalStatus)
    {
        $this->maritalStatus = $maritalStatus;
    }

    /**
     * @return ArrayCollection
     */
    public function getShortlists()
    {
        return $this->shortlists;
    }

    /**
     * @param ArrayCollection $shortlists
     */
    public function setShortlists($shortlists)
    {
        $this->shortlists = $shortlists;
    }

    /**
     * @return ArrayCollection
     */
    public function getEndorsements()
    {
        return $this->endorsements;
    }

    /**
     * @param ArrayCollection $endorsements
     */
    public function setEndorsements($endorsements)
    {
        $this->endorsements = $endorsements;
    }

    /**
     * @return PreScreenedCandidate
     */
    public function getPreScreenedEntry()
    {
        return $this->preScreenedEntry;
    }

    /**
     * @param PreScreenedCandidate $preScreenedEntry
     */
    public function setPreScreenedEntry($preScreenedEntry)
    {
        $this->preScreenedEntry = $preScreenedEntry;
    }

    /**
     * @return ArrayCollection
     */
    public function getInactiveEntries()
    {
        return $this->inactiveEntries;
    }

    /**
     * @param ArrayCollection $inactiveEntries
     */
    public function setInactiveEntries($inactiveEntries)
    {
        $this->inactiveEntries = $inactiveEntries;
    }

    /**
     * @return ArrayCollection
     */
    public function getRemoteReadyEntries()
    {
        return $this->remoteReadyEntries;
    }

    /**
     * @param ArrayCollection $remoteReadyEntries
     */
    public function setRemoteReadyEntries($remoteReadyEntries)
    {
        $this->remoteReadyEntries = $remoteReadyEntries;
    }

    /**
     * @return ArrayCollection
     */
    public function getCategorizedEntries()
    {
        return $this->categorizedEntries;
    }

    /**
     * @param $categorizedEntries
     */
    public function setCategorizedEntries($categorizedEntries)
    {
        $this->categorizedEntries = $categorizedEntries;

    }


    /**
     * Adds entry to categorizedEntries
     * Returns the added entry if successfully added
     * Returns null otherwise
     * @param CategorizedEntry $categorizedEntryToAdd
     * @return null|CategorizedEntry
     */
    public function addCategorizedEntry(CategorizedEntry $categorizedEntryToAdd){
        $found = false;
        $addedItem = null;


        foreach ($this->getCategorizedEntries() as $item) {
            if($item->getSubCategory()->getId() === $categorizedEntryToAdd->getSubCategory()->getId()){
                $found = true;
                break;
            }
        }

        if(!$found){
            $this->getCategorizedEntries()->add($categorizedEntryToAdd);
            $addedItem = $categorizedEntryToAdd;
        }

        return $addedItem;
    }


    /**
     * Returns deleted entry if successfully deleted
     * Returns null otherwise
     * @param CategorizedEntry $categorizedEntry
     * @return null|CategorizedEntry
     */
    public function removeCategorizedEntry(CategorizedEntry $categorizedEntry){
        $newItems = new ArrayCollection();
        $deletedItem = null;
        foreach ($this->getCategorizedEntries() as $item) {
            if($item->getId() != $categorizedEntry->getId()){
                $newItems->add($item);
            } else{
                $deletedItem = $categorizedEntry;
            }
        }

        $this->setCategorizedEntries($newItems);

        return $deletedItem;
    }

    /**
     * @return ArrayCollection
     */
    public function getRequestForInterviews()
    {
        return $this->requestForInterviews;
    }

    /**
     * @param ArrayCollection $requestForInterviews
     */
    public function setRequestForInterviews($requestForInterviews)
    {
        $this->requestForInterviews = $requestForInterviews;
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * @param string $postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    }

    /**
     * @return string
     */
    public function getYahoo()
    {
        return $this->yahoo;
    }

    /**
     * @param string $yahoo
     */
    public function setYahoo($yahoo)
    {
        $this->yahoo = $yahoo;
    }

    /**
     * @return string
     */
    public function getComputerHardware()
    {
        return $this->computerHardware;
    }

    /**
     * @param string $computerHardware
     */
    public function setComputerHardware($computerHardware)
    {
        $this->computerHardware = $computerHardware;
    }

    /**
     * @return string
     */
    public function getInternetConsequences()
    {
        return $this->internetConsequences;
    }

    /**
     * @param string $internetConsequences
     */
    public function setInternetConsequences($internetConsequences)
    {
        $this->internetConsequences = $internetConsequences;
    }

    /**
     * @return Education
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @param Education $education
     */
    public function setEducation($education)
    {
        $this->education = $education;
    }


    public function toArray()
    {
        // TODO: Implement toJSON() method.
        return array(
            "firstName" => $this->getFirstName(),
            "lastName" => $this->getLastName(),
            "id" => $this->getId(),
            "email" => $this->getEmail(),
            "mobile" => $this->getMobile(),
            "dateRegistered" => $this->getDateCreated(),
            "dateUpdated" => $this->getDateUpdated(),
            "gender" => $this->getGender(),
            "skype" => $this->getSkypeId()
        );
    }

    /**
     * @return ResumeCreationHistory
     */
    public function getCreatedResumeHistory()
    {
        return $this->createdResumeHistory;
    }

    /**
     * @param ResumeCreationHistory $createdResumeHistory
     */
    public function setCreatedResumeHistory($createdResumeHistory)
    {
        $this->createdResumeHistory = $createdResumeHistory;
    }

    /**
     * @return ArrayCollection
     */
    public function getCallNotes()
    {
        return $this->CallNotes;
    }

    /**
     * @param ArrayCollection $CallNotes
     */
    public function setCallNotes($CallNotes)
    {
        $this->CallNotes = $CallNotes;
    }

    /**
     * @return ArrayCollection
     */
    public function getStaffHistory()
    {
        return $this->staffHistory;
    }

    /**
     * @param ArrayCollection $staffHistory
     */
    public function setStaffHistory($staffHistory)
    {
        $this->staffHistory = $staffHistory;
    }

    /**
     * @return ArrayCollection
     */
    public function getEvaluationNotes()
    {
        return $this->evaluationNotes;
    }

    /**
     * @param ArrayCollection $evaluationNotes
     */
    public function setEvaluationNotes($evaluationNotes)
    {
        $this->evaluationNotes[] = $evaluationNotes;
    }


//    public function getEvalNotes(){
//        $criteria = Criteria::create();
//        $criteria->orderBy(array("id"=> Criteria::DESC));
//        return $this->evaluationNotes->matching($criteria);
//    }
//

    /**
     * @return ArrayCollection
     */
    public function getActiveContract(){
        $criteria = Criteria::create()
            ->where(Criteria::expr()->in("status", ['ACTIVE', 'suspended']));
        return $this->getSubcontractors()->matching($criteria);
    }

    /**
     * @return \RemoteStaff\Entities\Admin
     */
    public function getActiveRecruiter(){
        $criteria = Criteria::create()
            ->orderBy(["id"=>Criteria::DESC])
            ->setFirstResult(0)
            ->setMaxResults(1);

        $assignment = $this->getRecruiterStaff()->matching($criteria);
        if ($assignment->count()>0){
            /**
             * @var $recruiterStaff \RemoteStaff\Entities\RecruiterStaff
             */
            $recruiterStaff = $assignment->get(0);
            return $recruiterStaff->getRecruiter();
        }else{
            return null;
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getNoShowEntries()
    {
        return $this->noShowEntries;
    }

    /**
     * @param ArrayCollection $noShowEntries
     */
    public function setNoShowEntries($noShowEntries)
    {
        $this->noShowEntries = $noShowEntries;
    }


    public function getEvaluation()
    {
        return $this->Evaluation;
    }


    public function setEvaluation($Evaluation)
    {
        $this->Evaluation = $Evaluation;
    }

    /**
     * @return StaffRate
     */
    public function getStaffRate()
    {
        return $this->staffRate;
    }

    /**
     * @param StaffRate $staffRate
     */
    public function setStaffRate($staffRate)
    {
        $this->staffRate = $staffRate;
    }

    /**
     * @return StaffTimezone
     */
    public function getStaffTimezone()
    {
        return $this->staffTimezone;
    }

    /**
     * @param StaffTimezone $staffTimezone
     */
    public function setStaffTimezone($staffTimezone)
    {
        $this->staffTimezone = $staffTimezone;
    }

    /**
     * @return Admin
     */
    public function getAdminInformation()
    {
        return $this->adminInformation;
    }

    /**
     * @param Admin $adminInformation
     */
    public function setAdminInformation($adminInformation)
    {
        $this->adminInformation = $adminInformation;
    }

    /**
     * @return ArrayCollection
     */
    public function getEmploymentHistory()
    {
        return $this->employmentHistory;
    }

    /**
     * @param ArrayCollection $employmentHistory
     */
    public function setEmploymentHistory($employmentHistory)
    {
        $this->employmentHistory[] = $employmentHistory;
    }

    /**
     * @return ArrayCollection
     */
    public function getAssesmentResult()
    {
        return $this->assesmentResult;
    }

    /**
     * @param ArrayCollection $assesmentResult
     */
    public function setAssesmentResult($assesmentResult)
    {
        $this->assesmentResult = $assesmentResult;
    }

    /**
     * @return ArrayCollection
     */
    public function getPreviousJobIndustry()
    {
        return $this->previousJobIndustry;
    }

    /**
     * @param ArrayCollection $previousJobIndustry
     */
    public function setPreviousJobIndustry($previousJobIndustry)
    {
        $this->previousJobIndustry = $previousJobIndustry;
    }

    /**
     * @return string
     */
    public function getHeadsetQuality()
    {
        return $this->headsetQuality;
    }

    /**
     * @param string $headsetQuality
     */
    public function setHeadsetQuality($headsetQuality)
    {
        $this->headsetQuality = $headsetQuality;
    }

    /**
     * @return string
     */
    public function getHomeWorkingEnvironment()
    {
        return $this->homeWorkingEnvironment;
    }

    /**
     * @param string $homeWorkingEnvironment
     */
    public function setHomeWorkingEnvironment($homeWorkingEnvironment)
    {
        $this->homeWorkingEnvironment = $homeWorkingEnvironment;
    }


}