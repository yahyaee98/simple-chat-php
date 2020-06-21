<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Responses\SuccessResponse;
use App\Services\Chat\Contracts\ChatServiceContract;
use Illuminate\Http\Request;
use Laravel\Lumen\Http\ResponseFactory;

class ChatController extends Controller
{
    private ChatServiceContract $chatService;

    public function __construct(ChatServiceContract $chatService)
    {
        $this->chatService = $chatService;
    }

    public function getInbox(Request $request, ResponseFactory $responseFactory)
    {
        return $responseFactory->json(
            new SuccessResponse([
                'inbox' => [
                    'messages' => $this->chatService
                        ->getMessages($request->user()->id),
                ],
            ])
        );
    }

    public function postMessage(Request $request, ResponseFactory $responseFactory)
    {
        $this->validate($request, [
            'to' => ['required', 'string', 'min:3'],
            'text' => ['required', 'string', 'min:1'],
        ]);

        return $responseFactory->json(
            new SuccessResponse([
                'message' => $this->chatService
                    ->sendMessage(
                        $request->user()->id,
                        $request->input('to'),
                        $request->input('text')
                    )
            ])
        );
    }
}
