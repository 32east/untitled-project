<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use function Laravel\Prompts\warning;

class Request extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        warning($this->ip() . " : " . $this->url() . " : validation failed : " . $validator->errors());
        throw new HttpResponseException(response()->json(['success' => false], 422));
    }
}
