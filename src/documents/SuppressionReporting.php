<?php

namespace RemoteStaff\Documents;


namespace RemoteStaff\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use RemoteStaff\Interfaces\Persistable;


/**
 * Class SuppressionReporting
 * @package RemoteStaff\Documents
 * @ODM\Document(db="invoice", collection="suppression_reporting")
 */
class SuppressionReporting
{

    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    protected $_id;

    /**
     * @var string
     * @ODM\Field(type="string", name="email")
     */
    private $email;

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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


}