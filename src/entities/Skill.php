<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 6:56 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class Skill
 * @Entity
 * @Table(name="skills")
 */
class Skill {
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="skills")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;
    /**
     * @var string
     * @Column(name="skill", type="string")
     */
    private $skill;
    /**
     * @var int
     * @Column(name="experience", type="integer")
     */
    private $experience;
    /**
     * @var int
     * @Column(name="proficiency", type="string")
     */
    private $proficiency;
    /**
     * @var string
     * @Column(name="skill_type", type="string")
     */
    private $skillType;

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
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param int $experience
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
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
     * @return int
     */
    public function getProficiency()
    {
        return $this->proficiency;
    }

    /**
     * @param int $proficiency
     */
    public function setProficiency($proficiency)
    {
        $this->proficiency = $proficiency;
    }

    /**
     * @return string
     */
    public function getSkill()
    {
        return $this->skill;
    }

    /**
     * @param string $skill
     */
    public function setSkill($skill)
    {
        $this->skill = $skill;
    }

    /**
     * @return string
     */
    public function getSkillType()
    {
        return $this->skillType;
    }

    /**
     * @param string $skillType
     */
    public function setSkillType($skillType)
    {
        $this->skillType = $skillType;
    }
    /**
     * @var \DateTime
     * @Column(name="date_time", type="datetime")
     */
    private $dateCreated;
} 