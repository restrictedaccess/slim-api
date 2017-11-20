<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 9:31 PM
 */

namespace RemoteStaff\Exceptions;



class InvalidFileSizeException extends \Exception
{

    function __construct()
    {
        parent::__construct("File size too large. Max file upload size: 5MB.");
    }
}