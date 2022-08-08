<?php
declare(strict_types = 1);

namespace middleware;

use auth\JwtOperations;

class AuthMiddleware
{
    private string $COOKIE_NAME = 'ACCESS_TOKEN';

    public function checkSession(): bool {
        if(session_status() === PHP_SESSION_ACTIVE || isset($_COOKIE["PHPSESSID"])){
            return true;
        }
        return false;
    }

    public function checkCookie(): bool {
        if(isset($_COOKIE[$this->COOKIE_NAME])) {
            return true;
        }
        return false;
    }

    public function getJwtFromCookie(): string {
        return $_COOKIE[$this->COOKIE_NAME];
    }

    public function redirectToHomePage(): void {
        $url = 'http://localhost:8000/web/home.php';
        ob_start();
        header('Location: '. $url);
        ob_end_flush();
        die();
    }

    public function redirectToErrorPage(int $errorCode, string $relativeErrorPagePath): void {
        http_response_code($errorCode);
        include($relativeErrorPagePath);
        die();
    }


    public function loadHomePage(string $jwt): string {
        $jwtOperations = new JwtOperations();
        $data = $jwtOperations->decodeJwt($jwt);
        return 'Hello ' . $data['login'];
    }
}
