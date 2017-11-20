<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 23/08/16
 * Time: 11:51 PM
 */

namespace RemoteStaff\Entities;


/**
 * Class RequestForInterview
 * @package RemoteStaff\Entities
 * @Entity
 * @Table(name="tb_request_for_interview")
 */
class RequestForInterview {
    /**
     * @var int
     * @Id @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @var \RemoteStaff\Entities\Personal
     * @ManyToOne(targetEntity="RemoteStaff\Entities\Personal", inversedBy="requestForInterviews")
     * @JoinColumn(name="applicant_id", referencedColumnName="userid")
     */
    private $candidate;

} 