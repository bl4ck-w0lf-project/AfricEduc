<?php

require_once __DIR__ . '/../models/DashboardAdminModel.php';
require_once __DIR__ . '/../middlewares/AuthMiddleware.php';

class DashboardAdminController
{
    private DashboardAdminModel $model;

    public function __construct(PDO $db)
    {
        $this->model = new DashboardAdminModel($db);
    }

    public function index()
    {
        $schoolId = $_SESSION['school_id'] ?? null;

        if (!$schoolId) {
            die('school_id absent');
        }

        $isConfigured = $this->model->getIsConfigured($schoolId);

        require __DIR__ . '/../views/admin/dashboard_admin.php';
    }

    public function adminSettings()
    {
        AuthMiddleware::requireRole(['admin', 'super_admin']);

        $adminId = (int) $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $action = $_POST['action'] ?? '';
            
            switch ($action) {
                case 'update_profile':
                    $this->updateProfile($adminId);
                    break;

                case 'update_avatar':
                    $this->updateAvatar($adminId);
                    break;

                case 'delete_avatar':
                    $this->deleteAvatar($adminId);
                    break;
            }
        }

        $admin = $this->model->findAdminById($adminId);

        require __DIR__ . '/../views/admin/settings.php';
    }

    private function updateProfile(int $adminId): void
    {
        $data = [
            'name'   => trim($_POST['name'] ?? ''),
            'email'  => trim($_POST['email'] ?? ''),
            'role'   => $_POST['role'] ?? 'admin',
            'status' => $_POST['status'] ?? 'active',
        ];

        $password = trim($_POST['password'] ?? '');

        if (!empty($password)) {
            if ($password !== ($_POST['confirm_password'] ?? '')) {
                $_SESSION['toast_error'] = true;
                $_SESSION['toast_message'] = 'Les mots de passe ne correspondent pas';
                header('Location: /AfricEduc/public/index.php?url=admin_settings');
                exit;
            }
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $this->model->updateAdminProfile($adminId, $data);

        $_SESSION['user_name'] = $data['name'];
        $_SESSION['role'] = $data['role'];

        $_SESSION['toast_message'] = 'Profil mis à jour avec succès';
        $_SESSION['toast_error'] = false;

        header('Location: /AfricEduc/public/index.php?url=admin_settings');
        exit;
    }

    private function updateAvatar(int $adminId): void
    {
        try {
            if (!isset($_FILES['avatar']) || $_FILES['avatar']['error'] !== UPLOAD_ERR_OK) {
                $_SESSION['toast_error'] = true;
                $_SESSION['toast_message'] = 'Aucun fichier sélectionné';
                header('Location: /AfricEduc/public/index.php?url=admin_settings');
                exit;
            }

            $file = $_FILES['avatar'];

            // Vérifier le type
            $allowedTypes = ['image/jpeg', 'image/png'];
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mimeType = finfo_file($finfo, $file['tmp_name']);
            finfo_close($finfo);

            if (!in_array($mimeType, $allowedTypes)) {
                $_SESSION['toast_error'] = true;
                $_SESSION['toast_message'] = 'Format non accepté. Utilisez PNG ou JPG.';
                header('Location: /AfricEduc/public/index.php?url=admin_settings');
                exit;
            }

            if ($file['size'] > 2 * 1024 * 1024) {
                $_SESSION['toast_error'] = true;
                $_SESSION['toast_message'] = 'L\'image ne doit pas dépasser 2 Mo.';
                header('Location: /AfricEduc/public/index.php?url=admin_settings');
                exit;
            }

            $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $fileName = time() . '_' . bin2hex(random_bytes(8)) . '.' . $extension;

            // ✅ CHEMIN CORRIGÉ
            $uploadDir = __DIR__ . '/../../public/uploads/avatars/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            // Supprimer l'ancien avatar
            $admin = $this->model->findAdminById($adminId);
            if ($admin && !empty($admin['avatar'])) {
                $oldFile = __DIR__ . '/../../public/' . $admin['avatar'];
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
            }

            $targetPath = $uploadDir . $fileName;
            if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
                $_SESSION['toast_error'] = true;
                $_SESSION['toast_message'] = 'Erreur lors de l\'enregistrement';
                header('Location: /AfricEduc/public/index.php?url=admin_settings');
                exit;
            }

            // ✅ CHEMIN CORRIGÉ
            $avatarPath = 'uploads/avatars/' . $fileName;

            $this->model->updateAvatar($adminId, $avatarPath);
            $_SESSION['user_avatar'] = $avatarPath;

            $_SESSION['toast_message'] = 'Photo de profil mise à jour avec succès';
            $_SESSION['toast_error'] = false;

        } catch (Exception $e) {
            $_SESSION['toast_error'] = true;
            $_SESSION['toast_message'] = 'Erreur : ' . $e->getMessage();
        }

        header('Location: /AfricEduc/public/index.php?url=admin_settings');
        exit;
    }

    private function deleteAvatar(int $adminId): void
    {
        try {
            $admin = $this->model->findAdminById($adminId);
            if ($admin && !empty($admin['avatar'])) {
                $filePath = __DIR__ . '/../../public/' . $admin['avatar'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $this->model->deleteAvatar($adminId);
            unset($_SESSION['user_avatar']);

            $_SESSION['toast_message'] = 'Photo supprimée avec succès';
            $_SESSION['toast_error'] = false;

        } catch (Exception $e) {
            $_SESSION['toast_error'] = true;
            $_SESSION['toast_message'] = 'Erreur : ' . $e->getMessage();
        }

        header('Location: /AfricEduc/public/index.php?url=admin_settings');
        exit;
    }
}