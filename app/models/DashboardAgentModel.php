<?php

class DashboardAgentModel {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getDashboardStats($schoolId, $userId)
    {
        // exemple simple (tu adapteras après)
        return [
            'students_count' => 0,
            'notes_count' => 0,
        ];
    }
}