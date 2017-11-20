<?php

/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/7/2016
 * Time: 4:38 PM
 */
namespace RemoteStaff\Resources;

use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\StaffTimezone;
use RemoteStaff\Entities\EmployeeCurrentProfile;
use RemoteStaff\Entities\StaffRate;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Entities\Personal;

class AvailabilityResource extends AbstractResource
{
    public function create($params)
    {
        // Delete existing record
//        $deleteCurrentJob = $this->getEntityManager()->getRepository('RemoteStaff\Entities\EmployeeCurrentProfile')->findOneBy(array("userid" => $params["staffTimezone"]["candidate"]["id"] ));
//        if($deleteCurrentJob) {
//            $this->getEntityManager()->remove($deleteCurrentJob);
//            $this->getEntityManager()->flush();
//            echo "deleted";
//        }


        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["staffTimezone"]["candidate"]["id"]);
        $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($params["admin"]["id"]);

        $fullTimeRate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Product')->find($params["staffRate"]["fullTimePrice"]["id"]);
        $partTimeRate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Product')->find($params["staffRate"]["partTimePrice"]["id"]);


        $staffTimezone = new StaffTimezone();
        $staffTimezone->setCandidate($candidate);
        $staffTimezone->setFullTimeTimezone($params["staffTimezone"]["timezone"]);
        $staffTimezone->setPartTimeTimezone($params["staffTimezone"]["p_timezone"]);

        $currentJob = new EmployeeCurrentProfile();
        $currentJob->setCandidate($candidate);
        $currentJob->setAvailableStatus($params["currentJob"]["availableStatus"]);
        if ($params["currentJob"]["availableNotice"]) {
            $currentJob->setAvailableNotice($params["currentJob"]["availableNotice"]);
        }
        if ($params["currentJob"]["aday"] || $params["currentJob"]["amonth"]) {
            $currentJob->setADay($params["currentJob"]["aday"]);
            $currentJob->setAMonth($params["currentJob"]["amonth"]);
            $currentJob->setAYear($params["currentJob"]["ayear"]);
        }

        if($params["staffTimezone"]["timezone"]){
            $staffHistory1 = $this->createStaffHistory($candidate, $admin, "Updated <font color=#FF0000>Full Time</font> timezone availability ".$params["staffTimezone"]["timezone"]);
            $this->getEntityManager()->persist($staffHistory1);
        }

        if($params["staffTimezone"]["p_timezone"]){
            $staffHistory2 = $this->createStaffHistory($candidate, $admin, "Updated <font color=#FF0000>Part Time</font> timezone availability ".$params["staffTimezone"]["p_timezone"]);
            $this->getEntityManager()->persist($staffHistory2);
        }

        if($params["staffRate"]["full_time_product"]["id"]){
            $staffHistory3 = $this->createStaffHistory($candidate, $admin, "Added Full Time Staff Rate <font color=#FF0000>.".$fullTimeRate->getCode().".</font>");
            $this->getEntityManager()->persist($staffHistory3);
        }

        if($params["staffRate"]["part_time_product"]["id"]){
            $staffHistory4 = $this->createStaffHistory($candidate, $admin, "Added Part Time Staff Rate <font color=#FF0000>.".$partTimeRate->getCode().".</font>");
            $this->getEntityManager()->persist($staffHistory4);
        }


        $staffRate = new StaffRate();
        $staffRate->setCandidate($candidate);
        $staffRate->setAdminInformation($admin);
        $staffRate->setFullTimeRate($fullTimeRate);
        $staffRate->setPartFullTimeRate($partTimeRate);

        $this->getEntityManager()->persist($staffTimezone);
        $this->getEntityManager()->persist($currentJob);
        $this->getEntityManager()->persist($staffRate);

        $this->getEntityManager()->flush();

        return $staffTimezone;
    }

    public function getEvaluation($params)
    {
        /**
         * @var Personal $candidate
         */
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params['candidate']);
        /**
         * @var StaffTimezone $staffTimezone
         */
        $staffTimezone = $candidate->getStaffTimezone();

        /**
         * @var EmployeeCurrentProfile $currentJob
         */
        $currentJob = $candidate->getEmployeeCurrentProfile();

        return [
            "fulltime" => $staffTimezone->getFullTimeTimezone(),
            "parttime" => $staffTimezone->getPartTimeTimezone(),
            "availabilityStatus" => $currentJob->getAvailableStatus(),
            "availabilityNotice" => $currentJob->getAvailableNotice(),
            "aday" => $currentJob->getADay(),
            "amonth" => $currentJob->getAMonth(),
            "ayear" => $currentJob->getAYear()
        ];
    }

    private function convertArrayStafffTimezone(StaffTimezone $params){

        return [
            "id"=>$params->get(),
            "userid"=>$params->getUserid(),
            "fulltime_timezone"=>$params->getFullTimeTimezone(),
            "parttime_timezone"=>$params->getPartTimeTimezone(),
        ];
    }

    /**
     * Create Staff History for created Resume
     * @param Personal $candidate
     * @param Admin $recruiter
     * @return StaffHistory
     */
    public function createStaffHistory(Personal $candidate, Admin $recruiter, $historyChanges)
    {
        $credential = $recruiter->getStatus();
        if($credential){
            if ($credential == "FULL-CONTROL") {
                $credential = "ADMIN";
            }
        } else {
            $credential = "HR";
        }

        $staffHistory = new StaffHistory();
        $staffHistory->setCandidate($candidate);
        $staffHistory->setChangedBy($recruiter);
        $staffHistory->setChanges($historyChanges);
        $staffHistory->setType($credential);
        $staffHistory->setDateCreated(new \DateTime());
        return $staffHistory;
    }
}