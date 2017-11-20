<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 27/07/16
 * Time: 9:05 AM
 */

namespace RemoteStaff\Resources;
use RemoteStaff\AbstractResource as AbstractResource;
use RemoteStaff\Entities\Subcontractor;

class SubcontractorResource extends AbstractResource{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id)
    {
        if ($id===null){
            $subcontractors = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Subcontractor')->findAll();
            $subcontractors = array_map(function($subcontractor){
                return $this->convertArray($subcontractor);
            }, $subcontractors);
            $data = $subcontractors;
        }else{
            $data = $this->convertArray($this->getEntityManager()->find('RemoteStaff\Entities\Subcontractor', $id));
        }
        return $data;
    }

    private function convertArray(Subcontractor $subcontractor){
        return [
            "id"=>$subcontractor->getId(),
            "personal_information"=>$subcontractor->getPersonalInformation()->getBasic()
        ];
    }
} 