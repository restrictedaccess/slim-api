<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/13/2016
 * Time: 10:36 AM
 */

namespace RemoteStaff\Tests;

use RemoteStaff\Entities\Personal;
use RemoteStaff\Entities\Admin;
use RemoteStaff\Entities\EvaluationComment;

class EvaluationNotes extends \PHPUnit_Framework_TestCase
{
    private $candidate;
    private $recruiter;
    private $recruiter2;
    private $recruiter_name;
    private $recruiter_name2;

    protected function setUp()
    {
        $candidate = new Personal();
        $candidate->setUserid(119569);
        $candidate->setFirstName("Jocelyn");
        $candidate->setLastName("Gudmalin");
        $this->candidate = $candidate;

        $recruiter = new Admin();
        $recruiter->setId(167);
        $recruiter->setFirstName("Honeylyn");
        $recruiter->setLastName("Lapidario");
        $this->recruiter = $recruiter;
        $this->recruiter_name = $recruiter->getFirstName() . " " . $recruiter->getLastName();

        $recruiter2 = new Admin();
        $recruiter2->setFirstName("Andrew");
        $this->recruiter2 = $recruiter2;
        $this->recruiter_name2 = $recruiter2->getFirstName();
    }

    // Adding of Data

    public function testCase1()
    {
        $comment = new EvaluationComment();
        $comment->setCandidate($this->candidate);
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("For Prescreening");
        $comment->setOrdering(1);
        $comment->setCommentDate(new \DateTime("2016-08-18 13:00:00"));

        $this->assertEquals(1, count($comment->getComments()));
        $this->assertEquals(1, $comment->getOrdering());
        $this->assertEquals(167, $comment->getCommentBy()->getId());
        $this->assertEquals($comment->getComments(), "For Prescreening");
        $this->assertEquals("Honeylyn Lapidario", $this->recruiter_name);

    }

    public function testCase2()
    {
        $comment = new EvaluationComment();
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("For Prescreening");
        $comment->setOrdering(1);
        $comment->setCommentDate(new \DateTime("2016-08-18 13:00:00"));

        $comment2 = new EvaluationComment();
        $comment2->setCommentBy($this->recruiter);
        $comment2->setComments("<strong> Phone Interview - Done</strong> will give feed later today</p>");
        $comment2->setOrdering(2);
        $comment2->setCommentDate(new \DateTime("2016-08-18 13:34:00"));

        $this->candidate->setEvaluationNotes($comment);
        $this->candidate->setEvaluationNotes($comment2);


        $this->assertEquals(2, count($this->candidate->getEvaluationNotes()));
        $this->assertEquals(2, $comment2->getOrdering());
        $this->assertEquals('<strong> Phone Interview - Done</strong> will give feed later today</p>', $comment2->getComments());
        $this->assertEquals("Honeylyn Lapidario", $this->recruiter_name);

    }

