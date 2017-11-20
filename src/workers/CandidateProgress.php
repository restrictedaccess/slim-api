<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 09/08/16
 * Time: 8:28 PM
 */

namespace RemoteStaff\Workers;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Workers\AbstractWorker;
use RemoteStaff\Documents\Candidate;
use RemoteStaff\Resources\CandidateResource as MyCandidateResource;
use RemoteStaff\Mongo\Resources\CandidateResource as MongoCandidateResource;


/**
 * Worker for Candidate Progress sync
 *
 * Class CandidateProgress
 *
 * @package RemoteStaff\Workers
 *
 */
class CandidateProgress extends AbstractWorker{

    public function init(){
        $this->setLoggerFileName("candidates_progress");
    }

    /**
     * Sync Data for Candidate Progress
     * @throws \RemoteStaff\Resources\Exception
     */
    public function sync($data)
    {
        $logger = $this->getLogger();
        // TODO: Implement sync() method.
        $mysqlResource = new MyCandidateResource();
        $mongoResource = new MongoCandidateResource();
        if (isset($data["id"])){
            $candidate = $mysqlResource->get($data["id"]);
            $mongoResource->syncCandidateProgress($candidate);
            $mongoResource->getDocumentManager()->flush();
        }else{
            $page = 1;
            while(true){

                $candidates = $mysqlResource->getAll($page, 10000);
                if (empty($candidates)){
                    break;
                }

                foreach($candidates as $candidate){
                    /* @var $candidate Personal */
                    /* @var $mongoCandidate Candidate */
                    echo "Syncing candidate ID ".$candidate->getId()."\n";
                    $logger->info("Syncing candidate ID ".$candidate->getId());
                    $mongoResource->syncCandidateProgress($candidate);
                    $mysqlResource->markSynced($candidate);

                }
                $mongoResource->getDocumentManager()->flush();
                $mysqlResource->getEntityManager()->flush();
                echo $page."\n";
                $page++;
            }
        }


    }
}