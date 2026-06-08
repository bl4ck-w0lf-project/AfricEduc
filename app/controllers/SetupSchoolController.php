<?php

class SetupSchoolController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function index()
    {
        require_once __DIR__ . '/../config/database.php';
        require_once __DIR__ . '/../models/SetupSchoolModel.php';
        

        if (!isset($_SESSION['user_id'])) {
            header("Location: /AfricEduc/public/index.php?url=login");
            exit;
        }

        $model = new SchoolConfigModel($this->pdo);

        $periodType = $_POST['period_system'] ?? 'semestre';

        $data = [
            'school_id' => $_SESSION['school_id'],
            'period_type' => $periodType,
            'nb_periods' => $periodType === 'trimestre' ? 3 : 2,

            'use_interro' => isset($_POST['hw_mi']) ? 1 : 0,
            'use_d1' => isset($_POST['hw_d1']) ? 1 : 0,
            'use_d2' => isset($_POST['hw_d2']) ? 1 : 0,
            'use_dh' => isset($_POST['hw_dh']) ? 1 : 0,

            'use_conduite' => isset($_POST['conduct_enabled']) ? 1 : 0,
            'conduite_coef' => $_POST['conduct_coefficient'] ?? 1,
            'conduite_max' => $_POST['conduct_max'] ?? 20,

            'passing_grade' => 10,
            'poids_s1' => 1,
            'poids_s2' => 2,

            'currency' => $_POST['currency'] ?? 'FCFA',
            'is_configured' => 1
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!in_array($data['period_type'], ['semestre', 'trimestre'])) {
                die("Type de période invalide");
            }

            if ($data['conduite_coef'] < 0) {
                die("Coefficient invalide");
            }

            if ($data['conduite_max'] < 1) {
                die("Note max invalide");
            }

            $success = $model->saveConfig($data);

            if ($success) {
                header("Location: /AfricEduc/public/index.php?url=dashboard_admin");
                exit;
            }

            echo "Erreur insertion";
        }

        require __DIR__ . '/../views/admin/setup_school.php';
    }
}