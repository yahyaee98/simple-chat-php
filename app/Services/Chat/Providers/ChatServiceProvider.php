<?php

declare(strict_types=1);

namespace App\Services\Chat\Providers;

use App\Services\Chat\ChatService;
use App\Services\Chat\Contracts\ChatServiceContract;
use App\Services\Chat\Contracts\MessageRepositoryContract;
use App\Services\Chat\Data\Models\Message;
use App\Services\Chat\Data\Repositories\MessageRepository;
use Illuminate\Support\ServiceProvider;

class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            MessageRepositoryContract::class,
            static function (): MessageRepositoryContract {
                return new MessageRepository(Message::query());
            }
        );

        $this->app->singleton(
            ChatServiceContract::class,
            ChatService::class
        );
    }
}
