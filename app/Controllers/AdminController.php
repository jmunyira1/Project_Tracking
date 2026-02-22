<?php
include_once 'UserController.php';
include_once '../app/Models/ProjectModel.php';

class AdminController extends UserController
{
    

    public function index()
    {

        $totalProjects = new ProjectModel();
        $pendingProjects = $totalProjects->selectAll('status="Pending"');
        $pendingProjects = count($pendingProjects);
        $completedProjects = $totalProjects->countCompleted();
        $milestoneProgress = $totalProjects->getMilestoneProgress();

        $totalProjects = $totalProjects->selectAll();

        $totalProjects=count($totalProjects);
        $totalStudents = $this->UserModel->selectAll('role = "student"');
        $totalStudents = count($totalStudents);
        $totalSupervisors = $this->UserModel->selectAll('role = "supervisor"');
        $totalSupervisors = count($totalSupervisors);

        require '../app/Views/Admin/index.php';
    }

    public function manage_admins()
    {
        $admins = $this->UserModel->selectAll('role = "admin"');
        require '../app/Views/Admin/admins.php';
    }
}
