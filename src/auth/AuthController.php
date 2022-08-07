<?php
declare(strict_types = 1);

namespace auth;

use db\DbController;
require_once '..\db\DbController.php';

class AuthController
{
    public static function isAjax(): bool {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    public function regUser(string $reqBody): string {
        $result = array('message' => 'Bad request', 'status' => 400);
        $dbController = new DbController();
        $userData = json_decode($reqBody);

        $login = $userData->login;
        $email = $userData->email;

        if($dbController->isInfoExists('login', $login)){
            http_response_code(400);
            $result = array('message' => 'User with such login already exists!');
            return json_encode($result);
        }

        if($dbController->isInfoExists('email', $email)){
            http_response_code(400);
            $result = array('message' => 'User with such email already exists!');
            return json_encode($result);
        }

        if($dbController->saveUser(json_encode($userData))){
            $result = array('message' => 'Successful registration');
            return json_encode($result);
        }

        return json_encode($result);
    }

    public function loginUser(string $reqBody): string {
        $dbController = new DbController();
        $userData = json_decode($reqBody);

        $login = $userData->login;
        $password = $userData->password;

        if(!$dbController->isInfoExists('login', $login)){
            http_response_code(400);
            $result = array('message' => 'No such user!');
            return json_encode($result);
        }

        if(!$dbController->isInfoExists('password', $password) && $dbController->isInfoExists('login', $login)){
            http_response_code(400);
            $result = array('message' => 'Wrong password!');
            return json_encode($result);
        }
        else {
            $result = array('message' => "Successful log in");
        }

        return json_encode($result);
    }
}