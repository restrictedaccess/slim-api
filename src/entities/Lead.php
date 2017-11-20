<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 03/08/16
 * Time: 4:43 PM
 */

namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Criteria;

/**
 * Class Lead
 * @Entity
 * @Table(name="leads")
 */
class Lead {

    /**
     * @var Int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;
    /**
     * @var String
     * @Column(type="string", name="fname")
     */
    private $first_name;
    /**
     * @var String
     * @Column(type="string", name="lname")
     */
    private $last_name;

    /**
     * @var array
     * @OneToMany(targetEntity="RemoteStaff\Entities\Subcontractor", mappedBy="client")
     *
     */
    private $subcontractors;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\EndorsementEntry", mappedBy="lead", cascade={"remove"})
     */
    private $endorsements;


    public function __construct(){
        $this->subcontractors = new ArrayCollection();
        $this->endorsements = new ArrayCollection();
    }

    /**
     * @param $fname The name of the lead
     */
    public function setFirstName($fname){
        $this->first_name = $fname;
    }

    public function getFirstName(){
        return $this->first_name;
    }

    public function setLastName($lname){
        $this->last_name = $lname;
    }

    public function getLastName(){
        return $this->last_name;
    }

    public function getId(){
        return $this->id;
    }

    public function getSubcontractors(){
        return $this->subcontractors;
    }

    public function getActiveSubcontractors(){
        $criteria = Criteria::create();
        $criteria->where(Criteria::expr()->in("status", ["ACTIVE", "suspended"]));
        return $this->subcontractors->matching($criteria);
    }

} 