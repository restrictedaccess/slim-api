<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 18/08/16
 * Time: 9:08 PM
 */

namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class Lead
 * @Entity
 * @Table(name="admin")
 */
class Admin implements Persistable{
    /**
     * @var int
     * @Id @Column(type="integer", name="admin_id")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var string
     * @Column(type="string", name="admin_fname")
     */
    private $firstName;
    /**
     * @var string
     * @Column(type="string", name="admin_lname")
     */
    private $lastName;

    /**
     * @var string
     * @Column(type="string", name="signature_company")
     */
    private $company;

    /**
     * @var string
     * @Column(type="string", name="admin_email")
     */
    private $email;



    /**
     * @var string
     * @Column(type="string", name="admin_password")
     */
    private $password;


    /**
     * @var string
     * @Column(type="string", name="signature_notes")
     */
    private $notes;

    /**
     * @var string
     * @Column(type="string", name="signature_contact_nos")
     */
    private $contacts;

    /**
     * @var string
     * @Column(type="string", name="signature_websites")
     */
    private $websites;

    /**
     * @var string
     * @Column(type="string", name="status")
     */
    private $status;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\RecruiterStaff", mappedBy="recruiter", cascade={"remove", "persist"})
     */
    private $recruiterStaff;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\ShortlistEntry", mappedBy="shortlistedBy", cascade={"remove", "persist"})
     */
    private $shortlists;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\ShortlistEntry", mappedBy="rejectedBy", cascade={"remove", "persist"})
     */
    private $rejectedShortlists;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\EndorsementEntry", mappedBy="endorsedBy", cascade={"remove", "persist"})
     */
    private $endorsements;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\InactiveEntry", mappedBy="inactiveBy", cascade={"remove", "persist"})
     */
    private $inactiveEntries;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\PreScreenedCandidate", mappedBy="prescreenedBy", cascade={"remove", "persist"})
     */
    private $prescreenedEntries;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\ResumeCreationHistory", mappedBy="recruiter", cascade={"remove", "persist"})
     */
    private $createdResumeHistory;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\StaffHistory", mappedBy="changedBy", cascade={"remove", "persist"})
     */
    private $staffHistory;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\SeoCategoryHistory", mappedBy="changedBy", cascade={"remove", "persist"})
     */
    private $seoCategoryHistory;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\ApplicationHistory", mappedBy="adminInfo", cascade={"remove", "persist"})
     *
     */
    private $CallNotes = [];

    /**
     * @var \RemoteStaff\Entities\Evaluation
     * @OneToOne(targetEntity="RemoteStaff\Entities\Evaluation", mappedBy="adminInfo", cascade={"persist", "remove"}, fetch="LAZY")
     */

    private $Evaluation;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\StaffRate", mappedBy="adminInformation", cascade={"remove", "persist"})
     *
     */

    private $staffRateInfo = [];


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\NoShowEntry", mappedBy="noShowBy", cascade={"remove", "persist"})
     *
     */
    private $noShowEntries;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\EvaluationComment", mappedBy="adminInformation", cascade={"remove", "persist"})
     *
     */
    private $evaluationNotes = [];


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\CategorizedEntry", mappedBy="categorizedBy", cascade={"remove", "persist"})
     */
    private $categorizedEntries;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\UnprocessedCandidate", mappedBy="admin", cascade={"remove", "persist"})
     */
    private $unprocessedEntries;


    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="adminInformation", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $personalInformation;

    /**
     * @return ArrayCollection
     */
    public function getCreatedResumeHistory()
    {
        return $this->createdResumeHistory;
    }

    /**
     * @param ArrayCollection $createdResumeHistory
     */
    public function setCreatedResumeHistory($createdResumeHistory)
    {
        $this->createdResumeHistory = $createdResumeHistory;
    }

    /**
     * @return ArrayCollection
     */
    public function getSeoCategoryHistory()
    {
        return $this->seoCategoryHistory;
    }

    /**
     * @param ArrayCollection $seoCategoryHistory
     */
    public function setSeoCategoryHistory($seoCategoryHistory)
    {
        $this->seoCategoryHistory = $seoCategoryHistory;
    }


    /**
     * @return ArrayCollection
     */
    public function getRejectedShortlists()
    {
        return $this->rejectedShortlists;
    }

