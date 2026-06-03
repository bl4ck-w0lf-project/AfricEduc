<?php
class DashboardAdminModel {

    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function isSchoolConfigured($schoolId) {

    $stmt = $this->db->prepare("
        SELECT is_configured 
        FROM school_settings 
        WHERE school_id = ?
        LIMIT 1
    ");

    $stmt->execute([$schoolId]);

    return (int) $stmt->fetchColumn();
}
}
?>