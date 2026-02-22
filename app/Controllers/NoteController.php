<?php
include_once 'Controller.php';
require_once '../app/Models/NoteModel.php';

class NoteController extends Controller
{
    private $NoteModel;

    public function __construct()
    {
        parent::__construct();
        $this->NoteModel = new NoteModel();
    }

    public function save()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['note'])) {

            $document_id = $_POST['document_id'];
            $note = trim($_POST['note']);

            $noteModel = new NoteModel();
            $inserted = $noteModel->insert([
                'document_id' => $document_id,
                'note' => $note,
                'user_id' => $_SESSION['user']['id']
            ]);
            $note = $noteModel->getLatestRecord();

            // Return JSON response
            echo json_encode([
                "success" => $inserted,
                "note" => $note
            ]);
            exit;
        }

        echo json_encode(["success" => false]);
        exit;
    }

    public function mark()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST['note'])) {
            
            $note_id = $_POST['note'];
            $noteModel = new NoteModel();
            
            $note = $noteModel->selectAll("id = $note_id");

            if (!empty($note)) {
                $note = $note[0];
                
               $noteModel->update(['is_checked' => 1], $note_id);
               $_SESSION['success'] = "Note marked as done";
               header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }
        } else {
            $_SESSION['errors'][] = "Note not found";
        }
    }
 
    
}
