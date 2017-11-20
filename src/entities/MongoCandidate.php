<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 10/08/16
 * Time: 8:35 AM
 */

namespace RemoteStaff\Entities;

/**
 * Class MongoCandidate
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="mongo_candidates")
 */
class MongoCandidate {

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \DateTime
     * @Column(type="datetime")
     */
    private $date;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="mongoSynced", fetch="LAZY")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     *
     */
    private $candidate;

    /**
     * @return Personal
     */
    public function getCandidate()
    {
        return $this->candidate;
    }

    /**
     * @param Personal $candidate
     */
    public function setCandidate($candidate)
    {
        $this->candidate = $candidate;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

} 