<?php
class DashboardAdminModel {

    private PDO $db;

    public function __construct(PDO $db) {
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

        return (int)($stmt->fetchColumn() ?? 0);
    }
}
?>

