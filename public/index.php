<?php

session_start();

require_once __DIR__ . '/../app/config/database.php';
require_once __DIR__ . '/../app/controllers/LoginController.php';

$url = $_GET['url'] ?? 'dashboard';

switch ($url) {

    case 'dashboard_super_admin':
        require_once __DIR__ . '/../app/controllers/DashboardSuperAdminController.php';
        $controller = new DashboardSuperAdminController($pdo);
        $controller->index();
        break;

    case 'dashboard_admin':
        require_once __DIR__ . '/../app/controllers/DashboardAdminController.php';
        $controller = new DashboardAdminController($pdo);
        $controller->index();
        break;

    case 'dashboard_agent':
        require_once __DIR__ . '/../app/controllers/DashboardAgentController.php';
        $controller = new DashboardAgentController($pdo);
        $controller->index();
        break;

    case 'setup_school':
        require_once __DIR__ . '/../app/controllers/SetupSchoolController.php.php';
        $controller = new SetupSchoolController($pdo);
        $controller->index();
        break;

    case 'manage_agents':
        require_once __DIR__ . '/../app/controllers/ManageAgentController.php';
        $controller = new ManageAgentController($pdo);
        $controller->index();
        break;
        
    case 'students':
        require_once __DIR__ . '/../app/controllers/StudentsController.php';
        $controller = new StudentsController($pdo);
        $controller->index();
        break;

    case 'login':
        require_once __DIR__ . '/../app/controllers/LoginController.php';
        $controller = new LoginController($pdo);
        $controller->index();
        break;
    
    case 'logout':
        require_once __DIR__ . '/../app/controllers/LogoutController.php';
        $controller = new LogoutController();
        $controller->index();
        break;

    default:
        echo "404 - Page introuvable";
}