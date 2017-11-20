<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/7/2016
 * Time: 8:58 AM
 */

namespace RemoteStaff\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class Category
 * @Entity
 * @Table(name="job_category")
 */
class Category implements Persistable
{

    /**
     * @var int
     * @Id @Column(type="integer", name="category_id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="status", columnDefinition="ENUM('new','posted','removed')")
     */
    private $status;

    /**
     * @var string
     * @Column(type="string", name="category_name")
     */
    private $categoryName;

    /**
     * @var string
     * @Column(type="string", name="singular_name")
     */
    private $singularName;


    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\SubCategory", mappedBy="category", cascade={"remove", "persist"})
     * @OrderBy({"subCategoryName" = "ASC"})
     */
    private $subCategories;


    /**
     * @var \RemoteStaff\Entities\Admin
     * @OneToOne(targetEntity="RemoteStaff\Entities\Admin", fetch="LAZY")
     * @JoinColumn(name="created_by", referencedColumnName="admin_id")
     */
    private $createdBy;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="category_date_created")
     */
    private $categoryDateCreated;


    /**
     * @var string
     * @Column(type="string", name="url")
     */
    private $url;

    /**
     * @var string
     * @Column(type="string", name="description")
     */
    private $description;

    /**
     * @var string
     * @Column(type="string", name="title")
     */
    private $title;

    /**
     * @var string
     * @Column(type="string", name="meta_description")
     */
    private $metaDescription;

    /**
     * @var string
     * @Column(type="string", name="keywords")
     */
    private $keywords;


    /**
     * @var string
     * @Column(type="string", name="page_header")
     */
    private $pageHeader;

    /**
     * @var string
     * @Column(type="string", name="page_description")
     */
    private $pageDescription;



    /**
     * @var string
     * @Column(type="string", name="asl_h1")
     */
    private $aslH1;



    /**
     * @var string
     * @Column(type="string", name="asl_h2")
     */
    private $aslH2;

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


    /**
     * @return \DateTime
     */
    public function getCategoryDateCreated()
    {
        return $this->categoryDateCreated;
    }

    /**
     * @param \DateTime $categoryDateCreated
     */
    public function setCategoryDateCreated($categoryDateCreated)
    {
        $this->categoryDateCreated = $categoryDateCreated;
    }



    /**
     * @return Admin
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param Admin $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
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
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getCategoryName()
    {
        return $this->categoryName;
    }

    /**
     * @param string $categoryName
     */
    public function setCategoryName($categoryName)
    {
        $this->categoryName = $categoryName;
    }

    /**
     * @return string
     */
    public function getSingularName()
    {
        return $this->singularName;
    }

    /**
     * @param string $singularName
     */
    public function setSingularName($singularName)
    {
        $this->singularName = $singularName;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getSubCategories()
    {
        return $this->subCategories;
    }

    /**
     * @param \Doctrine\Common\Collections\ArrayCollection $subCategories
     */
    public function setSubCategories($subCategories)
    {
        $this->subCategories = $subCategories;
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
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * @param string $keywords
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * @return string
     */
    public function getPageHeader()
    {
        return $this->pageHeader;
    }

    /**
     * @param string $pageHeader
     */
    public function setPageHeader($pageHeader)
    {
        $this->pageHeader = $pageHeader;
    }

    /**
     * @return string
     */
    public function getPageDescription()
    {
        return $this->pageDescription;
    }

    /**
     * @param string $pageDescription
     */
    public function setPageDescription($pageDescription)
    {
        $this->pageDescription = $pageDescription;
    }

    /**
     * @return string
     */
    public function getAslH1()
    {
        return $this->aslH1;
    }

    /**
     * @param string $aslH1
     */
    public function setAslH1($aslH1)
    {
        $this->aslH1 = $aslH1;
    }

    /**
     * @return string
     */
    public function getAslH2()
    {
        return $this->aslH2;
    }

    /**
     * @param string $aslH2
     */
    public function setAslH2($aslH2)
    {
        $this->aslH2 = $aslH2;
    }







    public function toArray(){
        $data = [
            "category_id" => $this->getId(),
            "status" => $this->getStatus(),
            "category_name" => $this->getCategoryName(),
            "singular_name" => $this->getSingularName(),
            "url" => $this->getUrl(),
            "description" => $this->getDescription(),
            "title" => $this->getTitle(),
            "meta_description" => $this->getMetaDescription(),
            "keywords" => $this->getKeywords(),
            "page_header" => $this->getPageHeader(),
            "page_description" => $this->getPageDescription(),
            "asl_h1" => $this->getAslH1(),
            "asl_h2" => $this->getAslH2()
        ];

        if(!empty($this->getCreatedBy())){
            $data["created_by"] = $this->getCreatedBy()->toArray();
        }


        if(!empty($this->getCategoryDateCreated())){
            $data["category_date_created"] = $this->getCategoryDateCreated()->format("Y-m-d H:i:s");
        }



        return $data;
    }



}