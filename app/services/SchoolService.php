<?php
final class SchoolService
{
    public function __construct(
        private SchoolModel $schoolModel,
        private UserModel $userModel,
        private PDO $pdo
    ) {}

   public function register(array $d): array
{
    if ($this->schoolModel->existsByName($d['school_name'])) {
        return ['error' => ['school_name' => "Nom déjà utilisé"]];
    }

    if ($this->schoolModel->existsByEmail($d['school_email'])) {
        return ['error' => ['school_email' => "Email déjà utilisé"]];
    }

    if ($this->userModel->existsByEmail($d['admin_email'])) {
        return ['error' => ['admin_email' => "Email admin déjà utilisé"]];
    }

    $this->pdo->beginTransaction();

    try {
        $slug = $this->generateSlug($d['school_name']);

        // 1. créer école
        $schoolId = $this->schoolModel->create([
            'name' => $d['school_name'],
            'subtype' => $d['school_subtype'],
            'email' => $d['school_email'],
            'phone' => $d['school_phone'],
            'address' => $d['school_address'],
            'slug' => $slug,
        ]);

        // 2. créer admin (UNE SEULE FOIS)
        $userId = $this->userModel->createAdmin([
            'school_id' => $schoolId,
            'name' => $d['admin_full_name'],
            'email' => $d['admin_email'],
            'password' => password_hash($d['password'], PASSWORD_BCRYPT),
            'status' => 'inactive'
        ]);

        $this->pdo->commit();

        return [
            'success' => true,
            'user_id' => $userId
        ];

    } catch (Exception $e) {
        if ($this->pdo->inTransaction()) {
            $this->pdo->rollBack();
        }

        return ['error' => ['global' => 'Erreur serveur']];
    }
}

    private function generateSlug(string $name): string
    {
        return strtolower(trim(preg_replace('/[^a-z0-9]+/', '-', $name), '-'));
    }
}
?>