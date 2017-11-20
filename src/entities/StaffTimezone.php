<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/7/2016
 * Time: 4:30 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class StaffTimezone
 * @Entity
 * @Table(name="staff_timezone")
 */
class StaffTimezone
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var int
     * @Column(type="integer", name="userid")
     */
    private $userid = null;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="staffTimezone", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate = null;

    /**
     * @var string
     * @Column(type="string", name="time_zone")
     */
    private $fullTimeTimezone = null;

    /**
     * @var string
     * @Column(type="string", name="p_timezone")
     */
    private $partTimeTimezone = null;

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
     * @return string
     */
    public function getFullTimeTimezone()
    {
        return $this->fullTimeTimezone;
    }

    /**
     * @param string $fullTimeTimezone
     */
    public function setFullTimeTimezone($fullTimeTimezone)
    {
        $this->fullTimeTimezone = $fullTimeTimezone;
    }

    /**
     * @return string
     */
    public function getPartTimeTimezone()
    {
        return $this->partTimeTimezone;
    }

    /**
     * @param string $partTimeTimezone
     */
    public function setPartTimeTimezone($partTimeTimezone)
    {
        $this->partTimeTimezone = $partTimeTimezone;
    }

    /**
     * @return string
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param string $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }

}