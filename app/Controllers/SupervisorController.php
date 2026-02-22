<?php
include_once 'UserController.php';
include_once 'CourseController.php';
include_once '../app/Models/ProjectModel.php';
include_once '../app/Models/MilestoneModel.php';

class SupervisorController extends UserController
{

    public function index()
    {
        $totalProjects = new ProjectModel();
        $completedProjects =0;
            $unapprovedProjects = $totalProjects->selectAll('supervisor_id = ' . $_SESSION['user']['id'] . ' AND status != "Approved"');
        $unapprovedProjects = count($unapprovedProjects);
        $totalProjects = $totalProjects->selectAll('supervisor_id = ' . $_SESSION['user']['id'] . ' AND status = "Approved"');

        $totalProjects = count($totalProjects);


        require '../app/Views/Supervisor/index.php';
    }

    public function manage_supervisors()
    {
        $supervisors = $this->UserModel->selectAll('role = "supervisor"');
        require '../app/Views/Supervisor/supervisors.php';
    }

    public function add_supervisor()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'phone' => $_POST['phone'],
                'gender' => $_POST['gender'],
                'role' => 'supervisor',
                'password' => password_hash($_POST['phone'], PASSWORD_DEFAULT)
            ];


            $this->UserModel->insert($data);
            header($this->router->generate('manage_supervisors'));
        }
    }
}
