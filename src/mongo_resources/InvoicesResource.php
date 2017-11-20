<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 11/23/2016
 * Time: 5:20 PM
 */

namespace RemoteStaff\Mongo\Resources;


use RemoteStaff\AbstractMongoResource;
use RemoteStaff\Documents\ClientDocs;
use RemoteStaff\Documents\EmailInvoice;
use RemoteStaff\Documents\InvoiceDeliveredReporting;
use RemoteStaff\Entities\Subcontractor;
use RemoteStaff\Resources\LeadResource;
use RemoteStaff\Resources\SubcontractorResource;


use Slim\Views\PhpRenderer;
use Mailgun\Mailgun;

class InvoicesResource extends AbstractMongoResource
{

    /**
     * @param $order_id
     * @return mixed
     */
    public function getByOrderId($order_id){

        $dm = $this->getDocumentManager();

        $invoice = $dm->getRepository('RemoteStaff\Documents\EmailInvoice')->findOneBy(["accountsOrderId" => $order_id]);

        return $invoice;
    }


    /**
     * @param $order_id
     * @return mixed
     */
    public function getByOrderIdReporting($order_id){

        $dm = $this->getDocumentManager();

        $invoice = $dm->getRepository('RemoteStaff\Documents\InvoiceDeliveredReporting')->findOneBy(["orderId" => $order_id]);

        return $invoice;
    }


    /**
     * @param $order_id
     * @return mixed
     */
    public function getByOrderIdClientDocs($order_id){

        $dm = $this->getDocumentManager();

        $invoice = $dm->getRepository('RemoteStaff\Documents\ClientDocs')->findOneBy(["orderId" => $order_id]);

        return $invoice;
    }


    /**
     * @param $email
     * @return mixed
     * @throws \Exception
     */
    public function getSuppressionReportByEmails($email){

        if(!isset($email) && !$email){
            throw new \Exception("email is required!");
        }

        $dm = $this->getDocumentManager();

        $reports = $dm->getRepository('RemoteStaff\Documents\SuppressionReporting')->findBy(["email" => strtolower($email)]);

        return $reports;
    }



    public function removeSuppressionReport($email){

        //remove suppression
        $existing_reports = $this->getSuppressionReportByEmails($email);

        if($existing_reports){
            foreach ($existing_reports as $existing_report) {

                $this->getDocumentManager()->remove($existing_report);
            }
        }



    }



    /**
     * @param $request
     * @return null
     */
    public function updateInvoiceEmailDelivered($item){
        $dm = $this->getDocumentManager();

        $invoice = null;

        /**
         * @var $new_invoice EmailInvoice
         */
        if(isset($item["accounts_order_id"])){

            $invoice = $this->getByOrderId($item["accounts_order_id"]);

            /**
             * @var $existing_invoice ClientDocs
             */
            $existing_invoice = $this->getByOrderIdClientDocs($item["accounts_order_id"]);



            $this->removeSuppressionReport($item["email"]);


            if(empty($invoice)){
                $new_invoice = new EmailInvoice();

                $new_invoice->setEmailStatus("Not Opened");
                if(isset($item["email"])){
                    $new_invoice->setEmail($item["email"]);
                }


            }
            if(isset($item["couch_id"])){
                $new_invoice->setCouchId($item["couch_id"]);
            }



            $new_invoice->setStatus("delivered");

            if(isset($item["accounts_order_id"])){
                $new_invoice->setAccountsOrderId($item["accounts_order_id"]);
            }



            if(isset($item["event"])){
                $new_invoice->setEvent($item["event"]);
            }

            if(isset($item["ip"])){
                $new_invoice->setIp($item["ip"]);
            }

            if(isset($item["response"])){
                $new_invoice->setResponse($item["response"]);
            }

            if(isset($item["sg_event_id"])){
                $new_invoice->setSgEventId($item["sg_event_id"]);
            }

            if(isset($item["sg_message_id"])){
                $new_invoice->setSgMessageId($item["sg_message_id"]);
            }

            if(isset($item["smtp-id"])){
                $new_invoice->setSmtpId($item["smtp-id"]);
            }

            if(isset($item["timestamp"])){
                $new_invoice->setTimestamp($item["timestamp"]);
                $date_delivered = new \DateTime();
                $date_delivered->setTimestamp($item["timestamp"]);
                $new_invoice->setDateDelivered($date_delivered);
            }

            if(isset($item["tls"])){
                $new_invoice->setTls(intval($item["tls"]));
            }


            $new_invoice->setInvoiceDateCreated($existing_invoice->getAddedOn());

            $new_invoice->setClientFname($existing_invoice->getClientFname());
            $new_invoice->setClientLname($existing_invoice->getClientLname());
            $new_invoice->setClientId($existing_invoice->getClientId());

            $new_invoice->setDateUpdated(new \DateTime());

            $this->getDocumentManager()->persist($new_invoice);

            $this->getDocumentManager()->flush();

        }





        return $invoice;
    }


