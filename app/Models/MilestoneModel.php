<?php
require_once 'BaseModel.php';

class MilestoneModel extends BaseModel
{
    public function __construct()
    {
        // Pass the table name 'users' to the parent constructor
        parent::__construct('milestones');
    }

    public function selectAll($condition = null)
    {
        // Define the base query with an inner join to submilestones
        if ($condition) {
            $condition = str_replace('id', 'm.id', $condition);
        }
        $sql = "SELECT m.*, 
            IFNULL(SUM(sm.max_marks), 0) AS max_marks
            FROM {$this->table} m
            LEFT JOIN submilestones sm ON m.id = sm.milestone_id";

        // Add condition to filter the query if needed
        if ($condition) {
            $sql .= " WHERE $condition";
        }

        // Group by milestone id to calculate the sum of marks per milestone
        $sql .= " GROUP BY m.id ORDER BY m.no";

        // Prepare and execute the query
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        // Fetch and return the results as an associative array
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function selectShort($short)
    {
        // First, get the 'id' from the first query
        $sql = "SELECT * FROM {$this->table} WHERE short = :short";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['short' => $short]);

        // Fetch the 'id' from the result
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getUngradedMilestones($supervisorId = null)
    {
        if ($supervisorId) {
            $sql = "SELECT
        m.id AS milestone_id,
        m.title AS milestone_title
    FROM
        milestones m
    WHERE EXISTS (
        SELECT 1
        FROM documents d
        JOIN projects p ON d.project_id = p.id
        WHERE d.milestone_id = m.id AND p.supervisor_id = :supervisorId
        AND NOT EXISTS (SELECT 1 FROM grades g WHERE g.project_id = d.project_id AND g.milestone_id = m.id)
    )";
        } else {
            $sql = "SELECT
        m.id AS milestone_id,
        m.title AS milestone_title
    FROM
        milestones m
    WHERE EXISTS (
        SELECT 1
        FROM documents d
        JOIN projects p ON d.project_id = p.id
        WHERE d.milestone_id = m.id
        AND NOT EXISTS (SELECT 1 FROM grades g WHERE g.project_id = d.project_id AND g.milestone_id = m.id)
    )";
        }

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':supervisorId', $supervisorId, PDO::PARAM_INT); // Bind the supervisor ID
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the error appropriately
            error_log("Database error: " . $e->getMessage());
            return [];
        }
    }

    public function getDocumentsByMilestone($supervisorId, $milestoneId)
    {
        $sql = "SELECT
    d.path AS document_path,
    d.version,
    d.id as document_id,
    p.id AS project_id,
    p.supervisor_id,
    p.title,
    d.milestone_id,
    p.student_id,
    s.reg_number,
    u.username,
    c.code AS course  -- Include the course name
FROM
    documents d
JOIN
    projects p ON d.project_id = p.id
JOIN
    students s ON p.student_id = s.user_id
JOIN
    users u ON s.user_id = u.id
LEFT JOIN  -- Use LEFT JOIN in case a student doesn't have a course
    courses c ON s.course_id = c.id
WHERE d.milestone_id = :milestoneId
  AND p.supervisor_id = :supervisorId
  AND d.version = (SELECT MAX(d2.version)
                   FROM documents d2
                   WHERE d2.project_id = d.project_id
                   AND d2.milestone_id = d.milestone_id)
";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':supervisorId', $supervisorId, PDO::PARAM_INT);
        $stmt->bindParam(':milestoneId', $milestoneId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
