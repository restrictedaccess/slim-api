<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/27/2016
 * Time: 10:04 AM
 */

namespace RemoteStaff\Mongo\Resources;


use RemoteStaff\AbstractMongoResource;
use RemoteStaff\Documents\CTATracker;

class CTATrackerResource extends AbstractMongoResource
{

    public function save($data){
        if(!isset($data["cta_tracker_cookie_value"])){
            throw new \Exception("cta_tracker_cookie_value is required!");
        }

        if(!isset($data["dom_id"])){
            throw new \Exception("dom_id is required!");
        }

        if(!isset($data["current_url"])){
            throw new \Exception("current_url is required!");
        }

        if(!isset($data["device"])){
            throw new \Exception("device is required!");
        }

        if(!isset($data["browser_version"])){
            throw new \Exception("browser_version is required!");
        }


        $result = [
            "success" => false,
            "result" => []
        ];


        $new_cta_tracker = new CTATracker();

        $new_cta_tracker->setDateCreated(new \DateTime());
        $new_cta_tracker->setCookieValue($data["cta_tracker_cookie_value"]);
        $new_cta_tracker->setDomId($data["dom_id"]);
        $new_cta_tracker->setLink($data["current_url"]);
        $new_cta_tracker->setDevice($data["device"]);
        $new_cta_tracker->setBrowserVersion($data["browser_version"]);
        $new_cta_tracker->setIpAddress($this->get_client_ip());

        $this->getDocumentManager()->persist($new_cta_tracker);
        $this->getDocumentManager()->flush();

        $result["success"] = true;
        $result["result"] = $new_cta_tracker->toArray();


        return $result;
    }

    // Function to get the client IP address
    public function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}