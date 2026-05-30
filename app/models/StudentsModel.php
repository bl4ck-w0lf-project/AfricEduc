<?php
class StudentModel {

    private PDO $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    // LISTE
    public function getAllBySchool($school_id) {
        $sql = "SELECT * FROM students WHERE school_id = :school_id ORDER BY id DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['school_id' => $school_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // ONE
    public function findById($id) {
        $sql = "SELECT * FROM students WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CREATE
    public function insert($data) {
        $sql = "INSERT INTO students (
            school_id, class_id, matricule, firstname, lastname,
            email, phone, gender, birthdate, birthplace,
            nationality, marital_status, photo, parent_name,
            parent_phone, address, status, enrolled_at, notes
        ) VALUES (
            :school_id, :class_id, :matricule, :firstname, :lastname,
            :email, :phone, :gender, :birthdate, :birthplace,
            :nationality, :marital_status, :photo, :parent_name,
            :parent_phone, :address, :status, :enrolled_at, :notes
        )";

        return $this->db->prepare($sql)->execute($data);
    }

    // UPDATE
    public function update($id, $data) {
        $data['id'] = $id;

        $sql = "UPDATE students SET
            class_id=:class_id,
            matricule=:matricule,
            firstname=:firstname,
            lastname=:lastname,
            email=:email,
            phone=:phone,
            gender=:gender,
            birthdate=:birthdate,
            birthplace=:birthplace,
            nationality=:nationality,
            marital_status=:marital_status,
            photo=:photo,
            parent_name=:parent_name,
            parent_phone=:parent_phone,
            address=:address,
            status=:status,
            enrolled_at=:enrolled_at,
            notes=:notes,
            updated_at=NOW()
        WHERE id=:id";

        return $this->db->prepare($sql)->execute($data);
    }

    // DELETE
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM students WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}
?>
