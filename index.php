<?php
declare(strict_types = 1);

require_once __DIR__ . '\vendor\autoload.php';

use eftec\bladeone\BladeOne;

use auth\JwtOperations;
require_once 'src\auth\JwtOperations.php';
use middleware\AuthMiddleware;
require_once 'src\middleware\AuthMiddleware.php';

$viewsDir = __DIR__ . '\views';
$blade = new BladeOne($viewsDir);

$authMiddleware = new AuthMiddleware();
$jwtOperations = new JwtOperations();

if($authMiddleware->checkCookie() && $authMiddleware->checkSession()){
    $jwt = $authMiddleware->getJwtFromCookie();
    $authMiddleware->redirectToHomePage();
}

try {
    echo $blade->run('index');
}
catch (Exception $e) {}
