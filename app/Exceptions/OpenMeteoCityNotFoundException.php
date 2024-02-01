<?php

namespace App\Exceptions;

use Exception;

class OpenMeteoCityNotFoundException extends Exception
{
    public $code = 422;

    public function __toString(): string
    {
        return 'There is no city like that.';
    }
}
