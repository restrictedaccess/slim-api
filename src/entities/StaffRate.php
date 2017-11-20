<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/6/2016
 * Time: 11:32 AM
 */

namespace RemoteStaff\Entities;

/**
 * Class StaffRate
 * @Entity
 * @Table(name="staff_rate")
 */
class StaffRate
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var RemoteStaff\Entities\Product
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Product", inversedBy="fullTimeStaffRate")
     * @JoinColumn(name="product_id", referencedColumnName="id")
     */
    private $fullTimeRate = null;

    /**
     * @var RemoteStaff\Entities\Product
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Product", inversedBy="partTimeStaffRate")
     * @JoinColumn(name="part_time_product_id", referencedColumnName="id")
     */
    private $partFullTimeRate = null;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="staffRate", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate = null;

    /**
     * @var RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="staffRateInfo")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $adminInformation = null;


    /**
     * @return \RemoteStaff\Entities\Product
     */
    public function getFullTimeRate()
    {
        return $this->fullTimeRate;
    }

    /**
     * @param RemoteStaff\Entities\Product $fullTimeRate
     */
    public function setFullTimeRate($fullTimeRate)
    {
        $this->fullTimeRate = $fullTimeRate;
    }

    /**
     * @return RemoteStaff\Entities\Product
     */
    public function getPartFullTimeRate()
    {
        return $this->partFullTimeRate;
    }

    /**
     * @param RemoteStaff\Entities\Product $partFullTimeRate
     */
    public function setPartFullTimeRate($partFullTimeRate)
    {
        $this->partFullTimeRate = $partFullTimeRate;
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
     * @return RemoteStaff\Entities\Admin
     */
    public function getAdminInformation()
    {
        return $this->adminInformation;
    }

    /**
     * @param RemoteStaff\Entities\Admin $adminInformation
     */
    public function setAdminInformation($adminInformation)
    {
        $this->adminInformation = $adminInformation;
    }


}