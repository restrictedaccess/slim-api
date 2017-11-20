<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 27/07/16
 * Time: 2:30 PM
 */

namespace RemoteStaff\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * Class JobOrder
 * @package RemoteStaff\Documents
 * @ODM\Document(db="prod", collection="job_orders")
 */
class JobOrder {
    /**
     * @var String
     * @ODM\Id(strategy="AUTO", type="string")
     */
    private $id;

    /**
     * @var String
     * @ODM\Field(type="string")
     */
    private $tracking_code;

    /**
     * @var Array
     * @ODM\EmbedMany(targetDocument="Endorsement")
     */
    private $endorsed = array();

    public function getBasic(){
        return [
          "tracking_code"=>$this->tracking_code,
            "id"=>$this->id
        ];
    }

    public function getEndorsed(){
        return $this->endorsed;
    }

}

/**
 * Class AbstractRecruitmentStage
 * @package RemoteStaff\Documents
 *
 * @ODM\EmbeddedDocument
 */
abstract class AbstractRecruitmentStage {
    /**
     * @var integer
     * @ODM\Field(type="int")
     */
    private $assigned_recruiter;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $userid;

    /**
     * @var date
     * @ODM\Field(type="date")
     */
    private $date_created;

}

/**
 * Class Endorsement
 * @package RemoteStaff\Documents
 *
 * @ODM\EmbeddedDocument
 */
class Endorsement extends AbstractRecruitmentStage{

}