<?php
declare(strict_types = 1);

require_once __DIR__ . '\..\vendor\autoload.php';

use eftec\bladeone\BladeOne;

$viewsDir = __DIR__ . '\..\views';
$blade = new BladeOne($viewsDir);

$errorMsg = '';
switch (http_response_code()){
    case 401:
        $errorMsg = http_response_code() . ": Unauthorized";
        break;
    case 400:
        $errorMsg = http_response_code() . ": Bad request";
        break;
}

try {
    echo $blade->run('error', ['errorMsg' => $errorMsg]);
}
catch (Exception $e) {}