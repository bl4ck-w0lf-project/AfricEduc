<?php

require_once __DIR__ . '/../models/DashboardAdminModel.php';
require_once __DIR__ . '/../config/database.php';

class DashboardAdminController {

    private $model;

    public function __construct($db) {
        $this->model = new DashboardAdminModel($db);
    }

    public function index()
{
    $schoolId = $_SESSION['school_id'] ?? null;

    if (!$schoolId) {
        die("school_id absent");
    }

    $isConfigured = $this->model->getIsConfigured($schoolId);

    require __DIR__ . '/../views/admin/dashboard_admin.php';
}


}

?>