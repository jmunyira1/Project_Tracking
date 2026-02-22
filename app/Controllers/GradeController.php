<?php
include_once 'Controller.php';
require_once '../app/Models/GradeModel.php';
require_once '../app/Models/DocumentModel.php';

class GradeController extends Controller
{
    private $GradeModel;

    public function __construct()
    {
        parent::__construct();
        $this->GradeModel = new GradeModel();
    }

    public function save()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['document_id'], $_POST['grade'], $_POST['submilestone_id'])) {
            $document_id = intval($_POST['document_id']);
            $grade = trim($_POST['grade']);
            $submilestone_id = intval($_POST['submilestone_id']);

            $documentModel = new DocumentModel();
            $document = $documentModel->selectAll("id = $document_id");

            if (!$document) {
                echo json_encode(["success" => false, "message" => "Document not found"]);
                exit;
            }

            $project_id = $document[0]['project_id'];
            $gradeModel = new GradeModel();

            // Check if the grade already exists for this document and submilestone
            $existingGrade = $gradeModel->selectAll("document_id = $document_id AND submilestone_id = $submilestone_id");

            if ($existingGrade) {
                // Update the existing grade record by using its primary key (id)
                $updated = $gradeModel->update(["grade" => $grade], $existingGrade[0]['id']);
            } else {
                // Insert a new grade record including document_id
                $updated = $gradeModel->insert([
                    'grade' => $grade,
                    'document_id' => $document_id,
                    'project_id' => $project_id,
                    'submilestone_id' => $submilestone_id,
                    'supervisor_id' => $_SESSION['user']['id'],
                ]);
            }

            if ($updated) {
                echo json_encode(["success" => true, "grade" => $grade]);
            } else {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to save grade. Debug Info: grade = $grade, document_id = $document_id, project_id = $project_id, submilestone_id = $submilestone_id"
                ]);
            }
            exit;
        }

        echo json_encode(["success" => false, "message" => "Invalid request"]);
        exit;

    }

    public function submit_grades()
    {

    }
}
