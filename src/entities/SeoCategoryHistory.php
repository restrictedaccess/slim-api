<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 10:47 AM
 */

namespace RemoteStaff\Entities;


/**
 * Class SeoCategoryHistory
 * @Entity
 * @Table(name="seo_category_history")
 */
class SeoCategoryHistory
{

    /**
     * @var int
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var string
     * @Column(type="string", name="changed_by_type")
     */
    private $changedByType;


    /**
     * @var string
     * @Column(type="string", name="changes")
     */
    private $changes;


    /**
     * @var \DateTime
     * @Column(type="datetime", name="date")
     */
    private $dateCreated;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="seoCategoryHistory")
     * @JoinColumn(name="changed_by_id", referencedColumnName="admin_id")
     */
    private $changedBy;

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
    public function getChangedByType()
    {
        return $this->changedByType;
    }

    /**
     * @param string $changedByType
     */
    public function setChangedByType($changedByType)
    {
        $this->changedByType = $changedByType;
    }

    /**
     * @return string
     */
    public function getChanges()
    {
        return $this->changes;
    }

    /**
     * @param string $changes
     */
    public function setChanges($changes)
    {
        $this->changes = $changes;
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
     * @return Admin
     */
    public function getChangedBy()
    {
        return $this->changedBy;
    }

    /**
     * @param Admin $changedBy
     */
    public function setChangedBy($changedBy)
    {
        $this->changedBy = $changedBy;
    }




}