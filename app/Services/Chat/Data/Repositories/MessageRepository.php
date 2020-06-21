<?php

declare(strict_types=1);

namespace App\Services\Chat\Data\Repositories;

use App\Services\Chat\Contracts\MessageRepositoryContract as Contract;
use App\Services\Chat\Data\Models\Message;
use Illuminate\Database\Eloquent\Builder;

class MessageRepository implements Contract
{
    private $queryBuilder;

    public function __construct(Builder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    /**
     * @return array<Message>
     */
    public function findMessages(string $for): array
    {
        return $this->queryBuilder
            ->newQuery()
            ->where(['to' => $for])
            ->with(['author'])
            ->latest('created_at')
            ->get()
            ->toArray();
    }

    public function persistMessage(Message $message): Message
    {
        $this->queryBuilder
            ->newQuery()
            ->insert([
                'id' => $message->id,
                'from' => $message->from,
                'to' => $message->to,
                'text' => $message->text,
                'created_at' => $message->created_at,
            ]);

        return $message;
    }
}
