<?php

namespace App\Http\Controllers\Login;

use App\DTO\AuthDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Login\TokenRequest;
use App\Services\TokenService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

final class TokenController extends Controller
{
    public function refresh(TokenRequest $request) : JsonResponse {
        $tokens = TokenService::refresh($request->validated()) ?? throw new HttpResponseException(response()->json([
            "success"=>false,
        ], 422));

        $DTO = new AuthDTO($tokens["access_token"], $tokens["refresh_token"]);
        return new JsonResponse($DTO());
    }
}
