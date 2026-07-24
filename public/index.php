<?php

session_start();

require_once __DIR__ . '/../app/config/database.php';

$url = $_GET['url'] ?? 'dashboard';
$action = $_GET['action'] ?? ''; 

switch ($url) {

    case 'dashboard_super_admin':
        require_once __DIR__ . '/../app/controllers/DashboardSuperAdminController.php';
        $controller = new DashboardSuperAdminController($pdo);
        $controller->index();
        break;

    case 'dashboard_admin':
        require_once __DIR__ . '/../app/controllers/DashboardAdminController.php';
        $controller = new DashboardAdminController($pdo);
        $controller->index();
        break;
    
    case 'admin_settings':
        require_once __DIR__ . '/../app/controllers/DashboardAdminController.php';
        $controller = new DashboardAdminController($pdo);
        $controller->adminSettings();
        break;

    case 'dashboard_agent':
        require_once __DIR__ . '/../app/controllers/DashboardAgentController.php';
        $controller = new DashboardAgentController($pdo);
        $controller->index();
        break;

    case 'setup_school':
        require_once __DIR__ . '/../app/controllers/SetupSchoolController.php';
        $controller = new SetupSchoolController($pdo);
        $controller->index();
        break;

    case 'school_identity':
        require_once __DIR__ . '/../app/controllers/SchoolController.php';
        $controller = new SchoolController($pdo);
        $controller->identity();
        break;


    case 'manage_agents':
        require_once __DIR__ . '/../app/controllers/ManageAgentController.php';
        $controller = new ManageAgentController($pdo);
        $controller->index();
        break;
        
    case 'classes':
        require_once __DIR__ . '/../app/controllers/ClassesController.php';
        $controller = new ClassesController($pdo);
        
        $action = $_GET['action'] ?? 'index';
        
        switch ($action) {
            case 'create':
                $controller->create();
                break;
            case 'store':
                $controller->store();
                break;
            case 'show':
                $controller->show();
                break;
            case 'edit':
                $controller->edit();
                break;
            case 'update':
                $controller->update();
                break;
            case 'delete':
                $controller->delete();
                break;
            case 'get_form_data':
                $controller->getFormData();
                break;
            case 'get_class':
                $controller->getClass();
                break;
            default:
                $controller->index();
                break;
        }
        break;

    case 'matieres':
        require_once __DIR__ . '/../app/controllers/MatieresController.php';
        $controller = new MatieresController($pdo);

        $action = $_GET['action'] ?? 'index';

        switch ($action) {
            case 'index':
                $controller->index();
                break;
            case 'add_matiere_to_classe':
                $controller->addMatiereToClasse();
                break;
            case 'update_coeff':
                $controller->updateCoeff();
                break;
            case 'remove_matiere_from_classe':
                $controller->removeMatiereFromClasse();
                break;
            default:
                $controller->index();
                break;
        }
        break;

        
    //API actions sur les étudiants
    //Afficher la vue l'index.php    
    case 'students':
        require_once __DIR__ . '/../app/controllers/StudentsController.php';
        $controller = new StudentsController($pdo);
        $controller->index();
        break;
    //Créer un étudiants
    //Modifier un étudiant
    //Supprimer un étudiant
    //Afficher les détails d'un étudiant
    
    case 'register':
        require_once __DIR__ . '/../app/controllers/RegisterController.php';
        $controller = new RegisterController();
        $controller->register();
        break;

    case 'login':
        require_once __DIR__ . '/../app/controllers/LoginController.php';
        $controller = new LoginController($pdo);
        $controller->index();
        break;

    case 'password':
        require_once __DIR__ . '/../app/controllers/PasswordController.php';
        $controller = new PasswordController($pdo);
        
        if ($action === 'forgot') {
            // Si c'est une requête GET, on affiche le formulaire
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $controller->showForgotForm();
            } else {
                $controller->handleForgot();
            }
        } elseif ($action === 'reset') {
            $controller->handleReset();
        } else {
            header("Location: /AfricEduc/app/views/auth/forgot_password.php");
            exit;
        }
        break;
    
    case 'logout':
        require_once __DIR__ . '/../app/controllers/LogoutController.php';
        $controller = new LogoutController();
        $controller->index();
        break;

    default:
        echo "404 - Page introuvable";
}
