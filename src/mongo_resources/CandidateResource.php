<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 09/08/16
 * Time: 8:36 PM
 */

namespace RemoteStaff\Mongo\Resources;
use RemoteStaff\AbstractMongoResource;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Documents\UnprocessedStage;
use RemoteStaff\Documents\Candidate;
use RemoteStaff\Exceptions\MissingUnprocessedEntryException;

class CandidateResource extends AbstractMongoResource{

    /**
     * Sync Candidate Progress from mySQL to Mongo
     * @param Personal $candidate
     */
    public function syncCandidateProgress(Personal $candidate){
        $mongoCandidate = new Candidate();
        $mongoCandidate->setId($candidate->getId());
        $mongoCandidate->setFirstName($candidate->getFirstName());
        $mongoCandidate->setEmail($candidate->getEmail());
        $mongoCandidate->setLastName($candidate->getLastName());
        $mongoCandidate->setDateCreated($candidate->getDateCreated());
        $mongoCandidate->setDateUpdated($candidate->getDateUpdated());


        //load unprocessed entry

        $unprocessedEntry = $candidate->getUnprocessedEntry();
        if ($unprocessedEntry){
            echo "Unprocessed Entry: ". $unprocessedEntry->getId()."\n";
            $unprocessedStage = new UnprocessedStage();
            $unprocessedStage->setDate($unprocessedEntry->getDate());
            $unprocessedStage->setId($unprocessedEntry->getId());
            $mongoCandidate->setUnprocessedEntry($unprocessedStage);
        }else{
            throw new MissingUnprocessedEntryException();
        }


        $this->getDocumentManager()->persist($mongoCandidate);

    }
} 