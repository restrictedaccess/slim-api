<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 9:25 PM
 */

namespace RemoteStaff\Exceptions;


class InvalidSampleWorkFileFormatException extends \Exception
{
    function __construct()
    {
        parent::__construct("Invalid Sample Work file Format! Valid formats: doc, docx, pdf");
    }
}