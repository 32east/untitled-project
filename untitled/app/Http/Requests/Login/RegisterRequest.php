<?php

namespace App\Http\Requests\Login;

use App\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function authorize(): bool
    {
        return $this->header("Authorization") === null;
    }

    public function rules(): array
    {
        return [
            "first_name"=>"required|string|min:3|max:78",
            "secondary_name"=>"required|string|min:3|max:78",
            "email"=>"required|email|min:3|max:78|unique:users",
            "password"=>"required|min:8|max:32"
        ];
    }
}
