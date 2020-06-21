<?php

declare(strict_types=1);

namespace App\Services\Chat;

use App\Services\Chat\Contracts\ChatServiceContract as Contract;
use App\Services\Chat\Data\Models\Message;
use App\Services\Chat\Features\GetMessagesFeature;
use App\Services\Chat\Features\SendMessageFeature;

class ChatService implements Contract
{
    private GetMessagesFeature $getMessagesFeature;

    private SendMessageFeature $sendMessageFeature;

    public function __construct(
        GetMessagesFeature $getMessagesAction,
        SendMessageFeature $postMessageAction
    ) {
        $this->getMessagesFeature = $getMessagesAction;
        $this->sendMessageFeature = $postMessageAction;
    }

    /**
     * @return array<Message>
     */
    public function getMessages(string $for): array
    {
        return $this->getMessagesFeature
            ->handle($for);
    }

    public function sendMessage(string $from, string $to, string $text): Message
    {
        return $this->sendMessageFeature
            ->handle($from, $to, $text);
    }
}
