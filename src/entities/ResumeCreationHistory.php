<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 24/08/16
 * Time: 11:22 AM
 */

namespace RemoteStaff\Entities;

/**
 * Class ResumeCreationHistory
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="resume_creation_history")
 */
class ResumeCreationHistory {
    /**
     * @var Int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="createdResumeHistory",cascade={"persist", "remove"}, fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;
    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="createdResumeHistory", cascade={"persist"})
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $recruiter;

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
     * @return Admin
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * @param Admin $recruiter
     */
    public function setRecruiter($recruiter)
    {
        $this->recruiter = $recruiter;
    }

    /**
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param Int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * @var \DateTime
     * @Column(type="datetime", name="date_created")
     */
    private $dateCreated;

    /**
     * @return Personal
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param Personal $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }
} 