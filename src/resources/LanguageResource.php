<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/28/2016
 * Time: 11:29 AM
 */

namespace RemoteStaff\Resources;
use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Language;
use RemoteStaff\Entities\Personal;

/**
 *
 * Resource of Applicant Files
 * Class LanguageResource
 * @package RemoteStaff\Resources
 *
 */
class LanguageResource extends AbstractResource
{
    /**
     * @param Personal $candidate
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function fetchAllLanguage(Personal $candidate){

        return $candidate->getLanguages();
    }


    /**
     * @param Personal $candidate
     * @param Admin $recruiter
     * @param $request
     * @return array
     */
    public function saveLanguage(Personal $candidate, Admin $recruiter, $request){

        $result = array();

        $result["success"] = false;

        foreach ($request["candidate"]["languages"] as $language) {
            $new_language = new Language();

            $new_language->setId($language["id"]);
            $new_language->setCandidate($candidate);
            $new_language->setLanguage($language["language"]);
            $new_language->setSpoken($language["spoken"]);
            $new_language->setSpokenAssessment($language["spoken_assessment"]);
            $new_language->setWritten($language["written"]);
            $new_language->setWrittenAssessment($language["written_assessment"]);

            try{
                $added = $candidate->addLanguage($new_language);

                if(!empty($added)){
                    $historyChanges = "Added new language <font color=#FF0000>" . $language["language"] . "</font>";

                    $history = $this->createStaffHistory($candidate, $recruiter, $historyChanges);

                    $this->getEntityManager()->persist($added);

                    $this->getEntityManager()->persist($history);

                    $result["success"] = true;
                }
            } catch(\Exception $e){
                $result["errors"][] = $e->getMessage();
            }

        }

        $candidate->setDateUpdated(new \DateTime());

        $this->getEntityManager()->persist($candidate);

        $this->getEntityManager()->flush();




        return $result;
    }


    /**
     * @param Personal $candidate
     * @param Admin $recruiter
     * @param $request
     * @return array
     */
    public function removeLanguage(Personal $candidate, Admin $recruiter, $request){

        $result = array();

        $result["success"] = true;

        $to_delete = new Language();

        $to_delete->setLanguage($request["language_to_delete"]["language"]);

        $candidate->removeLanguage($to_delete);

        $this->getEntityManager()->remove($to_delete);

        $historyChanges = "Delete Language <font color=#FF0000>". $to_delete->getLanguage() . "</font>";

        $this->createStaffHistory($candidate, $recruiter, $historyChanges);

        $candidate->setDateUpdated(new \DateTime());

        $this->getEntityManager()->persist($candidate);

        $this->getEntityManager()->flush();


        return $result;
    }
}