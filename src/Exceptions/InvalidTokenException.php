<?php

namespace BitterByter\JWT\Exceptions;

use Exception;

/**
 * Exception class for invalid token.
 */
class InvalidTokenException extends Exception
{
    protected $message = 'Invalid token';
}
