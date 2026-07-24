<?php
// app/models/MatieresModel.php

class MatieresModel
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Récupère toutes les classes avec leurs matières
     */
    public function getClassesWithMatieres($schoolId)
    {
        // Récupérer toutes les classes
        $stmt = $this->pdo->prepare("
            SELECT 
                c.id,
                CONCAT(l.name, ' ', c.group_name) as nom
            FROM classes c
            LEFT JOIN levels l ON c.level_id = l.id
            WHERE c.school_id = ?
            ORDER BY l.name, c.group_name
        ");
        $stmt->execute([$schoolId]);
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Pour chaque classe, récupérer ses matières
        foreach ($classes as &$classe) {
            $stmt = $this->pdo->prepare("
                SELECT 
                    cs.id as curriculum_subject_id,
                    s.id as subject_id,
                    s.name,
                    cs.coefficient
                FROM curriculum_subjects cs
                JOIN subjects s ON cs.subject_id = s.id
                JOIN curricula cu ON cs.curriculum_id = cu.id
                WHERE cu.school_id = ? 
                    AND cu.level_id = (
                        SELECT level_id FROM classes WHERE id = ?
                    )
                    AND (cu.serie_id = (
                        SELECT serie_id FROM classes WHERE id = ?
                    ) OR (cu.serie_id IS NULL AND (
                        SELECT serie_id FROM classes WHERE id = ?
                    ) IS NULL))
            ");
            $stmt->execute([$schoolId, $classe['id'], $classe['id'], $classe['id']]);
            $classe['matieres'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $classe['nb_matieres'] = count($classe['matieres']);
        }

        return $classes;
    }

    /**
     * Récupère toutes les matières disponibles pour une école
     */
    public function getAllMatieres($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT id, name FROM subjects WHERE school_id = ?
            ORDER BY name
        ");
        $stmt->execute([$schoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère les statistiques
     */
    public function getStats($schoolId)
    {
        // Total matières
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM subjects WHERE school_id = ?");
        $stmt->execute([$schoolId]);
        $totalMatieres = $stmt->fetch(PDO::FETCH_ASSOC);

        // Total classes
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM classes WHERE school_id = ?");
        $stmt->execute([$schoolId]);
        $totalClasses = $stmt->fetch(PDO::FETCH_ASSOC);

        // Total curriculum_subjects
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) as total 
            FROM curriculum_subjects cs
            JOIN curricula cu ON cs.curriculum_id = cu.id
            WHERE cu.school_id = ?
        ");
        $stmt->execute([$schoolId]);
        $totalCurriculumSubjects = $stmt->fetch(PDO::FETCH_ASSOC);

        // Moyenne matières par classe
        $stmt = $this->pdo->prepare("
            SELECT 
                ROUND(AVG(nb_matieres), 1) as avg
            FROM (
                SELECT 
                    c.id,
                    COUNT(cs.id) as nb_matieres
                FROM classes c
                LEFT JOIN curricula cu ON c.school_id = cu.school_id 
                    AND c.level_id = cu.level_id 
                    AND (c.serie_id = cu.serie_id OR (c.serie_id IS NULL AND cu.serie_id IS NULL))
                LEFT JOIN curriculum_subjects cs ON cu.id = cs.curriculum_id
                WHERE c.school_id = ?
                GROUP BY c.id
            ) as stats
        ");
        $stmt->execute([$schoolId]);
        $avg = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'total_matieres' => $totalMatieres['total'] ?? 0,
            'total_classes' => $totalClasses['total'] ?? 0,
            'total_curriculum_subjects' => $totalCurriculumSubjects['total'] ?? 0,
            'avg_by_class' => $avg['avg'] ?? 0
        ];
    }

    /**
     * Ajoute une matière à une classe
     */
    public function addMatiereToClasse($classeId, $matiereId, $coefficient)
    {
        try {
            // Récupérer le curriculum de la classe
            $stmt = $this->pdo->prepare("
                SELECT cu.id 
                FROM curricula cu
                JOIN classes c ON c.school_id = cu.school_id 
                    AND c.level_id = cu.level_id 
                    AND (c.serie_id = cu.serie_id OR (c.serie_id IS NULL AND cu.serie_id IS NULL))
                WHERE c.id = ?
            ");
            $stmt->execute([$classeId]);
            $curriculum = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$curriculum) {
                return ['error' => 'Aucun curriculum trouvé pour cette classe'];
            }

            // Vérifier si la matière existe déjà
            $stmt = $this->pdo->prepare("
                SELECT id FROM curriculum_subjects 
                WHERE curriculum_id = ? AND subject_id = ?
            ");
            $stmt->execute([$curriculum['id'], $matiereId]);
            if ($stmt->fetch()) {
                return ['error' => 'Cette matière est déjà associée à cette classe'];
            }

            // Ajouter la matière
            $stmt = $this->pdo->prepare("
                INSERT INTO curriculum_subjects (curriculum_id, subject_id, coefficient)
                VALUES (?, ?, ?)
            ");
            $stmt->execute([$curriculum['id'], $matiereId, $coefficient]);

            return ['success' => true, 'id' => $this->pdo->lastInsertId()];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

    /**
     * Met à jour le coefficient d'une matière dans une classe
     */
    public function updateCoefficient($curriculumSubjectId, $coefficient)
    {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE curriculum_subjects 
                SET coefficient = ? 
                WHERE id = ?
            ");
            $stmt->execute([$coefficient, $curriculumSubjectId]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

   /**
     * ✅ CORRIGÉ : Retire une matière d'une classe UNIQUEMENT
     * Supprime le lien dans curriculum_subjects, PAS la matière de subjects
     */
    public function removeMatiereFromClasse($curriculumSubjectId)
    {
        try {
            // Vérifier d'abord que le lien existe
            $stmt = $this->pdo->prepare("
                SELECT cs.id, s.name as matiere_nom, 
                       CONCAT(
                           CASE 
                               WHEN c.level_id IS NOT NULL AND c.serie_id IS NULL THEN CONCAT(c.level_id, ' ', c.group_name)
                               WHEN c.level_id IS NULL AND c.serie_id IS NOT NULL THEN CONCAT(c.group_name, ' ', c.serie_id)
                               ELSE c.group_name
                           END
                       ) as classe_nom
                FROM curriculum_subjects cs
                JOIN curricula cu ON cs.curriculum_id = cu.id
                JOIN classes c ON c.school_id = cu.school_id 
                    AND c.level_id = cu.level_id 
                    AND (c.serie_id = cu.serie_id OR (c.serie_id IS NULL AND cu.serie_id IS NULL))
                JOIN subjects s ON cs.subject_id = s.id
                WHERE cs.id = ?
            ");
            $stmt->execute([$curriculumSubjectId]);
            $info = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$info) {
                return ['error' => 'Lien matière-classe non trouvé'];
            }

            // ✅ Supprimer UNIQUEMENT le lien (pas la matière)
            $stmt = $this->pdo->prepare("DELETE FROM curriculum_subjects WHERE id = ?");
            $stmt->execute([$curriculumSubjectId]);

            return [
                'success' => true, 
                'message' => "Matière '{$info['matiere_nom']}' retirée de la classe '{$info['classe_nom']}'",
                'info' => $info
            ];
        } catch (PDOException $e) {
            return ['error' => $e->getMessage()];
        }
    }

        /**
     * Récupère toutes les matières uniques associées à des classes via curricula
     * Utilisé pour le filtre par matière
     */
    public function getUniqueMatieresBySchool($schoolId)
    {
        $stmt = $this->pdo->prepare("
            SELECT DISTINCT 
                s.id,
                s.name
            FROM subjects s
            JOIN curriculum_subjects cs ON s.id = cs.subject_id
            JOIN curricula cu ON cs.curriculum_id = cu.id
            WHERE cu.school_id = ?
            ORDER BY s.name
        ");
        $stmt->execute([$schoolId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}