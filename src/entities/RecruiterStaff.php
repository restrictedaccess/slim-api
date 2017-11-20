<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 18/08/16
 * Time: 8:59 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class RecruiterStaff
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="recruiter_staff")
 */
class RecruiterStaff {
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="recruiterStaff")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="recruiterStaff")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $recruiter;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="date")
     */
    private $date;

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


} 