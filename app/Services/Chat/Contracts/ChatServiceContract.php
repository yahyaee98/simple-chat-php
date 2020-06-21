<?php

declare(strict_types=1);

namespace App\Services\Chat\Contracts;

use App\Services\Chat\Data\Models\Message;

interface ChatServiceContract
{
    /**
     * @return array<Message>
     */
    public function getMessages(string $for): array;

    public function sendMessage(string $from, string $to, string $text): Message;
}
