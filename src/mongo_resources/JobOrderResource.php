<?php
namespace RemoteStaff\Mongo\Resources;

use RemoteStaff\AbstractMongoResource;

class JobOrderResource extends AbstractMongoResource{

    public function getByTrackingCode($tracking_code){
        $dm = $this->getDocumentManager();

        if ($tracking_code===null){
            return null;
        }

        $job_order = $dm->getRepository('RemoteStaff\Documents\JobOrder')->findOneBy(["tracking_code"=>$tracking_code]);
        return $job_order->getBasic();
    }
}
