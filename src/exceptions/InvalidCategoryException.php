<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 10:45 AM
 */

namespace RemoteStaff\Exceptions;


class InvalidCategoryException extends \Exception
{

    function __construct()
    {
        parent::__construct("Category must not be empty.");
    }
}