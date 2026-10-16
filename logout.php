<?php
require_once "auth.php";

$_SESSION = [];
if (ini_get('session.use_cookies')) {
    $parameter = session_get_cookie_params();
    setcookie(session_name(), '', [
        'expires' => time() - 42000,
        'path' => $parameter['path'],
        'domain' => $parameter['domain'],
        'secure' => $parameter['secure'],
        'httponly' => $parameter['httponly'],
        'samesite' => 'Lax',
    ]);
}
session_destroy();
header('Location: index.html');
exit;
