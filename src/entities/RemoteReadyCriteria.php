<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 8/10/2016
 * Time: 4:19 PM
 */

namespace RemoteStaff\Entities;


/**
 * Class RemoteReadyCriteria
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="remote_ready_criteria")
 */
class RemoteReadyCriteria
{

    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="name")
     */
    private $name;

    /**
     * @var int
     * @Column(type="integer", name="points")
     */
    private $points;



    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param int $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }


}