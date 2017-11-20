<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/20/2016
 * Time: 9:43 AM
 */

namespace RemoteStaff\Exceptions;


class InvalidVoiceFormatException extends \Exception
{
    function __construct()
    {
        parent::__construct("Invalid file format. Valid formats: mp3,wma,wav,mpeg");
    }
}