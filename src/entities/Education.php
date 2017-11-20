<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 9:53 PM
 */

namespace RemoteStaff\Entities;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class Country
 * @Entity
 * @Table(name="education")
 */
class Education implements Persistable{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="education", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     *
     */
    private $candidate;

    /**
     * @var string
     * @Column(type="string", name="educationallevel")
     */
    private $educationalLevel;

    /**
     * @var string
     * @Column(type="string", name="fieldstudy")
     */
    private $fieldStudy;
    /**
     * @var string
     * @Column(type="string", name="major")
     */
    private $major;
    /**
     * @var string
     * @Column(type="string", name="college_name")
     */
    private $collegeName;
    /**
     * @var string
     * @Column(type="string", name="college_country")
     */
    private $collegeCountry;
    /**
     * @var string
     * @Column(type="string", name="graduate_month")
     */
    private $graduateMonth;
    /**
     * @var string
     * @Column(type="string", name="graduate_year")
     */
    private $graduateYear;
    /**
     * @var string
     * @Column(type="string", name="trainings_seminars")
     */
    private $trainingsSeminar;

    /**
     * @var string
     * @Column(type="string", name="licence_certification")
     */
    private $licenceCertification;

    /**
     * @var string
     * @Column(type="string", name="grade")
     */
    private $grade;

    /**
     * @var string
     * @Column(type="string", name="gpascore")
     */
    private $gpascore;

    /**
     * @return string
     */
    public function getGpascore()
    {
        return $this->gpascore;
    }

    /**
     * @param string $gpascore
     */
    public function setGpascore($gpascore)
    {
        $this->gpascore = $gpascore;
    }

    /**
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * @param string $grade
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;
    }

    /**
     * @return string
     */
    public function getLicenceCertification()
    {
        return $this->licenceCertification;
    }

    /**
     * @param string $licenceCertification
     */
    public function setLicenceCertification($licenceCertification)
    {
        $this->licenceCertification = $licenceCertification;
    }

    /**
     * @return string
     */
    public function getCollegeCountry()
    {
        return $this->collegeCountry;
    }

    /**
     * @param string $collegeCountry
     */
    public function setCollegeCountry($collegeCountry)
    {
        $this->collegeCountry = $collegeCountry;
    }

    /**
     * @return string
     */
    public function getCollegeName()
    {
        return $this->collegeName;
    }

    /**
     * @param string $collegeName
     */
    public function setCollegeName($collegeName)
    {
        $this->collegeName = $collegeName;
    }

    /**
     * @return string
     */
    public function getFieldStudy()
    {
        return $this->fieldStudy;
    }

    /**
     * @param string $fieldStudy
     */
    public function setFieldStudy($fieldStudy)
    {
        $this->fieldStudy = $fieldStudy;
    }

    /**
     * @return string
     */
    public function getGraduateMonth()
    {
        return $this->graduateMonth;
    }

    /**
     * @param string $graduateMonth
     */
    public function setGraduateMonth($graduateMonth)
    {
        $this->graduateMonth = $graduateMonth;
    }

    /**
     * @return string
     */
    public function getGraduateYear()
    {
        return $this->graduateYear;
    }

    /**
     * @param string $graduateYear
     */
    public function setGraduateYear($graduateYear)
    {
        $this->graduateYear = $graduateYear;
    }


    /**
     * @return string
     */
    public function getMajor()
    {
        return $this->major;
    }

    /**
     * @param string $major
     */
    public function setMajor($major)
    {
        $this->major = $major;
    }

    /**
     * @return string
     */
    public function getTrainingsSeminar()
    {
        return $this->trainingsSeminar;
    }

    /**
     * @param string $trainingsSeminar
     */
    public function setTrainingsSeminar($trainingsSeminar)
    {
        $this->trainingsSeminar = $trainingsSeminar;
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
    public function getEducationalLevel()
    {
        return $this->educationalLevel;
    }

    /**
     * @param string $educationalLevel
     */
    public function setEducationalLevel($educationalLevel)
    {
        $this->educationalLevel = $educationalLevel;
    }

    public function toArray(){
        return [
            "id" => $this->getId(),
            "educationallevel"=> $this->getEducationalLevel(),
            "fieldstudy" => $this->getFieldStudy(),
            "major" => $this->getMajor(),
            "grade" => $this->getGrade(),
            "gpascore" => $this->getGpascore(),
            "college_name" => $this->getCollegeName(),
            "college_country" => $this->getCollegeCountry(),
            "graduate_month" => $this->getGraduateMonth(),
            "graduate_year" => $this->getGraduateYear(),
            "trainings_seminars" => $this->getTrainingsSeminar(),
            "licence_certification" => $this->getLicenceCertification()
        ];
    }
} 