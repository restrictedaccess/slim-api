<?php

namespace RemoteStaff\Resources;

use RemoteStaff\AbstractResource;
use RemoteStaff\Resources\ApplicationHistoryResource;
class InstantEmailResource extends AbstractResource
{


    public function getEmailResource($params)
    {
        $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Personal')->find($params["userid"]);


        return $candidate;
    }


    public function getAdminData($params)
    {
        $admin = $candidate = $this->getEntityManager()->getRepository('RemoteStaff\Entities\Admin')->find($params["adminid"]);

        return $admin;
    }

    public function insertToHistory($params)
    {
        $appHistory = new ApplicationHistoryResource();
        $appHistory->create($params);
    }


}
