<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 7:13 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class Shortlist Entry
 * @Entity
 * @Table(name="tb_shortlist_history")
 */
class ShortlistEntry {

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

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

    /**
     * @return \DateTime
     */
    public function getDateListed()
    {
        return $this->dateListed;
    }

    /**
     * @param \DateTime $dateListed
     */
    public function setDateListed($dateListed)
    {
        $this->dateListed = $dateListed;
    }

    /**
     * @return \DateTime
     */
    public function getDateRejected()
    {
        return $this->dateRejected;
    }

    /**
     * @param \DateTime $dateRejected
     */
    public function setDateRejected($dateRejected)
    {
        $this->dateRejected = $dateRejected;
    }

    /**
     * @return string
     */
    public function getFeedback()
    {
        return $this->feedback;
    }

    /**
     * @param string $feedback
     */
    public function setFeedback($feedback)
    {
        $this->feedback = $feedback;
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
     * @return Posting
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param Posting $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }


    /**
     * @return Admin
     */
    public function getRejectedBy()
    {
        return $this->rejectedBy;
    }

    /**
     * @param Admin $rejectedBy
     */
    public function setRejectedBy($rejectedBy)
    {
        $this->rejectedBy = $rejectedBy;
    }

    /**
     * @return Admin
     */
    public function getShortlistedBy()
    {
        return $this->shortlistedBy;
    }

    /**
     * @param Admin $shortlistedBy
     */
    public function setShortlistedBy($shortlistedBy)
    {
        $this->shortlistedBy = $shortlistedBy;
    }
    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="shortlists")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="shortlists")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $shortlistedBy;
    /**
     * @var \RemoteStaff\Entities\Posting
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Posting", inversedBy="shortlists")
     * @JoinColumn(name="position", referencedColumnName="id")
     */
    private $position;

    /**
     * @var \DateTime
     * @Column(name="date_listed", type="datetime")
     */
    private $dateListed;
    /**
     * @var boolean
     * @Column(name="rejected", type="boolean")
     */
    private $rejected;
    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="rejectedShortlists")
     * @JoinColumn(name="rejected_by", referencedColumnName="admin_id")
     */
    private $rejectedBy;

    /**
     * @var \DateTime
     * @Column(name="date_rejected", type="datetime")
     */
    private $dateRejected;

    /**
     * @var string
     * @Column(name="feedback", type="string")
     */
    private $feedback;

    /**
     * @return boolean
     */
    public function isRejected()
    {
        return $this->rejected;
    }

    /**
     * @param boolean $rejected
     */
    public function setRejected($rejected)
    {
        $this->rejected = $rejected;
    }

} 