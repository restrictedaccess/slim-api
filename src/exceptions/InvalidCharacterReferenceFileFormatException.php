<?php
/**
 * Created by PhpStorm.
 * User: IT STAFF
 * Date: 9/22/2016
 * Time: 9:26 PM
 */

namespace RemoteStaff\Exceptions;


class InvalidCharacterReferenceFileFormatException extends \Exception
{
    function __construct()
    {
        parent::__construct("Invalid Character Reference file Format! Valid formats: doc, docx, pdf");
    }
}