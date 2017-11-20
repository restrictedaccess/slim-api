<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 5:06 PM
 */

namespace RemoteStaff\Documents;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * Class FieldStudy
 * @package RemoteStaff\Documents
 * @ODM\Document(db="candidates_profile_filters", collection="field_of_study")
 */
class FieldStudy
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
     * @ODM\Field(type="string", name="value")
     */
    private $value;


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
    public function getFieldId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setFieldId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

}