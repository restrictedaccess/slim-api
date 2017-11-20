<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 7:20 PM
 */

namespace RemoteStaff\Entities;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Class Posting
 * @Entity
 * @Table(name="posting")
 */
class Posting {
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection;
     * @OneToMany(targetEntity="RemoteStaff\Entities\ShortlistEntry", mappedBy="position")
     */
    private $shortlists;

    public function __construct(){
        $this->shortlists = new ArrayCollection();
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