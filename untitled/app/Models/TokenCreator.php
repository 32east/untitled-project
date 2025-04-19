<?php

namespace App\Models;

use App\Core\RandomString;
use App\Repositories\TokenRepository;
use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redis;
use PhpParser\Token;
use Random\RandomException;
use function Laravel\Prompts\warning;
use function Sodium\randombytes_buf;

/**
 *
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TokenCreator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TokenCreator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TokenCreator query()
 * @mixin \Eloquent
 */
class TokenCreator extends Model
{
    static public function createAccessToken(array $request, array... $ext) : string {
        return JWT::encode([
            "id"=>$request["user"]["id"],
            "fingerprint"=>$request["fingerprint"],
            "exp"=>time()+3600,
            ...$ext,
        ], env("JWT_KEY_ACCESS_TOKEN"), "HS256");
    }

    static public function createRefreshToken(array $request, array... $ext) : string {
        return JWT::encode([
            "id"=>$request["user"]["id"],
            "fingerprint"=>$request["fingerprint"],
            "exp"=>time()+3600*24*3,
            ...$ext,
        ], env("JWT_KEY_REFRESH_TOKEN"), "HS256");
    }

    /**
     * @throws RandomException
     */
    static public function createAccessAndRefreshTokens(User $user) : array {
        $cachedTokens = Redis::get('QuickTokens:'.$user["id"]);

        if ($cachedTokens !== null) {
            $data = json_decode($cachedTokens, true);

            if (request()->ip() === $data["ip_address"]) {
                return $data;
            }
        }

        $request = [
            "fingerprint"=>RandomString::generate(),
            "user"=>$user,
        ];

        $tokens = [
            "access_token"=>self::createAccessToken($request),
            "refresh_token"=>self::createRefreshToken($request)
        ];

        TokenRepository::create([
            ...$request,
            ...$tokens
        ]);

        return $tokens;
    }

    static public function deleteAllOld() : void {
        $records = RefreshToken::whereDate('created_at',  '<', Carbon::today()->toDateString())->get();
        foreach ($records as $record) {
            TokenRepository::delete($record);
        }
    }
}
