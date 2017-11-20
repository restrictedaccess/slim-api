<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 11/08/16
 * Time: 4:23 PM
 */

namespace RemoteStaff\Resources;
use RemoteStaff\AbstractResource;

class RemoteReadyResource extends AbstractResource{


    /**
     * @param $id
     * @return RemoteStaff\Entities\RemoteReadyCriteria
     * @throws Exception
     */
    public function getRemoteReadyCriteria($id){
        if ($id===null){
            throw new Exception("ID is required");
        }
        $criteria = $this->getEntityManager()->getRepository('RemoteStaff\Entities\RemoteReadyCriteria')->find($id);
        return $criteria;
    }
} 