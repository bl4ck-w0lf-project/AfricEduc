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

            switch ($_POST['action'] ?? '') {

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

        $_SESSION['toast_message'] = 'Profil mis à jour avec succès';

        header('Location: /AfricEduc/public/index.php?url=admin_settings');
        exit;
    }

    private function updateAvatar(int $adminId): void
    {
        if (
            !isset($_FILES['avatar']) ||
            $_FILES['avatar']['error'] !== 0
        ) {
            return;
        }

        $fileName = time() . '_' . basename($_FILES['avatar']['name']);

        $uploadDir = __DIR__ . '/../../public/uploads/avatars/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        move_uploaded_file(
            $_FILES['avatar']['tmp_name'],
            $uploadDir . $fileName
        );

        $avatarPath = 'uploads/avatars/' . $fileName;

        $this->model->updateAvatar($adminId, $avatarPath);

        $_SESSION['toast_message'] = 'Photo de profil mise à jour';

        header('Location: /AfricEduc/public/index.php?url=admin_settings');
        exit;
    }

    private function deleteAvatar(int $adminId): void
    {
        $this->model->deleteAvatar($adminId);

        $_SESSION['toast_message'] = 'Photo supprimée';

        header('Location: /AfricEduc/public/index.php?url=admin_settings');
        exit;
    }
}