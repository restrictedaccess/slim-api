<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 09/08/16
 * Time: 8:38 PM
 */

namespace RemoteStaff\Resources;
use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\EmployeeCurrentProfile;
use RemoteStaff\Entities\NoShowEntry;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\MongoCandidate;
use RemoteStaff\Entities\PreScreenedCandidate;
use RemoteStaff\Entities\RecruiterStaff;
use RemoteStaff\Entities\StaffHistory;
use RemoteStaff\Entities\UnprocessedCandidate;
use RemoteStaff\Resources\AdminResource;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Resources\CandidateResource;
use \Doctrine\Common\Collections\ArrayCollection;
/**
 * Resource for Prescreened Data
 * Class PrescreenedResource
 * @package RemoteStaff\Resources
 *
 */
class PrescreenedResource extends AbstractResource {

    public function addNoShow($request){
        $mysql_resource = new CandidateResource();
        $mysql_resource->setEntityManager($this->getEntityManager());
        $admin_resource = new AdminResource();
        $admin_resource->setEntityManager($mysql_resource->getEntityManager());
        $candidate = $mysql_resource->get($request["candidate_id"]);
        $admin = $admin_resource->get($request["admin_id"]);

        $noShowInitialEntry = new NoShowEntry();
        $noShowInitialEntry->setCandidate($candidate);
        $noShowInitialEntry->setNoShowBy($admin);
        $noShowInitialEntry->setDate(new \DateTime());
        $noShowInitialEntry->setServiceType($request["service_type"]);

        $this->getEntityManager()->persist($noShowInitialEntry);

        if($candidate->getNoShowEntries() == null){
            $candidate->setNoShowEntries(new ArrayCollection());
        }

        if($admin->getNoShowEntries() == null){
            $admin->setNoShowEntries(new ArrayCollection());
        }

        $candidate->setDateUpdated(new \DateTime());

        $candidate->getNoShowEntries()->add($noShowInitialEntry);

        $this->getEntityManager()->persist($candidate);

        $admin->getNoShowEntries()->add($noShowInitialEntry);

        $this->getEntityManager()->persist($admin);

        $staffHistory = $this->createStaffHistory($candidate, $admin, "marked as <font color=#FF0000>NO SHOW</font> on " . $request["service_type"] . " RECRUITMENT.");

        $this->getEntityManager()->persist($staffHistory);

        $this->getEntityManager()->flush();

        $data = $candidate->toArray();

        $data["new_no_show_id"] = $candidate->getNoShowEntries()->last()->getId();

        return $data;
    }

    public function moveToPrescreened($candidateRaw){

        $mysql_resource = new CandidateResource();
        $mysql_resource->setEntityManager($this->getEntityManager());
        $admin_resource = new AdminResource();
        $admin_resource->setEntityManager($mysql_resource->getEntityManager());
        $candidate = $mysql_resource->get($candidateRaw["candidate_id"]);

        if($candidate->getPreScreenedEntry() == null){
            $admin = $admin_resource->get($candidateRaw["admin_id"]);
            //Add prescreened data
            $prescreened_entry = new PreScreenedCandidate();
            $prescreened_entry->setCandidate($candidate);
            $prescreened_entry->setDate(new \DateTime());
            $prescreened_entry->setPrescreenedBy($admin);

            if($admin->getPrescreenedEntries() == null){
                $admin->setPrescreenedEntries(new ArrayCollection());
            }

            $admin->getPrescreenedEntries()->add($prescreened_entry);

            
            $candidate->setPreScreenedEntry($prescreened_entry);
            $candidate->setDateUpdated(new \DateTime());



            //staff history
            /**
             * GOES HERE
             */
            $staffHistory = $this->createStaffHistory($candidate, $admin, "added status to <font color=#FF0000>PRESCREENED</font> listings.");

            $this->getEntityManager()->persist($candidate);
            $this->getEntityManager()->persist($prescreened_entry);
            $this->getEntityManager()->persist($staffHistory);


            $this->getEntityManager()->flush();
        }

        return $candidate->toArray();
    }



}
