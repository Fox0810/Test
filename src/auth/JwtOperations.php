<?php
declare(strict_types = 1);

namespace auth;

require_once __DIR__ . '\..\..\vendor\autoload.php';

use DateTimeImmutable;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtOperations
{
    // Generated with SHA256
    private string $TOKEN_KEY = '7145d94eeca4eaec63f0b5f49330f26dce09a97bf1c7e67b87476d04e2b38611';

    public function createJwt(string $userLogin): string {
        $issuedAt = new DateTimeImmutable();

        // Token expire time should be the same as cookie
        $expireTime = $issuedAt->modify('+1 hour')->getTimestamp();
        $serverName = 'http://localhost:8000';

        $payload = [
            'iss' => $serverName,
            'iat' => $issuedAt->getTimestamp(), // when token was generated
            'nbf' => $issuedAt->getTimestamp(), // when token start to be valid
            'exp' => $expireTime,
            'login' => $userLogin
        ];

        return JWT::encode($payload, $this->TOKEN_KEY, 'HS256');
    }

    public function decodeJwt(string $jwt): array {
        return (array) JWT::decode($jwt, new Key($this->TOKEN_KEY, 'HS256'));
    }
}