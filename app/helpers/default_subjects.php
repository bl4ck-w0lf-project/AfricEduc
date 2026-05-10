<?php
// ============================================================
//  africeduc — app/helpers/default_subjects.php
//  Insertion automatique des matières par défaut
//  Appelé par ClassController quand une classe est créée
//
//  Table cible : subjects (school_id, class_id, name, coefficient)
//  DB : utilise 'classes' (PAS 'groups') — schéma collège only
// ============================================================

class DefaultSubjects
{
    // ============================================================
    //  MÉTHODE PRINCIPALE
    //  Insère les matières par défaut selon le cycle
    //  Appelée à la création d'une classe
    //
    //  @param PDO    $pdo      Connexion DB
    //  @param int    $schoolId ID de l'école (depuis la session)
    //  @param int    $classId  ID de la classe créée
    //  @param string $cycle    'premier' ou 'second'
    //  @param string $serie    null | 'A' | 'B' | 'C' | 'D' (second cycle)
    //  @return int   Nombre de matières insérées
    // ============================================================
    public static function insertForClass(
        PDO    $pdo,
        int    $schoolId,
        int    $classId,
        string $cycle,
        ?string $serie = null
    ): int {
        $subjects = self::getSubjectsByCycle($cycle, $serie);

        if (empty($subjects)) return 0;

        try {
            $pdo->beginTransaction();

            $stmt = $pdo->prepare('
                INSERT INTO subjects (school_id, class_id, name, coefficient, is_default)
                VALUES (?, ?, ?, ?, 1)
            ');

            $count = 0;
            foreach ($subjects as $subject) {
                $stmt->execute([
                    $schoolId,
                    $classId,
                    $subject['name'],
                    $subject['coefficient'],
                ]);
                $count++;
            }

            $pdo->commit();
            return $count;

        } catch (PDOException $e) {
            $pdo->rollBack();
            error_log('[africeduc][DefaultSubjects] Erreur insertion: ' . $e->getMessage());
            return 0;
        }
    }

    // ============================================================
    //  MÉTHODE DE PREVIEW (sans insertion DB)
    //  Retourne la liste des matières sans toucher à la DB
    //  Utilisée pour afficher un aperçu dans le formulaire
    // ============================================================
    public static function getSubjectsByCycle(string $cycle, ?string $serie = null): array
    {
        if ($cycle === 'premier') {
            return self::premierCycle();
        }

        if ($cycle === 'second') {
            return self::secondCycle($serie);
        }

        return [];
    }

    // ============================================================
    //  MATIÈRES — PREMIER CYCLE (6ème → 3ème)
    // ============================================================
    private static function premierCycle(): array
    {
        return [
            ['name' => 'Mathématiques',        'coefficient' => 4],
            ['name' => 'PCT',                  'coefficient' => 3],
            ['name' => 'SVT',                  'coefficient' => 2],
            ['name' => 'Lecture',              'coefficient' => 3],
            ['name' => 'Communication écrite', 'coefficient' => 3],
            ['name' => 'Anglais',              'coefficient' => 2],
            ['name' => 'EPS',                  'coefficient' => 1],
        ];
    }

    // ============================================================
    //  MATIÈRES — SECOND CYCLE (2nde → Terminale)
    //  Tronc commun + matières selon la série
    // ============================================================
    private static function secondCycle(?string $serie = null): array
    {
        // Tronc commun à toutes les séries
        $common = [
            ['name' => 'Mathématiques', 'coefficient' => 4],
            ['name' => 'PCT',           'coefficient' => 3],
            ['name' => 'SVT',           'coefficient' => 2],
            ['name' => 'Français',      'coefficient' => 3],
            ['name' => 'Philosophie',   'coefficient' => 2],
            ['name' => 'Anglais',       'coefficient' => 2],
            ['name' => 'EPS',           'coefficient' => 1],
        ];

        // Matières spécifiques par série
        $serieSubjects = self::getSerieSubjects($serie);

        return array_merge($common, $serieSubjects);
    }

    // ============================================================
    //  MATIÈRES SPÉCIFIQUES PAR SÉRIE (second cycle)
    //  L'admin peut modifier ces matières après création
    // ============================================================
    public static function getSerieSubjects(?string $serie): array
    {
        switch (strtoupper((string)$serie)) {
            case 'A':
                // Série A : Lettres, Langues et Sciences Humaines
                return [
                    ['name' => 'Histoire-Géographie', 'coefficient' => 3],
                    ['name' => 'Espagnol',             'coefficient' => 2],
                    ['name' => 'Allemand',             'coefficient' => 2],
                    ['name' => 'Latin',                'coefficient' => 1],
                ];

            case 'B':
                // Série B : Sciences Économiques et Sociales
                return [
                    ['name' => 'Économie',             'coefficient' => 3],
                    ['name' => 'Histoire-Géographie',  'coefficient' => 2],
                    ['name' => 'Sciences Sociales',    'coefficient' => 2],
                    ['name' => 'Comptabilité',         'coefficient' => 2],
                ];

            case 'C':
                // Série C : Mathématiques et Sciences Physiques
                return [
                    ['name' => 'Mathématiques Spé', 'coefficient' => 5],
                    ['name' => 'Physique-Chimie',    'coefficient' => 4],
                    ['name' => 'Informatique',       'coefficient' => 2],
                ];

            case 'D':
                // Série D : Sciences de la Vie et de la Terre
                return [
                    ['name' => 'SVT Spécialité',     'coefficient' => 4],
                    ['name' => 'Physique-Chimie',    'coefficient' => 3],
                    ['name' => 'Agriculture',        'coefficient' => 2],
                ];

            default:
                // Pas de série précisée (2nde générale ou configuration personnalisée)
                return [];
        }
    }

    // ============================================================
    //  UTILITAIRE : liste des séries disponibles
    // ============================================================
    public static function getAvailableSeries(): array
    {
        return [
            'A' => 'Série A — Lettres, Langues et Sciences Humaines',
            'B' => 'Série B — Sciences Économiques et Sociales',
            'C' => 'Série C — Mathématiques et Sciences Physiques',
            'D' => 'Série D — Sciences de la Vie et de la Terre',
        ];
    }

    // ============================================================
    //  UTILITAIRE : résumé pour affichage (nombre + coef total)
    // ============================================================
    public static function getSummary(string $cycle, ?string $serie = null): array
    {
        $subjects = self::getSubjectsByCycle($cycle, $serie);
        $totalCoef = array_sum(array_column($subjects, 'coefficient'));

        return [
            'count'      => count($subjects),
            'total_coef' => $totalCoef,
            'subjects'   => $subjects,
        ];
    }
}
