<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 11/30/2016
 * Time: 10:01 AM
 */

namespace RemoteStaff\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use RemoteStaff\Interfaces\Persistable;


/**
 * Class InvoiceDeliveredReporting
 * @package RemoteStaff\Documents
 * @ODM\Document(db="invoice", collection="invoice_delivered_reporting")
 */
class InvoiceDeliveredReporting implements Persistable
{

    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    protected $_id;



    /**
     * @var string
     * @ODM\Field(type="string", name="client_fname")
     */
    private $clientFname;


    /**
     * @var string
     * @ODM\Field(type="string", name="client_lname")
     */
    private $clientLname;



    /**
     * @var string
     * @ODM\Field(type="string", name="order_id")
     */
    private $orderId;


    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="invoice_date_created")
     */
    private $invoiceDateCreated;


    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_delivered")
     */
    private $dateDelivered;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_opened")
     */
    private $dateOpened;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_clicked")
     */
    private $dateClicked;


    /**
     * @var string
     * @ODM\Field(type="string", name="added_by")
     */
    private $addedBy;

    /**
     * @var string
     * @ODM\Field(type="string", name="email_status")
     */
    private $emailStatus;


    /**
     * @var integer
     * @ODM\Field(type="int", name="age_in_days")
     */
    private $ageInDays = 0;

    /**
     * @return \DateTime
     */
    public function getDateOpened()
    {
        return $this->dateOpened;
    }

    /**
     * @param \DateTime $dateOpened
     */
    public function setDateOpened($dateOpened)
    {
        $this->dateOpened = $dateOpened;
    }

    /**
     * @return \DateTime
     */
    public function getDateClicked()
    {
        return $this->dateClicked;
    }

    /**
     * @param \DateTime $dateClicked
     */
    public function setDateClicked($dateClicked)
    {
        $this->dateClicked = $dateClicked;
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
    public function getClientFname()
    {
        return $this->clientFname;
    }

    /**
     * @param string $clientFname
     */
    public function setClientFname($clientFname)
    {
        $this->clientFname = $clientFname;
    }

    /**
     * @return string
     */
    public function getClientLname()
    {
        return $this->clientLname;
    }

    /**
     * @param string $clientLname
     */
    public function setClientLname($clientLname)
    {
        $this->clientLname = $clientLname;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param string $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * @return \DateTime
     */
    public function getInvoiceDateCreated()
    {
        return $this->invoiceDateCreated;
    }

    /**
     * @param \DateTime $invoiceDateCreated
     */
    public function setInvoiceDateCreated($invoiceDateCreated)
    {
        $this->invoiceDateCreated = $invoiceDateCreated;
    }

    /**
     * @return \DateTime
     */
    public function getDateDelivered()
    {
        return $this->dateDelivered;
    }

    /**
     * @param \DateTime $dateDelivered
     */
    public function setDateDelivered($dateDelivered)
    {
        $this->dateDelivered = $dateDelivered;
    }

    /**
     * @return string
     */
    public function getAddedBy()
    {
        return $this->addedBy;
    }

    /**
     * @param string $addedBy
     */
    public function setAddedBy($addedBy)
    {
        $this->addedBy = $addedBy;
    }

    /**
     * @return string
     */
    public function getEmailStatus()
    {
        return $this->emailStatus;
    }

    /**
     * @param string $emailStatus
     */
    public function setEmailStatus($emailStatus)
    {
        $this->emailStatus = $emailStatus;
    }

    /**
     * @return int
     */
    public function getAgeInDays()
    {
        return $this->ageInDays;
    }

    /**
     * @param int $ageInDays
     */
    public function setAgeInDays($ageInDays)
    {
        $this->ageInDays = $ageInDays;
    }




    /**
     * @return array
     */
    public function toArray(){
        $data = [
            "_id" => $this->getId(),
            "added_by" => $this->getAddedBy(),
            "age_in_days" => $this->getAgeInDays(),
            "client_fname" => $this->getClientFname(),
            "client_lname" => $this->getClientLname(),
            "email_status" => $this->getEmailStatus(),
            "invoice_date_created" => $this->getInvoiceDateCreated()->format("Y-m-d H:i:s"),
            "order_id" => $this->getOrderId()
        ];

        if(!empty($this->getDateDelivered())){
            $data["date_delivered"] = $this->getDateDelivered()->format("Y-m-d H:i:s");
        }

        return $data;
    }
}