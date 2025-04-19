<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\TokenRepository;
use App\Repositories\UserRepository;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\warning;

class UserService
{
    static public function registerUser(array $request): bool
    {
        return UserRepository::create($request);
    }

    static public function authUser(array $request) : ?User
    {
        $user = UserRepository::findByEmail($request["email"]);
        if (!isset($user) || !Hash::check($request["password"], $user["password"])) {
            return null;
        }

        return $user;
    }

    static public function logoutUser(string $accessToken) : bool
    {
        try {
            $data = JWT::decode($accessToken, new Key(env("JWT_KEY_ACCESS_TOKEN"), "HS256"));
        } catch (Exception $exception) {
            return false;
        }

        $token = TokenRepository::findOneBy("fingerprint", $data->fingerprint);
        if ($token === null) {
            return false;
        }

        TokenRepository::delete($token);

        return true;
    }
}
