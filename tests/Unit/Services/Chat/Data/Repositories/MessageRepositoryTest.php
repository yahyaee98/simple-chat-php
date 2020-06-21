<?php

namespace Tests\Unit\Services\Chat\Data\Repositories;

use App\Services\Chat\Data\Models\Message;
use App\Services\Chat\Data\Repositories\MessageRepository;
use Illuminate\Database\Eloquent\Builder;
use Mockery\MockInterface;
use Tests\TestCase;

class MessageRepositoryTest extends TestCase
{
    public function test_find_messages_fetch_right_messages_from_provided_query_builder()
    {
        $builderMock = \Mockery::mock(Builder::class, function (MockInterface $mock) {
            $mock
                ->shouldReceive('newQuery')->once()->andReturnSelf()
                ->shouldReceive('where')->with(['to' => 'someone'])->once()->andReturnSelf()
                ->shouldReceive('with')->with(['author'])->once()->andReturnSelf()
                ->shouldReceive('latest')->with('created_at')->once()->andReturnSelf()
                ->shouldReceive('get')->once()->andReturnSelf()
                ->shouldReceive('toArray')->once()->andReturn([]);
        });

        $repository = new MessageRepository($builderMock);

        $repository->findMessages("someone");
    }

    public function test_persist_saves_model()
    {
        Message::unguard();

        $messageProperties = [
            'id' => 'someid',
            'from' => 'someone',
            'to' => 'someotheronw',
            'text' => 'atext',
            'created_at' => '2020-01-01 11:11:11',
        ];

        $message = new Message($messageProperties);

        $builderMock = \Mockery::mock(Builder::class,
            function (MockInterface $mock) use ($messageProperties, $message) {
                $mock
                    ->shouldReceive('newQuery')->once()->andReturnSelf()
                    ->shouldReceive('insert')->with($messageProperties)->once()->andReturn($message);
            });

        $repository = new MessageRepository($builderMock);

        $repository->persistMessage($message);
    }
}
