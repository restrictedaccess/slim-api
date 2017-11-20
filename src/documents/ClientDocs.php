<?php

namespace RemoteStaff\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class ClientDocs
 * @package RemoteStaff\Documents
 * @ODM\Document(db="prod", collection="client_docs")
 */
class ClientDocs implements Persistable
{

    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    protected $_id;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="added_on")
     */
    private $addedOn;

    /**
     * @var string
     * @ODM\Field(type="string", name="disable_auto_follow_up")
     */
    private $disableAutoFollowUp;

    /**
     * @var string
     * @ODM\Field(type="string", name="apply_gst")
     */
    private $applyGst;

    /**
     * @var string
     * @ODM\Field(type="string", name="order_id")
     */
    private $orderId;

    /**
     * @var string
     * @ODM\Field(type="string", name="client_email")
     */
    private $clientEmail;

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
     * @ODM\Field(type="string", name="type")
     */
    private $type;

    /**
     * @var bool
     * @ODM\Field(type="boolean", name="payment_advise")
     */
    private $paymentAdvise;

    /**
     * @var integer
     * @ODM\Field(type="int", name="client_id")
     */
    private $client_id;

    /**
     * @var integer
     * @ODM\Field(type="int", name="pay_before_date_unix")
     */
    private $payBeforeDateUnix;

    /**
     * @var float
     * @ODM\Field(type="float", name="sub_total")
     */
    private $subTotal;

    /**
     * @var float
     * @ODM\Field(type="float", name="gst_amount")
     */
    private $gstAmount;

    /**
     * @var string
     * @ODM\Field(type="string", name="currency")
     */
    private $currency;

    /**
     * @var string
     * @ODM\Field(type="string", name="added_by")
     */
    private $addedBy;


    /**
     * @var string
     * @ODM\Field(type="string", name="invoice_setup")
     */
    private $invoiceSetup;

    /**
     * @var string
     * @ODM\Field(type="string", name="status")
     */
    private $status;

    /**
     * @var string
     * @ODM\Field(type="string", name="added_on_formatted")
     */
    private $addedOnFormatted;



    /**
     * @var float
     * @ODM\Field(type="float", name="running_balance")
     */
    private $runningBalance;

    /**
     * @var float
     * @ODM\Field(type="float", name="total_amount")
     */
    private $totalAmount;

    /**
     * @var bool
     * @ODM\Field(type="boolean", name="over_payment")
     */
    private $overPayment;

    /**
     * @var string
     * @ODM\Field(type="string", name="couch_id")
     */
    private $couchId;

    /**
     * @var float
     * @ODM\Field(type="float", name="added_on_unix")
     */
    private $addedOnUnix;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     * @ODM\EmbedMany (targetDocument="Item")
     */
    private $items;

    /**
     * @var Doctrine\Common\Collections\ArrayCollection
     * @ODM\EmbedMany (targetDocument="History")
     */
    private $history;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="pay_before_date")
     */
    private $payBeforeDate;


    /**
     * @var integer
     * @ODM\Field(type="int", name="percentage_margin")
     */
    private $percentageMargin;

    /**
     * @return int
     */
    public function getPercentageMargin()
    {
        return $this->percentageMargin;
    }

    /**
     * @param int $percentageMargin
     */
    public function setPercentageMargin($percentageMargin)
    {
        $this->percentageMargin = $percentageMargin;
    }


    /**
     * @return \DateTime
     */
    public function getPayBeforeDate()
    {
        return $this->payBeforeDate;
    }

    /**
     * @param \DateTime $payBeforeDate
     */
    public function setPayBeforeDate($payBeforeDate)
    {
        $this->payBeforeDate = $payBeforeDate;
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
     * @return \DateTime
     */
    public function getAddedOn()
    {
        return $this->addedOn;
    }

    /**
     * @param \DateTime $addedOn
     */
    public function setAddedOn($addedOn)
    {
        $this->addedOn = $addedOn;
    }

    /**
     * @return string
     */
    public function getDisableAutoFollowUp()
    {
        return $this->disableAutoFollowUp;
    }

    /**
     * @param string $disableAutoFollowUp
     */
    public function setDisableAutoFollowUp($disableAutoFollowUp)
    {
        $this->disableAutoFollowUp = $disableAutoFollowUp;
    }

    /**
     * @return string
     */
    public function getApplyGst()
    {
        return $this->applyGst;
    }

    /**
     * @param string $applyGst
     */
    public function setApplyGst($applyGst)
    {
        $this->applyGst = $applyGst;
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
     * @return string
     */
    public function getClientEmail()
    {
        return $this->clientEmail;
    }

    /**
     * @param string $clientEmail
     */
    public function setClientEmail($clientEmail)
    {
        $this->clientEmail = $clientEmail;
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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return boolean
     */
    public function isPaymentAdvise()
    {
        return $this->paymentAdvise;
    }

    /**
     * @param boolean $paymentAdvise
     */
    public function setPaymentAdvise($paymentAdvise)
    {
        $this->paymentAdvise = $paymentAdvise;
    }

    /**
     * @return int
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param int $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return int
     */
    public function getPayBeforeDateUnix()
    {
        return $this->payBeforeDateUnix;
    }

    /**
     * @param int $payBeforeDateUnix
     */
    public function setPayBeforeDateUnix($payBeforeDateUnix)
    {
        $this->payBeforeDateUnix = $payBeforeDateUnix;
    }

    /**
     * @return float
     */
    public function getSubTotal()
    {
        return $this->subTotal;
    }

    /**
     * @param float $subTotal
     */
    public function setSubTotal($subTotal)
    {
        $this->subTotal = $subTotal;
    }

    /**
     * @return float
     */
    public function getGstAmount()
    {
        return $this->gstAmount;
    }

    /**
     * @param float $gstAmount
     */
    public function setGstAmount($gstAmount)
    {
        $this->gstAmount = $gstAmount;
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
    public function getInvoiceSetup()
    {
        return $this->invoiceSetup;
    }

    /**
     * @param string $invoiceSetup
     */
    public function setInvoiceSetup($invoiceSetup)
    {
        $this->invoiceSetup = $invoiceSetup;
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
     * @return string
     */
    public function getAddedOnFormatted()
    {
        return $this->addedOnFormatted;
    }

    /**
     * @param string $addedOnFormatted
     */
    public function setAddedOnFormatted($addedOnFormatted)
    {
        $this->addedOnFormatted = $addedOnFormatted;
    }

    /**
     * @return float
     */
    public function getRunningBalance()
    {
        return $this->runningBalance;
    }

    /**
     * @param float $runningBalance
     */
    public function setRunningBalance($runningBalance)
    {
        $this->runningBalance = $runningBalance;
    }

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }

    /**
     * @return boolean
     */
    public function isOverPayment()
    {
        return $this->overPayment;
    }

    /**
     * @param boolean $overPayment
     */
    public function setOverPayment($overPayment)
    {
        $this->overPayment = $overPayment;
    }

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
     * @return float
     */
    public function getAddedOnUnix()
    {
        return $this->addedOnUnix;
    }

    /**
     * @param float $addedOnUnix
     */
    public function setAddedOnUnix($addedOnUnix)
    {
        $this->addedOnUnix = $addedOnUnix;
    }

    /**
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * @param Doctrine\Common\Collections\ArrayCollection $items
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * @return Doctrine\Common\Collections\ArrayCollection
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * @param Doctrine\Common\Collections\ArrayCollection $history
     */
    public function setHistory($history)
    {
        $this->history = $history;
    }

    /**
     * @return array
     */
    public function toArray(){
        $data = [
            "_id" => $this->getId(),
            "order_id" => $this->getOrderId(),
            "added_by" => $this->getAddedBy(),
            "currency" => $this->getCurrency(),
            "gst_amount" => $this->getGstAmount(),
            "sub_total" => $this->getSubTotal(),
            "total_amount" => $this->getTotalAmount(),
            "invoice_setup" => $this->getInvoiceSetup(),
            "percentage_margin" => $this->getPercentageMargin(),
            "client_id" => $this->getClientId(),
            "client_fname" => $this->getClientFname(),
            "client_lname" => $this->getClientLname()
        ];


        if(!empty($this->getCouchId())){
            $data["couch_id"] = $this->getCouchId();
        }

        if(!empty($this->getAddedOn())){
            $data["added_on"] = $this->getAddedOn()->format("Y-m-d H:i:s");
        }

        if(!empty($this->getPayBeforeDate())){
            $data["pay_before_date"] = $this->getPayBeforeDate()->format("Y-m-d H:i:s");
        }

        if(!empty($this->getItems())){
            $data["items"] = [];
            /**
             * @var $item Item
             */
            foreach ($this->getItems() as $item) {
                $data["items"][] = $item->toArray();
            }
        }





        return $data;
    }



}


/**
 * Class Item
 * @package RemoteStaff\Documents
 * @ODM\EmbeddedDocument
 */
class Item implements Persistable{
    /**
     * @var integer
     * @ODM\Field(type="int", name="item_id")
     */
    private $itemId;

    /**
     * @var float
     * @ODM\Field(type="float", name="amount")
     */
    private $amount;


    /**
     * @var string
     * @ODM\Field(type="string", name="description")
     */
    private $description;

    /**
     * @var float
     * @ODM\Field(type="float", name="unit_price")
     */
    private $unitPrice;

    /**
     * @var float
     * @ODM\Field(type="float", name="qty")
     */
    private $qty;

    /**
     * @var integer
     * @ODM\Field(type="int", name="subcontractors_id")
     */
    private $subcontractorsId;

    /**
     * @var string
     * @ODM\Field(type="string", name="item_type")
     */
    private $itemType;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="start_date")
     */
    private $startDate;

    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="end_date")
     */
    private $endDate;

    /**
     * @var float
     * @ODM\Field(type="float", name="remotestaff_fee")
     */
    private $remotestaffFee;

    /**
     * @var float
     * @ODM\Field(type="float", name="total_amount")
     */
    private $totalAmount;

    /**
     * @return float
     */
    public function getTotalAmount()
    {
        return $this->totalAmount;
    }

    /**
     * @param float $totalAmount
     */
    public function setTotalAmount($totalAmount)
    {
        $this->totalAmount = $totalAmount;
    }



    /**
     * @return float
     */
    public function getRemotestaffFee()
    {
        return $this->remotestaffFee;
    }

    /**
     * @param float $remotestaffFee
     */
    public function setRemotestaffFee($remotestaffFee)
    {
        $this->remotestaffFee = $remotestaffFee;
    }



    /**
     * @return string
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * @param string $itemType
     */
    public function setItemType($itemType)
    {
        $this->itemType = $itemType;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    /**
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param \DateTime $endDate
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }





    /**
     * @return int
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * @param int $itemId
     */
    public function setItemId($itemId)
    {
        $this->itemId = $itemId;
    }

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
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return float
     */
    public function getUnitPrice()
    {
        return $this->unitPrice;
    }

    /**
     * @param float $unitPrice
     */
    public function setUnitPrice($unitPrice)
    {
        $this->unitPrice = $unitPrice;
    }

    /**
     * @return float
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param float $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    /**
     * @return int
     */
    public function getSubcontractorsId()
    {
        return $this->subcontractorsId;
    }

    /**
     * @param int $subcontractorsId
     */
    public function setSubcontractorsId($subcontractorsId)
    {
        $this->subcontractorsId = $subcontractorsId;
    }


    /**
     * @return array
     */
    public function toArray(){
        $data = [
            "item_id" => $this->getItemId(),
            "amount" => $this->getAmount(),
            "description" => $this->getDescription(),
            "unit_price" => $this->getUnitPrice(),
            "qty" => $this->getQty(),
            "item_type" => $this->getItemType(),
            "remotestaff_fee" => $this->getRemotestaffFee(),
        ];

        if(!empty($this->getSubcontractorsId())){
            $data["subcontractors_id"] = $this->getSubcontractorsId();
        }

        if(!empty($this->getStartDate())){
            $data["start_date"] = $this->getStartDate()->format("Y-m-d H:i:s");
        }

        if(!empty($this->getEndDate())){
            $data["end_date"] = $this->getEndDate()->format("Y-m-d H:i:s");
        }

        return $data;
    }
}

/**
 * Class History
 * @package RemoteStaff\Documents
 * @ODM\EmbeddedDocument
 */
class History implements Persistable{
    /**
     * @var \DateTime
     * @ODM\Field(type="date", name="timestamp")
     */
    private $timestamp;

    /**
     * @var string
     * @ODM\Field(type="string", name="by")
     */
    private $by;

    /**
     * @var string
     * @ODM\Field(type="string", name="changes")
     */
    private $changes;

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime $timestamp
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return string
     */
    public function getBy()
    {
        return $this->by;
    }

    /**
     * @param string $by
     */
    public function setBy($by)
    {
        $this->by = $by;
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
     * @return array
     */
    public function toArray(){
        $data = [
            "by" => $this->getBy(),
            "changes" => $this->getChanges()

        ];

        if(!empty($this->getTimestamp())){
            $data["timestamp"] = $this->getTimestamp()->format("Y-m-d H:i:s");
        }

        return $data;
    }


}


