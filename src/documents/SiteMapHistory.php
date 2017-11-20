<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/24/2016
 * Time: 5:36 PM
 */

namespace RemoteStaff\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * Class SiteMapHistory
 * @package RemoteStaff\Documents
 * @ODM\Document(db="seo", collection="site_map_history")
 */
class SiteMapHistory
{
    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    protected $_id;

    /**
     * @var string
     * @ODM\Field(type="string", name="changes")
     */
    private $changes;


    /**
     * @var string
     * @ODM\Field(type="string", name="change_by_type")
     */
    private $changedByType;

    /**
     * @var integer
     * @ODM\Field(type="int", name="changed_by_id")
     */
    private $changedById;

    /**
     * @var string
     * @ODM\Field(type="string", name="changed_by_first_name")
     */
    private $changedByFirstName;


    /**
     * @var string
     * @ODM\Field(type="string", name="changed_by_last_name")
     */
    private $changedByLastName;

    /**
     * @var string
     * @ODM\Field(type="string", name="changed_by_full_name")
     */
    private $changedByFullName;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_created")
     */
    private $dateCreated;

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
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param string $changes
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;
    }

    /**
     * @return string
     */
    public function getChangedByType()
    {
        return $this->changedByType;
    }

    /**
     * @param string $changedByType
     */
    public function setChangedByType($changedByType)
    {
        $this->changedByType = $changedByType;
    }

    /**
     * @return int
     */
    public function getChangedById()
    {
        return $this->changedById;
    }

    /**
     * @param int $changedById
     */
    public function setChangedById($changedById)
    {
        $this->changedById = $changedById;
    }

    /**
     * @return string
     */
    public function getChangedByFirstName()
    {
        return $this->changedByFirstName;
    }

    /**
     * @param string $changedByFirstName
     */
    public function setChangedByFirstName($changedByFirstName)
    {
        $this->changedByFirstName = $changedByFirstName;
    }

    /**
     * @return string
     */
    public function getChangedByLastName()
    {
        return $this->changedByLastName;
    }

    /**
     * @param string $changedByLastName
     */
    public function setChangedByLastName($changedByLastName)
    {
        $this->changedByLastName = $changedByLastName;
    }

    /**
     * @return string
     */
    public function getChangedByFullName()
    {
        return $this->changedByFullName;
    }

    /**
     * @param string $changedByFullName
     */
    public function setChangedByFullName($changedByFullName)
    {
        $this->changedByFullName = $changedByFullName;
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


}