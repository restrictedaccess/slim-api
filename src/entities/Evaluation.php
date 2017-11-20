<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/6/2016
 * Time: 2:09 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class Evaluation
 * @Entity
 * @Table(name="evaluation")
 */
class Evaluation
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="Evaluation", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate = null;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @OneToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="Evaluation", fetch="LAZY")
     * @JoinColumn(name="created_by", referencedColumnName="admin_id")
     */
    private $adminInfo = null;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="evaluation_date")
     */
    private $dateCreated = null;

    /**
     * @var string
     * @Column(type="string", name="work_fulltime")
     */
    private $workFulltime = null;

    /**
     * @var string
     * @Column(type="string", name="fulltime_sched")
     */
    private $fulltimeSched = null;

    /**
     * @var string
     * @Column(type="string", name="work_parttime")
     */
    private $workParttime = null;

    /**
     * @var string
     * @Column(type="string", name="parttime_sched")
     */
    private $parttimeSched = null;

    /**
     * @var string
     * @Column(type="string", name="work_freelancer")
     */
    private $workFreelancer = null;

    /**
     * @var string
     * @Column(type="string", name="expected_minimum_salary")
     */
    private $expectedMinimumSalary = null;

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
     * @return string
     */
    public function getWorkFulltime()
    {
        return $this->workFulltime;
    }

    /**
     * @param string $workFulltime
     */
    public function setWorkFulltime($workFulltime)
    {
        $this->workFulltime = $workFulltime;
    }

    /**
     * @return string
     */
    public function getFulltimeSched()
    {
        return $this->fulltimeSched;
    }

    /**
     * @param string $fulltimeSched
     */
    public function setFulltimeSched($fulltimeSched)
    {
        $this->fulltimeSched = $fulltimeSched;
    }

    /**
     * @return string
     */
    public function getWorkParttime()
    {
        return $this->workParttime;
    }

    /**
     * @param string $workParttime
     */
    public function setWorkParttime($workParttime)
    {
        $this->workParttime = $workParttime;
    }

    /**
     * @return string
     */
    public function getParttimeSched()
    {
        return $this->parttimeSched;
    }

    /**
     * @param string $parttimeSched
     */
    public function setParttimeSched($parttimeSched)
    {
        $this->parttimeSched = $parttimeSched;
    }

    /**
     * @return string
     */
    public function getWorkFreelancer()
    {
        return $this->workFreelancer;
    }

    /**
     * @param string $workFreelancer
     */
    public function setWorkFreelancer($workFreelancer)
    {
        $this->workFreelancer = $workFreelancer;
    }

    /**
     * @return string
     */
    public function getExpectedMinimumSalary()
    {
        return $this->expectedMinimumSalary;
    }

    /**
     * @param string $expectedMinimumSalary
     */
    public function setExpectedMinimumSalary($expectedMinimumSalary)
    {
        $this->expectedMinimumSalary = $expectedMinimumSalary;
    }


}