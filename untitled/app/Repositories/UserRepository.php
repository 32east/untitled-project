<?php

namespace App\Repositories;

use App\Models\RefreshToken;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    static public function create(array $request): bool
    {
        return (new User($request))->save();
    }

    static public function findByEmail(string $request): ?User
    {
        return User::query()
            ->where("email", "=", $request)
            ->first();
    }

    static public function findByID(int $id) {
        return User::find($id);
    }
}
