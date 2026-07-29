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
     * Récupère toutes les classes d'une école avec leurs infos
     */
    public function getClassesBySchool($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.*,
                l.name as level_name,
                s.name as serie_name,
                (SELECT COUNT(*) FROM students WHERE class_id = c.id) as students_count
            FROM classes c
            LEFT JOIN levels l ON c.level_id = l.id
            LEFT JOIN series s ON c.serie_id = s.id
            WHERE c.school_id = ?
            ORDER BY c.level_id, c.serie_id, c.group_name
        ");
        $stmt->execute([$schoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les statistiques des classes
     */
    public function getStats($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                COUNT(*) as total_classes,
                SUM(max_students) as total_capacity,
                (SELECT COUNT(*) FROM students WHERE school_id = ?) as total_students
            FROM classes
            WHERE school_id = ?
        ");
        $stmt->execute([$schoolId, $schoolId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère une classe par son ID
     */
    public function getClassById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                c.*,
                l.name as level_name,
                s.name as serie_name,
                (SELECT COUNT(*) FROM students WHERE class_id = c.id) as students_count
            FROM classes c
            LEFT JOIN levels l ON c.level_id = l.id
            LEFT JOIN series s ON c.serie_id = s.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * ✅ CORRIGÉ : Crée une nouvelle classe
     */
    public function createClass($data)
    {
        try {
            // S'assurer que les valeurs sont des INT ou NULL
            $levelId = !empty($data['level_id']) ? (int)$data['level_id'] : null;
            $serieId = !empty($data['serie_id']) ? (int)$data['serie_id'] : null;
            $maxStudents = !empty($data['max_students']) ? (int)$data['max_students'] : 50;
            $academicYear = !empty($data['academic_year']) ? (int)$data['academic_year'] : date('Y');
            
            // group_name peut être NULL pour le second cycle
            $groupName = !empty($data['group_name']) ? $data['group_name'] : null;

            $stmt = $this->pdo->prepare("
                INSERT INTO classes (school_id, level_id, serie_id, group_name, max_students, academic_year)
                VALUES (?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $data['school_id'],
                $levelId,
                $serieId,
                $groupName,
                $maxStudents,
                $academicYear
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log('[ClassesModel] Erreur createClass: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * ✅ CORRIGÉ : Met à jour une classe
     */
    public function updateClass($id, $data)
    {
        try {
            // S'assurer que les valeurs sont des INT ou NULL
            $levelId = !empty($data['level_id']) ? (int)$data['level_id'] : null;
            $serieId = !empty($data['serie_id']) ? (int)$data['serie_id'] : null;
            $maxStudents = !empty($data['max_students']) ? (int)$data['max_students'] : 50;
            $academicYear = !empty($data['academic_year']) ? (int)$data['academic_year'] : date('Y');
            $groupName = !empty($data['group_name']) ? $data['group_name'] : null;

            $stmt = $this->pdo->prepare("
                UPDATE classes 
                SET level_id = ?, serie_id = ?, group_name = ?, max_students = ?, academic_year = ?
                WHERE id = ?
            ");
            $stmt->execute([
                $levelId,
                $serieId,
                $groupName,
                $maxStudents,
                $academicYear,
                $id
            ]);
            return true;
        } catch (PDOException $e) {
            error_log('[ClassesModel] Erreur updateClass: ' . $e->getMessage());
            return false;
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
            return true;
        } catch (PDOException $e) {
            error_log('[ClassesModel] Erreur deleteClass: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Récupère les niveaux disponibles pour une école
     */
    public function getLevelsBySchool($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT id, name, cycle FROM levels WHERE school_id = ?
            ORDER BY `order`
        ");
        $stmt->execute([$schoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les séries disponibles pour une école
     */
    public function getSeriesBySchool($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT id, name FROM series WHERE school_id = ?
            ORDER BY name
        ");
        $stmt->execute([$schoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les matières d'une classe via curriculum_subjects avec classe_id
     */
    public function getSubjectsByClass($classId)
    {
        $stmt = $this->pdo->prepare("
            SELECT 
                s.name as subject_name,
                cs.coefficient
            FROM curriculum_subjects cs
            JOIN subjects s ON cs.subject_id = s.id
            WHERE cs.classe_id = ?
            ORDER BY cs.coefficient DESC
        ");
        $stmt->execute([$classId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}