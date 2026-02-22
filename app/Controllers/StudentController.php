<?php

require_once '../app/Models/StudentModel.php';
require_once '../app/Models/ProjectModel.php';
include_once 'UserController.php';
include_once 'CourseController.php';

class StudentController extends UserController
{
    protected $StudentModel;
    protected $ProjectModel;

    public function __construct()
    {
        parent::__construct($this->router);
        $this->StudentModel = new StudentModel();  // Initialize UserModel here
        $this->ProjectModel = new ProjectModel();  // Initialize ProjectModel here
    }
    public function index()
    {
        $project = $this->ProjectModel->selectAll('student_id = ' . $_SESSION['user']['id']);
        $project = $project ? $project[0] : null;
        if ($project) {
            $_SESSION['user']['project_id'] = $project['project_id'];
        }

        $progress = 0; // Default progress
        if ($project) {
            $progress = $this->ProjectModel->getProjectProgress($project['project_id']);

        }
        $finalGrade = $this->ProjectModel->projectGrade($project['project_id']);
     


        // The line below remains the same, it will now also pass $project and $progress to the view
       require_once '../app/Views/Student/index.php';
    }

    public function manage_students()
    {
        $students = $this->StudentModel->selectAll();
        $course_model = new CourseModel();
        $courses = $course_model->selectAll();
        require '../app/Views/Supervisor/students.php';
    }

    public function add_student()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $userData = [
                'username' => $_POST['username'],
                'email' => str_replace('/', '', $_POST['reg_number']) . '@students.kcau.ac.ke',
                'phone' => $_POST['phone'],
                'gender' => $_POST['gender'],
                'role' => 'student',
                'password' => password_hash($_POST['phone'], PASSWORD_DEFAULT)
            ];

            $studentData = [
                'reg_number' => $_POST['reg_number'],
                'course_id' => $_POST['course']
            ];
            $data = [
                'userData' => $userData,
                'studentData' => $studentData
            ];

            $this->StudentModel->insertStudent($data);

            header($this->router->generate('manage_students'));
        }
    }

    public function view_courses()
    {
        $course_model = new CourseModel();
        $courses = $course_model->selectAll();
        require '../app/Views/Student/courses.php';
    }
}
