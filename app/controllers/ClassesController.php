<?php
// app/controllers/ClassesController.php

require_once __DIR__ . '/../models/ClassesModel.php';

class ClassesController
{
    private $pdo;
    private $model;

    public function __construct($pdo)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Vérifier si l'utilisateur est connecté
        if (!isset($_SESSION['user_id'])) {
            header("Location: /AfricEduc/public/index.php?url=login");
            exit;
        }

        $this->pdo = $pdo;
        $this->model = new ClassesModel($pdo);
    }

    /**
     * Affiche la liste des classes
     */
    public function index()
    {
        $schoolId = $_SESSION['school_id'] ?? null;
        if (!$schoolId) {
            // Rediriger si pas d'école
            header("Location: /AfricEduc/public/index.php?url=dashboard_admin");
            exit;
        }

        $classes = $this->model->getClassesBySchool($schoolId);
        $stats = $this->model->getStats($schoolId);

        require_once __DIR__ . '/../views/admin/classes.php';
    }

    /**
     * Affiche le formulaire de création d'une classe
     */
    public function create()
    {
        $schoolId = $_SESSION['school_id'] ?? null;
        if (!$schoolId) {
            header("Location: /AfricEduc/public/index.php?url=dashboard_admin");
            exit;
        }

        $cycles = $this->model->getAvailableCycles();
        $levels = $this->model->getLevelsBySchool($schoolId);
        $series = $this->model->getSeriesBySchool($schoolId);

        require_once __DIR__ . '/../views/admin/classes_create.php';
    }

    /**
     * Enregistre une nouvelle classe
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $schoolId = $_SESSION['school_id'] ?? null;
        if (!$schoolId) {
            $_SESSION['errors'] = ['global' => 'École non trouvée'];
            header("Location: /AfricEduc/public/index.php?url=classes&action=create");
            exit;
        }

        // Validation des données
        $errors = [];
        $cycle = $_POST['cycle'] ?? '';
        $level = $_POST['level'] ?? '';
        $serie = $_POST['serie'] ?? null;
        $group = $_POST['group'] ?? '';
        $maxStudents = (int)($_POST['max_students'] ?? 50);
        $academicYear = $_POST['academic_year'] ?? date('Y');

        if (empty($cycle)) {
            $errors['cycle'] = "Le cycle est obligatoire.";
        }
        if (empty($level)) {
            $errors['level'] = "Le niveau est obligatoire.";
        }
        if ($cycle === 'second' && empty($serie)) {
            $errors['serie'] = "La série est obligatoire pour le second cycle.";
        }
        if (empty($group) && $cycle === 'premier') {
            $errors['group'] = "Le nom du groupe est obligatoire.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            header("Location: /AfricEduc/public/index.php?url=classes&action=create");
            exit;
        }

        // Créer la classe
        $result = $this->model->createClass([
            'school_id' => $schoolId,
            'level_id' => $level,
            'serie_id' => $serie,
            'group_name' => $cycle === 'premier' ? $group : null,
            'max_students' => $maxStudents,
            'academic_year' => $academicYear,
            'cycle' => $cycle
        ]);

        if ($result['success']) {
            $_SESSION['success'] = "Classe créée avec succès !";
            header("Location: /AfricEduc/public/index.php?url=classes");
        } else {
            $_SESSION['errors'] = ['global' => $result['message']];
            header("Location: /AfricEduc/public/index.php?url=classes&action=create");
        }
        exit;
    }

    /**
     * Affiche les détails d'une classe
     */
    public function show()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /AfricEduc/public/index.php?url=classes");
            exit;
        }

        $class = $this->model->getClassById($id);
        if (!$class) {
            $_SESSION['errors'] = ['global' => 'Classe non trouvée'];
            header("Location: /AfricEduc/public/index.php?url=classes");
            exit;
        }

        // Récupérer les matières de la classe via le curriculum
        $subjects = $this->model->getSubjectsByClass($id);

        require_once __DIR__ . '/../views/admin/classes_show.php';
    }

    /**
     * Affiche le formulaire d'édition d'une classe
     */
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header("Location: /AfricEduc/public/index.php?url=classes");
            exit;
        }

        $class = $this->model->getClassById($id);
        if (!$class) {
            $_SESSION['errors'] = ['global' => 'Classe non trouvée'];
            header("Location: /AfricEduc/public/index.php?url=classes");
            exit;
        }

        $cycles = $this->model->getAvailableCycles();
        $levels = $this->model->getLevelsBySchool($class['school_id']);
        $series = $this->model->getSeriesBySchool($class['school_id']);

        require_once __DIR__ . '/../views/admin/classes_edit.php';
    }

    /**
     * Met à jour une classe
     */
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['errors'] = ['global' => 'ID de classe manquant'];
            header("Location: /AfricEduc/public/index.php?url=classes");
            exit;
        }

        // Validation
        $errors = [];
        $maxStudents = (int)($_POST['max_students'] ?? 50);
        $academicYear = $_POST['academic_year'] ?? date('Y');

        if (empty($maxStudents) || $maxStudents < 0) {
            $errors['max_students'] = "La capacité doit être un nombre positif.";
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header("Location: /AfricEduc/public/index.php?url=classes&action=edit&id=" . $id);
            exit;
        }

        $result = $this->model->updateClass($id, [
            'max_students' => $maxStudents,
            'academic_year' => $academicYear
        ]);

        if ($result['success']) {
            $_SESSION['success'] = "Classe mise à jour avec succès !";
            header("Location: /AfricEduc/public/index.php?url=classes");
        } else {
            $_SESSION['errors'] = ['global' => $result['message']];
            header("Location: /AfricEduc/public/index.php?url=classes&action=edit&id=" . $id);
        }
        exit;
    }

    /**
     * Supprime une classe
     */
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            return;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['errors'] = ['global' => 'ID de classe manquant'];
            header("Location: /AfricEduc/public/index.php?url=classes");
            exit;
        }

        $result = $this->model->deleteClass($id);

        if ($result['success']) {
            $_SESSION['success'] = "Classe supprimée avec succès !";
        } else {
            $_SESSION['errors'] = ['global' => $result['message']];
        }

        header("Location: /AfricEduc/public/index.php?url=classes");
        exit;
    }
}
