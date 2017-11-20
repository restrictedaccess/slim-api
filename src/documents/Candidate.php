<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 09/08/16
 * Time: 7:59 PM
 */

namespace RemoteStaff\Documents;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
/**
 * Class Candidate
 * @package RemoteStaff\Documents
 * @ODM\Document(db="prod", collection="candidates")
 */
class Candidate {
    /**
     * @var string
     * @ODM\Id(strategy="NONE", type="int")
     */
    private $id;

    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $firstName;
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $lastName;
    /**
     * @var string
     * @ODM\Field(type="string")
     */
    private $email;
    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     */
    private $dateCreated;
    /**
     * @var \DateTime
     * @ODM\Field(type="date")
     */
    private $dateUpdated;

    /**
     * @var \RemoteStaff\Documents\UnprocessedStage
     * @ODM\EmbedOne(targetDocument="UnprocessedStage")
     */
    private $unprocessedEntry;

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = utf8_encode($firstName);
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = utf8_encode($lastName);
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param \DateTime $dateUpdated
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;
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

    /**
     * @return UnprocessedStage
     */
    public function getUnprocessedEntry()
    {
        return $this->unprocessedEntry;
    }

    /**
     * @param UnprocessedStage $unprocessedEntry
     */
    public function setUnprocessedEntry($unprocessedEntry)
    {
        $this->unprocessedEntry = $unprocessedEntry;
    }


}

/**
 * Class RecruitmentStage
 * @package RemoteStaff\Documents
 * @ODM\EmbeddedDocument
 */
abstract class RecruitmentStage{
    /**
     * MySQL Reference of the recruitment stage
     * @var int
     * @ODM\Field(type="int")
     */
    private $id;
    /**
     * Date when the recruitment stage happened
     * @var \DateTime
     * @ODM\Field(type="date")
     */
    private $date;

    /**
     *
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
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

}

/**
 * Class UnprocessedStage
 * @package RemoteStaff\Documents
 * @ODM\EmbeddedDocument
 */
class UnprocessedStage extends RecruitmentStage{

}
/**
 * Class ProfileCompletionStage
 * @package RemoteStaff\Documents
 * @ODM\EmbeddedDocument
 */
class ProfileCompletionStage extends RecruitmentStage{
    private $points;

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points)
    {
        $this->points = $points;
    }

}

/**
 * Class PreScreenedStage
 * @package RemoteStaff\Documents
 * @ODM\EmbeddedDocument
 */
class PreScreenedStage extends RecruitmentStage{

}


