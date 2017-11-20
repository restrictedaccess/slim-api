<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/7/2016
 * Time: 3:18 PM
 */

namespace RemoteStaff\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Abstract Class ProductPrice
 * @package RemoteStaff\Documents
 * @ODM\Document
 */
abstract class ProductPrice
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
     * @ODM\Field(type="string", name="code")
     */
    private $code;

    /**
     * @var string
     * @ODM\Field(type="string", name="label")
     */
    private $label;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     * @ODM\EmbedMany (targetDocument="PriceDetails")
     */
    private $details;

    function __construct()
    {
        $this->details = new ArrayCollection();
    }


    /**
     * @return int
     */
    public function getPriceId()
    {
        return $this->id;
    }

    /**
     * @param $id
     */
    public function setPriceId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel($label)
    {
        $this->label = $label;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }



    /**
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param Doctrine\Common\Collections\ArrayCollection $details
     */
    public function setDetails($details)
    {
        $this->details = $details;
    }
}


/**
 * Class Details
 * @package RemoteStaff\Documents
 * @ODM\EmbeddedDocument
 */
class PriceDetails{
    /**
     * @var string
     * @ODM\Field(type="string", name="amount")
     */
    private $amount;

    /**
     * @var string
     * @ODM\Field(type="string", name="currency")
     */
    private $currency;

    /**
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    public function toArray(){
        $data = [
            "amount" => $this->getAmount(),
            "currency" => $this->getCurrency()
        ];

        return $data;
    }
}