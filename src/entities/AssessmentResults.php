<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/26/2016
 * Time: 6:32 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class AssessmentResults
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="assessment_results")
 */
class AssessmentResults
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="assesmentResult")
     * @JoinColumn(name="result_uid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var RemoteStaff\Entities\AssessmentList
     * @ManyToOne(targetEntity="RemoteStaff\Entities\AssessmentList", inversedBy="assesmentResult")
     * @JoinColumn(name="result_aid", referencedColumnName="assessment_id")
     */
    private $assementList;

    /**
     * @return RemoteStaff\Entities\AssessmentList
     */
    public function getAssementList()
    {
        return $this->assementList;
    }

    /**
     * @param RemoteStaff\Entities\AssessmentList $assementList
     */
    public function setAssementList($assementList)
    {
        $this->assementList = $assementList;
    }

    /**
     * @var string
     * @Column(type="string", name="result_type")
     */
    private $resultType;

    /**
     * @var string
     * @Column(type="string", name="result_score")
     */
    private $resultScore;

    /**
     * @var string
     * @Column(type="string", name="result_pct")
     */
    private $resultPct;

    /**
     * @var string
     * @Column(type="string", name="result_url")
     */
    private $resultUrl;

    /**
     * @var string
     * @Column(type="string", name="result_date")
     */
    private $resultDate;

    /**
     * @var string
     * @Column(type="string", name="result_session")
     */
    private $resultSession;

    /**
     * @var int
     * @Column(type="integer", name="result_selected")
     */
    private $resultSelected;

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
    public function getResultType()
    {
        return $this->resultType;
    }

    /**
     * @param string $resultType
     */
    public function setResultType($resultType)
    {
        $this->resultType = $resultType;
    }

    /**
     * @return string
     */
    public function getResultScore()
    {
        return $this->resultScore;
    }

    /**
     * @param string $resultScore
     */
    public function setResultScore($resultScore)
    {
        $this->resultScore = $resultScore;
    }

    /**
     * @return string
     */
    public function getResultPct()
    {
        return $this->resultPct;
    }

    /**
     * @param string $resultPct
     */
    public function setResultPct($resultPct)
    {
        $this->resultPct = $resultPct;
    }

    /**
     * @return string
     */
    public function getResultUrl()
    {
        return $this->resultUrl;
    }

    /**
     * @param string $resultUrl
     */
    public function setResultUrl($resultUrl)
    {
        $this->resultUrl = $resultUrl;
    }

    /**
     * @return string
     */
    public function getResultDate()
    {
        return $this->resultDate;
    }

    /**
     * @param string $resultDate
     */
    public function setResultDate($resultDate)
    {
        $this->resultDate = $resultDate;
    }

    /**
     * @return string
     */
    public function getResultSession()
    {
        return $this->resultSession;
    }

    /**
     * @param string $resultSession
     */
    public function setResultSession($resultSession)
    {
        $this->resultSession = $resultSession;
    }

    /**
     * @return int
     */
    public function getResultSelected()
    {
        return $this->resultSelected;
    }

    /**
     * @param int $resultSelected
     */
    public function setResultSelected($resultSelected)
    {
        $this->resultSelected = $resultSelected;
    }

}