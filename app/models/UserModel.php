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

 public function findByEmail(string $email): ?array
{
    $stmt = $this->pdo->prepare("
        SELECT 
            u.id,
            u.school_id,
            u.name AS full_name,
            u.email,
            u.password AS password_hash,
            u.role,
            u.status,

            s.name AS school_name,
            s.address AS school_address,
            s.phone AS school_phone,
            s.email AS school_email,
            s.logo AS school_logo,
            s.slug AS school_slug

        FROM users u
        LEFT JOIN schools s ON s.id = u.school_id
        WHERE u.email = ?
        LIMIT 1
    ");

    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

public function findByEmailForReset(string $email): array|null
{
    $stmt = $this->pdo->prepare(
        "SELECT id, email, role
         FROM users
         WHERE email = ?
         LIMIT 1"
    );

    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // utilisateur inexistant
    if (!$user) {
        return [
            'status' => 'not_found'
        ];
    }

    // rôle interdit
    if (!in_array($user['role'], ['admin', 'super_admin'], true)) {
        return [
            'status' => 'forbidden'
        ];
    }

    // utilisateur valide
    return [
        'status' => 'success',
        'user'   => $user
    ];
}


/**
 * Supprime les anciens tokens de l'email puis insère le nouveau.
 */
public function createPasswordResetToken(
    string $email,
    string $tokenHash,
    string $expiresAt
): bool {
    // Purge les tokens précédents pour cet email
    $del = $this->pdo->prepare(
        "DELETE FROM password_resets WHERE email = ?"
    );
    $del->execute([$email]);

    $stmt = $this->pdo->prepare(
        "INSERT INTO password_resets (email, token_hash, expires_at)
         VALUES (?, ?, ?)"
    );
    return $stmt->execute([$email, $tokenHash, $expiresAt]);
}

/**
 * Cherche un token valide (non expiré). Retourne la ligne ou null.
 */
public function findValidResetToken(string $tokenHash): ?array
{
    $stmt = $this->pdo->prepare(
        "SELECT *
         FROM password_resets
         WHERE token_hash = ?
           AND expires_at > NOW()
         LIMIT 1"
    );
    $stmt->execute([$tokenHash]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null;
}

/**
 * Met à jour le mot de passe d'un utilisateur par email.
 */
public function updatePasswordByEmail(
    string $email,
    string $hashedPassword
): bool {
    $stmt = $this->pdo->prepare(
        "UPDATE users SET password = ? WHERE email = ?"
    );
    return $stmt->execute([$hashedPassword, $email]);
}

/**
 * Invalide tous les tokens de reset pour cet email (après usage).
 */
public function deleteResetTokensByEmail(string $email): void
{
    $stmt = $this->pdo->prepare(
        "DELETE FROM password_resets WHERE email = ?"
    );
    $stmt->execute([$email]);
}

public function updateLastLogin(int $userId): bool
{
    $stmt = $this->pdo->prepare("
        UPDATE users 
        SET last_login = NOW()
        WHERE id = ?
    ");

    return $stmt->execute([$userId]);
}

}

?>