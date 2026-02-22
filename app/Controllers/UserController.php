<?php
include_once 'Controller.php';
require_once '../app/Models/UserModel.php';

class UserController extends Controller
{
    protected $UserModel;

    public function __construct()
    {
        parent::__construct($this->router);
        $this->UserModel = new UserModel();  // Initialize UserModel here
    }

    public function loginForm()
    {
        $loginUrl = $this->router->generate('login');
        require '../app/Views/Auth/login.php'; // Load the login view
    }

    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Use the initialized UserModel to find the user by email
        $user = $this->UserModel->findByEmail($email);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header('Location: /');
                exit();
            } else {
                $_SESSION['errors'][] = 'incorrect password';
            }
        }
        else {
            $_SESSION['errors'][] = 'user not found';
        }
        header('Location: ' . $this->router->generate('login'));
        exit();
    }


    public function logout()
    {
        session_destroy();
        header('Location: /');
        exit();
    }
}
