<?php
namespace RemoteStaff\Entities;
/**
 * Class Subcontractor
 * @Entity
 * @Table(name="subcontractors")
 */
class Subcontractor{
    /** @Id @Column(type="integer")
     *  @GeneratedValue
     */
    private $id;
    /**
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="subcontractors")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $personal_information;

    /**
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Lead", inversedBy="subcontractors")
     * @JoinColumn(name="leads_id", referencedColumnName="id")
     *
     */
    private $client;

    /**
     * @var string
     * @Column(type="string", name="status")
     */
    private $status;

    public function getId(){
        return $this->id;
    }

    public function setId($id){
        $this->id = $id;
    }

    public function getPersonalInformation(){
        if($this->personal_information->getId()==0) return null;
        return $this->personal_information;
    }

}
