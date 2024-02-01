<?php

declare(strict_types=1);

namespace App\Exceptions;

class OpenMeteoCityNotFoundException extends \Exception
{
    public $code = 422;

    public function __toString(): string
    {
        return 'There is no city like that.';
    }
}
