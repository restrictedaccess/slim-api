<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/19/2016
 * Time: 10:28 AM
 */

namespace RemoteStaff\Entities;

/**
 * Class EmploymentHistory
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="employment_history")
 */
class EmploymentHistory
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="employmentHistory")
     * @JoinColumn(name="candidate_id", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var string
     * @Column(type="string", name="company_name")
     */
    private $companyName;

    /**
     * @var string
     * @Column(type="string", name="position")
     */
    private $position;

    /**
     * @var string
     * @Column(type="string", name="month_from")
     */
    private $monthFrom;

    /**
     * @var string
     * @Column(type="string", name="year_from")
     */
    private $yearFrom;

    /**
     * @var string
     * @Column(type="string", name="month_to")
     */
    private $monthTo;

    /**
     * @var string
     * @Column(type="string", name="year_to")
     */
    private $yearTo;

    /**
     * @var string
     * @Column(type="text", name="description")
     */
    private $description;

    /**
     * @var string
     * @Column(type="text", name="benefits")
     */
    private $benefits;

    /**
     * @var string
     * @Column(type="string", name="work_setup")
     */
    private $workSetup;

    /**
     * @var integer
     * @Column(type="int", name="column_index")
     */
    private $columnIndex;

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
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * @param string $companyName
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition($position)
    {
        $this->position = $position;
    }

    /**
     * @return string
     */
    public function getMonthFrom()
    {
        return $this->monthFrom;
    }

    /**
     * @param string $monthFrom
     */
    public function setMonthFrom($monthFrom)
    {
        $this->monthFrom = $monthFrom;
    }

    /**
     * @return string
     */
    public function getYearFrom()
    {
        return $this->yearFrom;
    }

    /**
     * @param string $yearFrom
     */
    public function setYearFrom($yearFrom)
    {
        $this->yearFrom = $yearFrom;
    }

    /**
     * @return string
     */
    public function getMonthTo()
    {
        return $this->monthTo;
    }

    /**
     * @param string $monthTo
     */
    public function setMonthTo($monthTo)
    {
        $this->monthTo = $monthTo;
    }

    /**
     * @return string
     */
    public function getYearTo()
    {
        return $this->yearTo;
    }

    /**
     * @param string $yearTo
     */
    public function setYearTo($yearTo)
    {
        $this->yearTo = $yearTo;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getBenefits()
    {
        return $this->benefits;
    }

    /**
     * @param string $benefits
     */
    public function setBenefits($benefits)
    {
        $this->benefits = $benefits;
    }

    /**
     * @return string
     */
    public function getWorkSetup()
    {
        return $this->workSetup;
    }

    /**
     * @param string $workSetup
     */
    public function setWorkSetup($workSetup)
    {
        $this->workSetup = $workSetup;
    }

    /**
     * @return int
     */
    public function getColumnIndex()
    {
        return $this->columnIndex;
    }

    /**
     * @param int $columnIndex
     */
    public function setColumnIndex($columnIndex)
    {
        $this->columnIndex = $columnIndex;
    }


}