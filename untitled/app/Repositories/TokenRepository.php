<?php

namespace App\Repositories;

use App\Models\RefreshToken;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\Redis;
use function Laravel\Prompts\warning;
use Illuminate\Database\Eloquent\Collection;
class TokenRepository
{
    static public function create(array $request): bool
    {
        self::updateInRedis($request);

        return (new RefreshToken([
            "user_id"=>$request["user"]["id"],
            "ip_address"=>request()->ip(),
            "fingerprint"=>$request["fingerprint"],
            "refresh_token"=>$request["refresh_token"],
        ]))->save();
    }

    static public function delete(RefreshToken $token): ?bool
    {
        try {
            $data = JWT::decode($token["refresh_token"], new Key(env("JWT_KEY_REFRESH_TOKEN"), "HS256"));
        } catch (Exception $e) {
            return false;
        }

        Redis::del('QuickTokens:'.$data->id);
        return $token->delete();
    }

    static public function findOneBy(string $column, string $request): ?RefreshToken
    {
        return RefreshToken::query()
            ->where($column, "=", $request)
            ->first();
    }

    static public function findByUserId(int $id) : Collection {
        return RefreshToken::query()
            ->where("user_id", "=", $id)
            ->get();
    }

    static public function updateInRedis(array $request) : void {
        $data = [
            "access_token"=>$request["access_token"],
            "refresh_token"=>$request["refresh_token"],
            "ip_address"=>request()->ip()
        ];

        Redis::setex('QuickTokens:'.$request["user"]["id"], 300, json_encode($data));
    }
}
