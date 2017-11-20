<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 09/08/16
 * Time: 11:40 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class UnprocessedCandidate
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="unprocessed_staff")
 */
class UnprocessedCandidate {

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
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="unprocessedEntry", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="unprocessedEntries")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $admin;

    /**
     * @return Admin
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param Admin $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }



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
} 