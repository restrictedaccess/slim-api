<?php

/**
 * Created by PhpStorm.
 * User: IT
 * Date: 8/24/2016
 * Time: 10:48 PM
 */
namespace RemoteStaff\Resources;

use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\InactiveEntry;
use RemoteStaff\Entities\InactiveEntryNote;
use RemoteStaff\Entities\StaffHistory;

class InactiveStaffResource extends AbstractResource
{
    public function create($params)
    {
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["userid"]);
        $admin = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($params["admin_id"]);

        $inActive = new InactiveEntry();
        $inActive->setCandidate($candidate);
        $inActive->setInactiveBy($admin);
        $inActive->setType($params["type"]);
        $inActive->setDate(new \DateTime());

        $this->getEntityManager()->persist($inActive);

        $candidate->getInactiveEntries()->add($inActive);

        $this->getEntityManager()->persist($candidate);

        $inactiveEntryNotes = new InactiveEntryNote();
        $inactiveEntryNotes->setInactiveEntry($inActive);
        $inactiveEntryNotes->setNote($params["note"]);
        $inactiveEntryNotes->setDate(new \DateTime());

        $staffHistory = $this->createStaffHistory($candidate, $admin, "added status to <font color=#FF0000>INACTIVE</font> listings.");

        $inActive->setInactiveEntryNote($inactiveEntryNotes);
        $this->getEntityManager()->persist($inactiveEntryNotes);
        $this->getEntityManager()->persist($staffHistory);
        $this->getEntityManager()->flush();

        return $inActive;
    }

    public function addInactiveEntryNote(InactiveEntry $params, $note)
    {
        $inactiveEntryNotes = new InactiveEntryNote();
        $inactiveEntryNotes->setInactiveEntry($params);
        $inactiveEntryNotes->setNote($note);
        $inactiveEntryNotes->setDate(new \DateTime());

        return inactiveEntryNotes;
    }


}