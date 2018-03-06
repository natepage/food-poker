<?php
declare(strict_types=1);

namespace App\Exceptions;

use Exception;

class BaseException extends Exception
{
    /**
     * Get array representation of exception.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'code' => $this->code,
            'message' => $this->message
        ];
    }
}
