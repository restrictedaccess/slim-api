<?php
namespace RemoteStaff\Tests;

use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\EvaluationComment;
use RemoteStaff\Entities\Personal;


class EvaluationCommentTest extends \PHPUnit_Framework_TestCase
{


    /**
     * @var \RemoteStaff\Entities\Admin
     */
    private $honeylyn;

    /**
     * @var \RemoteStaff\Entities\EvaluationComment
     */
    private $addedComments;

    /**
     * @var \RemoteStaff\Entities\Personal
     */
    private $jocelyn;

    protected function setUp()
    {
        $candidate = new Personal();
        $candidate->setUserid(119569 );
        $candidate->setFirstName('Jocelyn ');
        $candidate->setLastName('Gudmalin ');

        $recruiter = new Admin();
        $recruiter->setFirstName("Honeylyn");
        $recruiter->setLastName("Lapidario");

            $arrComments = ["For Prescreening","Phone Interview - Done",""];

            for($i = 1 ; $i <= count($arrComments) ; $i++ )
            {
                $evaluationComments = new EvaluationComment();
                $evaluationComments->setCandidate($candidate);
                $evaluationComments->setAdmin($recruiter);
                $evaluationComments->setCommentDate(new \DateTime("2016-08-18 13:00:00"));
                $evaluationComments->setComments($arrComments[$i-1]);
                $evaluationComments->setOrdering(($i));

                $recruiter->setEvaluationNotes($evaluationComments);
            }




        $this->jocelyn = $candidate;
        $this->honeylyn = $recruiter;


    }

    public function testHonelynAddEvalComment()
    {

        $honeylyn = $this->honeylyn;
        $this->assertEquals(3, count( $honeylyn->getEvaluationNotes()));

    }
}
