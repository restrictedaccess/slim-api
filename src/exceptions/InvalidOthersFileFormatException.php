<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 9:28 PM
 */

namespace RemoteStaff\Exceptions;


class InvalidOthersFileFormatException extends \Exception
{
    function __construct()
    {
        parent::__construct("Invalid Others file Format! Valid formats: doc, docx, pdf");
    }
}