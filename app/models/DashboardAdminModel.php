<?php

class DashboardAdminModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getIsConfigured($schoolId): int
    {
        $stmt = $this->db->prepare("
            SELECT is_configured
            FROM school_settings
            WHERE school_id = ?
            LIMIT 1
        ");

        $stmt->execute([$schoolId]);

        return (int) ($stmt->fetchColumn() ?? 0);
    }

    /**
     * Récupérer un administrateur
     */
    public function findAdminById(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                id,
                school_id,
                name,
                email,
                role,
                avatar,
                status,
                last_login,
                email_verified_at
            FROM users
            WHERE id = ?
            LIMIT 1
        ");

        $stmt->execute([$id]);

        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        return $admin ?: null;
    }

    /**
     * Mise à jour des informations admin
     */
    public function updateAdminProfile(int $id, array $data): void
    {
        if (!empty($data['password'])) {

            $stmt = $this->db->prepare("
                UPDATE users
                SET
                    name = ?,
                    email = ?,
                    password = ?,
                    role = ?,
                    status = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['password'],
                $data['role'],
                $data['status'],
                $id
            ]);

        } else {

            $stmt = $this->db->prepare("
                UPDATE users
                SET
                    name = ?,
                    email = ?,
                    role = ?,
                    status = ?
                WHERE id = ?
            ");

            $stmt->execute([
                $data['name'],
                $data['email'],
                $data['role'],
                $data['status'],
                $id
            ]);
        }
    }

    /**
     * Mise à jour avatar
     */
    public function updateAvatar(int $id, string $avatar): void
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET avatar = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $avatar,
            $id
        ]);
    }

    /**
     * Supprimer avatar
     */
    public function deleteAvatar(int $id): void
    {
        $stmt = $this->db->prepare("
            UPDATE users
            SET avatar = NULL
            WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}