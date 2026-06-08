<?php
session_start();

require_once __DIR__ . '/../models/SetupSchoolModel.php';
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$model = new SchoolConfigModel($pdo);

$periodType = $_POST['period_system'] ?? 'semestre';

$nbPeriods = ($periodType === 'semestre') ? 2 : 3;

$data = [
    'school_id' => $_SESSION['school_id'],

    'period_type' => $_POST['period_system'] ?? 'semestre',
    'nb_periods' => $_POST['period_system'] === 'trimestre' ? 3 : 2,

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

// validation simple backend
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