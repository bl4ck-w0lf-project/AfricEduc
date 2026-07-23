<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/UserModel.php';
require_once __DIR__ . '/../models/SchoolModel.php';
require_once __DIR__ . '/../services/UserService.php';

class LoginController
{
    private $authService;

    public function __construct($pdo)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userModel = new UserModel($pdo);
        $this->authService = new AuthService($userModel);
    }

    public function index()
    {
        
        $errors = [];
        $old = [];
       

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember_me']);

            $old['email'] = $email;

            // validation simple
            if (empty($email)) {
                $errors['email'] = "L'email est requis";
            }

            if (empty($password)) {
                $errors['password'] = "Le mot de passe est requis";
            }

            if (empty($errors)) {

                $result = $this->authService->login($email, $password, $remember);

                if ($result['success']) {

                    switch ($result['role']) {

                        case 'super_admin':
                            header("Location: /AfricEduc/public/index.php?url=dashboard_super_admin");
                            break;

                        case 'admin':
                            header("Location: /AfricEduc/public/index.php?url=dashboard_admin");
                            break;

                        case 'agent':
                            header("Location: /AfricEduc/public/index.php?url=dashboard_agent");
                            break;

                        default:
                            header("Location: /AfricEduc/index.php");
                    }

                    exit;
                }

                $errors = $result['errors'];
            }

            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $old;

            header("Location: /AfricEduc/public/index.php?url=login");
            exit;
        }

        


        require __DIR__ . '/../views/auth/login.php';
    }
}
