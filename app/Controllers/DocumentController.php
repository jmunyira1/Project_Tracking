<?php
include_once 'Controller.php';
require_once '../app/Models/DocumentModel.php';
require_once '../app/Models/StudentModel.php';
require_once '../app/Models/MilestoneModel.php';
require_once '../app/Models/NoteModel.php';
require_once '../app/Models/ProjectModel.php';
require_once '../app/Models/SubMilestoneModel.php';

class DocumentController extends Controller
{
    private $DocumentModel;

    public function __construct()
    {
        parent::__construct();
        $this->DocumentModel = new DocumentModel();
    }

    public function upload()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $project_id = $_POST['project_id'];
            $milestone = new MilestoneModel();
            $milestone = $milestone->selectAll("id =  " . $_POST['milestone_id']);
            $milestone = $milestone[0];
            $user_id = $_SESSION['user']['id'];
            $version = $this->DocumentModel->getLatestVersion($project_id, $milestone['id']) + 1;

            $student = new StudentModel();
            $student = $student->selectAll('user_id=' . $user_id);

            $student = $student[0];

            $student['reg_no'] = str_replace('/', '_', $student['reg_number']);
            if (isset($_FILES['document'])) {
                $file = $_FILES['document'];
                $fileName = $milestone['short'] . "_" . $student['reg_no'] . "_" . $student['username'] . "_v" . $version . "." . pathinfo($file['name'], PATHINFO_EXTENSION);
                $uploadDir = dirname($_SERVER['DOCUMENT_ROOT']) . "/uploads/{$student['reg_no']}/";

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filePath = "{$student['reg_no']}/" . $fileName;

                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    $data = [
                        'project_id' => $project_id,
                        'user_id' => $user_id,
                        'milestone_id' => $milestone['id'],
                        'version' => $version,
                        'path' => $filePath,
                    ];

                    $documentModel = new DocumentModel();

                    $result = $documentModel->insert($data);

                    if ($result === true) {
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit;
                    } else {
                        echo "Insert failed!<br>";
                        // Get PDO error info

                    }
                }
            }
        }
    }

    public function view($id)
    {
        $_SESSION['viewpdf'] = TRUE;
        $document = $this->DocumentModel->selectAll("id = $id");
        $document = $document[0];
        $m_id = $document['id'];
        $noteModel = new NoteModel();

        if ($_SESSION['user']['role'] == 'student') {
            $personal_notes = $noteModel->getNotes($m_id, $_SESSION['user']['id']);
            $supervisor_notes = $noteModel->getNotes($m_id, $_SESSION['user']['id'], '<>');
        } else {
            $supervisor_notes = $noteModel->getNotes($m_id, $_SESSION['user']['id']);

            $projectModel = new ProjectModel();
            // Pass the document id instead of project_id so that only submilestones for the current document's milestone are returned.
            $submilestones = $projectModel->getSubmilestones($document['id']);

            $project_id = $document['project_id']; // If needed elsewhere
        }
        require_once '../app/Views/viewpdf.php';

    }
}
