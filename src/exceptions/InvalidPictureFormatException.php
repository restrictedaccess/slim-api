<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/19/2016
 * Time: 7:52 AM
 */

namespace RemoteStaff\Exceptions;


class InvalidPictureFormatException extends \Exception
{
    function __construct()
    {
        parent::__construct("Invalid file format. Valid formats: png,jpg,jpeg");
    }
}