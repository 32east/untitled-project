<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\LogoutRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class LogoutController extends Controller
{
    public function logout(LogoutRequest $request) : JsonResponse {
        return new JsonResponse([
            "success"=>UserService::logoutUser($request->validated()["token"]),
        ]);
    }
}
