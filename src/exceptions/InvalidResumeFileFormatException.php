<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 9:27 PM
 */

namespace RemoteStaff\Exceptions;


class InvalidResumeFileFormatException extends \Exception
{
    function __construct()
    {
        parent::__construct("Invalid Resume file Format! Valid formats: doc, docx, pdf");
    }
}