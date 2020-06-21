<?php

declare(strict_types=1);

namespace App\Services\Chat\Features;

use App\Services\Chat\Contracts\MessageRepositoryContract;
use App\Services\Chat\Data\Models\Message;

class GetMessagesFeature
{
    private MessageRepositoryContract $messageRepository;

    public function __construct(MessageRepositoryContract $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    /**
     * @return array<Message>
     */
    public function handle(string $for): array
    {
        return $this->messageRepository
            ->findMessages($for);
    }
}
