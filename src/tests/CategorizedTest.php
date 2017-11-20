<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 05/09/16
 * Time: 2:51 PM
 */

namespace RemoteStaff\Tests;

use RemoteStaff\Documents\Candidate;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\CategorizedEntry;
use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\PreScreenedCandidate;
use RemoteStaff\Entities\RemoteReadyCriteria;
use RemoteStaff\Entities\RemoteReadyEntry;
use RemoteStaff\Entities\UnprocessedCandidate;

/**
 * This class is used to test adding candidate to the ASL List
 * @refer TC_DISPLAY_OF_ASL_CANDIDATES
 * Class CategorizedTest
 * @package RemoteStaff\Tests
 */
class CategorizedTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var \RemoteStaff\Entities\Personal
     */
    private $lara;
    /**
     * @var \RemoteStaff\Entities\Admin
     */
    private $honeylyn;

    /**
     * @var \RemoteStaff\Entities\Admin
     */
    private $andrew;

    protected function setUp(){

        echo "Hey Jay!";
        $candidate = new Personal();
        $candidate->setUserid(82933);
        $candidate->setFirstName("Lara Maricon");
        $candidate->setLastName("Sala");
        $candidate->setEmail("laramariconsala@yahoo.com");
        $candidate->setDateCreated(new \DateTime("2016-08-18 13:00:00"));

        $subcategories = ["Email Support", "Chat Support", "Data Entry"];
        foreach($subcategories as $subcategory){
            $jobSubCategory = new JobSubCategory();
            $jobSubCategory->setName($subcategory);
            $categorizationEntry = new CategorizedEntry();
            $categorizationEntry->setSubCategory($jobSubCategory);
            $categorizationEntry->setCandidate($candidate);
        }

        $recruiter = new Admin();
        $recruiter->setFirstName("Honeylyn");
        $recruiter->setLastName("Lapidario");
        for($i=0;$i<10;$i++){
            $temp = new Personal();
            $temp->setUnprocessedEntry(new UnprocessedCandidate());
            $recruiter->addCandidateToUnprocessed($temp);
        }
        for($i=0;$i<5;$i++){
            $temp = new Personal();
            $temp->setUnprocessedEntry(new UnprocessedCandidate());
            $remoteEntry = new RemoteReadyEntry();
            $remoteEntry->setCandidate($temp);
            $remoteReadyCriteria = new RemoteReadyCriteria();
            $remoteReadyCriteria->setPoints(70);
            $remoteEntry->setRemoteReadyCriteria($remoteReadyCriteria);
            $temp->addRemoteReadyEntry($remoteEntry);
            $recruiter->addCandidate($temp);
        }

        for($i=0;$i<2;$i++){
            $temp = new Personal();
            $temp->setUnprocessedEntry(new UnprocessedCandidate());
            $remoteEntry = new RemoteReadyEntry();
            $remoteEntry->setCandidate($temp);
            $remoteReadyCriteria = new RemoteReadyCriteria();
            $remoteReadyCriteria->setPoints(70);
            $remoteEntry->setRemoteReadyCriteria($remoteReadyCriteria);
            $temp->addRemoteReadyEntry($remoteEntry);
            $temp->setPreScreenedEntry(new PreScreenedCandidate());
            $recruiter->addCandidate($temp);
        }

        for($i=0;$i<1;$i++){
            $temp = new Personal();
            $temp->setUnprocessedEntry(new UnprocessedCandidate());
            $remoteEntry = new RemoteReadyEntry();
            $remoteEntry->setCandidate($temp);
            $remoteReadyCriteria = new RemoteReadyCriteria();
            $remoteReadyCriteria->setPoints(70);
            $remoteEntry->setRemoteReadyCriteria($remoteReadyCriteria);
            $temp->addRemoteReadyEntry($remoteEntry);
            $temp->setPreScreenedEntry(new PreScreenedCandidate());
            $temp->addCategorizedEntry(new CategorizedEntry());
            $recruiter->addCandidate($temp);
        }

        $this->lara = $candidate;
        $this->honeylyn = $recruiter;

        $recruiter = new Admin();
        $recruiter->setFirstName("Andrew");
        $recruiter->setLastName("Hiponia");

        for($i=0;$i<3;$i++){
            $temp = new Personal();
            $temp->setUnprocessedEntry(new UnprocessedCandidate());
            $remoteEntry = new RemoteReadyEntry();
            $remoteEntry->setCandidate($temp);
            $remoteReadyCriteria = new RemoteReadyCriteria();
            $remoteReadyCriteria->setPoints(70);
            $remoteEntry->setRemoteReadyCriteria($remoteReadyCriteria);
            $temp->addRemoteReadyEntry($remoteEntry);
            $temp->setPreScreenedEntry(new PreScreenedCandidate());
            $recruiter->addCandidate($temp);
        }
        for($i=0;$i<1;$i++){
            $temp = new Personal();
            $temp->setUnprocessedEntry(new UnprocessedCandidate());
            $remoteEntry = new RemoteReadyEntry();
            $remoteEntry->setCandidate($temp);
            $remoteReadyCriteria = new RemoteReadyCriteria();
            $remoteReadyCriteria->setPoints(70);
            $remoteEntry->setRemoteReadyCriteria($remoteReadyCriteria);
            $temp->addRemoteReadyEntry($remoteEntry);
            $temp->setPreScreenedEntry(new PreScreenedCandidate());
            $temp->addCategorizedEntry(new CategorizedEntry());
            $recruiter->addCandidate($temp);
        }

        $this->andrew = $recruiter;
    }

    public function testHoneylynGetLara(){
        //recruiter
        $honeylyn = $this->honeylyn;
        //candidate
        $lara = $this->lara;

        $honeylyn->addCandidate($lara);//assign recruiter
        $this->assertEmpty(11, count($this->honeylyn->getUnprocessedCandidates()));
    }
    /**
     * @depends testHoneylynGetLara
     */
    public function testHoneylynPrescreenedLara(){
        $lara = $this->lara;
        $lara->setPreScreenedEntry(new PrescreenedEntry());
        $this->assertEquals(10, count($this->honeylyn->getUnprocessedCandidates()));
        $this->assertEquals(3, count($this->honeylyn->getPrescreenedCandidates()));
    }

} 