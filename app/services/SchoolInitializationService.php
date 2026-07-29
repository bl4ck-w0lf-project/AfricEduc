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
            $curricula = $this->createCurricula($schoolId, $levels, $series);
            
            // 5. Créer les classes par défaut
            $classes = $this->createDefaultClasses($schoolId, $levels, $series, $academicYear);
            
            // 6. Lier les matières aux classes (chaque classe a ses propres matières)
            $this->linkSubjectsToClasses($schoolId, $classes, $curricula);
            
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
    /**
 * Crée les niveaux scolaires - TOUT EST COLLÈGE
    */
    private function createLevels($schoolId)
    {
        $levelsData = [
            ['name' => '6ème', 'cycle' => 'college', 'order' => 1],
            ['name' => '5ème', 'cycle' => 'college', 'order' => 2],
            ['name' => '4ème', 'cycle' => 'college', 'order' => 3],
            ['name' => '3ème', 'cycle' => 'college', 'order' => 4],
            ['name' => 'Seconde', 'cycle' => 'college', 'order' => 5],  // ✅ changé
            ['name' => 'Première', 'cycle' => 'college', 'order' => 6], // ✅ changé
            ['name' => 'Terminale', 'cycle' => 'college', 'order' => 7] // ✅ changé
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
     * Crée les séries - TOUT EST COLLÈGE
     */
    private function createSeries($schoolId)
    {
        // Les séries A, B, C, D sont pour le second cycle (qui est aussi collège)
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
     * Retourne les curricula créés avec leurs IDs
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
        
        // Liste des curricula à créer
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
        
        $curricula = [];
        $stmtCurriculum = $this->pdo->prepare("
            INSERT IGNORE INTO curricula (school_id, level_id, serie_id, name)
            VALUES (?, ?, ?, ?)
        ");
        
        foreach ($curriculaList as $curriculumData) {
            $levelId = $levels[$curriculumData['level_name']];
            $serieId = $curriculumData['serie_name'] ? $series[$curriculumData['serie_name']] : null;
            $cycle = $curriculumData['cycle'];
            
            $name = $serieId 
                ? "Programme " . $curriculumData['level_name'] . " " . $curriculumData['serie_name'] 
                : "Programme " . $curriculumData['level_name'];
            
            $stmtCurriculum->execute([$schoolId, $levelId, $serieId, $name]);
            $curriculumId = $this->pdo->lastInsertId();
            
            $curricula[$curriculumData['level_name'] . ($serieId ? '_' . $curriculumData['serie_name'] : '')] = [
                'id' => $curriculumId,
                'level_id' => $levelId,
                'serie_id' => $serieId,
                'cycle' => $cycle,
                'level_name' => $curriculumData['level_name'],
                'serie_name' => $curriculumData['serie_name']
            ];
        }
        
        return $curricula;
    }
    
   /**
 * Crée les classes par défaut et retourne la liste des classes créées
 */
private function createDefaultClasses($schoolId, $levels, $series, $academicYear)
{
    $createdClasses = [];
    
    // ============================================
    // PREMIER CYCLE (Collège)
    // level_id = ID du niveau, serie_id = NULL, group_name = A, B, C, D
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
            $classId = $this->pdo->lastInsertId();
            $createdClasses[] = [
                'id' => $classId,
                'level_id' => $levelId,
                'serie_id' => null,
                'level_name' => $levelName,
                'group_name' => $group,
                'serie_name' => null,
                'cycle' => 'premier'
            ];
        }
    }
    
    // ============================================
    // SECOND CYCLE (Lycée)
    // level_id = ID du niveau, serie_id = ID de la série, group_name = Seconde, Première, Terminale
    // ============================================
    $lyceeLevels = ['Seconde', 'Première', 'Terminale'];
    $seriesNames = ['A', 'B', 'C', 'D'];
    
    $stmt = $this->pdo->prepare("
        INSERT IGNORE INTO classes (school_id, level_id, serie_id, group_name, max_students, academic_year)
        VALUES (?, ?, ?, ?, 50, ?)  -- ✅ group_name = le nom du niveau
    ");
    
    foreach ($lyceeLevels as $levelName) {
        $levelId = $levels[$levelName];
        foreach ($seriesNames as $serieName) {
            $serieId = $series[$serieName];
            $stmt->execute([$schoolId, $levelId, $serieId, $levelName, $academicYear]);  // ✅ group_name = $levelName
            $classId = $this->pdo->lastInsertId();
            $createdClasses[] = [
                'id' => $classId,
                'level_id' => $levelId,
                'serie_id' => $serieId,
                'level_name' => $levelName,
                'group_name' => $levelName,  // ✅ group_name = le nom du niveau
                'serie_name' => $serieName,
                'cycle' => 'second'
            ];
        }
    }
    
    return $createdClasses;
}
    
    /**
     * ✅ NOUVEAU : Lie les matières à chaque classe individuellement
     * Chaque classe aura ses propres matières dans curriculum_subjects
     */
    /**
 * ✅ NOUVEAU : Lie les matières à chaque classe individuellement
 * Chaque classe aura ses propres matières dans curriculum_subjects
 */
private function linkSubjectsToClasses($schoolId, $classes, $curricula)
{
    // Récupérer toutes les matières de l'école
    $stmt = $this->pdo->prepare("SELECT id, name FROM subjects WHERE school_id = ?");
    $stmt->execute([$schoolId]);
    $schoolSubjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $subjectsMap = [];
    foreach ($schoolSubjects as $s) {
        $subjectsMap[$s['name']] = $s['id'];
    }
    
    $stmt = $this->pdo->prepare("
        INSERT IGNORE INTO curriculum_subjects (curriculum_id, classe_id, subject_id, coefficient)
        VALUES (?, ?, ?, ?)
    ");
    
    foreach ($classes as $class) {
        // ✅ Construire la clé de la même façon que dans createCurricula()
        $key = $class['level_name'] . ($class['serie_name'] ? '_' . $class['serie_name'] : '');
        $curriculum = $curricula[$key] ?? null;
        
        if (!$curriculum) {
            continue;
        }
        
        // Récupérer les matières pour ce cycle/série
        $subjects = DefaultSubjects::getSubjectsByCycle($class['cycle'], $class['serie_name']);
        
        foreach ($subjects as $subject) {
            if (isset($subjectsMap[$subject['name']])) {
                $stmt->execute([
                    $curriculum['id'],
                    $class['id'],
                    $subjectsMap[$subject['name']],
                    $subject['coefficient']
                ]);
            }
        }
    }
}
}