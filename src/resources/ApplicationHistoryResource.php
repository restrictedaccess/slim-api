<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 8/22/2016
 * Time: 10:46 AM
 */

namespace RemoteStaff\Resources;

use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\ApplicationHistory;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\StaffHistory;

class ApplicationHistoryResource extends AbstractResource
{

    public function create($params)
    {
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["user_id"]);
        $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($params["admin_id"]);


        $insertNotes = new ApplicationHistory();
        $insertNotes->setAdminInfo($admin);
        $insertNotes->setCandidate($candidate);
        $insertNotes->setActions($params["actions"]);
        $insertNotes->setHistory($params["history"]);
        $insertNotes->setCreatedByType("admin");
        $insertNotes->setDateCreated(new \DateTime());
        if (isset($params["subject"])) {
            $insertNotes->setSubject($params["subject"]);
        }

        if ($params["actions"] != 'EMAIL') {

            $staffHistory = $this->createStaffHistory($candidate, $admin, "added a communication notes <font color=#FF0000>[CALL].</font>");


            $this->getEntityManager()->persist($staffHistory);
        } else {
            $staffHistoryforEmail = $this->createStaffHistory($candidate, $admin, "added a communication notes <font color=#FF0000>[EMAIL].</font>");


            $this->getEntityManager()->persist($staffHistoryforEmail);
        }
        $this->getEntityManager()->persist($insertNotes);
        $this->getEntityManager()->flush();
        return $insertNotes;
    }


    public function getFilteredNotes($params)
    {
        if (!$params) {
            return null;
        }


        $notes = $this->getEntityManager()->getRepository('RemoteStaff\Entities\ApplicationHistory')->findBy(["userid" => $params['user_id'], "actions" => "CALL"]);


        forEach ($notes as $note => $e) {
            $data[] = $this->convertArray($notes[$note]);
        }

        return $data;

    }

    private function mapAdmin(Admin $admininfo)
    {
        return [
            "name" => $admininfo->getName()
        ];
    }

    private function convertArray(ApplicationHistory $note)
    {

        $admin_info = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($note->getAdminId());

        $date = $note->getDateCreated();

        return [
            "id" => $note->getId(),
            "userid" => $note->getUserId(),
            "notes" => $note->getHistory(),
            "date" => date_format($date, "M dS Y, h:m:s a"),
            "admin" => $this->mapAdmin($admin_info)
        ];
    }

}
