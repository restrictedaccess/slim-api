<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 27/07/16
 * Time: 8:56 AM
 */
namespace RemoteStaff;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\Personal;
use Doctrine\Common\Collections\ArrayCollection;
use RemoteStaff\Entities\StaffHistory;

abstract class AbstractResource
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    public function getEntityManager()
    {
        if ($this->entityManager=== null) {
            $this->entityManager = $this->createEntityManager();
        }

        return $this->entityManager;
    }



    /**
     * @return EntityManager
     */
    public function createEntityManager()
    {
        $cacheDir = '/srv/api/src/entities';
        if (!is_dir($cacheDir)) {
            mkdir($cacheDir);
        }
        $paths = [BASE_DIR.'/../src/entities'];
        $isDevMode = false;
        // Instantiate the app
        $settings = require BASE_DIR . '/../src/settings.php';
        $dbParams = $settings["settings"]["mysql"];

        $config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $cacheDir);

        return EntityManager::create($dbParams, $config);
    }

    /**
     * @param EntityManager $entityManager
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }


    /**
     * Create Staff History for created Resume
     * @param Personal $candidate
     * @param Admin $recruiter
     * @return StaffHistory
     */
    public function createStaffHistory(Personal $candidate, Admin $recruiter, $historyChanges){
        $staffHistory = new StaffHistory();
        $staffHistory->setCandidate($candidate);
        $staffHistory->setChangedBy($recruiter);
        $staffHistory->setChanges($historyChanges);
        $admin_status = $recruiter->getStatus();
        $admin_type = $admin_status;
        if($admin_type == "FULL-CONTROL"){
            $admin_type = "ADMIN";
        }

        if($admin_type == null){
            $admin_type = "HR";
        }
        $staffHistory->setType($admin_type);
        $staffHistory->setDateCreated(new \DateTime());
        if($candidate->getStaffHistory() == null){
            $candidate->setStaffHistory(new ArrayCollection());
        }

        if($recruiter->getStaffHistory() == null){
            $recruiter->setStaffHistory(new ArrayCollection());
        }

        $candidate->getStaffHistory()->add($staffHistory);
        $recruiter->getStaffHistory()->add($staffHistory);
        return $staffHistory;
    }
}