<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 8/22/2016
 * Time: 9:55 AM
 */

namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Class ApplicationHistory
 * @Entity
 * @Table(name="applicant_history")
 */
class ApplicationHistory
{
    /**
     * @var int
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="CallNotes")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="CallNotes")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $adminInfo;

    /**
     * @var int
     * @Column(type="integer", name="admin_id")
     */
    private $admin_id = null;

    /**
     * @var int
     * @Column(type="integer", name="userid")
     */
    private $userid = null;

    /**
     * @var string
     * @Column(type="string", name="actions")
     */
    private $actions = null;

    /**
     * @var text
     * @Column(type="text", name="history")
     */
    private $history = null;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="date_created")
     */
    private $dateCreated = null;

    /**
     * @var string
     * @Column(type="text", name="created_by_type")
     */
    private $createdByType = null;

    /**
     * @var string
     * @Column(type="string", name="subject")
     */
    private $subject = null;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getActions()
    {
        return $this->actions;
    }

    /**
     * @param string $actions
     */
    public function setActions($actions)
    {
        $this->actions = $actions;
    }

    /**
     * @return string
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param string $history
     */
    public function setHistory($history)
    {
        $this->history = $history;
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
     * @return int
     */
    public function getAdminId()
    {
        return $this->admin_id;
    }

    /**
     * @param int $admin_id
     */
    public function setAdminId($admin_id)
    {
        $this->admin_id = $admin_id;
    }

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     */
    public function setUserId($userid)
    {
        $this->userid = $userid;
    }

    /**
     * @return string
     */
    public function getCreatedByType()
    {
        return $this->createdByType;
    }

    /**
     * @param string $createdByType
     */
    public function setCreatedByType($createdByType)
    {
        $this->createdByType = $createdByType;
    }

    /**
     * @return Admin
     */
    public function getAdmin()
    {
        return $this->admin_information;
    }

    /**
     * @return RemoteStaff\Entities\Personal
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param RemoteStaff\Entities\Personal $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * @return RemoteStaff\Entities\Admin
     */
    public function getAdminInfo()
    {
        return $this->adminInfo;
    }

    /**
     * @param RemoteStaff\Entities\Admin $adminInfo
     */
    public function setAdminInfo($adminInfo)
    {
        $this->adminInfo = $adminInfo;
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

}
