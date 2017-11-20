<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 9:23 PM
 */

namespace RemoteStaff\Exceptions;


class InvalidMockCallFileFormatException extends \Exception
{
    function __construct()
    {
        parent::__construct("Invalid Mock Call file Format! Valid formats: mp3, wma, wav");
    }
}