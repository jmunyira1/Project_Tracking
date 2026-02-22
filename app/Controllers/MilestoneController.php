<?php
include_once 'Controller.php';

require_once '../app/Models/MilestoneModel.php';
require_once '../app/Models/DocumentModel.php';
require_once '../app/Models/NoteModel.php';

class MilestoneController extends Controller
{
    private $MilestoneModel;

    public function __construct()
    {
        parent::__construct();
        $this->MilestoneModel = new MilestoneModel();
    }

    public function index()
    {
        $milestones = $this->MilestoneModel->selectAll();
        require '../app/Views/Admin/milestones.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'no' => $_POST['order']
            ];
            $this->MilestoneModel->insert($data);
            header('Location: /Milestones');
        }
    }

    public function show($milestone_short)
    {

        $current_milestone = $this->MilestoneModel->selectShort($milestone_short);

        $documents = new DocumentModel();
        $project_id = $_SESSION['user']['project_id'];

        $documents = $documents->selectByStudent($project_id, $current_milestone['id']);
        $notes = new NoteModel();
        $pnotes = $supervisor_notes = [];
        $m_id = $documents[0]['id'];
        $noteModel = new NoteModel();
        $pnotes = $noteModel->getNotes($m_id, $_SESSION['user']['id']);
        $supervisor_notes = $noteModel->getNotes($m_id, $_SESSION['user']['id'], '!=');


        require '../app/Views/Student/milestone.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'no' => $_POST['order'],
            ];
            $this->MilestoneModel->update($data, $id);
            header('Location: /Milestones');
        }
    }

    public function showmilestone($milestone_short)
    {
        // Get the milestone ID from the database using the short code
        $newmilestoneid = $this->MilestoneModel->selectShort($milestone_short);

        if (!$newmilestoneid) {
            // Handle the error if the milestone code does not exist
            echo "Milestone not found.";
            exit; // Or redirect to a different page
        }
        $xmilestone = $newmilestoneid['title'];
        $newmilestoneid = $newmilestoneid['id'];

        // Use the MilestoneModel to get the data
        $projectsAndDocuments = $this->MilestoneModel->getDocumentsByMilestone($_SESSION['user']['id'], $newmilestoneid);


        // Organize the data for easier display in the view
        $organizedData = [];
        foreach ($projectsAndDocuments as $item) {
            $projectId = $item['project_id'];
            if (!isset($organizedData[$projectId])) {
                $organizedData[$projectId] = [
                    'project_id' => $projectId,
                    'project_title' => $item['title'],
                    'student_name' => $item['username'],
                    'milestone_id' => $item['milestone_id'],
                    'documents' => [],
                    'student_reg_no' => $item['reg_number'],
                    'course' => $item['course'],
                ];
            }
            if ($item['document_id']) {
                $grade = new DocumentModel; // Only add document if it exists
                $organizedData[$projectId]['documents'][] = [
                    'document_id' => $item['document_id'],
                    'document_path' => $item['document_path'],
                    'document_version' => $item['version'],
                    'grade' => $grade->selectGrade($item['document_id'])['total_grade']


                ];
            }
        }
        $projects = $organizedData;
        require '../app/Views/Supervisor/milestone.php';
    }
}
