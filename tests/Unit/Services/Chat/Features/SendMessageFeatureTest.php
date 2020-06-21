<?php

namespace Tests\Unit\Services\Chat\Features;

use App\Services\Chat\Contracts\MessageRepositoryContract;
use App\Services\Chat\Data\Models\Message;
use App\Services\Chat\Features\SendMessageFeature;
use Mockery\MockInterface;
use Tests\TestCase;

class SendMessageFeatureTest extends TestCase
{
    public function test_handle_passes_message_to_repository()
    {
        Message::unguard();

        $feature = new SendMessageFeature(
            \Mockery::mock(MessageRepositoryContract::class, function (MockInterface $mock) {
                $mock
                    ->shouldReceive('persistMessage')
                    ->once()
                    ->withArgs(function (Message $message) {
                        return strlen($message->id) > 3 &&
                            $message->from === 'someone' &&
                            $message->to === 'someotherone' &&
                            isset($message->created_at);
                    })
                    ->andReturn(new Message([]));
            })
        );

        $feature->handle('someone', 'someotherone', 'hello');
    }
}
