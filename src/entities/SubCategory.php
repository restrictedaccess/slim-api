<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/7/2016
 * Time: 9:06 AM
 */

namespace RemoteStaff\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class Category
 * @Entity
 * @Table(name="job_sub_category")
 */
class SubCategory implements Persistable
{

    /**
     * @var int
     * @Id @Column(type="integer", name="sub_category_id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \RemoteStaff\Entities\Category
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Category", inversedBy="subCategories")
     * @JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private $category;

    /**
     * @var string
     * @Column(type="string", name="sub_category_name")
     */
    private $subCategoryName;

    /**
     * @var string
     * @Column(type="string", name="singular_name")
     */
    private $singularName;

    /**
     * @var string
     * @Column(type="string", name="status", columnDefinition="ENUM('new','posted')")
     */
    private $status;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="sub_category_date_created")
     */
    private $subCategoryDateCreated;

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
     * @Column(type="string", name="keywords")
     */
    private $keywords;


    /**
     * @var string
     * @Column(type="string", name="meta_description")
     */
    private $metaDescription;

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
     * @Column(type="string", name="classification")
     */
    private $classification;


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
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return string
     */
    public function getSubCategoryName()
    {
        return $this->subCategoryName;
    }

    /**
     * @param string $subCategoryName
     */
    public function setSubCategoryName($subCategoryName)
    {
        $this->subCategoryName = $subCategoryName;
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
     * @return \DateTime
     */
    public function getSubCategoryDateCreated()
    {
        return $this->subCategoryDateCreated;
    }

    /**
     * @param \DateTime $subCategoryDateCreated
     */
    public function setSubCategoryDateCreated($subCategoryDateCreated)
    {
        $this->subCategoryDateCreated = $subCategoryDateCreated;
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
    public function getClassification()
    {
        return $this->classification;
    }

    /**
     * @param string $classification
     */
    public function setClassification($classification)
    {
        $this->classification = $classification;
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
            "sub_category_id" => $this->getId(),
            "sub_category_name" => $this->getSubCategoryName(),
            "singular_name" => $this->getSingularName(),
            "url" => $this->getUrl(),
            "description" => $this->getDescription(),
            "title" => $this->getTitle(),
            "keywords" => $this->getKeywords(),
            "meta_description" => $this->getMetaDescription(),
            "page_header" => $this->getPageHeader(),
            "page_description" => $this->getPageDescription(),
            "status" => $this->getStatus(),
            "classification" => $this->getClassification(),
            "asl_h1" => $this->getAslH1(),
            "asl_h2" => $this->getAslH2()
        ];

        if(!empty($this->getCategory())){
            $data["category"] = $this->getCategory()->toArray();
        }


        if(!empty($this->getSubCategoryDateCreated())){

            //"sub_category_date_created" => $this->getId(),

            $data["sub_category_date_created"] = $this->getSubCategoryDateCreated()->format("Y-m-d H:i:s");
        }

        return $data;
    }


}