<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Data\Models\User;
use App\Data\Responses\ErrorResponse;
use App\Data\Responses\SuccessResponse;
use Firebase\JWT\JWT;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;
use Ramsey\Uuid\Uuid;

/**
 * This controller comes out-of-scope. So, I kept the logic here.
 * It just helps to create a new user and fetch the JWT token for it, so we would be able to
 * make further requests.
 */
class UserController extends Controller
{
    public function register(Request $request, ResponseFactory $responseFactory)
    {
        $this->validate($request, [
            'nickname' => 'required|string|min:3',
        ]);

        $uid = Uuid::uuid4();

        $payload = [
            'iss' => 'backend',
            'sub' => $uid,
            'iat' => time(),
            'exp' => time() + 60 * 60,
        ];

        $token = JWT::encode($payload, config('jwt.secret'));

        try {
            $user = new User([
                'id' => $uid,
                'nickname' => $request->input('nickname'),
            ]);
            $user->save();
        } catch (QueryException $exception) {
            return $responseFactory->json(
                new ErrorResponse('Nickname is already taken'),
                Response::HTTP_PRECONDITION_FAILED
            );
        }

        return $responseFactory->json(
            new SuccessResponse([
                'user' => $user,
                'token' => $token,
            ])
        );
    }
}
