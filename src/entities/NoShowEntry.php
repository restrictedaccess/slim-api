<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 8:58 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class Country
 * @Entity
 * @Table(name="staff_no_show")
 */
class NoShowEntry {

    /**
     * @var Int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

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
    public function getNoShowBy()
    {
        return $this->noShowBy;
    }

    /**
     * @param Admin $noShowBy
     */
    public function setNoShowBy($noShowBy)
    {
        $this->noShowBy = $noShowBy;
    }

    /**
     * @return string
     */
    public function getServiceType()
    {
        return $this->serviceType;
    }

    /**
     * @param string $serviceType
     */
    public function setServiceType($serviceType)
    {
        $this->serviceType = $serviceType;
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
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="noShowEntries", cascade={"persist", "remove"})
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;


    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="noShowEntries", cascade={"persist", "remove"})
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $noShowBy;



    /**
     * @var string
     * @Column(type="string", name="service_type")
     */
    private $serviceType;



    /**
     * @var \DateTime
     * @Column(type="datetime", name="date")
     */
    private $date;





}