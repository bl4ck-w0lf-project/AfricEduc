<?php

require_once __DIR__ . '/../helpers/default_subjects.php';

class SchoolInitializationService
{
    private $pdo;
    
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    /**
     * Initialise toute la structure scolaire pour une nouvelle école
     */
    public function initializeSchool($schoolId, $academicYear = null)
    {
        if (!$academicYear) {
            $academicYear = date('Y');
        }
        
        try {
            $this->pdo->beginTransaction();
            
            // 1. Créer les matières par défaut pour l'école
            $this->createDefaultSubjects($schoolId);
            
            // 2. Créer les curricula (programmes) avec leurs matières
            $this->createCurricula($schoolId);
            
            // 3. Créer les classes par défaut
            $this->createDefaultClasses($schoolId, $academicYear);
            
            $this->pdo->commit();
            return ['success' => true, 'message' => 'École initialisée avec succès'];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Crée les matières par défaut pour l'école
     */
    private function createDefaultSubjects($schoolId)
    {
        // Matières par défaut (toutes les matières possibles)
        $defaultSubjects = [
            'Français',
            'Mathématiques',
            'Anglais',
            'Histoire-Géographie',
            'SVT',
            'Physique-Chimie',
            'EPS',
            'Philosophie',
            'Espagnol',
            'Allemand',
            'Latin',
            'Économie',
            'Sciences Sociales',
            'Comptabilité',
            'Mathématiques Spé',
            'Informatique',
            'SVT Spécialité',
            'Agriculture',
            'PCT',
            'Lecture',
            'Communication écrite',
            'Géographie',
            'Education Civique'
        ];
        
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO subjects (school_id, name) VALUES (?, ?)");
        
        foreach ($defaultSubjects as $name) {
            $stmt->execute([$schoolId, $name]);
        }
    }
    
    /**
     * Crée les curricula (programmes) avec leurs matières
     */
    private function createCurricula($schoolId)
    {
        // Récupérer toutes les matières de l'école
        $stmt = $this->pdo->prepare("SELECT id, name FROM subjects WHERE school_id = ?");
        $stmt->execute([$schoolId]);
        $schoolSubjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $subjectsMap = [];
        foreach ($schoolSubjects as $s) {
            $subjectsMap[$s['name']] = $s['id'];
        }
        
        // Liste des curricula à créer (niveau + série)
        $curriculaList = [
            // Collège
            ['level_id' => '6ème', 'serie_id' => null, 'cycle' => 'premier'],
            ['level_id' => '5ème', 'serie_id' => null, 'cycle' => 'premier'],
            ['level_id' => '4ème', 'serie_id' => null, 'cycle' => 'premier'],
            ['level_id' => '3ème', 'serie_id' => null, 'cycle' => 'premier'],
            
            // Lycée
            ['level_id' => 'Seconde', 'serie_id' => 'A', 'cycle' => 'second'],
            ['level_id' => 'Seconde', 'serie_id' => 'B', 'cycle' => 'second'],
            ['level_id' => 'Seconde', 'serie_id' => 'C', 'cycle' => 'second'],
            ['level_id' => 'Seconde', 'serie_id' => 'D', 'cycle' => 'second'],
            
            ['level_id' => 'Première', 'serie_id' => 'A', 'cycle' => 'second'],
            ['level_id' => 'Première', 'serie_id' => 'B', 'cycle' => 'second'],
            ['level_id' => 'Première', 'serie_id' => 'C', 'cycle' => 'second'],
            ['level_id' => 'Première', 'serie_id' => 'D', 'cycle' => 'second'],
            
            ['level_id' => 'Terminale', 'serie_id' => 'A', 'cycle' => 'second'],
            ['level_id' => 'Terminale', 'serie_id' => 'B', 'cycle' => 'second'],
            ['level_id' => 'Terminale', 'serie_id' => 'C', 'cycle' => 'second'],
            ['level_id' => 'Terminale', 'serie_id' => 'D', 'cycle' => 'second'],
        ];
        
        $stmtCurriculum = $this->pdo->prepare("
            INSERT IGNORE INTO curricula (school_id, level_id, serie_id, name)
            VALUES (?, ?, ?, ?)
        ");
        
        $stmtSubject = $this->pdo->prepare("
            INSERT IGNORE INTO curriculum_subjects (curriculum_id, subject_id, coefficient)
            VALUES (?, ?, ?)
        ");
        
        foreach ($curriculaList as $curriculumData) {
            $levelId = $curriculumData['level_id'];
            $serieId = $curriculumData['serie_id'];
            $cycle = $curriculumData['cycle'];
            
            // Nom du curriculum
            $name = $serieId ? "Programme " . $levelId . " " . $serieId : "Programme " . $levelId;
            
            // Insérer le curriculum
            $stmtCurriculum->execute([$schoolId, $levelId, $serieId, $name]);
            $curriculumId = $this->pdo->lastInsertId();
            
            // Récupérer les matières pour ce curriculum
            $subjects = DefaultSubjects::getSubjectsByCycle($cycle, $serieId);
            
            foreach ($subjects as $subject) {
                if (isset($subjectsMap[$subject['name']])) {
                    $stmtSubject->execute([
                        $curriculumId,
                        $subjectsMap[$subject['name']],
                        $subject['coefficient']
                    ]);
                }
            }
        }
    }
    
    /**
     * Crée les classes par défaut
     */
    private function createDefaultClasses($schoolId, $academicYear)
    {
        // Classes du collège (4 niveaux × 4 groupes)
        $collegeLevels = ['6ème', '5ème', '4ème', '3ème'];
        $groups = ['A', 'B', 'C', 'D'];
        
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO classes (school_id, level_id, serie_id, group_name, max_students, academic_year)
            VALUES (?, ?, NULL, ?, 50, ?)
        ");
        
        foreach ($collegeLevels as $level) {
            foreach ($groups as $group) {
                $stmt->execute([$schoolId, $level, $group, $academicYear]);
            }
        }
        
        // Classes du lycée (3 niveaux × 4 séries)
        $lyceeLevels = ['Seconde', 'Première', 'Terminale'];
        $series = ['A', 'B', 'C', 'D'];
        
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO classes (school_id, level_id, serie_id, group_name, max_students, academic_year)
            VALUES (?, ?, ?, NULL, 50, ?)
        ");
        
        foreach ($lyceeLevels as $level) {
            foreach ($series as $serie) {
                $stmt->execute([$schoolId, $level, $serie, $academicYear]);
            }
        }
    }
}
