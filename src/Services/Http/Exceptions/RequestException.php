<?php
declare(strict_types=1);

namespace App\Services\Http\Exceptions;

use App\Exceptions\BaseException;
use App\Services\Http\Interfaces\HttpExceptionInterface;

class RequestException extends BaseException implements HttpExceptionInterface
{
    //
}
