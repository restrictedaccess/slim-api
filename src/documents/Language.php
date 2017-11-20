<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 5:25 PM
 */

namespace RemoteStaff\Documents;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * Class Language
 * @package RemoteStaff\Documents
 * @ODM\Document(db="candidates_profile_filters", collection="languages")
 */
class Language
{
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
    public function getLanguageId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setLanguageId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $value
     */
    public function setName($name)
    {
        $this->name = $name;
    }

}