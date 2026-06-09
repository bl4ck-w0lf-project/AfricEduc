<?php

final class SchoolModel
{
    public function __construct(private PDO $pdo) {}

    // =========================
    // FIND
    // =========================
    public function findById(int $id): ?array
    {
        $stmt = $this->pdo->prepare("SELECT * FROM schools WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // =========================
    // CHECK EXISTENCE
    // =========================
    public function existsByName(string $name): bool
    {
        $stmt = $this->pdo->prepare("SELECT id FROM schools WHERE name = ? LIMIT 1");
        $stmt->execute([$name]);
        return (bool) $stmt->fetch();
    }

    public function existsByEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT id FROM schools WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    // =========================
    // CREATE
    // =========================
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO schools (name, subtype, email, phone, address, slug, status)
            VALUES (?, ?, ?, ?, ?, ?, 'active')
        ");

        $stmt->execute([
            $data['name'],
            $data['subtype'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['slug'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    // =========================
    // UPDATE INFOS
    // =========================
    public function updateInfo(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE schools
            SET name = ?,
                subtype = ?,
                email = ?,
                phone = ?,
                address = ?,
                status = ?
            WHERE id = ?
        ");

        $stmt->execute([
            $data['name'],
            $data['subtype'],
            $data['email'],
            $data['phone'],
            $data['address'],
            $data['status'],
            $id
        ]);
    }

    // =========================
    // LOGO
    // =========================
    public function updateLogo(int $id, string $logoPath): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE schools SET logo = ? WHERE id = ?
        ");

        $stmt->execute([$logoPath, $id]);
    }

    public function deleteLogo(int $id): void
    {
        $stmt = $this->pdo->prepare("
            UPDATE schools SET logo = NULL WHERE id = ?
        ");

        $stmt->execute([$id]);
    }
}