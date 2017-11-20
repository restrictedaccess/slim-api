<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/19/2016
 * Time: 7:30 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class SolrSlimCandidates
 * @Entity
 * @Table(name="solr_slim_candidates")
 */
class SolrSlimCandidate
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;


    /**
     * @var \RemoteStaff\Entities\Personal
     * @OneToOne(targetEntity="RemoteStaff\Entities\Personal", fetch="LAZY")
     * @JoinColumn(name="candidate_id", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="date_synced")
     */
    private $dateSynced;

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
    public function getDateSynced()
    {
        return $this->dateSynced;
    }

    /**
     * @param \DateTime $dateSynced
     */
    public function setDateSynced($dateSynced)
    {
        $this->dateSynced = $dateSynced;
    }
}