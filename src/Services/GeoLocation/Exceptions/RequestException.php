<?php
declare(strict_types=1);

namespace App\Services\GeoLocation\Exceptions;

use App\Exceptions\BaseException;
use App\Services\GeoLocation\Interfaces\GeoLocationExceptionInterface;

class RequestException extends BaseException implements GeoLocationExceptionInterface
{
    //
}
