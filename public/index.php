<?php
require_once __DIR__ . '/../src/views/config/view_main.php';
require_once __DIR__ . '/../src/views/home_view.php';
require_once __DIR__ . '/../src/views/login_view.php';
require_once __DIR__ . '/../src/views/usuario_view.php';
require_once __DIR__ . '/../src/views/paciente_view.php';

$uri = Helper::getCurrentUri();
Log::new(Log::TYPE_CONTROL)->setMessage($_SERVER["REQUEST_METHOD"] . '-' . $uri);
if (Helper::uriRoot($uri) !== Helper::uriLogin()) {
    Auth::verificarAutenticacao();
}

if (preg_match('/^\/storage/', $uri)) {
    require_once __DIR__ . '/../src/services/storage.php';
    return;
}

if (preg_match('/^\/api/i', $uri)) {
    require_once __DIR__ . '/../src/bootstrap.php';
    apiRequest();
    return;
}

function isCurrent(string $option): bool {
    global $uri;
    if (preg_match($option, $uri)) return true;
    return false;
}

if (Helper::uriRoot($uri) === Helper::uriLogin()) {
    new Login_view();
    return;
} else if ($uri === '/') {
    new Home_view();
    return;
} else if (isCurrent('/^\/usuario\/[0-9]+$/')) {
    new Usuario_view();
    return;
} else if (isCurrent('/^\/paciente\/[0-9]+$/')) {
    new Paciente_view();
    return;
}

new View_main();
return;

?>