<?php

declare(strict_types=1);

namespace App\Providers;

use App\Data\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AuthServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $provideUser = static function ($request) {
            $authorizationHeader = $request->header('Authorization');
            if (
                ! isset($authorizationHeader) ||
                strlen($authorizationHeader) < 8
            ) {
                return null;
            }

            $jwtToken = substr($authorizationHeader, 7);
            try {
                $claims = JWT::decode(
                    $jwtToken,
                    config('jwt.secret'),
                    config('jwt.algos')
                );
            } catch (Throwable $throwable) {
                return null;
            }

            return User::where('id', $claims->sub)->first();
        };

        $this->app['auth']
            ->viaRequest('api', $provideUser);
    }
}
