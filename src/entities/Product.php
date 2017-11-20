<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 9/6/2016
 * Time: 11:37 AM
 */

namespace RemoteStaff\Entities;

/**
 * Class Products
 * @Entity
 * @Table(name="products")
 */
class Product
{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id = null;

    /**
     * @var string
     * @Column(type="string")
     */
    private $code = null;

    /**
     * @var string
     * @Column(type="string")
     */
    private $name = null;

    /**
     * @var \Doctrine\Common\Collections\StaffRate;
     * @OneToMany(targetEntity="RemoteStaff\Entities\ApplicationHistory", mappedBy="fullTimeRate")
     *
     */
    private $fullTimeStaffRate = null;

    /**
     * @var \Doctrine\Common\Collections\StaffRate;
     * @OneToMany(targetEntity="RemoteStaff\Entities\ApplicationHistory", mappedBy="partFullTimeRate")
     *
     */
    private $partTimeStaffRate = null;

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
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode($code)
    {
        $this->code = $code;
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
}