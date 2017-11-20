<?php
namespace RemoteStaff\Entities;

/**
 * Class DefinedSkill
 * @Entity
 * @Table(name="defined_skills")
 */
class DefinedSkill
{

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(name="skill_name", type="string")
     */
    private $skillName;


    /**
     * @var string
     * @Column(name="meta_description", type="string")
     */
    private $metaDescription;


    /**
     * @var string
     * @Column(name="meta_title", type="string")
     */
    private $metaTitle;


    /**
     * @var string
     * @Column(name="meta_keywords", type="string")
     */
    private $metaKeywords;


    /**
     * @var string
     * @Column(name="url", type="string")
     */
    private $url;

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
    public function getSkillName()
    {
        return $this->skillName;
    }

    public function getSkillNameUtf8(){
        return mb_convert_encoding($this->skillName, 'UTF-8', 'ISO-8859-1');
    }

    /**
     * @param string $skillName
     */
    public function setSkillName($skillName)
    {
        $this->skillName = $skillName;
    }

    /**
     * @return string
     */
    public function getMetaDescription()
    {
        return $this->metaDescription;
    }

    /**
     * @param string $metaDescription
     */
    public function setMetaDescription($metaDescription)
    {
        $this->metaDescription = $metaDescription;
    }

    /**
     * @return string
     */
    public function getMetaTitle()
    {
        return $this->metaTitle;
    }

    /**
     * @param string $metaTitle
     */
    public function setMetaTitle($metaTitle)
    {
        $this->metaTitle = $metaTitle;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->metaKeywords;
    }

    /**
     * @param string $metaKeywords
     */
    public function setMetaKeywords($metaKeywords)
    {
        $this->metaKeywords = $metaKeywords;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }


}