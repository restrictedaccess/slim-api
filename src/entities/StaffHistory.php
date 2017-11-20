<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 24/08/16
 * Time: 11:59 AM
 */

namespace RemoteStaff\Entities;

/**
 * Class ResumeCreationHistory
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="staff_history")
 */
class StaffHistory {
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="staffHistory", cascade={"persist", "remove"})
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="staffHistory", cascade={"persist", "remove"})
     * @JoinColumn(name="change_by_id", referencedColumnName="admin_id")
     */
    private $changedBy;
    /**
     * @var string
     * @Column(name="change_by_type", type="string")
     */
    private $type;
    /**
     * @var string
     * @Column(name="changes", type="string")
     */
    private $changes;
    /**
     * @var \DateTime
     * @Column(name="date_change", type="datetime")
     */
    private $dateCreated;

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
     * @return Admin
     */
    public function getChangedBy()
    {
        return $this->changedBy;
    }

    /**
     * @param Admin $changedBy
     */
    public function setChangedBy($changedBy)
    {
        $this->changedBy = $changedBy;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param string $changes
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;
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
} 