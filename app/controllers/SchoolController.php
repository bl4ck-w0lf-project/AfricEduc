<?php

require_once __DIR__ . '/../middlewares/AuthMiddleware.php';
require_once __DIR__ . '/../models/SchoolModel.php';

class SchoolController
{
    private SchoolModel $schoolModel;

    public function __construct(PDO $pdo)
    {
        $this->schoolModel = new SchoolModel($pdo);
    }

    public function identity(): void
    {
        AuthMiddleware::requireRole(['admin', 'super_admin']);

        $schoolId = (int) $_SESSION['school_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // =========================
            // DELETE LOGO
            // =========================
            if (($_POST['action'] ?? '') === 'delete_logo') {

                $this->schoolModel->deleteLogo($schoolId);

                $_SESSION['toast_message'] = "Logo supprimé avec succès.";

                header("Location: /AfricEduc/public/index.php?url=school_identity");
                exit;
            }

            // =========================
            // UPLOAD LOGO
            // =========================
            if (
                isset($_FILES['logo']) &&
                $_FILES['logo']['error'] === UPLOAD_ERR_OK
            ) {

                $fileName = time() . '_' . basename($_FILES['logo']['name']);

                $uploadDir = __DIR__ . '/../../public/uploads/logos/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0775, true);
                }

                $filePath = 'uploads/logos/' . $fileName;

                if (
                    move_uploaded_file(
                        $_FILES['logo']['tmp_name'],
                        $uploadDir . $fileName
                    )
                ) {

                    $this->schoolModel->updateLogo(
                        $schoolId,
                        $filePath
                    );

                    $_SESSION['toast_message'] = "Logo mis à jour avec succès.";
                }

                header("Location: /AfricEduc/public/index.php?url=school_identity");
                exit;
            }

            // =========================
            // UPDATE INFORMATIONS
            // =========================
            $this->schoolModel->updateInfo(
                $schoolId,
                [
                    'name'     => $_POST['name'] ?? '',
                    'subtype'  => $_POST['subtype'] ?? '',
                    'email'    => $_POST['email'] ?? '',
                    'phone'    => $_POST['phone'] ?? '',
                    'address'  => $_POST['address'] ?? '',
                    'status'   => $_POST['status'] ?? 'active'
                ]
            );

            $_SESSION['toast_message'] = "Informations mises à jour avec succès.";

            header("Location: /AfricEduc/public/index.php?url=school_identity");
            exit;
        }

        // =========================
        // LOAD SCHOOL
        // =========================
        $school = $this->schoolModel->findById($schoolId);

        require __DIR__ . '/../views/admin/identity.php';
    }
}