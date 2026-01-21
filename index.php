<?php
define('ROOT', dirname(__DIR__));   // IMPORTANT

require ROOT.'/config/config.php';
require ROOT.'/app/controllers/AuthController.php';
require ROOT.'/app/controllers/ShopController.php';
require ROOT.'/app/controllers/ProfileController.php';

$page = $_GET['page'] ?? 'welcome';

switch ($page) {

    case 'login':        (new AuthController())->login(); break;
    case 'register':     (new AuthController())->register(); break;
    case 'forgot':       (new AuthController())->forgot(); break;
    case 'change':       (new AuthController())->change(); break;
    case 'logout':       (new AuthController())->logout(); break;

    case 'home':         (new ShopController())->home(); break;
    case 'profile':      (new ProfileController())->index(); break;
    case 'profile_update':
                          (new ProfileController())->update(); break;

    default:
        require ROOT.'/app/views/welcome.php';
}
