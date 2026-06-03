<?php

class DashboardSuperAdminModel {

    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getGlobalStats()
    {
        return [
            'schools_count' => 0,
            'users_count' => 0,
            'agents_count' => 0,
            'students_count' => 0
        ];
    }
}