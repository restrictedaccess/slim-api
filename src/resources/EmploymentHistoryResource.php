<?php

/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/22/2016
 * Time: 1:40 PM
 */
namespace RemoteStaff\Resources;

use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\EmployeeCurrentProfile;
use RemoteStaff\Entities\Industry;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\PreviousJobIndustry;

class EmploymentHistoryResource extends AbstractResource
{
    public function create($params)
    {
        /**
         * @var Personal $candidate
         */
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["id"]);
        /**
         * @var EmployeeCurrentProfile $candidateSource
         */
        $candidateSource = $candidate->getEmployeeCurrentProfile();


        if (count($candidateSource) > 0) {
            // Update existing CurrentJob

            $candidateSource->setCandidate($candidate);

            if ($params["employmentHistory"][0]["companyName"] != "" || isset($params["employmentHistory"][0]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][0]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][0]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName($params["employmentHistory"][0]["companyName"]);
                $candidateSource->setPosition($params["employmentHistory"][0]["position"]);
                $candidateSource->setDuties($params["employmentHistory"][0]["duties"]);
                $candidateSource->setMonthFrom($monthFrom);
                $candidateSource->setYearFrom($yearFrom);
                $candidateSource->setMonthTo($monthTo);
                $candidateSource->setYearTo($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][0]["industryId"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(1);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][1]["companyName"] != "" || isset($params["employmentHistory"][1]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][1]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][1]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName2($params["employmentHistory"][1]["companyName"]);
                $candidateSource->setPosition2($params["employmentHistory"][1]["position"]);
                $candidateSource->setDuties2($params["employmentHistory"][1]["duties"]);
                $candidateSource->setMonthFrom2($monthFrom);
                $candidateSource->setYearFrom2($yearFrom);
                $candidateSource->setMonthTo2($monthTo);
                $candidateSource->setYearTo2($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][1]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(2);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][2]["companyName"] != "" || isset($params["employmentHistory"][2]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][2]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][2]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName3($params["employmentHistory"][2]["companyName"]);
                $candidateSource->setPosition3($params["employmentHistory"][2]["position"]);
                $candidateSource->setDuties3($params["employmentHistory"][2]["duties"]);
                $candidateSource->setMonthFrom3($monthFrom);
                $candidateSource->setYearFrom3($yearFrom);
                $candidateSource->setMonthTo3($monthTo);
                $candidateSource->setYearTo3($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][2]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(3);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][3]["companyName"] != "" || isset($params["employmentHistory"][3]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][3]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][3]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName4($params["employmentHistory"][3]["companyName"]);
                $candidateSource->setPosition4($params["employmentHistory"][3]["position"]);
                $candidateSource->setDuties4($params["employmentHistory"][3]["duties"]);
                $candidateSource->setMonthFrom4($monthFrom);
                $candidateSource->setYearFrom4($yearFrom);
                $candidateSource->setMonthTo4($monthTo);
                $candidateSource->setYearTo4($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][3]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(4);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][4]["companyName"] != "" || isset($params["employmentHistory"][4]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][4]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][4]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName5($params["employmentHistory"][4]["companyName"]);
                $candidateSource->setPosition5($params["employmentHistory"][4]["position"]);
                $candidateSource->setDuties5($params["employmentHistory"][4]["duties"]);
                $candidateSource->setMonthFrom5($monthFrom);
                $candidateSource->setYearFrom5($yearFrom);
                $candidateSource->setMonthTo5($monthTo);
                $candidateSource->setYearTo5($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][4]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(5);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][5]["companyName"] != "" || isset($params["employmentHistory"][5]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][5]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][5]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName6($params["employmentHistory"][5]["companyName"]);
                $candidateSource->setPosition6($params["employmentHistory"][5]["position"]);
                $candidateSource->setDuties6($params["employmentHistory"][5]["duties"]);
                $candidateSource->setMonthFrom6($monthFrom);
                $candidateSource->setYearFrom6($yearFrom);
                $candidateSource->setMonthTo6($monthTo);
                $candidateSource->setYearTo6($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][5]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(6);
                $previousIndustry->setDateCreated(new \DateTime());

            }

            if ($params["employmentHistory"][6]["companyName"] != "" || isset($params["employmentHistory"][6]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][6]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][6]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName7($params["employmentHistory"][6]["companyName"]);
                $candidateSource->setPosition7($params["employmentHistory"][6]["position"]);
                $candidateSource->setDuties7($params["employmentHistory"][6]["duties"]);
                $candidateSource->setMonthFrom7($monthFrom);
                $candidateSource->setYearFrom7($yearFrom);
                $candidateSource->setMonthTo7($monthTo);
                $candidateSource->setYearTo7($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][6]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(7);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][7]["companyName"] != "" || isset($params["employmentHistory"][7]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][7]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][7]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName8($params["employmentHistory"][7]["companyName"]);
                $candidateSource->setPosition8($params["employmentHistory"][7]["position"]);
                $candidateSource->setDuties8($params["employmentHistory"][7]["duties"]);
                $candidateSource->setMonthFrom8($monthFrom);
                $candidateSource->setYearFrom8($yearFrom);
                $candidateSource->setMonthTo8($monthTo);
                $candidateSource->setYearTo8($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][7]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(8);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][8]["companyName"] != "" || isset($params["employmentHistory"][8]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][8]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][8]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName9($params["employmentHistory"][8]["companyName"]);
                $candidateSource->setPosition9($params["employmentHistory"][8]["position"]);
                $candidateSource->setDuties9($params["employmentHistory"][8]["duties"]);
                $candidateSource->setMonthFrom9($monthFrom);
                $candidateSource->setYearFrom9($yearFrom);
                $candidateSource->setMonthTo9($monthTo);
                $candidateSource->setYearTo9($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][8]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(9);
                $previousIndustry->setDateCreated(new \DateTime());
            }

            if ($params["employmentHistory"][9]["companyName"] != "" || isset($params["employmentHistory"][9]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][9]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][9]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $candidateSource->setCompanyName10($params["employmentHistory"][9]["companyName"]);
                $candidateSource->setPosition10($params["employmentHistory"][9]["position"]);
                $candidateSource->setDuties10($params["employmentHistory"][9]["duties"]);
                $candidateSource->setMonthFrom10($monthFrom);
                $candidateSource->setYearFrom10($yearFrom);
                $candidateSource->setMonthTo10($monthTo);
                $candidateSource->setYearTo10($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][9]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(10);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            $this->getEntityManager()->persist($candidateSource);
            $this->getEntityManager()->flush();


        } else {
            // Add new record in currentJob
            echo "Saving employment history";
            $this->addEmploymentHistory($params, "ADD");

        }


    }

    public function getEmploymentHistory($params)
    {
        $currentJobArr = [];
        /**
         * @var Personal $candidate
         */
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["candidate"]["id"]);
        /**
         * @var EmployeeCurrentProfile $currentJob
         */
        $currentJob = $candidate->getEmployeeCurrentProfile();


        if (count($currentJob) != 0) {

            if ($currentJob->getCompanyName() != "" || $currentJob->getCompanyName() != NULL) {
                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[0])){
                        $industry = $previousJobIndustry[0]->getIndustry();
                    }
                }
                $current_data = [
                    "companyName" => $currentJob->getCompanyName(),
                    "position" => $currentJob->getPosition(),
                    "duties" => $currentJob->getDuties(),
                    "monthFrom" => $currentJob->getMonthFrom(),
                    "yearFrom" => $currentJob->getYearFrom(),
                    "monthTo" => $currentJob->getMonthTo(),
                    "yearTo" => $currentJob->getYearTo(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }



                $currentJobArr[] = $current_data;
            }
            if ($currentJob->getCompanyName2() != "" || $currentJob->getCompanyName2() != NULL) {

                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[1])){
                        $industry = $previousJobIndustry[1]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName2(),
                    "position" => $currentJob->getPosition2(),
                    "duties" => $currentJob->getDuties2(),
                    "monthFrom" => $currentJob->getMonthFrom2(),
                    "yearFrom" => $currentJob->getYearFrom2(),
                    "monthTo" => $currentJob->getMonthTo2(),
                    "yearTo" => $currentJob->getMonthTo2(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }



                $currentJobArr[] = $current_data;

            }
            if ($currentJob->getCompanyName3() != "" || $currentJob->getCompanyName3() != NULL) {
                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[2])){
                        $industry = $previousJobIndustry[2]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName3(),
                    "position" => $currentJob->getPosition3(),
                    "duties" => $currentJob->getDuties3(),
                    "monthFrom" => $currentJob->getMonthFrom3(),
                    "yearFrom" => $currentJob->getYearFrom3(),
                    "monthTo" => $currentJob->getMonthTo3(),
                    "yearTo" => $currentJob->getMonthTo3(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }



                $currentJobArr[] = $current_data;

            }
            if ($currentJob->getCompanyName4() != "" || $currentJob->getCompanyName4() != NULL) {

                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[3])){
                        $industry = $previousJobIndustry[3]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName4(),
                    "position" => $currentJob->getPosition4(),
                    "duties" => $currentJob->getDuties4(),
                    "monthFrom" => $currentJob->getMonthFrom4(),
                    "yearFrom" => $currentJob->getYearFrom4(),
                    "monthTo" => $currentJob->getMonthTo4(),
                    "yearTo" => $currentJob->getMonthTo4(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }



                $currentJobArr[] = $current_data;

            }
            if ($currentJob->getCompanyName5() != "" || $currentJob->getCompanyName5() != NULL) {
                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[4])){
                        $industry = $previousJobIndustry[4]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName5(),
                    "position" => $currentJob->getPosition5(),
                    "duties" => $currentJob->getDuties5(),
                    "monthFrom" => $currentJob->getMonthFrom5(),
                    "yearFrom" => $currentJob->getYearFrom5(),
                    "monthTo" => $currentJob->getMonthTo5(),
                    "yearTo" => $currentJob->getMonthTo5(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }



                $currentJobArr[] = $current_data;


            }
            if ($currentJob->getCompanyName6() != "" || $currentJob->getCompanyName6() != NULL) {

                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[5])){
                        $industry = $previousJobIndustry[5]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName6(),
                    "position" => $currentJob->getPosition6(),
                    "duties" => $currentJob->getDuties6(),
                    "monthFrom" => $currentJob->getMonthFrom6(),
                    "yearFrom" => $currentJob->getYearFrom6(),
                    "monthTo" => $currentJob->getMonthTo6(),
                    "yearTo" => $currentJob->getMonthTo6(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }


                $currentJobArr[] = $current_data;

            }
            if ($currentJob->getCompanyName7() != "" || $currentJob->getCompanyName7() != NULL) {

                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[6])){
                        $industry = $previousJobIndustry[6]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName7(),
                    "position" => $currentJob->getPosition7(),
                    "duties" => $currentJob->getDuties7(),
                    "monthFrom" => $currentJob->getMonthFrom7(),
                    "yearFrom" => $currentJob->getYearFrom7(),
                    "monthTo" => $currentJob->getMonthTo7(),
                    "yearTo" => $currentJob->getMonthTo7(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }


                $currentJobArr[] = $current_data;


            }
            if ($currentJob->getCompanyName8() != "" || $currentJob->getCompanyName8() != NULL) {

                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[7])){
                        $industry = $previousJobIndustry[7]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName8(),
                    "position" => $currentJob->getPosition8(),
                    "duties" => $currentJob->getDuties8(),
                    "monthFrom" => $currentJob->getMonthFrom8(),
                    "yearFrom" => $currentJob->getYearFrom8(),
                    "monthTo" => $currentJob->getMonthTo8(),
                    "yearTo" => $currentJob->getMonthTo8(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }


                $currentJobArr[] = $current_data;

            }
            if ($currentJob->getCompanyName9() != "" || $currentJob->getCompanyName9() != NULL) {

                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[8])){
                        $industry = $previousJobIndustry[8]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName9(),
                    "position" => $currentJob->getPosition9(),
                    "duties" => $currentJob->getDuties9(),
                    "monthFrom" => $currentJob->getMonthFrom9(),
                    "yearFrom" => $currentJob->getYearFrom9(),
                    "monthTo" => $currentJob->getMonthTo9(),
                    "yearTo" => $currentJob->getMonthTo9(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }


                $currentJobArr[] = $current_data;

            }
            if ($currentJob->getCompanyName10() != "" || $currentJob->getCompanyName10() != NULL) {

                /**
                 * @var Industry $industry
                 */
                $industry = null;
                /**
                 * @var PreviousJobIndustry $previousJobIndustry
                 */
                $previousJobIndustry = $candidate->getPreviousJobIndustry();
                if(!empty($previousJobIndustry)){
                    if(isset($previousJobIndustry[9])){
                        $industry = $previousJobIndustry[9]->getIndustry();
                    }
                }

                $current_data = [
                    "companyName" => $currentJob->getCompanyName10(),
                    "position" => $currentJob->getPosition10(),
                    "duties" => $currentJob->getDuties10(),
                    "monthFrom" => $currentJob->getMonthFrom10(),
                    "yearFrom" => $currentJob->getYearFrom10(),
                    "monthTo" => $currentJob->getMonthTo10(),
                    "yearTo" => $currentJob->getMonthTo10(),
                ];


                if(!empty($industry)){

                    $current_data["industry"] = $industry->getValue();
                    $current_data["industry_id"] = $industry->getId();
                }


                $currentJobArr[] = $current_data;

            }

        }

        return $currentJobArr;
    }


    public function addEmploymentHistory($params, $method)
    {
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["id"]);

        if ($method == "ADD") {
            $addEmploymentHistory = new EmployeeCurrentProfile();

            /*
             * There are pre-defined 10 Jobs Limit, this is the adding of
             * all 10 Job History
             */

            $addEmploymentHistory->setCandidate($candidate);

            if ($params["employmentHistory"][0]["companyName"] != "" || isset($params["employmentHistory"][0]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][0]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][0]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName($params["employmentHistory"][0]["companyName"]);
                $addEmploymentHistory->setPosition($params["employmentHistory"][0]["position"]);
                $addEmploymentHistory->setDuties($params["employmentHistory"][0]["duties"]);
                $addEmploymentHistory->setMonthFrom($monthFrom);
                $addEmploymentHistory->setYearFrom($yearFrom);
                $addEmploymentHistory->setMonthTo($monthTo);
                $addEmploymentHistory->setYearTo($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][0]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(1);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            if ($params["employmentHistory"][1]["companyName"] != "" || isset($params["employmentHistory"][1]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][1]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][1]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName2($params["employmentHistory"][1]["companyName"]);
                $addEmploymentHistory->setPosition2($params["employmentHistory"][1]["position"]);
                $addEmploymentHistory->setDuties2($params["employmentHistory"][1]["duties"]);
                $addEmploymentHistory->setMonthFrom2($monthFrom);
                $addEmploymentHistory->setYearFrom2($yearFrom);
                $addEmploymentHistory->setMonthTo2($monthTo);
                $addEmploymentHistory->setYearTo2($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][1]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(2);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            if ($params["employmentHistory"][2]["companyName"] != "" || isset($params["employmentHistory"][2]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][2]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][2]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName3($params["employmentHistory"][2]["companyName"]);
                $addEmploymentHistory->setPosition3($params["employmentHistory"][2]["position"]);
                $addEmploymentHistory->setDuties3($params["employmentHistory"][2]["duties"]);
                $addEmploymentHistory->setMonthFrom3($monthFrom);
                $addEmploymentHistory->setYearFrom3($yearFrom);
                $addEmploymentHistory->setMonthTo3($monthTo);
                $addEmploymentHistory->setYearTo3($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][2]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(3);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            if ($params["employmentHistory"][3]["companyName"] != "" || isset($params["employmentHistory"][3]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][3]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][3]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName4($params["employmentHistory"][3]["companyName"]);
                $addEmploymentHistory->setPosition4($params["employmentHistory"][3]["position"]);
                $addEmploymentHistory->setDuties4($params["employmentHistory"][3]["duties"]);
                $addEmploymentHistory->setMonthFrom4($monthFrom);
                $addEmploymentHistory->setYearFrom4($yearFrom);
                $addEmploymentHistory->setMonthTo4($monthTo);
                $addEmploymentHistory->setYearTo4($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][3]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(4);
                $previousIndustry->setDateCreated(new \DateTime());

            }

            if ($params["employmentHistory"][4]["companyName"] != "" || isset($params["employmentHistory"][4]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][4]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][4]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName5($params["employmentHistory"][4]["companyName"]);
                $addEmploymentHistory->setPosition5($params["employmentHistory"][4]["position"]);
                $addEmploymentHistory->setDuties5($params["employmentHistory"][4]["duties"]);
                $addEmploymentHistory->setMonthFrom5($monthFrom);
                $addEmploymentHistory->setYearFrom5($yearFrom);
                $addEmploymentHistory->setMonthTo5($monthTo);
                $addEmploymentHistory->setYearTo5($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][4]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(5);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            if ($params["employmentHistory"][5]["companyName"] != "" || isset($params["employmentHistory"][5]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][5]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][5]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName6($params["employmentHistory"][5]["companyName"]);
                $addEmploymentHistory->setPosition6($params["employmentHistory"][5]["position"]);
                $addEmploymentHistory->setDuties6($params["employmentHistory"][5]["duties"]);
                $addEmploymentHistory->setMonthFrom6($monthFrom);
                $addEmploymentHistory->setYearFrom6($yearFrom);
                $addEmploymentHistory->setMonthTo6($monthTo);
                $addEmploymentHistory->setYearTo6($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][5]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(6);
                $previousIndustry->setDateCreated(new \DateTime());

            }

            if ($params["employmentHistory"][6]["companyName"] != "" || isset($params["employmentHistory"][6]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][6]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][6]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName7($params["employmentHistory"][6]["companyName"]);
                $addEmploymentHistory->setPosition7($params["employmentHistory"][6]["position"]);
                $addEmploymentHistory->setDuties7($params["employmentHistory"][6]["duties"]);
                $addEmploymentHistory->setMonthFrom7($monthFrom);
                $addEmploymentHistory->setYearFrom7($yearFrom);
                $addEmploymentHistory->setMonthTo7($monthTo);
                $addEmploymentHistory->setYearTo7($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][6]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(7);
                $previousIndustry->setDateCreated(new \DateTime());

            }

            if ($params["employmentHistory"][7]["companyName"] != "" || isset($params["employmentHistory"][7]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][7]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][7]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName8($params["employmentHistory"][7]["companyName"]);
                $addEmploymentHistory->setPosition8($params["employmentHistory"][7]["position"]);
                $addEmploymentHistory->setDuties8($params["employmentHistory"][7]["duties"]);
                $addEmploymentHistory->setMonthFrom8($monthFrom);
                $addEmploymentHistory->setYearFrom8($yearFrom);
                $addEmploymentHistory->setMonthTo8($monthTo);
                $addEmploymentHistory->setYearTo8($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][7]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(8);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            if ($params["employmentHistory"][8]["companyName"] != "" || isset($params["employmentHistory"][8]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][8]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][8]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName9($params["employmentHistory"][8]["companyName"]);
                $addEmploymentHistory->setPosition9($params["employmentHistory"][8]["position"]);
                $addEmploymentHistory->setDuties9($params["employmentHistory"][8]["duties"]);
                $addEmploymentHistory->setMonthFrom9($monthFrom);
                $addEmploymentHistory->setYearFrom9($yearFrom);
                $addEmploymentHistory->setMonthTo9($monthTo);
                $addEmploymentHistory->setYearTo9($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][8]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(9);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            if ($params["employmentHistory"][9]["companyName"] != "" || isset($params["employmentHistory"][9]["companyName"])) {
                $timeFrom = strtotime($params["employmentHistory"][9]["periodFrom"]);
                $monthFrom = date("F", $timeFrom);
                $yearFrom = date("Y", $timeFrom);
                $timeTo = strtotime($params["employmentHistory"][9]["periodTo"]);
                $monthTo = date("F", $timeTo);
                $yearTo = date("Y", $timeTo);
                $addEmploymentHistory->setCompanyName10($params["employmentHistory"][9]["companyName"]);
                $addEmploymentHistory->setPosition10($params["employmentHistory"][9]["position"]);
                $addEmploymentHistory->setDuties10($params["employmentHistory"][9]["duties"]);
                $addEmploymentHistory->setMonthFrom10($monthFrom);
                $addEmploymentHistory->setYearFrom10($yearFrom);
                $addEmploymentHistory->setMonthTo10($monthTo);
                $addEmploymentHistory->setYearTo10($yearTo);

                /**
                 * @var Industry $industry
                 */
                $industry = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Industry')->find($params["employmentHistory"][9]["industry"]);

                $previousIndustry = new PreviousJobIndustry();
                $previousIndustry->setIndustry($industry);
                $previousIndustry->setCandidate($candidate);
                $previousIndustry->setIndex(10);
                $previousIndustry->setDateCreated(new \DateTime());


            }

            $this->getEntityManager()->persist($addEmploymentHistory);
            $this->getEntityManager()->persist($previousIndustry);
            $this->getEntityManager()->flush();


        }


    }

}