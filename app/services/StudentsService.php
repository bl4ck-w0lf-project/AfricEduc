<?php

class StudentService {

    private StudentModel $model;

    public function __construct(StudentModel $model) {
        $this->model = $model;
    }

    public function list($school_id) {
        return $this->model->getAllBySchool($school_id);
    }

    public function get($id) {
        return $this->model->findById($id);
    }

    public function create($data, $school_id) {

        $data['school_id'] = $school_id;
        $data['status'] = $data['status'] ?? 'actif';

        return $this->model->insert($data);
    }

    public function update($id, $data) {
        return $this->model->update($id, $data);
    }

    public function delete($id) {
        return $this->model->delete($id);
    }
}
?>
