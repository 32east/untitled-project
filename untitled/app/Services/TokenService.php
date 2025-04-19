<?php

namespace App\Services;

use App\Models\TokenCreator;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use function Laravel\Prompts\warning;

class TokenService
{
    static public function refresh(array $request) : ?array
    {
        $foundedToken = TokenRepository::findOneBy("refresh_token", $request["token"]);
        if ($foundedToken === null) {
            return null;
        }

        $user = UserRepository::findByID($foundedToken["user_id"]);
        if ($user === null) {
            return null;
        }

        TokenRepository::delete($foundedToken);
        return TokenCreator::createAccessAndRefreshTokens($user);
    }
}
