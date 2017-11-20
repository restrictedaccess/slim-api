<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 8/25/2016
 * Time: 10:55 AM
 */

namespace RemoteStaff\Entities;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class InactiveEntryNote
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="inactive_staff_note")
 */
class InactiveEntryNote
{
    /**
     * @var int
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \RemoteStaff\Entities\InactiveEntry
     * @OneToOne(targetEntity="RemoteStaff\Entities\InactiveEntry", inversedBy="inactiveEntryNote", fetch="LAZY")
     * @JoinColumn(name="inactive_staff_id", referencedColumnName="id")
     */
    private $inactiveEntry;


    /**
     * @var string
     * @Column(type="string", name="note")
     */
    private $note = null;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="date_time")
     */
    private $date = null;

    /**
     * @return Int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return InactiveEntry
     */
    public function getInactiveEntry()
    {
        return $this->inactiveEntry;
    }

    /**
     * @param InactiveEntry $inactiveEntry
     */
    public function setInactiveEntry($inactiveEntry)
    {
        $this->inactiveEntry = $inactiveEntry;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param string $note
     */
    public function setNote($note)
    {
        $this->note = $note;
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

}