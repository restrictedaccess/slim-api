<?php
namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Class EvaluationComment
 * @Entity
 * @Table(name="evaluation_comments")
 */
class EvaluationComment{


    /**
     * @var Int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;


    /**
     * @var Int
     * @Column(type="integer", name="userid")
     *
     */
    private $userid;


    /**
     * @var Int
     * @Column(type="integer", name="comment_by")
     *
     */
    private $commentby;

    /**
     * @var RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="evaluationNotes")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="evaluationNotes")
     * @JoinColumn(name="comment_by", referencedColumnName="admin_id")
     */
    private $adminInformation;


    /**
     * @var string
     * @Column(type="string", name="comments")
     */

    private $comments;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="comment_date")
     */
    private $comment_date = null;


    /**
     * @var int
     * @Column(type="integer", name="ordering")
     */
    private $ordering = null;


    /**$userid
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }






    /**
     * @param RemoteStaff\Entities\Admin $admin
     */
    public function setAdmin($admin)
    {
        $this->adminInformation = $admin;
    }

    /**
     * @return Admin
     */
    public function getAdmin()
    {
        return $this->admin_information;
    }

    /**
     * @return RemoteStaff\Entities\Personal
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param RemoteStaff\Entities\Personal $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }


    /**
     * @return string
     */

    public function getComments()
    {
        return $this->comments;
    }


    /**
     * @param string
     */
    public function setComments($eval_comments)
    {
        $this->comments = $eval_comments;
    }

    /**
     * @return \DateTime
     */
    public function getCommentDate()
    {
        return $this->comment_date;
    }

    /**
     * @param \DateTime $comment_date
     */
    public function setCommentDate($comment_date)
    {
        $this->comment_date = $comment_date;
    }

    /**
     * @return int
     */
    public function getOrdering()
    {
        return $this->ordering;
    }

    /**
     * @param int $ordering
     */
    public function setOrdering($ordering)
    {
        $this->ordering = $ordering;
    }


    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @param int $userid
     */
    public function setUserid($userid)
    {
        $this->userid = $userid;
    }


    /**
     * @return int
     */
    public function getCommentBy()
    {
        return $this->commentby;
    }

    /**
     * @param int $comment_by
     */
    public function setCommentBy($commentby)
    {
        $this->commentby = $commentby;
    }


    public function getAdminInfo(){
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->neq('id', null));
        return $this->adminInformation->matching($criteria);
    }

    /**
     * @param Int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}
