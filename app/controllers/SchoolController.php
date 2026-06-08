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

            $stmt = $this->pdo->prepare("
                UPDATE schools
                SET
                    name = ?,
                    subtype = ?,
                    email = ?,
                    phone = ?,
                    address = ?,
                    logo = ?,
                    status = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $_POST['name'] ?? $school['name'],
                $_POST['subtype'] ?? $school['subtype'],
                $_POST['email'] ?? $school['email'],
                $_POST['phone'] ?? $school['phone'],
                $_POST['address'] ?? $school['address'],
                $_POST['logo'] ?? $school['logo'],
                $_POST['status'] ?? $school['status'],
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