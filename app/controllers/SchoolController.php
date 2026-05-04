<?php
// ============================================================
//  EduManager — app/controllers/SchoolController.php
//  Configuration pédagogique de l'école (setup wizard)
//  Actions : setup | get_settings | update_settings
//
//  Utilisé par : setup_school.php (première connexion admin)
//                dashboard_admin.php (modification des settings)
//
//  Tables : school_settings (INSERT / UPDATE)
//  Sécurité : school_id vient TOUJOURS de la session PHP
// ============================================================

session_start();
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate');

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

class SchoolController
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }

    // ============================================================
    //  ROUTER PRINCIPAL
    // ============================================================
    public function handle(string $action): void
    {
        // Toutes les actions nécessitent d'être connecté
        AuthMiddleware::requireLogin();

        // CSRF pour les POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->verifyCsrf();
        }

        switch ($action) {
            case 'setup':           $this->setup();          break;
            case 'get_settings':    $this->getSettings();    break;
            case 'update_settings': $this->updateSettings(); break;
            default:
                $this->json(['success' => false, 'message' => 'Action invalide.'], 400);
        }
    }

    // ============================================================
    //  ACTION : setup
    //  Sauvegarde la configuration initiale après première connexion
    //  Appelé par setup_school.php
    //  Seul l'admin peut faire le setup de SON école
    // ============================================================
    private function setup(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.'], 405);
        }

        // Seul l'admin peut configurer son école
        AuthMiddleware::requireRole(['admin']);

        // Le school_id vient TOUJOURS de la session — jamais du POST
        $schoolId = (int)$_SESSION['school_id'];

        // Vérifier que la config n'existe pas déjà (setup déjà fait)
        $stmt = $this->pdo->prepare('
            SELECT id FROM school_settings WHERE school_id = ? LIMIT 1
        ');
        $stmt->execute([$schoolId]);
        if ($stmt->fetch()) {
            $this->json([
                'success'  => false,
                'message'  => 'La configuration a déjà été effectuée. Utilisez "Modifier les paramètres".',
                'redirect' => '../../pages/dashboard_admin.php'
            ], 409);
        }

        // Récupérer et valider les données du wizard
        $settings = $this->extractAndValidateSettings();
        if (isset($settings['errors'])) {
            $this->json(['success' => false, 'errors' => $settings['errors']], 422);
        }

        try {
            $stmt = $this->pdo->prepare('
                INSERT INTO school_settings (
                    school_id,
                    period_type, nb_periods,
                    use_interro, use_d1, use_d2, use_dh,
                    use_conduite, conduite_coef, conduite_max,
                    passing_grade,
                    poids_s1, poids_s2,
                    currency
                ) VALUES (
                    ?,
                    ?, ?,
                    ?, ?, ?, ?,
                    ?, ?, ?,
                    ?,
                    ?, ?,
                    ?
                )
            ');

            $stmt->execute([
                $schoolId,
                $settings['period_type'],
                $settings['nb_periods'],
                $settings['use_interro'],
                $settings['use_d1'],
                $settings['use_d2'],
                $settings['use_dh'],
                $settings['use_conduite'],
                $settings['conduite_coef'],
                $settings['conduite_max'],
                $settings['passing_grade'],
                $settings['poids_s1'],
                $settings['poids_s2'],
                $settings['currency'],
            ]);

            $this->json([
                'success'  => true,
                'message'  => 'Configuration enregistrée ! Bienvenue sur EduManager.',
                'redirect' => '../../pages/dashboard_admin.php'
            ]);

        } catch (PDOException $e) {
            error_log('[EduManager][School][setup] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Réessayez.'], 500);
        }
    }

    // ============================================================
    //  ACTION : get_settings
    //  Retourne la configuration de l'école (GET)
    //  Utilisé pour pré-remplir les formulaires de modification
    // ============================================================
    private function getSettings(): void
    {
        // Admin et super_admin peuvent lire les settings
        AuthMiddleware::requireRole(['admin', 'super_admin']);

        $schoolId = (int)$_SESSION['school_id'];

        $stmt = $this->pdo->prepare('
            SELECT
                ss.*,
                s.name        AS school_name,
                s.email       AS school_email,
                s.phone       AS school_phone,
                s.address     AS school_address,
                s.logo        AS school_logo,
                s.subtype     AS school_subtype,
                s.status      AS school_status
            FROM school_settings ss
            JOIN schools s ON s.id = ss.school_id
            WHERE ss.school_id = ?
            LIMIT 1
        ');
        $stmt->execute([$schoolId]);
        $settings = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$settings) {
            $this->json([
                'success'       => false,
                'configured'    => false,
                'message'       => 'École non configurée.',
                'redirect'      => '../../pages/setup_school.php'
            ], 404);
        }

        // Convertir les TINYINT en booléens pour le JS
        $boolFields = [
            'use_interro', 'use_d1', 'use_d2', 'use_dh',
            'use_conduite'
        ];
        foreach ($boolFields as $field) {
            $settings[$field] = (bool)(int)$settings[$field];
        }

        $this->json([
            'success'    => true,
            'configured' => true,
            'settings'   => $settings
        ]);
    }

    // ============================================================
    //  ACTION : update_settings
    //  Modifie la configuration pédagogique existante
    //  Seuls admin et super_admin peuvent modifier
    // ============================================================
    private function updateSettings(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->json(['success' => false, 'message' => 'Méthode non autorisée.'], 405);
        }

        AuthMiddleware::requireRole(['admin', 'super_admin']);

        $schoolId = (int)$_SESSION['school_id'];

        // Vérifier que la config existe
        $stmt = $this->pdo->prepare('
            SELECT id FROM school_settings WHERE school_id = ? LIMIT 1
        ');
        $stmt->execute([$schoolId]);
        if (!$stmt->fetch()) {
            $this->json([
                'success' => false,
                'message' => 'Aucune configuration à modifier. Faites le setup d\'abord.'
            ], 404);
        }

        $settings = $this->extractAndValidateSettings();
        if (isset($settings['errors'])) {
            $this->json(['success' => false, 'errors' => $settings['errors']], 422);
        }

        try {
            $stmt = $this->pdo->prepare('
                UPDATE school_settings SET
                    period_type   = ?,
                    nb_periods    = ?,
                    use_interro   = ?,
                    use_d1        = ?,
                    use_d2        = ?,
                    use_dh        = ?,
                    use_conduite  = ?,
                    conduite_coef = ?,
                    conduite_max  = ?,
                    passing_grade = ?,
                    poids_s1      = ?,
                    poids_s2      = ?,
                    currency      = ?,
                    updated_at    = NOW()
                WHERE school_id = ?
            ');

            $stmt->execute([
                $settings['period_type'],
                $settings['nb_periods'],
                $settings['use_interro'],
                $settings['use_d1'],
                $settings['use_d2'],
                $settings['use_dh'],
                $settings['use_conduite'],
                $settings['conduite_coef'],
                $settings['conduite_max'],
                $settings['passing_grade'],
                $settings['poids_s1'],
                $settings['poids_s2'],
                $settings['currency'],
                $schoolId,
            ]);

            $this->json([
                'success' => true,
                'message' => 'Paramètres mis à jour avec succès.'
            ]);

        } catch (PDOException $e) {
            error_log('[EduManager][School][update_settings] DB error: ' . $e->getMessage());
            $this->json(['success' => false, 'message' => 'Erreur serveur. Réessayez.'], 500);
        }
    }

    // ============================================================
    //  HELPER : extraction et validation des settings du formulaire
    //  Retourne le tableau des valeurs validées OU ['errors' => [...]]
    // ============================================================
    private function extractAndValidateSettings(): array
    {
        $errors = [];

        // --- Système de périodes ---
        $periodType = $this->sanitize($_POST['period_type'] ?? '');
        if (!in_array($periodType, ['semestre', 'trimestre'])) {
            $errors['period_type'] = 'Choisissez semestre ou trimestre.';
        }
        $nbPeriods = $periodType === 'trimestre' ? 3 : 2;

        // --- Devoirs (toggles ON/OFF) ---
        // Les checkboxes/toggles envoient '1' si cochés, absent sinon
        $useInterro = isset($_POST['use_interro']) ? 1 : 0;
        $useD1      = isset($_POST['use_d1'])      ? 1 : 0;
        $useD2      = isset($_POST['use_d2'])      ? 1 : 0;
        $useDh      = isset($_POST['use_dh'])      ? 1 : 0;

        // Au minimum interro OU (D1 et D2) doit être activé
        if (!$useInterro && !$useD1 && !$useD2) {
            $errors['devoirs'] = 'Activez au moins un type de devoir (Interrogation, D1 ou D2).';
        }

        // --- Conduite ---
        $useConduite = isset($_POST['use_conduite']) ? 1 : 0;
        $conduiteCoef = (int)($_POST['conduite_coef'] ?? 1);
        $conduiteMax  = (float)($_POST['conduite_max'] ?? 20.00);

        if ($conduiteCoef < 1 || $conduiteCoef > 10) {
            $errors['conduite_coef'] = 'Le coefficient de conduite doit être entre 1 et 10.';
        }
        if ($conduiteMax < 10 || $conduiteMax > 100) {
            $errors['conduite_max'] = 'La note maximale de conduite doit être entre 10 et 100.';
        }

        // --- Moyenne de passage ---
        $passingGrade = (float)($_POST['passing_grade'] ?? 10.00);
        if ($passingGrade < 0 || $passingGrade > 20) {
            $errors['passing_grade'] = 'La moyenne de passage doit être entre 0 et 20.';
        }

        // --- Pondération semestres (uniquement si semestre) ---
        $poidsS1 = (int)($_POST['poids_s1'] ?? 1);
        $poidsS2 = (int)($_POST['poids_s2'] ?? 2);
        if ($periodType === 'semestre') {
            if ($poidsS1 < 1 || $poidsS1 > 10) $errors['poids_s1'] = 'Poids S1 invalide (1-10).';
            if ($poidsS2 < 1 || $poidsS2 > 10) $errors['poids_s2'] = 'Poids S2 invalide (1-10).';
        }

        // --- Devise ---
        $currency = $this->sanitize($_POST['currency'] ?? 'FCFA');
        if (empty($currency)) $currency = 'FCFA';

        if (!empty($errors)) {
            return ['errors' => $errors];
        }

        return [
            'period_type'   => $periodType,
            'nb_periods'    => $nbPeriods,
            'use_interro'   => $useInterro,
            'use_d1'        => $useD1,
            'use_d2'        => $useD2,
            'use_dh'        => $useDh,
            'use_conduite'  => $useConduite,
            'conduite_coef' => $conduiteCoef,
            'conduite_max'  => $conduiteMax,
            'passing_grade' => $passingGrade,
            'poids_s1'      => $poidsS1,
            'poids_s2'      => $poidsS2,
            'currency'      => $currency,
        ];
    }

    // ============================================================
    //  HELPERS
    // ============================================================
    private function verifyCsrf(): void
    {
        $token = $_POST['csrf_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
        if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
            $this->json(['success' => false, 'message' => 'Token de sécurité invalide.'], 403);
        }
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    private function sanitize(string $value): string
    {
        return htmlspecialchars(strip_tags(trim($value)), ENT_QUOTES, 'UTF-8');
    }

    private function json(array $data, int $statusCode = 200): never
    {
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }
}

// ============================================================
//  POINT D'ENTRÉE
// ============================================================
$controller = new SchoolController();
$action     = $_POST['action'] ?? $_POST['school_action'] ?? $_GET['action'] ?? '';
$controller->handle($action);
