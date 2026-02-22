
<?php
require_once 'BaseModel.php';
require_once 'UserModel.php';

class StudentModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct('students'); // Define the students table

    }
    public function insertStudent($data)
    {
        // Insert into users table using UserModel
        $userModel = new UserModel();
        $userModel->insert($data['userData']);

        // Get the last inserted user ID
        $userId = $userModel->db->lastInsertId();
        if (!$userId) {
            throw new Exception("Failed to insert user.");
        }

        // Insert into students table with user_id reference
        $data['studentData']['user_id'] = $userId;
        $this->insert($data['studentData']);
    }

    public function selectAll($condition = null)
    {
        $sql = "SELECT u.*, s.reg_number AS 'reg_number', c.name AS 'course' FROM users u JOIN students s ON u.id = s.user_id JOIN courses c ON s.course_id = c.id";
        if ($condition) {
            $sql .= " WHERE $condition";
        }
        $sql .= " ORDER BY u.username;";
       
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
