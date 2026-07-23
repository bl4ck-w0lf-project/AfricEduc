<?php
// app/models/ClassesModel.php

class ClassesModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les classes d'une école
     */
    public function getClassesBySchool($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.*,
                cu.name as curriculum_name
            FROM classes c
            LEFT JOIN curricula cu ON c.school_id = cu.school_id 
                AND c.level_id = cu.level_id 
                AND (c.serie_id = cu.serie_id OR (c.serie_id IS NULL AND cu.serie_id IS NULL))
            WHERE c.school_id = ?
            ORDER BY c.level_id, c.serie_id, c.group_name
        ");
        $stmt->execute([$schoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les statistiques
     */
    public function getStats($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                COUNT(*) as total_classes,
                SUM(max_students) as total_capacity
            FROM classes
            WHERE school_id = ?
        ");
        $stmt->execute([$schoolId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une classe par son ID
     */
    public function getClassById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.*, s.name as school_name
            FROM classes c
            JOIN schools s ON c.school_id = s.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les niveaux disponibles pour une école
     */
    public function getLevelsBySchool($schoolId)
    {
        // On retourne les niveaux possibles (sans table levels)
        return [
            ['id' => '6ème', 'name' => '6ème', 'cycle' => 'premier'],
            ['id' => '5ème', 'name' => '5ème', 'cycle' => 'premier'],
            ['id' => '4ème', 'name' => '4ème', 'cycle' => 'premier'],
            ['id' => '3ème', 'name' => '3ème', 'cycle' => 'premier'],
            ['id' => 'Seconde', 'name' => 'Seconde', 'cycle' => 'second'],
            ['id' => 'Première', 'name' => 'Première', 'cycle' => 'second'],
            ['id' => 'Terminale', 'name' => 'Terminale', 'cycle' => 'second']
        ];
    }

    /**
     * Récupère les séries disponibles
     */
    public function getSeriesBySchool($schoolId)
    {
        return [
            ['id' => 'A', 'name' => 'Série A'],
            ['id' => 'B', 'name' => 'Série B'],
            ['id' => 'C', 'name' => 'Série C'],
            ['id' => 'D', 'name' => 'Série D']
        ];
    }

    /**
     * Récupère les cycles disponibles
     */
    public function getAvailableCycles()
    {
        return [
            ['id' => 'premier', 'name' => 'Premier cycle (Collège)'],
            ['id' => 'second', 'name' => 'Second cycle (Lycée)']
        ];
    }

    /**
     * Crée une nouvelle classe
     */
    public function createClass($data)
    {
        try {
            $stmt = $this->pdo->prepare("
                INSERT INTO classes (
                    school_id, level_id, serie_id, group_name, max_students, academic_year
                ) VALUES (?, ?, ?, ?, ?, ?)
            ");

            $stmt->execute([
                $data['school_id'],
                $data['level_id'],
                $data['serie_id'] ?? null,
                $data['group_name'] ?? null,
                $data['max_students'] ?? 50,
                $data['academic_year'] ?? date('Y')
            ]);

            $classId = $this->pdo->lastInsertId();

            // Vérifier si un curriculum existe déjà pour ce niveau/série
            $curriculum = $this->getOrCreateCurriculum($data['school_id'], $data['level_id'], $data['serie_id'], $data['cycle'] ?? 'premier');

            return ['success' => true, 'class_id' => $classId, 'curriculum_id' => $curriculum];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Récupère ou crée un curriculum pour un niveau/série
     */
    private function getOrCreateCurriculum($schoolId, $levelId, $serieId, $cycle)
    {
        // Vérifier si le curriculum existe déjà
        $stmt = $this->pdo->prepare("
            SELECT id FROM curricula 
            WHERE school_id = ? AND level_id = ? AND (serie_id = ? OR (serie_id IS NULL AND ? IS NULL))
        ");
        $stmt->execute([$schoolId, $levelId, $serieId, $serieId]);
        $existing = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existing) {
            return $existing['id'];
        }

        // Créer le curriculum
        $name = $serieId ? "Programme " . $levelId . " " . $serieId : "Programme " . $levelId;
        $stmt = $this->pdo->prepare("
            INSERT INTO curricula (school_id, level_id, serie_id, name)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$schoolId, $levelId, $serieId, $name]);
        $curriculumId = $this->pdo->lastInsertId();

        // Ajouter les matières par défaut
        require_once __DIR__ . '/../helpers/default_subjects.php';
        
        $subjects = DefaultSubjects::getSubjectsByCycle($cycle, $serieId);
        
        // Récupérer les IDs des matières pour cette école
        $stmt = $this->pdo->prepare("SELECT id, name FROM subjects WHERE school_id = ?");
        $stmt->execute([$schoolId]);
        $schoolSubjects = [];
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $s) {
            $schoolSubjects[$s['name']] = $s['id'];
        }

        $stmt = $this->pdo->prepare("
            INSERT INTO curriculum_subjects (curriculum_id, subject_id, coefficient)
            VALUES (?, ?, ?)
        ");

        foreach ($subjects as $subject) {
            if (isset($schoolSubjects[$subject['name']])) {
                $stmt->execute([$curriculumId, $schoolSubjects[$subject['name']], $subject['coefficient']]);
            }
        }

        return $curriculumId;
    }

    /**
     * Met à jour une classe
     */
    public function updateClass($id, $data)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE classes 
                SET max_students = ?, academic_year = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $data['max_students'],
                $data['academic_year'],
                $id
            ]);

            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Supprime une classe
     */
    public function deleteClass($id)
    {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM classes WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Récupère les matières d'une classe via son curriculum
     */
    public function getSubjectsByClass($classId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                s.name as subject_name,
                cs.coefficient
            FROM classes c
            JOIN curricula cu ON c.school_id = cu.school_id 
                AND c.level_id = cu.level_id 
                AND (c.serie_id = cu.serie_id OR (c.serie_id IS NULL AND cu.serie_id IS NULL))
            JOIN curriculum_subjects cs ON cu.id = cs.curriculum_id
            JOIN subjects s ON cs.subject_id = s.id
            WHERE c.id = ?
            ORDER BY cs.coefficient DESC
        ");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
