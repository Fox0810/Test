<?php
declare(strict_types = 1);

namespace auth;

require_once 'AuthController.php';

$reqBody = file_get_contents('php://input');

if(AuthController::isAjax())
{
    $authController = new AuthController();
    $result = $authController->regUser($reqBody);
}
else {
    http_response_code(400);
    $result = json_encode(array('message' => 'Request was not AJAX!'));
}
print_r($result);
