<?php

namespace App\Exceptions;

use Exception;

class IncorrectPhotoNumberException extends Exception
{
    protected $message = 'Incorrect number photos and models';
}
