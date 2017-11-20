<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/28/2016
 * Time: 11:31 AM
 */

namespace RemoteStaff\Entities;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class Language
 * @Entity
 * @Table(name="language")
 */
class Language implements Persistable
{

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="languages")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;
    /**
     * @var string
     * @Column(name="language", type="string")
     */
    private $language;
    /**
     * @var int
     * @Column(name="spoken", type="integer")
     */
    private $spoken;
    /**
     * @var int
     * @Column(name="written", type="string")
     */
    private $written;

    /**
     * @var int
     * @Column(name="spoken_assessment", type="string")
     */
    private $spoken_assessment;


    /**
     * @var int
     * @Column(name="written_assessment", type="string")
     */
    private $written_assessment;



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
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @param string $language
     */
    public function setLanguage($language)
    {
        $this->language = $language;
    }

    /**
     * @return int
     */
    public function getSpoken()
    {
        return $this->spoken;
    }

    /**
     * @param int $spoken
     */
    public function setSpoken($spoken)
    {
        $this->spoken = $spoken;
    }

    /**
     * @return int
     */
    public function getWritten()
    {
        return $this->written;
    }

    /**
     * @param int $written
     */
    public function setWritten($written)
    {
        $this->written = $written;
    }

    /**
     * @return int
     */
    public function getSpokenAssessment()
    {
        return $this->spoken_assessment;
    }

    /**
     * @param int $spoken_assessment
     */
    public function setSpokenAssessment($spoken_assessment)
    {
        $this->spoken_assessment = $spoken_assessment;
    }

    /**
     * @return int
     */
    public function getWrittenAssessment()
    {
        return $this->written_assessment;
    }

    /**
     * @param int $written_assessment
     */
    public function setWrittenAssessment($written_assessment)
    {
        $this->written_assessment = $written_assessment;
    }


    /**
     * @return array
     */
    public function toArray(){
        return [
            "id" => $this->getId(),
            "language" => $this->getLanguage(),
            "spoken" => $this->getSpoken(),
            "written" => $this->getWritten(),
            "spoken_assessment" => $this->getSpokenAssessment(),
            "written_assessment" => $this->getWrittenAssessment()
        ];
    }
}