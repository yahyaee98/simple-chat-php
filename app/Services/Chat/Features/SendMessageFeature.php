<?php

declare(strict_types=1);

namespace App\Services\Chat\Features;

use App\Services\Chat\Contracts\MessageRepositoryContract;
use App\Services\Chat\Data\Models\Message;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class SendMessageFeature
{
    private MessageRepositoryContract $messageRepository;

    public function __construct(MessageRepositoryContract $messageRepository)
    {
        $this->messageRepository = $messageRepository;
    }

    public function handle(string $from, string $to, string $text): Message
    {
        $message = new Message();

        $message->id = Uuid::uuid4();
        $message->from = $from;
        $message->to = $to;
        $message->text = $text;
        $message->created_at = Carbon::now()->format(Carbon::DEFAULT_TO_STRING_FORMAT);

        return $this->messageRepository
            ->persistMessage($message);
    }
}
