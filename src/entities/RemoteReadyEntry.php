<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 8/10/2016
 * Time: 3:31 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class RemoteReadyEntry
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="remote_ready_criteria_entries")
 */

class RemoteReadyEntry
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="date_created")
     */
    private $dateCreated;

    /**
     * @var int
     * @Column(type="integer", name="added")
     */
    private $added;


    /**
     * @var \RemoteStaff\Entities\RemoteReadyCriteria
     * @ManyToOne(targetEntity="RemoteStaff\Entities\RemoteReadyCriteria")
     * @JoinColumn(name="remote_ready_criteria_id", referencedColumnName="id")
     */
    private $remoteReadyCriteria;


    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="remoteReadyEntries")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param \DateTime $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return int
     */
    public function getAdded()
    {
        return $this->added;
    }

    /**
     * @param int $added
     */
    public function setAdded($added)
    {
        $this->added = $added;
    }



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
     * @return RemoteReadyCriteria
     */
    public function getRemoteReadyCriteria()
    {
        return $this->remoteReadyCriteria;
    }

    /**
     * @param RemoteReadyCriteria $remoteReadyCriteria
     */
    public function setRemoteReadyCriteria($remoteReadyCriteria)
    {
        $this->remoteReadyCriteria = $remoteReadyCriteria;
    }
}