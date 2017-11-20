<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 11/29/2016
 * Time: 8:44 PM
 */

namespace RemoteStaff\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use RemoteStaff\Interfaces\Persistable;


/**
 * Class EmailInvoice
 * @package RemoteStaff\Documents
 * @ODM\Document(db="invoice", collection="delivered_invoices")
 */
class EmailInvoice implements Persistable
{

    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    protected $_id;

    /**
     * @var string
     * @ODM\Field(type="string", name="ip")
     */
    private $ip;

    /**
     * @var string
     * @ODM\Field(type="string", name="response")
     */
    private $response;

    /**
     * @var string
     * @ODM\Field(type="string", name="sg_event_id")
     */
    private $sg_event_id;


    /**
     * @var string
     * @ODM\Field(type="string", name="sg_message_id")
     */
    private $sg_message_id;


    /**
     * @var integer
     * @ODM\Field(type="int", name="tls")
     */
    private $tls;


    /**
     * @var string
     * @ODM\Field(type="string", name="event")
     */
    private $event;


    /**
     * @var string
     * @ODM\Field(type="string", name="email")
     */
    private $email;



    /**
     * @var integer
     * @ODM\Field(type="int", name="timestamp")
     */
    private $timestamp;


    /**
     * @var string
     * @ODM\Field(type="string", name="smtp_id")
     */
    private $smtpId;

    /**
     * @var string
     * @ODM\Field(type="string", name="accounts_order_id")
     */
    private $accountsOrderId;

    /**
     * @var string
     * @ODM\Field(type="string", name="status")
     */
    private $status;

    /**
     * @var string
     * @ODM\Field(type="string", name="email_status")
     */
    private $emailStatus;


    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_opened")
     */
    private $dateOpened;


    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_delivered")
     */
    private $dateDelivered;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_clicked")
     */
    private $dateClicked;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="date_updated")
     */
    private $dateUpdated;


    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="invoice_date_created")
     */
    private $invoiceDateCreated;

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
     * @ODM\Field(type="string", name="client_full_name")
     */
    private $clientFullname;

    /**
     * @var string
     * @ODM\Field(type="string", name="couch_id")
     */
    private $couchId;

    /**
     * @var integer
     * @ODM\Field(type="int", name="client_id")
     */
    private $clientId;

    /**
     * @return string
     */
    public function getCouchId()
    {
        return $this->couchId;
    }

    /**
     * @param string $couchId
     */
    public function setCouchId($couchId)
    {
        $this->couchId = $couchId;
    }



    /**
     * @return string
     */
    public function getClientFullname()
    {
        return $this->clientFullname;
    }

    /**
     * @param string $clientFullname
     */
    public function setClientFullname($clientFullname)
    {
        $this->clientFullname = $clientFullname;
    }




    /**
     * @return int
     */
    public function getClientId()
    {
        return $this->clientId;
    }

    /**
     * @param int $clientId
     */
    public function setClientId($clientId)
    {
        $this->clientId = $clientId;
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
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string $ip
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
    }

    /**
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param string $response
     */
    public function setResponse($response)
    {
        $this->response = $response;
    }

    /**
     * @return string
     */
    public function getSgEventId()
    {
        return $this->sg_event_id;
    }

    /**
     * @param string $sg_event_id
     */
    public function setSgEventId($sg_event_id)
    {
        $this->sg_event_id = $sg_event_id;
    }

    /**
     * @return string
     */
    public function getSgMessageId()
    {
        return $this->sg_message_id;
    }

    /**
     * @param string $sg_message_id
     */
    public function setSgMessageId($sg_message_id)
    {
        $this->sg_message_id = $sg_message_id;
    }

    /**
     * @return int
     */
    public function getTls()
    {
        return $this->tls;
    }

    /**
     * @param int $tls
     */
    public function setTls($tls)
    {
        $this->tls = $tls;
    }

    /**
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param string $event
     */
    public function setEvent($event)
    {
        $this->event = $event;
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

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param int $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getSmtpId()
    {
        return $this->smtpId;
    }

    /**
     * @param string $smtpId
     */
    public function setSmtpId($smtpId)
    {
        $this->smtpId = $smtpId;
    }

    /**
     * @return string
     */
    public function getAccountsOrderId()
    {
        return $this->accountsOrderId;
    }

    /**
     * @param string $accountsOrderId
     */
    public function setAccountsOrderId($accountsOrderId)
    {
        $this->accountsOrderId = $accountsOrderId;
    }





    /**
     * @return array
     */
    public function toArray(){
        $data = [
            "order_id" => $this->getAccountsOrderId(),
            "_id" => $this->getId(),
            "event" => $this->getEvent(),
            "email" => $this->getEmail(),
            "ip" => $this->getIp(),
            "response" => $this->getResponse(),
            "sg_event_id" => $this->getSgEventId(),
            "smtp_id" => $this->getSmtpId(),
            "sg_message_id" => $this->getSgMessageId(),
            "timestamp" => $this->getTimestamp(),
            "tls" => $this->getTls(),
            "status" => $this->getStatus()
        ];



        if(!empty($this->getDateOpened())){
            $data["date_opened"] = $this->getDateOpened()->format("Y-m-d H:i:s");
        }

        if(!empty($this->getDateDelivered())){
            $data["date_delivered"] = $this->getDateDelivered()->format("Y-m-d H:i:s");
        }

        if(!empty($this->getDateClicked())){
            $data["date_clicked"] = $this->getDateClicked()->format("Y-m-d H:i:s");
        }

        return $data;
    }


}