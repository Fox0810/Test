<?php
declare(strict_types = 1);

namespace auth;

require_once 'AuthController.php';
require_once 'JwtOperations.php';

$reqBody = file_get_contents('php://input');
$decodedReqBody = json_decode($reqBody);

$jwtCreator = new JwtOperations();

$userLogin = $decodedReqBody->login;

$jwt = $jwtCreator->createJwt($userLogin);


$authController = new AuthController();
$result = $authController->loginUser($reqBody);
$decodedResult = json_decode($result);

if(AuthController::isAjax())
{
    if($decodedResult->message === 'Successful log in'){
        if(session_start()) {
            setcookie(
                'ACCESS_TOKEN',
                $jwt,
                [
                    'expires' => strtotime( '+1 hour' ),
                    'path' => '/',
                    'httponly' => true
                ]
            );
        }
    }
}
else {
    http_response_code(400);
    $result = json_encode(array('message' => 'Request was not AJAX!'));
}

print_r($result);