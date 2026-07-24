<?php
// app/controllers/MatieresController.php

require_once __DIR__ . '/../models/MatieresModel.php';

class MatieresController
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
        $this->model = new MatieresModel($pdo);
    }

    /**
     * Affiche la liste des matières par classe
     */
    public function index()
    {
        $schoolId = $_SESSION['school_id'] ?? null;
        if (!$schoolId) {
            header("Location: /AfricEduc/public/index.php?url=dashboard_admin");
            exit;
        }

        $classes = $this->model->getClassesWithMatieres($schoolId);
        $stats = $this->model->getStats($schoolId);
        $allMatieres = $this->model->getAllMatieres($schoolId);
        $uniqueMatieres = $this->model->getUniqueMatieresBySchool($schoolId);

        require_once __DIR__ . '/../views/admin/matieres.php';
    }

    /**
     * Ajoute une matière à une classe (AJAX)
     */
    public function addMatiereToClasse()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit;
        }

        $classeId = $_POST['classe_id'] ?? null;
        $matiereId = $_POST['matiere_id'] ?? null;
        $coefficient = $_POST['coefficient'] ?? 1;

        if (!$classeId || !$matiereId) {
            echo json_encode(['error' => 'Données manquantes']);
            exit;
        }

        $result = $this->model->addMatiereToClasse($classeId, $matiereId, $coefficient);

        if (isset($result['error'])) {
            echo json_encode(['error' => $result['error']]);
        } else {
            echo json_encode(['success' => true, 'message' => 'Matière ajoutée avec succès']);
        }
        exit;
    }

    /**
     * Met à jour le coefficient d'une matière (AJAX)
     */
    public function updateCoeff()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['error' => 'Méthode non autorisée']);
            exit;
        }

        $id = $_POST['id'] ?? null;
        $coefficient = $_POST['coefficient'] ?? null;

        if (!$id || !$coefficient) {
            echo json_encode(['error' => 'Données manquantes']);
            exit;
        }

        $result = $this->model->updateCoefficient($id, $coefficient);

        if (isset($result['error'])) {
            echo json_encode(['error' => $result['error']]);
        } else {
            echo json_encode(['success' => true, 'message' => 'Coefficient mis à jour avec succès']);
        }
        exit;
    }

    /**
     * Retire une matière d'une classe (AJAX)
     */
    public function removeMatiereFromClasse()
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

        $result = $this->model->removeMatiereFromClasse($id);

        if (isset($result['error'])) {
            echo json_encode(['error' => $result['error']]);
        } else {
            echo json_encode(['success' => true, 'message' => 'Matière retirée avec succès']);
        }
        exit;
    }
}