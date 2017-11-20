<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/13/2016
 * Time: 1:54 PM
 */

namespace RemoteStaff\Exceptions;


class CandidateDoesNotExistsException extends \Exception
{
    function __construct()
    {
        parent::__construct("Candidate does not exist.");
    }
}