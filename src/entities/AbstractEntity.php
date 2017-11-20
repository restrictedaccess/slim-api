<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 8/11/2016
 * Time: 5:23 PM
 */

namespace RemoteStaff\Entities;
/**
 * Class AbstractEntity
 * @package RemoteStaff\Entities
 */

abstract class AbstractEntity
{

    /**
     * @var \RemoteStaff\AbstractResource
     */
    protected $resource;

    /**
     * @return \RemoteStaff\AbstractResource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param \RemoteStaff\AbstractResource $resource
     */
    public function setResource($resource)
    {
        $this->resource = $resource;
    }


}