    public function testCase3()
    {
        $comment = new EvaluationComment();
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("For Prescreening");
        $comment->setOrdering(1);
        $comment->setCommentDate(new \DateTime("2016-08-18 13:00:00"));

        $comment2 = new EvaluationComment();
        $comment2->setCommentBy($this->recruiter);
        $comment2->setComments("<strong> Phone Interview - Done</strong> will give feed later today</p>");
        $comment2->setOrdering(2);
        $comment2->setCommentDate(new \DateTime("2016-08-18 13:34:00"));

        $comment3 = new EvaluationComment();
        $comment3->setCommentBy($this->recruiter);
        $comment3->setComments("<p>Added Evaluation Comment/Note: 
                              <br>She worked in various industries such as <br>
                              1.<strong> Entertainment and Media</strong><br>
                              2.<strong> Human Resource Education</strong><br>
                              3.<strong> Real Estate</strong></p>");
        $comment3->setOrdering(3);
        $comment3->setCommentDate(new \DateTime("2016-08-18 13:34:00"));


        $this->candidate->setEvaluationNotes($comment);
        $this->candidate->setEvaluationNotes($comment2);
        $this->candidate->setEvaluationNotes($comment3);

        $this->assertEquals(3, count($this->candidate->getEvaluationNotes()));
        $this->assertEquals(3, $comment3->getOrdering());
        $this->assertEquals("<p>Added Evaluation Comment/Note: 
                              <br>She worked in various industries such as <br>
                              1.<strong> Entertainment and Media</strong><br>
                              2.<strong> Human Resource Education</strong><br>
                              3.<strong> Real Estate</strong></p>", $comment3->getComments());
        $this->assertEquals("Honeylyn Lapidario", $this->recruiter_name);
    }

    public function testCase4()
    {
        $comment = new EvaluationComment();
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("For Prescreening");
        $comment->setOrdering(1);
        $comment->setCommentDate(new \DateTime("2016-08-18 13:00:00"));

        $comment2 = new EvaluationComment();
        $comment2->setCommentBy($this->recruiter);
        $comment2->setComments("<strong> Phone Interview - Done</strong> will give feed later today</p>");
        $comment2->setOrdering(2);
        $comment2->setCommentDate(new \DateTime("2016-08-18 13:34:00"));

        $comment3 = new EvaluationComment();
        $comment3->setCommentBy($this->recruiter);
        $comment3->setComments("<p>Added Evaluation Comment/Note: 
                              <br>She worked in various industries such as <br>
                              1.<strong> Entertainment and Media</strong><br>
                              2.<strong> Human Resource Education</strong><br>
                              3.<strong> Real Estate</strong></p>");
        $comment3->setOrdering(3);
        $comment3->setCommentDate(new \DateTime("2016-08-18 13:34:00"));

        $comment4 = new EvaluationComment();
        $comment4->setCommentBy($this->recruiter2);
        $comment4->setComments("Candidate has been professionally working since 2018 focused in Back Office Admin, Executive, Assistant, Training and Development");
        $comment4->setOrdering(4);
        $comment4->setCommentDate(new \DateTime("2016-08-19 08:00:00"));

        $this->candidate->setEvaluationNotes($comment);
        $this->candidate->setEvaluationNotes($comment2);
        $this->candidate->setEvaluationNotes($comment3);
        $this->candidate->setEvaluationNotes($comment4);

        $this->assertEquals(4, count($this->candidate->getEvaluationNotes()));
        $this->assertEquals(4, $comment4->getOrdering());
        $this->assertEquals("Candidate has been professionally working since 2018 focused in Back Office Admin, Executive, Assistant, Training and Development", $comment4->getComments());
        $this->assertEquals("Andrew", $this->recruiter_name2);
    }

    public function testCase5()
    {
        $comment = new EvaluationComment();
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("For Prescreening");
        $comment->setOrdering(1);
        $comment->setCommentDate(new \DateTime("2016-08-18 13:00:00"));

        $comment2 = new EvaluationComment();
        $comment2->setCommentBy($this->recruiter);
        $comment2->setComments("<strong> Phone Interview - Done</strong> will give feed later today</p>");
        $comment2->setOrdering(2);
        $comment2->setCommentDate(new \DateTime("2016-08-18 13:34:00"));

        $comment3 = new EvaluationComment();
        $comment3->setCommentBy($this->recruiter);
        $comment3->setComments("<p>Added Evaluation Comment/Note: 
                              <br>She worked in various industries such as <br>
                              1.<strong> Entertainment and Media</strong><br>
                              2.<strong> Human Resource Education</strong><br>
                              3.<strong> Real Estate</strong></p>");
        $comment3->setOrdering(3);
        $comment3->setCommentDate(new \DateTime("2016-08-18 13:34:00"));

        $comment4 = new EvaluationComment();
        $comment4->setCommentBy($this->recruiter2);
        $comment4->setComments("Candidate has been professionally working since 2018 focused in Back Office Admin, Executive, Assistant, Training and Development");
        $comment4->setOrdering(4);
        $comment4->setCommentDate(new \DateTime("2016-08-19 08:00:00"));

        $comment5 = new EvaluationComment();
        $comment5->setCommentBy($this->recruiter2);
        $comment5->setComments("She is amenable to work Full Time");
        $comment5->setOrdering(5);
        $comment5->setCommentDate(new \DateTime("2016-08-19 08:10:00"));

        $this->candidate->setEvaluationNotes($comment);
        $this->candidate->setEvaluationNotes($comment2);
        $this->candidate->setEvaluationNotes($comment3);
        $this->candidate->setEvaluationNotes($comment4);
        $this->candidate->setEvaluationNotes($comment5);

        $this->assertEquals(5, count($this->candidate->getEvaluationNotes()));
        $this->assertEquals(5, $comment5->getOrdering());
        $this->assertEquals("She is amenable to work Full Time", $comment5->getComments());
        $this->assertEquals("Andrew", $this->recruiter_name2);

    }

    // Updating of data
    public function testCase6()
    {
        $comment = new EvaluationComment();
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("She is amenable to work Full Time");
        $comment->setOrdering(5);
        $comment->setCommentDate(new \DateTime("2016-08-19 09:10:00"));

        // Edited comment
        $comment->setComments("She is amenable to work either full time or part time - any shift");

        $this->candidate->setEvaluationNotes($comment);

        $this->assertEquals("She is amenable to work either full time or part time - any shift", $comment->getComments());
        $this->assertEquals(5, $comment->getOrdering());
        $this->assertEquals(1, count($this->candidate->getEvaluationNotes()));
    }

    // Deleting of data
    public function testCase7()
    {
        $comment = new EvaluationComment();
        $comment->setId(101);
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("Added Evaluation Comment: She is amenable to work Full Time");
        $comment->setOrdering(1);
        $comment->setCommentDate(new \DateTime("2016-08-19 09:10:00"));

        $comment2 = new EvaluationComment();
        $comment2->setId(102);
        $comment2->setCommentBy($this->recruiter);
        $comment2->setComments("Candidate has been professionally working since 2018 focused in Back Office Admin, Executive, Assistant, Training and Development");
        $comment2->setOrdering(2);
        $comment2->setCommentDate(new \DateTime("2016-08-19 14:30:00"));

        $this->candidate->setEvaluationNotes($comment);
        $this->candidate->setEvaluationNotes($comment2);

        $comments = $this->candidate->getEvaluationNotes();

        foreach ($comments as $key => $value) {
            if ($value->getId() == 102) {
                unset($comments[$key]);
            }
        }

        $this->assertEquals(1, count($comments));
        $this->assertEquals(1, $comment->getOrdering());
    }

    // Moving of ordering
    public function testCase8()
    {
        $comment = new EvaluationComment();
        $comment->setCommentBy($this->recruiter);
        $comment->setComments("Added Evaluation Comment: She is amenable to work Full Time");
        $comment->setOrdering(1);
        $comment->setCommentDate(new \DateTime("2016-08-19 09:10:00"));

        $comment2 = new EvaluationComment();
        $comment2->setCommentBy($this->recruiter);
        $comment2->setComments("Candidate has been professionally working since 2018 focused in Back Office Admin, Executive, Assistant, Training and Development ");
        $comment2->setOrdering(2);
        $comment2->setCommentDate(new \DateTime("2016-08-19 14:30:00"));

        $comment2->setOrdering(1);
        $comment->setOrdering(2);

        $this->candidate->setEvaluationNotes($comment);
        $this->candidate->setEvaluationNotes($comment2);


        $this->assertEquals(1, $comment2->getOrdering());
        $this->assertEquals(2, count($this->candidate->getEvaluationNotes()));

    }


}