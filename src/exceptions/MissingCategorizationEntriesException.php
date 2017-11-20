<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/13/2016
 * Time: 8:09 AM
 */

namespace RemoteStaff\Exceptions;


class MissingCategorizationEntriesException extends \Exception
{
    function __construct()
    {
        parent::__construct("Canidate must have at least 1 category.");
    }
}