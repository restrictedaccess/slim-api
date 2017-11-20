<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 9:36 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class PreScreenedCandidate
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="pre_screened_staff")
 */
class PreScreenedCandidate {
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var \DateTime
     * @Column(type="datetime", name="date")
     */
    private $date;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="preScreenedEntry", cascade={"persist", "remove"}, fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
    public function getPrescreenedBy()
    {
        return $this->prescreenedBy;
    }

    /**
     * @param Admin $prescreenedBy
     */
    public function setPrescreenedBy($prescreenedBy)
    {
        $this->prescreenedBy = $prescreenedBy;
    }

} 