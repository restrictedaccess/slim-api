<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 11:41 PM
 */

namespace RemoteStaff\Entities;

/**
 * Class CategorizedEntry
 * @Entity
 * @Table(name="job_sub_category_applicants")
 */
class CategorizedEntry {



    /**
     * @var int
     * @Id @Column(type="integer", name="id")
     * @GeneratedValue
     */
    private $id;


    /**
     * @var int
     * @Column(type="integer", name="ratings")
     */
    private $ratings;

    /**
     * @var \DateTime
     * @Column(type="datetime", name="sub_category_applicants_date_created")
     */
    private $date_created;


    /**
     * @var \RemoteStaff\Entities\Category
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Category")
     * @JoinColumn(name="category_id", referencedColumnName="category_id")
     */
    private $category;


    /**
     * @var \RemoteStaff\Entities\SubCategory
     * @ManyToOne(targetEntity="RemoteStaff\Entities\SubCategory")
     * @JoinColumn(name="sub_category_id", referencedColumnName="sub_category_id")
     */
    private $subCategory;


    /**
     * @var \RemoteStaff\Entities\Admin
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Admin", inversedBy="categorizedEntries")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $categorizedBy;


    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="categorizedEntries")
     * @JoinColumn(name="userid", referencedColumnName="userid")
     */
    private $candidate;

    /**
     * @var \RemoteStaff\Entities\Admin
     * @OneToOne(targetEntity="RemoteStaff\Entities\Admin", fetch="LAZY")
     * @JoinColumn(name="admin_id", referencedColumnName="admin_id")
     */
    private $recruiter;

    /**
     * @return Admin
     */
    public function getRecruiter()
    {
        return $this->recruiter;
    }

    /**
     * @param Admin $recruiter
     */
    public function setRecruiter($recruiter)
    {
        $this->recruiter = $recruiter;
    }




    /**
     * @return int
     */
    public function getRatings()
    {
        return $this->ratings;
    }

    /**
     * @param int $ratings
     */
    public function setRatings($ratings)
    {
        $this->ratings = $ratings;
    }

    /**
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * @param \DateTime $date_created
     */
    public function setDateCreated($date_created)
    {
        $this->date_created = $date_created;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @return SubCategory
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * @param SubCategory $subCategory
     */
    public function setSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;
    }

    /**
     * @return Admin
     */
    public function getCategorizedBy()
    {
        return $this->categorizedBy;
    }

    /**
     * @param Admin $categorizedBy
     */
    public function setCategorizedBy($categorizedBy)
    {
        $this->categorizedBy = $categorizedBy;
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

} 