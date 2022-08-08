<?php
declare(strict_types = 1);

namespace auth;

require_once 'AuthController.php';

if(AuthController::isAjax())
{
    if (isset($_COOKIE['ACCESS_TOKEN'])) {
        unset($_COOKIE['ACCESS_TOKEN']);
        setcookie('ACCESS_TOKEN', '', -1, '/');
    }

    $_SESSION = array();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    session_destroy();
}
else {
    http_response_code(400);
    $result = json_encode(array('message' => 'Request was not AJAX!'));
    print_r($result);
}