    /**
     * @param $request
     * @return null|EmailInvoice
     */
    public function updateInvoiceEmailOpened($item){

        $dm = $this->getDocumentManager();

        $invoice = null;

        /**
         * @var $invoice EmailInvoice
         */

        if(isset($item["accounts_order_id"])){

            $invoice = $this->getByOrderId($item["accounts_order_id"]);

            $existing_invoice = $this->getByOrderIdClientDocs($item["accounts_order_id"]);

            if(!empty($invoice)){
                $this->removeSuppressionReport($item["email"]);
                $invoice->setStatus("opened");
                $invoice->setDateOpened(new \DateTime());
                $invoice->setDateUpdated(new \DateTime());
                $invoice->setEmailStatus("Opened");
                $invoice->setInvoiceDateCreated($existing_invoice->getAddedOn());
                $this->getDocumentManager()->persist($invoice);
            }
        }



        $this->getDocumentManager()->flush();


        return $invoice;
    }


    /**
     * @param $request
     * @return null|EmailInvoice
     */
    public function updateInvoiceEmailClicked($item){

        $dm = $this->getDocumentManager();

        $invoice = null;

        /**
         * @var $invoice EmailInvoice
         */

        if(isset($item["accounts_order_id"])){

            $invoice = $this->getByOrderId($item["accounts_order_id"]);
            $existing_invoice = $this->getByOrderIdClientDocs($item["accounts_order_id"]);


            if(!empty($invoice)){
                $this->removeSuppressionReport($item["email"]);
                $invoice->setStatus("clicked");
                $invoice->setEmailStatus("Opened");
                $invoice->setInvoiceDateCreated($existing_invoice->getAddedOn());
                $invoice->setDateClicked(new \DateTime());
                $invoice->setDateOpened(new \DateTime());
                $invoice->setDateUpdated(new \DateTime());
                $this->getDocumentManager()->persist($invoice);
            }
        }



        $this->getDocumentManager()->flush();


        return $invoice;
    }


