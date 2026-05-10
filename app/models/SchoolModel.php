<?php
final class SchoolModel
{
    public function __construct(private PDO $pdo) {}

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

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO schools (name, subtype, email, phone, address, slug, status)
            VALUES (?, ?, ?, ?, ?, ?, 'inactive')
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
}
?>