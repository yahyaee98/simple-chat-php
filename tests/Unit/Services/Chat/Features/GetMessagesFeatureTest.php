<?php

namespace Tests\Unit\Services\Chat\Features;

use App\Services\Chat\Contracts\MessageRepositoryContract;
use App\Services\Chat\Data\Models\Message;
use App\Services\Chat\Features\GetMessagesFeature;
use Mockery\MockInterface;
use Tests\TestCase;

class GetMessagesFeatureTest extends TestCase
{
    public function test_handle_returns_results_from_repository()
    {
        Message::unguard();

        $feature = new GetMessagesFeature(
            \Mockery::mock(MessageRepositoryContract::class, function (MockInterface $mock) {
                $mock
                    ->shouldReceive('findMessages')
                    ->once()
                    ->with('someone')
                    ->andReturn([new Message(['id' => 'someid'])]);
            })
        );

        $messages = $feature->handle('someone');

        $this->assertEquals(1, count($messages));
        $this->assertEquals('someid', $messages[0]->id);
    }
}
