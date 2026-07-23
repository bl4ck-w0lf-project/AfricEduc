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
            
            // 1. Créer les niveaux
            $levels = $this->createLevels($schoolId);
            
            // 2. Créer les séries
            $series = $this->createSeries($schoolId);
            
            // 3. Créer les matières par défaut pour l'école
            $this->createDefaultSubjects($schoolId);
            
            // 4. Créer les curricula (programmes) avec leurs matières
            $this->createCurricula($schoolId, $levels, $series);
            
            // 5. Créer les classes par défaut
            $this->createDefaultClasses($schoolId, $levels, $series, $academicYear);
            
            $this->pdo->commit();
            return ['success' => true, 'message' => 'École initialisée avec succès'];
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
    
    /**
     * Crée les niveaux scolaires
     */
    private function createLevels($schoolId)
    {
        $levelsData = [
            ['name' => '6ème', 'cycle' => 'college', 'order' => 1],
            ['name' => '5ème', 'cycle' => 'college', 'order' => 2],
            ['name' => '4ème', 'cycle' => 'college', 'order' => 3],
            ['name' => '3ème', 'cycle' => 'college', 'order' => 4],
            ['name' => 'Seconde', 'cycle' => 'lycee', 'order' => 5],
            ['name' => 'Première', 'cycle' => 'lycee', 'order' => 6],
            ['name' => 'Terminale', 'cycle' => 'lycee', 'order' => 7]
        ];
        
        $createdLevels = [];
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO levels (school_id, name, cycle, `order`)
            VALUES (?, ?, ?, ?)
        ");
        
        foreach ($levelsData as $level) {
            $stmt->execute([$schoolId, $level['name'], $level['cycle'], $level['order']]);
            $createdLevels[$level['name']] = $this->pdo->lastInsertId();
        }
        
        return $createdLevels;
    }
    
    /**
     * Crée les séries pour le lycée
     */
    private function createSeries($schoolId)
    {
        $seriesData = ['A', 'B', 'C', 'D'];
        $createdSeries = [];
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO series (school_id, name) VALUES (?, ?)");
        
        foreach ($seriesData as $serie) {
            $stmt->execute([$schoolId, $serie]);
            $createdSeries[$serie] = $this->pdo->lastInsertId();
        }
        
        return $createdSeries;
    }
    
    /**
     * Crée les matières par défaut pour l'école
     */
    private function createDefaultSubjects($schoolId)
    {
        $defaultSubjects = [
            'Français', 'Mathématiques', 'Anglais', 'Histoire-Géographie',
            'SVT', 'Physique-Chimie', 'EPS', 'Philosophie', 'Espagnol',
            'Allemand', 'Latin', 'Économie', 'Sciences Sociales', 'Comptabilité',
            'Mathématiques Spé', 'Informatique', 'SVT Spécialité', 'Agriculture',
            'PCT', 'Lecture', 'Communication écrite', 'Géographie', 'Education Civique'
        ];
        
        $stmt = $this->pdo->prepare("INSERT IGNORE INTO subjects (school_id, name) VALUES (?, ?)");
        
        foreach ($defaultSubjects as $name) {
            $stmt->execute([$schoolId, $name]);
        }
    }
    
    /**
     * Crée les curricula (programmes) avec leurs matières
     * Utilise les ID des levels et series
     */
    private function createCurricula($schoolId, $levels, $series)
    {
        // Récupérer toutes les matières de l'école
        $stmt = $this->pdo->prepare("SELECT id, name FROM subjects WHERE school_id = ?");
        $stmt->execute([$schoolId]);
        $schoolSubjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $subjectsMap = [];
        foreach ($schoolSubjects as $s) {
            $subjectsMap[$s['name']] = $s['id'];
        }
        
        // Liste des curricula à créer (avec les noms des niveaux/séries)
        $curriculaList = [
            // Collège - level_id = ID du niveau, serie_id = NULL
            ['level_name' => '6ème', 'serie_name' => null, 'cycle' => 'premier'],
            ['level_name' => '5ème', 'serie_name' => null, 'cycle' => 'premier'],
            ['level_name' => '4ème', 'serie_name' => null, 'cycle' => 'premier'],
            ['level_name' => '3ème', 'serie_name' => null, 'cycle' => 'premier'],
            
            // Lycée - level_id = ID du niveau, serie_id = ID de la série
            ['level_name' => 'Seconde', 'serie_name' => 'A', 'cycle' => 'second'],
            ['level_name' => 'Seconde', 'serie_name' => 'B', 'cycle' => 'second'],
            ['level_name' => 'Seconde', 'serie_name' => 'C', 'cycle' => 'second'],
            ['level_name' => 'Seconde', 'serie_name' => 'D', 'cycle' => 'second'],
            
            ['level_name' => 'Première', 'serie_name' => 'A', 'cycle' => 'second'],
            ['level_name' => 'Première', 'serie_name' => 'B', 'cycle' => 'second'],
            ['level_name' => 'Première', 'serie_name' => 'C', 'cycle' => 'second'],
            ['level_name' => 'Première', 'serie_name' => 'D', 'cycle' => 'second'],
            
            ['level_name' => 'Terminale', 'serie_name' => 'A', 'cycle' => 'second'],
            ['level_name' => 'Terminale', 'serie_name' => 'B', 'cycle' => 'second'],
            ['level_name' => 'Terminale', 'serie_name' => 'C', 'cycle' => 'second'],
            ['level_name' => 'Terminale', 'serie_name' => 'D', 'cycle' => 'second'],
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
            $levelId = $levels[$curriculumData['level_name']];
            $serieId = $curriculumData['serie_name'] ? $series[$curriculumData['serie_name']] : null;
            $cycle = $curriculumData['cycle'];
            
            $name = $serieId 
                ? "Programme " . $curriculumData['level_name'] . " " . $curriculumData['serie_name'] 
                : "Programme " . $curriculumData['level_name'];
            
            // Insérer le curriculum
            $stmtCurriculum->execute([$schoolId, $levelId, $serieId, $name]);
            $curriculumId = $this->pdo->lastInsertId();
            
            // Récupérer les matières pour ce curriculum
            $subjects = DefaultSubjects::getSubjectsByCycle($cycle, $curriculumData['serie_name']);
            
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
     * Utilise les ID des levels et series
     */
    private function createDefaultClasses($schoolId, $levels, $series, $academicYear)
    {
        // ============================================
        // PREMIER CYCLE (Collège)
        // level_id = ID du niveau (6ème, 5ème, 4ème, 3ème)
        // serie_id = NULL
        // group_name = A, B, C, D
        // ============================================
        $collegeLevels = ['6ème', '5ème', '4ème', '3ème'];
        $groups = ['A', 'B', 'C', 'D'];
        
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO classes (school_id, level_id, serie_id, group_name, max_students, academic_year)
            VALUES (?, ?, NULL, ?, 50, ?)
        ");
        
        foreach ($collegeLevels as $levelName) {
            $levelId = $levels[$levelName];
            foreach ($groups as $group) {
                $stmt->execute([$schoolId, $levelId, $group, $academicYear]);
            }
        }
        
        // ============================================
        // SECOND CYCLE (Lycée)
        // level_id = ID du niveau (Seconde, Première, Terminale)
        // serie_id = ID de la série (A, B, C, D)
        // group_name = NULL
        // ============================================
        $lyceeLevels = ['Seconde', 'Première', 'Terminale'];
        $seriesNames = ['A', 'B', 'C', 'D'];
        
        $stmt = $this->pdo->prepare("
            INSERT IGNORE INTO classes (school_id, level_id, serie_id, group_name, max_students, academic_year)
            VALUES (?, ?, ?, NULL, 50, ?)
        ");
        
        foreach ($lyceeLevels as $levelName) {
            $levelId = $levels[$levelName];
            foreach ($seriesNames as $serieName) {
                $serieId = $series[$serieName];
                $stmt->execute([$schoolId, $levelId, $serieId, $academicYear]);
            }
        }
    }
}