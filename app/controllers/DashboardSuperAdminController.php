<?php

require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../models/DashboardSuperAdminModel.php';

class DashboardSuperAdminController {

    private $model;

    public function __construct($db)
    {
        $this->model = new DashboardSuperAdminModel($db);
    }

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 🔐 sécurité
        AuthMiddleware::check();
        AuthMiddleware::role('super_admin');

        $userId = $_SESSION['user_id'] ?? null;

        if (!$userId) {
            header("Location: /AfricEduc/public/index.php?url=login");
            exit;
        }

        // 📊 données globales système
        $stats = $this->model->getGlobalStats();

        require __DIR__ . '/../views/superadmin/dashboard_superadmin.php';
    }
}