<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/24/2016
 * Time: 5:29 PM
 */

namespace RemoteStaff\Documents;
use RemoteStaff\Interfaces\Persistable;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * Class SiteMap
 * @package RemoteStaff\Documents
 * @ODM\Document(db="seo", collection="site_map")
 */
class SiteMap implements Persistable
{
    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    protected $_id;

    /**
     * @var string
     * @ODM\Field(type="string", name="link")
     */
    private $link;

    /**
     * @var string
     * @ODM\Field(type="string", name="uri")
     */
    private $uri;


    /**
     * @var string
     * @ODM\Field(type="string", name="title")
     */
    private $title;


    /**
     * @var string
     * @ODM\Field(type="string", name="meta_description")
     */
    private $meta_description;


    /**
     * @var string
     * @ODM\Field(type="string", name="meta_keywords")
     */
    private $meta_keywords;

    /**
     * @var string
     * @ODM\Field(type="string", name="page_h1")
     */
    private $page_h1;

    /**
     * @var string
     * @ODM\Field(type="string", name="page_h2")
     */
    private $page_h2;


    /**
     * @var string
     * @ODM\Field(type="string", name="page_h3")
     */
    private $page_h3;

    /**
     * @var string
     * @ODM\Field(type="string", name="redirects_to")
     */
    private $redirects_to;


    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_created")
     */
    private $dateCreated;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_updated")
     */
    private $dateUpdated;

    /**
     * @var string
     * @ODM\Field(type="string", name="status")
     */
    private $status;

    /**
     * @var integer
     * @ODM\Field(type="int", name="last_updated_by_id")
     */
    private $lastUpdatedById;

    /**
     * @var string
     * @ODM\Field(type="string", name="last_updated_by_name")
     */
    private $lastUpdatedByName;


    /**
     * @var integer
     * @ODM\Field(type="int", name="created_by_id")
     */
    private $createdById;

    /**
     * @var string
     * @ODM\Field(type="string", name="created_by_name")
     */
    private $createdByName;

    /**
     * @var integer
     * @ODM\Field(type="int", name="sort_number")
     */
    private $sortNumber;

    /**
     * @var string
     * @ODM\Field(type="string", name="save_params")
     */
    private $saveParams;

    /**
     * @return string
     */
    public function getSaveParams()
    {
        return $this->saveParams;
    }

    /**
     * @param string $saveParams
     */
    public function setSaveParams($saveParams)
    {
        $this->saveParams = $saveParams;
    }



    /**
     * @return int
     */
    public function getCreatedById()
    {
        return $this->createdById;
    }

    /**
     * @param int $createdById
     */
    public function setCreatedById($createdById)
    {
        $this->createdById = $createdById;
    }

    /**
     * @return string
     */
    public function getCreatedByName()
    {
        return $this->createdByName;
    }

    /**
     * @param string $createdByName
     */
    public function setCreatedByName($createdByName)
    {
        $this->createdByName = $createdByName;
    }


    /**
     * @return int
     */
    public function getSortNumber()
    {
        return $this->sortNumber;
    }

    /**
     * @param int $sortNumber
     */
    public function setSortNumber($sortNumber)
    {
        $this->sortNumber = $sortNumber;
    }



    /**
     * @return int
     */
    public function getLastUpdatedById()
    {
        return $this->lastUpdatedById;
    }

    /**
     * @param int $lastUpdatedById
     */
    public function setLastUpdatedById($lastUpdatedById)
    {
        $this->lastUpdatedById = $lastUpdatedById;
    }

    /**
     * @return string
     */
    public function getLastUpdatedByName()
    {
        return $this->lastUpdatedByName;
    }

    /**
     * @param string $lastUpdatedByName
     */
    public function setLastUpdatedByName($lastUpdatedByName)
    {
        $this->lastUpdatedByName = $lastUpdatedByName;
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
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTime $dateUpdated
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
    }



    /**
     * @return String
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param String $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri($uri)
    {
        $this->uri = $uri;
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
        return $this->meta_description;
    }

    /**
     * @param string $meta_description
     */
    public function setMetaDescription($meta_description)
    {
        $this->meta_description = $meta_description;
    }

    /**
     * @return string
     */
    public function getMetaKeywords()
    {
        return $this->meta_keywords;
    }

    /**
     * @param string $meta_keywords
     */
    public function setMetaKeywords($meta_keywords)
    {
        $this->meta_keywords = $meta_keywords;
    }

    /**
     * @return string
     */
    public function getPageH1()
    {
        return $this->page_h1;
    }

    /**
     * @param string $page_h1
     */
    public function setPageH1($page_h1)
    {
        $this->page_h1 = $page_h1;
    }

    /**
     * @return string
     */
    public function getPageH2()
    {
        return $this->page_h2;
    }

    /**
     * @param string $page_h2
     */
    public function setPageH2($page_h2)
    {
        $this->page_h2 = $page_h2;
    }

    /**
     * @return string
     */
    public function getPageH3()
    {
        return $this->page_h3;
    }

    /**
     * @param string $page_h3
     */
    public function setPageH3($page_h3)
    {
        $this->page_h3 = $page_h3;
    }

    /**
     * @return string
     */
    public function getRedirectsTo()
    {
        return $this->redirects_to;
    }

    /**
     * @param string $redirects_to
     */
    public function setRedirectsTo($redirects_to)
    {
        $this->redirects_to = $redirects_to;
    }


    /**
     * @return array
     */
    public function toArray(){
        $data = [
            "id" => $this->getId(),
            "link" => $this->getLink(),
            "uri" => $this->getUri(),
            "title" => $this->getTitle(),
            "meta_description" => $this->getMetaDescription(),
            "meta_keywords" => $this->getMetaKeywords(),
            "page_h1" => $this->getPageH1(),
            "page_h2" => $this->getPageH2(),
            "page_h3" => $this->getPageH3(),
            "redirects_to" => $this->getRedirectsTo(),
            "status" => $this->getStatus(),
            "sort_number" => $this->getSortNumber()
        ];
        if(!empty($this->getSaveParams())){
            $data["save_params"] = $this->getSaveParams();
        }

        if(!empty($this->getDateCreated())){
            $data["date_created"] = $this->getDateCreated()->format("Y-m-d H:i:s");
        }

        if(!empty($this->getDateUpdated())){
            $data["date_updated"] = $this->getDateUpdated()->format("Y-m-d H:i:s");
        }

        if(!empty($this->getLastUpdatedById())){
            $data["last_updated_by_id"] = $this->getLastUpdatedById();
            $data["last_updated_by_name"] = $this->getLastUpdatedByName();
        }

        if(!empty($this->getCreatedById())){
            $data["created_by_id"] = $this->getCreatedById();
            $data["created_by_name"] = $this->getCreatedByName();
        }

        return $data;
    }


}