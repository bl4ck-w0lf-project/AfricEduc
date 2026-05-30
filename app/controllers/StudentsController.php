<?php
class StudentController {

    private StudentService $service;

    public function __construct(StudentService $service) {
        $this->service = $service;
    }

    // LISTE
    public function index() {
        $school_id = $_SESSION['school_id'];
        $students = $this->service->list($school_id);

        require __DIR__ . '/../views/students/index.php';
    }

    // SHOW
    public function show() {
        $id = $_GET['id'];
        $student = $this->service->get($id);

        require __DIR__ . '/../views/students/show.php';
    }

    // CREATE FORM
    public function create() {
        require __DIR__ . '/../views/students/create.php';
    }

    // STORE
    public function store() {
        $this->service->create($_POST, $_SESSION['school_id']);
        header("Location: /students");
    }

    // EDIT FORM
    public function edit() {
        $id = $_GET['id'];
        $student = $this->service->get($id);

        require __DIR__ . '/../views/students/edit.php';
    }

    // UPDATE
    public function update() {
        $id = $_GET['id'];
        $this->service->update($id, $_POST);

        header("Location: /students");
    }

    // DELETE
    public function delete() {
        $id = $_GET['id'];
        $this->service->delete($id);

        header("Location: /students");
    }
}



?>
