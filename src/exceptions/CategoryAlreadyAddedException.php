<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/13/2016
 * Time: 1:22 PM
 */

namespace RemoteStaff\Exceptions;


class CategoryAlreadyAddedException extends \Exception
{
    function __construct()
    {
        parent::__construct("Candidate already categorized to the category.");
    }
}