<?php

declare(strict_types=1);

namespace App\Data\Responses;

use JsonSerializable;

class SuccessResponse implements JsonSerializable
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function jsonSerialize()
    {
        return [
            'data' => $this->data,
        ];
    }
}
