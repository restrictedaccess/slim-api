<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 22/08/16
 * Time: 6:55 PM
 */

namespace RemoteStaff\Entities;
use RemoteStaff\Interfaces\Persistable;

/**
 * Class ApplicantFile
 * @Entity
 * @Table(name="tb_applicant_files")
 */
class ApplicantFile implements Persistable{
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;


    /**
     * @var string
     * @Column(name="file_description", type="string")
     */
    private $fileDescription;

    /**
     * @var string
     * @Column(name="name", type="string")
     */
    private $name;

    /**
     * @var string
     * @Column(name="permission", type="string")
     */
    private $permission;

    /**
     * @var \DateTime
     * @Column(name="date_created", type="datetime")
     */
    private $dateCreated;

    /**
     * @var boolean
     * @Column(name="is_deleted", type="boolean")
     */
    private $deleted;

    /**
     * @var boolean
     * @Column(name="is_lock", type="boolean")
     */
    private $locked;


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
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="applicantFiles")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @param boolean $locked
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
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
     * @return string
     */
    public function getPermission()
    {
        return $this->permission;
    }

    /**
     * @param string $permission
     */
    public function setPermission($permission)
    {
        $this->permission = $permission;
    }

    /**
     * @return string
     */
    public function getFileDescription()
    {
        return $this->fileDescription;
    }

    /**
     * @param string $fileDescription
     */
    public function setFileDescription($fileDescription)
    {
        $this->fileDescription = $fileDescription;
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
     * @return array
     */
    public function toArray(){
        return [
            "id" => $this->getId(),
            "file_description" => $this->getFileDescription(),
            "name" => $this->getName(),
            "permission" => $this->getPermission(),
            "date_created" => $this->getDateCreated()->format("Y-m-d H:i:s"),
            "is_lock" => $this->isLocked()
        ];
    }
} 