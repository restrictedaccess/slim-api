<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 6:38 PM
 */

namespace RemoteStaff\Exceptions;


class InvalidSubCategoryException extends \Exception
{

    function __construct()
    {
        parent::__construct("Sub Category must not be empty.");
    }
}