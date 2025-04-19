<?php

namespace App\Http\Controllers\Login;

use App\DTO\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login\AuthRequest;
use App\Models\TokenCreator;
use App\Services\UserService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

final class AuthController extends Controller
{
    public function auth(AuthRequest $request): JsonResponse
    {
        $user = UserService::authUser($request->validated())
            ?? throw new HttpResponseException(response()->json([
                "success"=>false,
            ], 422));


        $tokens = TokenCreator::createAccessAndRefreshTokens($user);
        $DTO = new AuthDTO($tokens["access_token"], $tokens["refresh_token"]);

        return new JsonResponse($DTO());
    }

}
