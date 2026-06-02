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
        $sql = "INSERT INTO school_config (
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

            currency
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

            :currency
        )";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':school_id' => $d['school_id'],

            ':period_type' => $d['period_type'],
            ':nb_periods' => $d['nb_periods'],

            ':use_interro' => $d['use_interro'],
            ':use_d1' => $d['use_d1'],
            ':use_d2' => $d['use_d2'],
            ':use_dh' => $d['use_dh'],

            ':use_conduite' => $d['use_conduite'],
            ':conduite_coef' => $d['conduite_coef'],
            ':conduite_max' => $d['conduite_max'],

            ':passing_grade' => $d['passing_grade'],
            ':poids_s1' => $d['poids_s1'],
            ':poids_s2' => $d['poids_s2'],

            ':currency' => $d['currency']
        ]);
    }
}