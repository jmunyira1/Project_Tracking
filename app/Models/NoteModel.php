<?php
require_once 'BaseModel.php';

class NoteModel extends BaseModel
{
    public function __construct()
    {
        // Pass the table name 'Notes' to the parent constructor
        parent::__construct('notes');
    }

    public function getNotes($document_id, $user_id = null, $user_condition = '=')
    {
        $sql = "SELECT 
                    n.id AS note_id, 
                    n.note, 
                    n.is_checked, 
                    n.created_at AS note_created_at, 
                    n.updated_at AS note_updated_at, 
                    d.id AS document_id, 
                    m.short AS milestone_short, 
                    m.title AS milestone_title, 
                    n.user_id AS note_user_id
                FROM notes n
                JOIN documents d ON n.document_id = d.id
                JOIN milestones m ON d.milestone_id = m.id
                WHERE n.is_checked != 1 AND d.id = :document_id";

        if ($user_id !== null) {
            $sql .= " AND n.user_id $user_condition :user_id";
        }

        $sql .= " ORDER BY n.created_at DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':document_id', $document_id, PDO::PARAM_INT);

        if ($user_id !== null) {
            $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        }

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
