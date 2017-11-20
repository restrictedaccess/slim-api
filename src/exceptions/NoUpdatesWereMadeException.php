<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 10:02 AM
 */

namespace RemoteStaff\Exceptions;


class NoUpdatesWereMadeException extends \Exception
{

    function __construct()
    {
        parent::__construct("No changes were made!");
    }
}