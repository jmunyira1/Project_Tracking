<?php
include_once 'Controller.php';
require_once '../app/Models/ProjectModel.php';
require_once '../app/Models/UserModel.php';
require_once '../app/Models/DocumentModel.php';
require_once '../app/Models/NoteModel.php';
class ProjectController extends Controller
{
    private $ProjectModel;
    public function __construct()
    {
        parent::__construct();
        $this->ProjectModel = new ProjectModel();
    }
    public function create()
    {
        $supervisors = new UserModel();
        $supervisors = $supervisors->selectAll('role = "supervisor"');
        require '../app/Views/Student/register_project.php';
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'supervisor_id' => $_POST['supervisor_id'],
                'student_id' => $_POST['user_id']
            ];
            if ($this->ProjectModel->insert($data)) {
                header('Location: /');
                exit();
            } else {
                // Handle error
                echo "Error: Could not save project.";
            }
        } else {
            // Handle invalid request method
            echo "Invalid request method.";
        }
    }
    public function unapproved()
    {
        $projects = $this->ProjectModel->supervisor_projects($_SESSION['user']['id'], 'Pending');
        require '../app/Views/Supervisor/unapproved_projects.php';
    }
    public function projects()
    {
        if ($_SESSION['user']['role'] == 'supervisor') {
            $projects = $this->ProjectModel->supervisor_projects($_SESSION['user']['id'], 'Approved', 2);
        } elseif ($_SESSION['user']['role'] == 'admin') {
            $projects = $this->ProjectModel->selectAll();
        }
        require '../app/Views/Supervisor/projects.php';
    }
    public function approve()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $projectId = $_POST['project_id'];
            $data = [
                'status' => 'Approved'
            ];
            if ($this->ProjectModel->update($data, $projectId)) {
                header('Location: /');
                exit();
            } else {
                // Handle error
                echo "Error: Could not approve project.";
            }
        } else {
            // Handle invalid request method
            echo "Invalid request method.";
        }
    }
    public function show($id)
    {
        $projectModel = new ProjectModel();
        // Get project details
        $project = $projectModel->getProjectDetails($id);
        if (!$project) {
            return "Project not found!";
        }
        // Fetch related data
        $progress = $projectModel->getProjectProgress($id);
        $documents = new DocumentModel();
        $documents = $documents->selectDetails("project_id = $id");
        $latestDocuments = $documents['latest'];
        $olderDocuments = $documents['older'];
        // Load the view
        require '../app/Views/Supervisor/project.php';
    }
}
