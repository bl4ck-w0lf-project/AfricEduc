<?php

class SchoolConfigModel
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function saveConfig(array $d): bool
{
    $sql = "INSERT INTO school_settings (
        school_id,
        period_type,
        nb_periods,

        use_interro,
        use_d1,
        use_d2,
        use_dh,

        use_conduite,
        conduite_coef,
        conduite_max,

        passing_grade,
        poids_s1,
        poids_s2,
        currency,
        is_configured
    ) VALUES (
        :school_id,
        :period_type,
        :nb_periods,

        :use_interro,
        :use_d1,
        :use_d2,
        :use_dh,

        :use_conduite,
        :conduite_coef,
        :conduite_max,

        :passing_grade,
        :poids_s1,
        :poids_s2,
        :currency,
        :is_configured
    )
    ON DUPLICATE KEY UPDATE
        period_type = VALUES(period_type),
        nb_periods = VALUES(nb_periods),

        use_interro = VALUES(use_interro),
        use_d1 = VALUES(use_d1),
        use_d2 = VALUES(use_d2),
        use_dh = VALUES(use_dh),

        use_conduite = VALUES(use_conduite),
        conduite_coef = VALUES(conduite_coef),
        conduite_max = VALUES(conduite_max),

        passing_grade = VALUES(passing_grade),
        poids_s1 = VALUES(poids_s1),
        poids_s2 = VALUES(poids_s2),
        currency = VALUES(currency),
        is_configured = VALUES(is_configured)
    ";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute([
            ':school_id' => $d['school_id'] ?? null,
            ':period_type' => $d['period_type'] ?? 'semestre',
            ':nb_periods' => $d['nb_periods'] ?? 2,

            ':use_interro' => $d['use_interro'] ?? 0,
            ':use_d1' => $d['use_d1'] ?? 0,
            ':use_d2' => $d['use_d2'] ?? 0,
            ':use_dh' => $d['use_dh'] ?? 0,

            ':use_conduite' => $d['use_conduite'] ?? 0,
            ':conduite_coef' => $d['conduite_coef'] ?? 1,
            ':conduite_max' => $d['conduite_max'] ?? 20,

            ':passing_grade' => $d['passing_grade'] ?? 10,
            ':poids_s1' => $d['poids_s1'] ?? 1,
            ':poids_s2' => $d['poids_s2'] ?? 2,

            ':currency' => $d['currency'] ?? 'FCFA',
            ':is_configured' => $d['is_configured'] ?? 1
        ]);
}
}