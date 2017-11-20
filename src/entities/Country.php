<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 8:58 PM
 */

namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Country
 * @Entity
 * @Table(name="country")
 */
class Country {

    /**
     * @var string
     * @Id @Column(type="string", name="iso")
     * @GeneratedValue(strategy="NONE")
     */
    private $iso;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\Personal", mappedBy="country")
     */
    private $candidates;

    /**
     * @return ArrayCollection
     */
    public function getCandidates()
    {
        return $this->candidates;
    }

    /**
     * @param ArrayCollection $candidates
     */
    public function setCandidates($candidates)
    {
        $this->candidates = $candidates;
    }

    /**
     * @return string
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @param string $iso
     */
    public function setIso($iso)
    {
        $this->iso = $iso;
    }

    public function __construct(){
        $this->candidates = new ArrayCollection();
    }


} 