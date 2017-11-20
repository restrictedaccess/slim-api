<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 8:05 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class Shortlist Entry
 * @Entity
 * @Table(name="tb_endorsement_history")
 */
class EndorsementEntry {
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="endorsements")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="endorsements")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $endorsedBy;

    /**
     * @var \RemoteStaff\Entities\Lead
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Lead", inversedBy="endorsements")
     * @JoinColumn(name="client_name", referencedColumnName="id")
     */
    private $lead;

    /**
     * @return Lead
     */
    public function getLead()
    {
        return $this->lead;
    }

    /**
     * @param Lead $lead
     */
    public function setLead($lead)
    {
        $this->lead = $lead;
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
     * @return Admin
     */
    public function getEndorsedBy()
    {
        return $this->endorsedBy;
    }

    /**
     * @param Admin $endorsedBy
     */
    public function setEndorsedBy($endorsedBy)
    {
        $this->endorsedBy = $endorsedBy;
    }


} 