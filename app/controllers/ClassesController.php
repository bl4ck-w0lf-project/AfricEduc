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
            header("Location: /AfricEduc/public/index.php?url=dashboard_admin");
            exit;
        }

        $classes = $this->model->getClassesBySchool($schoolId);
        $stats = $this->model->getStats($schoolId);
        $levels = $this->model->getLevelsBySchool($schoolId);
        $series = $this->model->getSeriesBySchool($schoolId);

        require_once __DIR__ . '/../views/admin/classes.php';
    }

    /**
     * Récupère les données pour le formulaire (AJAX)
     */
    public function getFormData()
    {
        header('Content-Type: application/json');
        $schoolId = $_SESSION['school_id'] ?? null;
        
        if (!$schoolId) {
            echo json_encode(['error' => 'École non trouvée']);
            exit;
        }

        $levels = $this->model->getLevelsBySchool($schoolId);
        $series = $this->model->getSeriesBySchool($schoolId);

        echo json_encode([
            'levels' => $levels,
            'series' => $series
        ]);
        exit;
    }

    /**
     * Récupère les détails d'une classe (AJAX)
     */
    public function getClass()
    {
        header('Content-Type: application/json');
        $id = $_GET['id'] ?? null;
        
        if (!$id) {
            echo json_encode(['error' => 'ID manquant']);
            exit;
        }

        $class = $this->model->getClassById($id);
        if (!$class) {
            echo json_encode(['error' => 'Classe non trouvée']);
            exit;
        }

        // Récupérer les matières
        $subjects = $this->model->getSubjectsByClass($id);

        echo json_encode([
            'class' => $class,
            'subjects' => $subjects
        ]);
        exit;
    }

    /**
     * Crée une nouvelle classe (AJAX)
     */
    public function store()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit;
        }

        $schoolId = $_SESSION['school_id'] ?? null;
        if (!$schoolId) {
            echo json_encode(['error' => 'École non trouvée']);
            exit;
        }

        $data = [
            'school_id' => $schoolId,
            'level_id' => $_POST['level_id'] ?? null,
            'serie_id' => $_POST['serie_id'] ?? null,
            'group_name' => $_POST['group_name'] ?? null,
            'max_students' => $_POST['max_students'] ?? 50,
            'academic_year' => $_POST['academic_year'] ?? date('Y')
        ];

        // Validation
        if (!$data['level_id']) {
            echo json_encode(['error' => 'Le niveau est obligatoire']);
            exit;
        }

        $result = $this->model->createClass($data);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Classe créée avec succès', 'id' => $result]);
        } else {
            echo json_encode(['error' => 'Erreur lors de la création']);
        }
        exit;
    }

    /**
     * Met à jour une classe (AJAX)
     */
    public function update()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID manquant']);
            exit;
        }

        $data = [
            'level_id' => $_POST['level_id'] ?? null,
            'serie_id' => $_POST['serie_id'] ?? null,
            'group_name' => $_POST['group_name'] ?? null,
            'max_students' => $_POST['max_students'] ?? 50,
            'academic_year' => $_POST['academic_year'] ?? date('Y')
        ];

        if (!$data['level_id']) {
            echo json_encode(['error' => 'Le niveau est obligatoire']);
            exit;
        }

        $result = $this->model->updateClass($id, $data);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Classe modifiée avec succès']);
        } else {
            echo json_encode(['error' => 'Erreur lors de la modification']);
        }
        exit;
    }

    /**
     * Supprime une classe (AJAX)
     */
    public function delete()
    {
        header('Content-Type: application/json');
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit;
        }

        $id = $_POST['id'] ?? null;
        if (!$id) {
            echo json_encode(['error' => 'ID manquant']);
            exit;
        }

        $result = $this->model->deleteClass($id);
        
        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Classe supprimée avec succès']);
        } else {
            echo json_encode(['error' => 'Erreur lors de la suppression']);
        }
        exit;
    }
}