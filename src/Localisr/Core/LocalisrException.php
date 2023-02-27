<?php

namespace Siantech\Localisr\Core;

/**
 * The exception thrown when the Localisr Client recieves an error from the API.
 */
class LocalisrException extends \Exception
{
    var $message;
    var $httpStatusCode;
    var $localisrApiErrorCode;
}
