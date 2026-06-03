<?php

require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../models/DashboardAgentModel.php';

class DashboardAgentController {

    private $model;

    public function __construct($db)
    {
        $this->model = new DashboardAgentModel($db);
    }

    public function index()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    AuthMiddleware::check();
    AuthMiddleware::role('agent');

    $schoolId = $_SESSION['school_id'] ?? null;
    $userId = $_SESSION['user_id'] ?? null;

    // ❌ NE PAS envoyer agent vers setup_school
    if (!$userId) {
        header("Location: /AfricEduc/public/index.php?url=login");
        exit;
    }

    

    $stats = $this->model->getDashboardStats($schoolId, $userId);

    require __DIR__ . '/../views/agents/dashboard_agent.php';
}
}