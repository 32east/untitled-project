<?php

namespace App\DTO;

class AuthDTO
{
    private string $accessToken;
    private string $refreshToken;
    public function __construct(string $accessToken, string $refreshToken) {
        $this->accessToken = $accessToken;
        $this->refreshToken = $refreshToken;
    }

    public function __invoke(): array
    {
        return [
            "success"=>true,
            "access_token"=>$this->accessToken,
            "refresh_token"=>$this->refreshToken,
        ];
    }
}
