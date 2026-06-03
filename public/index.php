<?php

session_start();

require_once __DIR__ . '/../app/config/database.php';

$url = $_GET['url'] ?? 'dashboard';

switch ($url) {

    case 'dashboard':
        require_once __DIR__ . '/../app/controllers/DashboardAdminController.php';
        $controller = new DashboardAdminController($pdo);
        $controller->index();
        break;

    case 'students':
        require_once __DIR__ . '/../app/controllers/StudentsController.php';
        $controller = new StudentsController($pdo);
        $controller->index();
        break;

    default:
        echo "404 - Page introuvable";
}