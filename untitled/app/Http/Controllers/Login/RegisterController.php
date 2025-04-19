<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\RegisterRequest;
use App\Services\UserService;
use Symfony\Component\HttpFoundation\JsonResponse;

final class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return new JsonResponse([
            "success"=>UserService::registerUser($request->validated()),
        ]);
    }

}
