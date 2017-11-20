<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 5:14 PM
 */

namespace RemoteStaff\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * Class Country
 * @package RemoteStaff\Documents
 * @ODM\Document(db="candidates_profile_filters", collection="countries")
 */
class Country
{
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
     * @return int
     */
    public function getCountryId()
    {
        return $this->id;
    }

    /**
     * @param int $countryId
     */
    public function setCountryId($countryId)
    {
        $this->id = $countryId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSortname()
    {
        return $this->sortname;
    }

    /**
     * @param string $sortname
     */
    public function setSortname($sortname)
    {
        $this->sortname = $sortname;
    }
    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    protected $_id;

    /**
     * @var integer
     * @ODM\Field(type="int")
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string", name="name")
     */
    private $name;

    /**
     * @var string
     * @ODM\Field(type="string", name="sortname")
     */
    private $sortname;
}