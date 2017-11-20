<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 10/08/16
 * Time: 5:55 PM
 */

namespace RemoteStaff\Tests;
use RemoteStaff\Entities\Personal;

class PersonalTest extends \PHPUnit_Framework_TestCase {

    /**
     * Test to perform check if Personal has Unprocessed once created
     */
    public function testRecruitmentUnprocessedCount(){
        $personal = new Personal();
        $unprocessedEntry = $personal->getUnprocessedEntry();
        $this->assertTrue($unprocessedEntry!==null);
    }



    public function testPrescreeningCandidate(){
        $personal = new Personal();

        $evaluationComment = new EvaluationComment();
        $evaluationComment->setCandidate($personal);
        $personal->addEvaluationComment($evaluationComment);
        $personal->markAsPrescreened();
        $this->assertTrue($personal->getRecruitmentStage()=="prescreened");
    }


}
 