<?php
final class UserModel
{
    public function __construct(private PDO $pdo) {}

    public function existsByEmail(string $email): bool
    {
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
        $stmt->execute([$email]);
        return (bool) $stmt->fetch();
    }

    public function createAdmin(array $data): int
{
    $stmt = $this->pdo->prepare("
        INSERT INTO users (school_id, name, email, password, role, status)
        VALUES (?, ?, ?, ?, 'admin', 'inactive')
    ");

    $stmt->execute([
        $data['school_id'],
        $data['name'],
        $data['email'],
        $data['password'],
    ]);

    return (int) $this->pdo->lastInsertId();
}
}

?>