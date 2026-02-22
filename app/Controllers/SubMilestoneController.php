<?php
include_once 'Controller.php';
require_once '../app/Models/SubMilestoneModel.php';
require_once '../app/Models/MilestoneModel.php';

class SubMilestoneController extends Controller
{
    private $SubMilestoneModel;

    public function __construct()
    {
        parent::__construct();
        $this->SubMilestoneModel = new SubMilestoneModel();
    }

    public function index()
    {
        $milestones = new MilestoneModel();
        $milestones = $milestones->selectAll();
    
        // Fetch all submilestones
        $submilestones = $this->SubMilestoneModel->selectAll();
        require '../app/Views/Admin/submilestones.php';
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $milestone_id = $_POST['milestone_id'];
            $name = $_POST['name'];
            $max_marks = $_POST['max_marks'];
            $percentage = $_POST['percentage'];

            $data = [
                'milestone_id' => $milestone_id,
                'name' => $name,
                'max_marks' => $max_marks,
                'percentage' => $percentage
            ];

            $this->SubMilestoneModel->insert($data);
            // Redirect to the index page after successful insertion    
            header('Location: ' . $this->router->generate('grading_criteria'));
        }
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $max_marks = $_POST['max_marks'];
            $percentage = $_POST['percentage'];

            $data = [
                'name' => $name,
                'max_marks' => $max_marks,
                'percentage' => $percentage
            ];

            $this->SubMilestoneModel->update($data, $id);
            // Redirect to the index page after successful update    
            header('Location: ' . $this->router->generate('grading_criteria'));
        }
    }
}
