<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/27/2016
 * Time: 2:15 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class AssessmentResults
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="previous_job_industries")
 */
class PreviousJobIndustry
{
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
    public function getWorkSetupType()
    {
        return $this->workSetupType;
    }

    /**
     * @param string $workSetupType
     */
    public function setWorkSetupType($workSetupType)
    {
        $this->workSetupType = $workSetupType;
    }

    /**
     * @return RemoteStaff\Entities\Industry
     */
    public function getIndustry()
    {
        return $this->industry;
    }

    /**
     * @param RemoteStaff\Entities\Industry $industry
     */
    public function setIndustry($industry)
    {
        $this->industry = $industry;
    }

    /**
     * @return string
     */
    public function getCampaign()
    {
        return $this->campaign;
    }

    /**
     * @param string $campaign
     */
    public function setCampaign($campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }

    /**
     * @param int $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
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
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var int
     * @Column(type="integer", name="userid")
     */
    private $userId;

    /**
     * @var RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="previousJobIndustry")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var string
     * @Column(type="string", name="work_setup_type")
     */
    private $workSetupType;

    /**
     * @var RemoteStaff\Entities\Industry
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Industry", inversedBy="previousJobIndustry")
     * @JoinColumn(name="industry_id", referencedColumnName="id")
     */
    private $industry;

    /**
     * @var string
     * @Column(type="string", name="campaign")
     */
    private $campaign;

    /**
     * @var int
     * @Column(type="integer", name="`index`")
     */
    private $index;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="date_created")
     */
    private $dateCreated;

    /**
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    }

}