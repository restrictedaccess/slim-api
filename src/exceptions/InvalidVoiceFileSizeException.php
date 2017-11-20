<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/20/2016
 * Time: 4:20 PM
 */

namespace RemoteStaff\Exceptions;


class InvalidVoiceFileSizeException extends \Exception
{

    function __construct()
    {
        parent::__construct("File size too large. Max file upload size: 5MB.");
    }
}