    /**
     * @param ArrayCollection $rejectedShortlists
     */
    public function setRejectedShortlists($rejectedShortlists)
    {
        $this->rejectedShortlists = $rejectedShortlists;
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

    public function __construct(){
        $this->recruiterStaff = new ArrayCollection();
        $this->shortlists = new ArrayCollection();
        $this->rejectedShortlists = new ArrayCollection();
        $this->endorsements = new ArrayCollection();
        $this->inactiveEntries = new ArrayCollection();
        $this->createdResumeHistory = new ArrayCollection();
        $this->staffHistory = new ArrayCollection();
        $this->CallNotes = new ArrayCollection();
        $this->evaluationNotes =  new ArrayCollection();
        $this->prescreenedEntries = new ArrayCollection();
        $this->noShowEntries = new ArrayCollection();
        $this->categorizedEntries = new ArrayCollection();
        $this->staffRateInfo = new ArrayCollection();
    }
    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getRecruiterStaff()
    {
        return $this->recruiterStaff;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $recruiterStaff
     */
    public function setRecruiterStaff($recruiterStaff)
    {
        $this->recruiterStaff = $recruiterStaff;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    /**
     * Get the name of the admin
     * @return string
     */
    public function getName(){
        return $this->getFirstName()." ".$this->getLastName();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * Get the signature template of admin
     * @return string
     */
    public function getSignatureTemplate(){


        $signature_company = $this->company;
        $signature_notes = $this->notes;
        $signature_contact_nos = $this->contacts;
        $signature_websites = $this->websites;
        if($signature_notes!="")
        {
            $signature_notes = "<p><i>$signature_notes</i></p>";
        }
        else
        {
            $signature_notes = "";
        }
        if($signature_company!="")
        {
            $signature_company="<br>$signature_company";
        }
        else
        {
            $signature_company="RemoteStaff";
        }
        if($signature_contact_nos!="")
        {
            $signature_contact_nos = "<br>$signature_contact_nos";
        }
        else
        {
            $signature_contact_nos = "";
        }
        if($signature_websites!="")
        {
            $signature_websites = "<br>Websites : $signature_websites";
        }
        else
        {
            $signature_websites = "";
        }
        $name = $this->getName();
        $email = $this->getEmail();
        $signature_template = $signature_notes;
        $signature_template .= "<img src='http://remotestaff.com.au/portal/images/remote_staff_logo.png' width='171' height='49' border='0'/><br>";
        $signature_template .= "<br /><p>" . $name . "<br />";
        $signature_template .= "$signature_company$signature_contact_nos<br>Email : $email $signature_websites</p>";
        return $signature_template;
    }

    /**
     * @return string
     */
    public function getWebsites()
    {
        return $this->websites;
    }

    /**
     * @param string $websites
     */
    public function setWebsites($websites)
    {
        $this->websites = $websites;
    }

    /**
     * @return string
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @param string $contacts
     */
    public function setContacts($contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param string $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    /**
     * @return string
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param string $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
    public function getPrescreenedEntries()
    {
        return $this->prescreenedEntries;
    }

    /**
     * @param ArrayCollection $prescreenedEntries
     */
    public function setPrescreenedEntries($prescreenedEntries)
    {
        $this->prescreenedEntries = $prescreenedEntries;
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
     * @param \Doctrine\Common\Collections\ArrayCollection
     */
    public function getEvaluationNotes()
    {
        return $this->evaluationNotes;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $eval
     */
    public function setEvaluationNotes($eval)
    {
        $this->evaluationNotes[] = $eval;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
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


    public function toArray()
    {
        // TODO: Implement toArray() method.
        return array(
            "admin_id" => $this->getId(),
            "fname" => $this->getFirstName(),
            "lname" => $this->getLastName(),
            "email" => $this->getEmail()
        );
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
     * @return ArrayCollection
     */
    public function getCategorizedEntries()
    {
        return $this->categorizedEntries;
    }

    /**
     * @param ArrayCollection $categorizedEntries
     */
    public function setCategorizedEntries($categorizedEntries)
    {
        $this->categorizedEntries = $categorizedEntries;
    }

    /**
     * @return ArrayCollection
     */
    public function getStaffRateInfo()
    {
        return $this->staffRateInfo;
    }

    /**
     * @param ArrayCollection $staffRateInfo
     */
    public function setStaffRateInfo($staffRateInfo)
    {
        $this->staffRateInfo = $staffRateInfo;
    }

    /**
     * @return Personal
     */
    public function getPersonalInformation()
    {
        return $this->personalInformation;
    }

    /**
     * @param Personal $personalInformation
     */
    public function setPersonalInformation($personalInformation)
    {
        $this->personalInformation = $personalInformation;
    }

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
        $this->password = $password;
    }


}