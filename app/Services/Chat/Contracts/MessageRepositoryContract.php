<?php

declare(strict_types=1);

namespace App\Services\Chat\Contracts;

use App\Services\Chat\Data\Models\Message;

interface MessageRepositoryContract
{
    /**
     * @return array<Message>
     */
    public function findMessages(string $for): array;

    public function persistMessage(Message $message): Message;
}
