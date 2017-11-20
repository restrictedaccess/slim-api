<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/27/2016
 * Time: 10:00 AM
 */

namespace RemoteStaff\Documents;


use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class CTATracker
 * @package RemoteStaff\Documents
 * @ODM\Document(db="cta_tracker", collection="cta_tracker")
 */
class CTATracker implements Persistable
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
     * @ODM\Field(type="string", name="dom_id")
     */
    private $domId;

    /**
     * @var string
     * @ODM\Field(type="string", name="cookie_value")
     */
    private $cookieValue;


    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_created")
     */
    private $dateCreated;

    /**
     * @var string
     * @ODM\Field(type="string", name="device")
     */
    private $device;

    /**
     * @var string
     * @ODM\Field(type="string", name="browser_version")
     */
    private $browserVersion;


    /**
     * @var string
     * @ODM\Field(type="string", name="ip_address")
     */
    private $ipAddress;

    /**
     * @return string
     */
    public function getBrowserVersion()
    {
        return $this->browserVersion;
    }

    /**
     * @param string $browserVersion
     */
    public function setBrowserVersion($browserVersion)
    {
        $this->browserVersion = $browserVersion;
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
    public function getDomId()
    {
        return $this->domId;
    }

    /**
     * @param string $domId
     */
    public function setDomId($domId)
    {
        $this->domId = $domId;
    }

    /**
     * @return string
     */
    public function getCookieValue()
    {
        return $this->cookieValue;
    }

    /**
     * @param string $cookieValue
     */
    public function setCookieValue($cookieValue)
    {
        $this->cookieValue = $cookieValue;
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
     * @return string
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param string $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }


    /**
     * @return array
     */
    public function toArray(){
        return [
            "id" => $this->getId(),
            "link" => $this->getLink(),
            "dom_id" => $this->getDomId(),
            "cookie_value" => $this->getCookieValue(),
            "date_created" => $this->getDateCreated()->format("Y-m-d H:i:s"),
            "device" => $this->getDevice(),
            "browser_version" => $this->getBrowserVersion(),
            "ip_address" => $this->getIpAddress()
        ];
    }



}