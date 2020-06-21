<?php

namespace Tests\Unit\Services\Chat;

use App\Services\Chat\ChatService;
use App\Services\Chat\Features\GetMessagesFeature;
use App\Services\Chat\Features\SendMessageFeature;
use Mockery\MockInterface;
use Tests\TestCase;

class ChatServiceTest extends TestCase
{
    public function test_get_messages_calls_corresponding_features()
    {
        $service = new ChatService(
            \Mockery::mock(GetMessagesFeature::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->with('someone');
            }),
            \Mockery::mock(SendMessageFeature::class, function (MockInterface $mock) {
            }),
        );

        $service->getMessages('someone');
    }

    public function test_send_message_calls_corresponding_features()
    {
        $service = new ChatService(
            \Mockery::mock(GetMessagesFeature::class, function (MockInterface $mock) {
            }),
            \Mockery::mock(SendMessageFeature::class, function (MockInterface $mock) {
                $mock->shouldReceive('handle')
                    ->once()
                    ->with('someone', 'someotherone', 'sometext');
            }),
        );

        $service->sendMessage('someone', 'someotherone', 'sometext');
    }
}
