<?php
declare(strict_types = 1);

namespace crypt;

class Hash
{
    // Generated with SHA256
    private string $STATIC_SALT = '9d0b7844ddfd0b1ef24d3660050ca1da904363620488b0ee55e0b87d8e5c77a4';

    public static function hashPassword(string $password): string {
        $saltedPassword = $password . (new Hash)->STATIC_SALT;
        return sha1($saltedPassword);
    }

    public static function comparePasswords(string $checkPassword, string $hashedPassword): bool {
        return (new Hash)->hashPassword($checkPassword) === $hashedPassword;
    }
}