    public function reportDeliveredInvoicesStatus($renderer, $date_to_evaluate = ""){
        $dm = $this->getDocumentManager();
        //get Date Yesterday

        $date_yesterday_timestamp_00 = strtotime(date('Y-m-d 00:00:00',strtotime($date_to_evaluate . " -1 days")));
        $date_time_yesterday_00 = new \DateTime();
        $date_time_yesterday_00->setTimestamp($date_yesterday_timestamp_00);

        $date_yesterday_timestamp_23 = strtotime(date('Y-m-d 23:59:59',strtotime($date_to_evaluate . " -1 days")));
        $date_time_yesterday_23 = new \DateTime();
        $date_time_yesterday_23->setTimestamp($date_yesterday_timestamp_23);


        $date_today = new \DateTime();

        if($date_to_evaluate != ""){
            $date_today->setTimestamp(strtotime($date_to_evaluate));
        }

        //Fetch Invoices delivered yesterday
        $qb = $dm->createQueryBuilder('RemoteStaff\Documents\EmailInvoice');
        $qb->field("dateDelivered")->gte($date_time_yesterday_00);
        $qb->field("dateDelivered")->lte($date_time_yesterday_23);
        $qb->sort('dateUpdated', 'asc');
        $query = $qb->getQuery();

        $delivered_invoices = $query->execute();


        if(!empty($delivered_invoices)){
            foreach ($delivered_invoices as $delivered_invoice) {
                /**
                 * @var $delivered_invoice EmailInvoice
                 */
                $current_age_in_days = 0;
//                $interval = $date_today->diff($delivered_invoice->getDateDelivered());
//                $current_age_in_days = intval($interval->format('%d'));

                //Fetch Order_id details from prod.client_docs
                /**
                 * @var $client_docs_order ClientDocs
                 */
                $client_docs_order = $this->getByOrderIdClientDocs($delivered_invoice->getAccountsOrderId());


                //Save to invoice.invoice_delivered_reporting
                $existing_reporting_entry = $this->getByOrderIdReporting($delivered_invoice->getAccountsOrderId());

                $new_reporting_entry = new InvoiceDeliveredReporting();


                $new_reporting_entry->setDateDelivered($delivered_invoice->getDateDelivered());
                if(!empty($delivered_invoice->getDateOpened())){
                    $new_reporting_entry->setDateOpened($delivered_invoice->getDateOpened());
                }
                if(!empty($delivered_invoice->getDateClicked())){
                    $new_reporting_entry->setDateClicked($delivered_invoice->getDateClicked());
                }

                $new_reporting_entry->setAddedBy($client_docs_order->getAddedBy());
                $new_reporting_entry->setAgeInDays($current_age_in_days);
                $new_reporting_entry->setClientFname($client_docs_order->getClientFname());
                $new_reporting_entry->setClientLname($client_docs_order->getClientLname());


                $new_reporting_entry->setInvoiceDateCreated($client_docs_order->getAddedOn());
                $new_reporting_entry->setOrderId($delivered_invoice->getAccountsOrderId());

                if(!empty($existing_reporting_entry)){
                    $new_reporting_entry = $existing_reporting_entry;
                }


                $email_status = "Not Opened";

                if($delivered_invoice->getStatus() != "delivered"){
                    $email_status = "Opened";
                }

                $new_reporting_entry->setEmailStatus($email_status);

                $this->getDocumentManager()->persist($new_reporting_entry);


            }
            $this->getDocumentManager()->flush();
        }

        //Compute Age date_delivered of invoices with age less than 2 in invoice.invoice_delivered_reporting
        $qb = $dm->createQueryBuilder('RemoteStaff\Documents\InvoiceDeliveredReporting');
        $qb->field("ageInDays")->lt(2);
        $query = $qb->getQuery();

        $less_than_two_days_invoices = $query->execute();

        foreach ($less_than_two_days_invoices as $less_than_two_days_invoice) {
            /**
             * @var $less_than_two_days_invoice InvoiceDeliveredReporting
             */
            $current_age_in_days = 0;
            $interval = $date_today->diff($less_than_two_days_invoice->getDateDelivered());
            $current_age_in_days = intval($interval->format('%d'));

            $less_than_two_days_invoice->setAgeInDays($current_age_in_days);

            $this->getDocumentManager()->persist($less_than_two_days_invoice);
        }
        $this->getDocumentManager()->flush();



        //Collect Invoices that are at least 2 days old
        $qb = $dm->createQueryBuilder('RemoteStaff\Documents\InvoiceDeliveredReporting');
        $qb->field("ageInDays")->gte(2);
        $qb->sort('dateDelivered', 'desc');
        $query = $qb->getQuery();

        $invoices_to_report = $query->execute();

        $collected_invoices = [];

        foreach ($invoices_to_report as $invoice_to_report) {
            /**
             * @var $invoice_to_report InvoiceDeliveredReporting
             */
            $collected_invoices[] = $invoice_to_report->toArray();
        }


        //Send an email from collected invoice

        $settings = require BASE_DIR . '/../src/settings.php';

        $site = "";
        if (TEST) {
            $site = "devs.remotestaff.com.au";
        } else if (STAGING) {
            $site = "staging.remotestaff.com.au";

        } else {

            $site = "remotestaff.com.au";
        }

        $mgClient = new Mailgun($settings["settings"]["mailgun"]["api_key"]);
        $domain = $settings["settings"]["mailgun"]["domain"];

        $bodyText_ref = $renderer->fetch('emails/invoice_delivered_report.phtml', [
            "collected_invoices"=>$collected_invoices,
            "site" => $site,
            "date_today" => $date_today->format("M d, Y")
        ]);

        $to_array_ref = [];
        $bcc_array_ref = [];
        $cc_array_ref = [];
        $subject_ref = "Invoice Email Reporting " . $date_today->format("M d, Y");

        $from = "noreply@remotestaff.com.au";

        if (in_array($settings["settings"]["env"], ["dev", "staging"])){
            $to_array_ref = array('devs@remotestaff.com.au');

        }else{
            $bcc_array_ref[] = 'devs@remotestaff.com.au';
            $to_array_ref = array('chrisj@remotestaff.com.au', "accounts@remotestaff.com.au", "lance@remotestaff.com.au", "edward@remotestaff.com.au");

        }



        $mgResult = $mgClient->sendMessage($domain, array(
            'from'    => $from,
            'to'      => $to_array_ref,
            'subject' => $subject_ref,
            'html'    => $bodyText_ref,
            'bcc'     => $bcc_array_ref,
            'cc'      => $cc_array_ref,
        ));
    }






}