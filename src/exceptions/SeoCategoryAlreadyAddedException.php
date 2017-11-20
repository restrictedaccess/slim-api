<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 3:55 PM
 */

namespace RemoteStaff\Exceptions;


class SeoCategoryAlreadyAddedException extends \Exception
{

    function __construct()
    {
        parent::__construct("Category Already Added!");
    }
}