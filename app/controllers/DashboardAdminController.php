<?php
session_start();

require_once __DIR__ . '/models/DashboardAdminModel.php';
require_once __DIR__ . '/../config/database.php';

class DashboardAdminController {

    private $model;

    public function __construct($db) {
        $this->model = new DashboardAdminModel($db);
    }

    public function index() {

    $schoolId = $_SESSION['school_id'];

    $isConfigured = (int) $this->model->isSchoolConfigured($schoolId);
    $data = [
        'isConfigured' => $isConfigured
    ];

    require "../views/admin/dashboard_admin.php";
}

}
?>