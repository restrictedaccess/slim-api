<?php
/**
 * Created by PhpStorm.
 * User: remotestaff
 * Date: 27/07/16
 * Time: 9:05 AM
 */

namespace RemoteStaff\Resources;
use RemoteStaff\AbstractResource;
use RemoteStaff\Entities\Lead;
use RemoteStaff\Entities\Subcontractor;

class LeadResource extends AbstractResource{

    /**
     * @param $id
     *
     * @return string
     */
    public function get($id)
    {
        if ($id===null){
            throw new Exception("Missing leads Id");
        }else{
            $lead = $this->getEntityManager()->find('RemoteStaff\Entities\Lead', $id);
            $data = $this->convertArray($lead);
        }
        return $data;
    }

    private function mapSubcon(Subcontractor $subcontractor){
        return [
          "id"=>$subcontractor->getId(),
            "personal"=>$subcontractor->getPersonalInformation()->getBasic()
        ];
    }

    private function convertArray(Lead $lead){
        $subcontractors = array();
        foreach($lead->getActiveSubcontractors() as $subcontractor){
            try{
                $subcontractors[] = $this->mapSubcon($subcontractor);
            }catch(Exception $e){

            }
        }
        return [
            "id"=>$lead->getId(),
            "fname"=>$lead->getFirstName(),
            "lname"=>$lead->getLastName(),
            "subcontractors"=>$subcontractors
        ];
    }
}