<?php

declare(strict_types=1);

namespace App\Data\Responses;

use JsonSerializable;

class ErrorResponse implements JsonSerializable
{
    private string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function jsonSerialize(): array
    {
        return [
            'error' => [
                'message' => $this->message,
            ],
        ];
    }
}
