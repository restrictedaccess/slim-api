<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/27/2016
 * Time: 2:35 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class Industry
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="defined_industries")
 */
use Doctrine\Common\Collections\ArrayCollection;
class Industry
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

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
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * @return ArrayCollection
     */
    public function getPreviousJobIndustry()
    {
        return $this->previousJobIndustry;
    }

    /**
     * @param ArrayCollection $previousJobIndustry
     */
    public function setPreviousJobIndustry($previousJobIndustry)
    {
        $this->previousJobIndustry = $previousJobIndustry;
    }

    /**
     * @var string
     * @Column(type="string", name="value")
     */
    private $value;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     * @OneToMany(targetEntity="RemoteStaff\Entities\PreviousJobIndustry", mappedBy="industry")
     *
     */
    private $previousJobIndustry = [];

    /**
     * Constructor class
     */
    public function __construct(){
        $this->previousJobIndustry = new ArrayCollection();
    }

}