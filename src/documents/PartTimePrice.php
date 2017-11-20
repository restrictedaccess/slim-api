<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/7/2016
 * Time: 12:26 PM
 */

namespace RemoteStaff\Documents;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * Class PartTimePrice
 * @package RemoteStaff\Documents
 * @ODM\Document(db="prod", collection="price_part_time_collection")
 * @ODM\InheritanceType("COLLECTION_PER_CLASS")
 */
class PartTimePrice extends ProductPrice
{

}


