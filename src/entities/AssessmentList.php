<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/26/2016
 * Time: 8:46 PM
 */

namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class AssessmentList
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="assessment_lists")
 */
class AssessmentList
{
    /**
     * @var int
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @return int
     */
    public function getAssessmentId()
    {
        return $this->assessmentId;
    }

    /**
     * @param int $assessmentId
     */
    public function setAssessmentId($assessmentId)
    {
        $this->assessmentId = $assessmentId;
    }

    /**
     * @var int
     * @Id @Column(type="integer", name="assessment_id")
     */
    private $assessmentId;


    /**
     * @var string
     * @Column(type="string", name="assessment_title")
     */
    private $assessmentTitle;

    /**
     * @var string
     * @Column(type="string", name="assessment_type")
     */
    private $assessmentType;

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
     * @return string
     */
    public function getAssessmentTitle()
    {
        return $this->assessmentTitle;
    }

    /**
     * @param string $assessmentTitle
     */
    public function setAssessmentTitle($assessmentTitle)
    {
        $this->assessmentTitle = $assessmentTitle;
    }

    /**
     * @return string
     */
    public function getAssessmentType()
    {
        return $this->assessmentType;
    }

    /**
     * @param string $assessmentType
     */
    public function setAssessmentType($assessmentType)
    {
        $this->assessmentType = $assessmentType;
    }

    /**
     * @return string
     */
    public function getAssessmentCategory()
    {
        return $this->assessmentCategory;
    }

    /**
     * @param string $assessmentCategory
     */
    public function setAssessmentCategory($assessmentCategory)
    {
        $this->assessmentCategory = $assessmentCategory;
    }

    /**
     * @return ArrayCollection
     */
    public function getAssesmentResult()
    {
        return $this->assesmentResult;
    }

    /**
     * @param ArrayCollection $assesmentResult
     */
    public function setAssesmentResult($assesmentResult)
    {
        $this->assesmentResult = $assesmentResult;
    }

    /**
     * @var string
     * @Column(type="string", name="assessment_category")
     */
    private $assessmentCategory;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\AssessmentResults", mappedBy="assementList")
     *
     */
    private $assesmentResult = [];

    public function __construct(){
        $this->assesmentResult = new ArrayCollection();
    }

}