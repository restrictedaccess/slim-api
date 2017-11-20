<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 9:42 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class InactiveEntry
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="inactive_staff")
 */
class InactiveEntry {
    /**
     * @var Int
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
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
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
     * @return Admin
     */
    public function getInactiveBy()
    {
        return $this->inactiveBy;
    }

    /**
     * @param Admin $inactiveBy
     */
    public function setInactiveBy($inactiveBy)
    {
        $this->inactiveBy = $inactiveBy;
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
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="inactiveEntries")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="inactiveEntries")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $inactiveBy;

    /**
     * @var \RemoteStaff\Entities\InactiveEntryNote
     * @OneToOne(targetEntity="RemoteStaff\Entities\InactiveEntryNote", mappedBy="inactiveEntry", cascade={"persist", "remove"}, fetch="LAZY")
     */
    private $inactiveEntryNote = null;


    /**
     * @var string
     * @Column(type="string", name="type")
     */
    private $type;
    /**
     * @var \DateTime
     * @Column(type="datetime", name="date")
     */
    private $date;

    /**
     * @return InactiveEntryNote
     */
    public function getInactiveEntryNote()
    {
        return $this->inactiveEntryNote;
    }

    /**
     * @param InactiveEntryNote $inactiveEntryNote
     */
    public function setInactiveEntryNote($inactiveEntryNote)
    {
        $this->inactiveEntryNote = $inactiveEntryNote;
    }
} 