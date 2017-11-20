<?php
/**
 * Created by PhpStorm.
 * User: IT
 * Date: 10/10/2016
 * Time: 6:39 PM
 */

namespace RemoteStaff\Exceptions;


class SeoSubCategoryAlreadyAddedException extends \Exception
{

    function __construct()
    {
        parent::__construct("Sub category already added.");
    }
}