<?php

    require_once __DIR__ . '/../middlewares/AuthMiddleware.php';


class SchoolController
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Mise à jour des données de l'école
    public function identity(): void
    {
        AuthMiddleware::requireRole(['admin', 'super_admin']);

        $schoolId = (int) $_SESSION['school_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // =========================
    // 1. DELETE LOGO
    // =========================
        if (($_POST['action'] ?? '') === 'delete_logo') {

            $stmt = $this->pdo->prepare("UPDATE schools SET logo = NULL WHERE id = ?");
            $stmt->execute([$schoolId]);

            header("Location: /AfricEduc/public/index.php?url=school_identity");
            exit;
        }

        // =========================
        // 2. UPLOAD LOGO
        // =========================
        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === 0) {

            $fileName = time() . '_' . $_FILES['logo']['name'];

            $uploadDir = __DIR__ . '/../../public/uploads/logos/';
            $filePath = 'uploads/logos/' . $fileName;

            move_uploaded_file($_FILES['logo']['tmp_name'], $uploadDir . $fileName);

            $stmt = $this->pdo->prepare("
                UPDATE schools SET logo = ? WHERE id = ?
            ");

            $stmt->execute([$filePath, $schoolId]);

            header("Location: /AfricEduc/public/index.php?url=school_identity");
            exit;
        }

        // =========================
        // 3. UPDATE INFOS ECOLE
        // =========================
        $stmt = $this->pdo->prepare("
            UPDATE schools
            SET
                name = ?,
                subtype = ?,
                email = ?,
                phone = ?,
                address = ?,
                status = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $_POST['name'] ?? '',
            $_POST['subtype'] ?? '',
            $_POST['email'] ?? '',
            $_POST['phone'] ?? '',
            $_POST['address'] ?? '',
            $_POST['status'] ?? 'active',
            $schoolId
        ]);

        header("Location: /AfricEduc/public/index.php?url=school_identity");
        exit;
    }

        $stmt = $this->pdo->prepare("
            SELECT
                name,
                subtype,
                email,
                phone,
                address,
                logo,
                status
            FROM schools
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$schoolId]);

        $school = $stmt->fetch(PDO::FETCH_ASSOC);

        require __DIR__ . '/../views/admin/identity.php';
    }
}