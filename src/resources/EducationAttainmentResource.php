<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 9:57 AM
 */

namespace RemoteStaff\Resources;


use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Education;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Exceptions\NoUpdatesWereMadeException;

class EducationAttainmentResource extends AbstractResource
{

    /**
     * @param Personal $candidate
     * @param Admin $recruiter
     * @param $request
     * @throws NoUpdatesWereMadeException
     */
    public function updatedEducationAttainment(Personal $candidate, Admin $recruiter, $request){

        if(empty($request)){
            throw new NoUpdatesWereMadeException();
        }

        if(empty($candidate->getEducation())){
            $new_education = new Education();
            $candidate->setEducation($new_education);
        }

        $candidate_education = $candidate->getEducation();

        $old_record = [
            "educationallevel" => $candidate_education->getEducationalLevel(),
            "fieldstudy" => $candidate_education->getFieldStudy(),
            "major" => $candidate_education->getMajor(),
            "college_name" => $candidate_education->getCollegeName(),
            "college_country" => $candidate_education->getCollegeCountry(),
            "graduate_year" => $candidate_education->getGraduateYear(),
            "graduate_month" => $candidate_education->getGraduateMonth(),
            "trainings_seminars" => $candidate_education->getTrainingsSeminar(),
            "licence_certification" => $candidate_education->getLicenceCertification()
        ];


        $candidate_education->setCandidate($candidate);
        $candidate_education->setGrade("Grade Point Average (GPA)");
        $candidate_education->setGPAScore(0);
        $updates_were_made = false;

        $fields_updated = [];
        if(!empty($request["educationallevel"]) && isset($request["educationallevel"])){
            if($request["educationallevel"] !== $candidate_education->getEducationalLevel()){
                $candidate_education->setEducationalLevel($request["educationallevel"]);
                $updates_were_made = true;
                $fields_updated[] = "educationallevel";
            }
        }


        if(!empty($request["fieldstudy"]) && isset($request["fieldstudy"])){

            if($request["fieldstudy"] !== $candidate_education->getFieldStudy()){
                $candidate_education->setFieldStudy($request["fieldstudy"]);
                $updates_were_made = true;
                $fields_updated[] = "fieldstudy";
            }
        }

        if(!empty($request["major"]) && isset($request["major"])){
            if($request["major"] !== $candidate_education->getMajor()){
                $candidate_education->setMajor($request["major"]);
                $updates_were_made = true;
                $fields_updated[] = "major";
            }
        }

        if(!empty($request["college_name"]) && isset($request["college_name"])){
            if($request["college_name"] !== $candidate_education->getCollegeName()){
                $candidate_education->setCollegeName($request["college_name"]);
                $updates_were_made = true;
                $fields_updated[] = "college_name";
            }
        }

        if(!empty($request["college_country"]) && isset($request["college_country"])){
            if($request["college_country"] !== $candidate_education->getCollegeCountry()){
                $candidate_education->setCollegeCountry($request["college_country"]);
                $updates_were_made = true;
                $fields_updated[] = "college_country";
            }
        }


        if(!empty($request["trainings_seminars"]) && isset($request["trainings_seminars"])){
            if($request["trainings_seminars"] !== $candidate_education->getTrainingsSeminar()){
                $candidate_education->setTrainingsSeminar($request["trainings_seminars"]);
                $updates_were_made = true;
                $fields_updated[] = "trainings_seminars";
            }
        }

        if(!empty($request["graduate_year"]) && isset($request["graduate_year"])){
            if($request["graduate_year"] != $candidate_education->getGraduateYear()){
                $candidate_education->setGraduateYear($request["graduate_year"]);
                $updates_were_made = true;
                $fields_updated[] = "graduate_year";
            }
        }

        if(!empty($request["graduate_month"]) && isset($request["graduate_month"])){
            if($request["graduate_month"] != $candidate_education->getGraduateMonth()){
                $candidate_education->setGraduateMonth($request["graduate_month"]);
                $updates_were_made = true;
                $fields_updated[] = "graduate_month";
            }
        }

        if(!empty($request["licence_certification"]) && isset($request["licence_certification"])){
            if($request["licence_certification"] !== $candidate_education->getLicenceCertification()){
                $candidate_education->setLicenceCertification($request["licence_certification"]);
                $updates_were_made = true;
                $fields_updated[] = "licence_certification";
            }
        }


        if($updates_were_made){
            $candidate->setEducation($candidate_education);

            $this->getEntityManager()->persist($candidate_education);

            $candidate->setDateUpdated(new \DateTime());


            $difference = array_diff_assoc($old_record,$request);

            $history_changes = "";
            if( count($difference) > 0) {
                foreach (array_keys($difference) as $array_key) {
                    if(isset($request[$array_key])){
                        $history_changes .= sprintf("[%s] from %s to %s,\n", $array_key, $old_record[$array_key], $request[$array_key]);
                    }
                }
            }


            $this->createStaffHistory($candidate, $recruiter, $history_changes);


            $this->getEntityManager()->persist($candidate);

            $this->getEntityManager()->flush();
        } else{
            throw new NoUpdatesWereMadeException();
        }

        return [
            "success" => $updates_were_made,
            "result" => "Update Successful!",
            "updated" => $fields_updated
        ];
    }
}