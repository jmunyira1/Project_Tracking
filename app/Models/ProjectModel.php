
<?php
require_once 'BaseModel.php';

class ProjectModel extends BaseModel
{
    public function __construct()
    {
        // Pass the table name 'projects' to the parent constructor
        parent::__construct('projects');
    }


    public function selectAll($condition = null)
    {
        $sql = "SELECT p.id AS project_id,
            p.title,
            p.description,
            p.status,
            p.created_at,
            p.updated_at,
            s.id AS student_id,
            s.username AS student_name,
            s.email AS student_email,
            st.reg_number AS student_reg_no,
            c.code AS course,
            sp.id AS supervisor_id,
            sp.username AS supervisor_name,
            sp.email AS supervisor_email,
            -- Progress Calculation
            FLOOR(IFNULL((SELECT COUNT(DISTINCT d.milestone_id)
                           FROM documents d
                           WHERE d.project_id = p.id), 0) / :total_milestones * 100) AS progress
        FROM projects p
        JOIN users s ON p.student_id = s.id
        JOIN students st ON s.id = st.user_id
        LEFT JOIN courses c ON st.course_id = c.id
        LEFT JOIN users sp ON p.supervisor_id = sp.id";

        // Add WHERE clause if condition is provided
        if ($condition !== null) {
            $sql .= " WHERE $condition";
        }

        $sql .= " ORDER BY progress DESC"; // Order by progress

        $stmt = $this->db->prepare($sql);

        $stmt->bindValue(
            ':total_milestones',
            $this->db->query("SELECT COUNT(*) FROM milestones")->fetchColumn(),
            PDO::PARAM_INT
        );

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function supervisor_projects($supervisor_id, $status = 'Approved')
    {
        // Get total number of milestones
        $milestone_count_sql = "SELECT COUNT(*) AS total_milestones FROM milestones";
        $milestone_stmt = $this->db->prepare($milestone_count_sql);
        $milestone_stmt->execute();
        $total_milestones = $milestone_stmt->fetchColumn();

        $sql = "SELECT
            p.id AS project_id, p.title, p.description, p.status,
            p.created_at, p.updated_at,
            s.id AS student_id, s.username AS student_name, s.email AS student_email,
            st.reg_number AS student_reg_no,
            c.code AS course,
            sp.id AS supervisor_id, sp.username AS supervisor_name, sp.email AS supervisor_email,
            FLOOR(IFNULL((COUNT(DISTINCT d.milestone_id) / :total_milestones) * 100, 0)) AS progress
        FROM projects p
        JOIN users s ON p.student_id = s.id
        JOIN students st ON s.id = st.user_id
        LEFT JOIN courses c ON st.course_id = c.id
        LEFT JOIN users sp ON p.supervisor_id = sp.id
        LEFT JOIN documents d ON p.id = d.project_id
        WHERE p.status = :status";

        $whereParams = [':status' => $status]; // Use an array to manage parameters

        if ($_SESSION['user']['role'] == 'supervisor') {
            $sql .= " AND p.supervisor_id = :supervisor_id";
            $whereParams[':supervisor_id'] = $supervisor_id; // Add supervisor_id to the array
        }

        $sql .= " GROUP BY p.id ORDER BY progress DESC"; // Append GROUP BY and ORDER BY

        $stmt = $this->db->prepare($sql);

        // Bind parameters from the array
        foreach ($whereParams as $param => $value) {
            $stmt->bindValue($param, $value);
        }
        $stmt->bindValue(':total_milestones', $total_milestones, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProjectDetails($project_id)
    {
        $sql = "SELECT p.id AS project_id, p.title, p.description, p.status, 
                           s.id AS student_id, s.username AS student_name, s.email AS student_email, 
                           st.reg_number AS student_reg_no, c.code AS course
                    FROM projects p
                    JOIN users s ON p.student_id = s.id
                    JOIN students st ON s.id = st.user_id
                    LEFT JOIN courses c ON st.course_id = c.id
                    WHERE p.id = :project_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getProjectProgress($project_id)
    {
        $total_milestones = count($this->db->query("SELECT id FROM milestones")->fetchAll(PDO::FETCH_ASSOC));

        $sql = "SELECT COUNT(DISTINCT milestone_id) AS completed_milestones 
                    FROM documents WHERE project_id = :project_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->execute();
        $completed_milestones = $stmt->fetch(PDO::FETCH_ASSOC)['completed_milestones'];

        return $total_milestones > 0 ? floor(($completed_milestones / $total_milestones) * 100) : 0;
    }

    public function getSubmilestones($document_id)
    {
        $sql = "SELECT 
                    sm.id AS submilestone_id,
                    sm.name,
                    sm.max_marks,
                    g.grade
                FROM submilestones sm
                JOIN documents d ON d.milestone_id = sm.milestone_id
                LEFT JOIN grades g ON sm.id = g.submilestone_id AND g.document_id = d.id
                WHERE d.id = :document_id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':document_id', $document_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countCompleted()
    {
        $sql = "SELECT p.*
FROM projects p
WHERE (
    SELECT COUNT(*) 
    FROM grades g
    WHERE g.project_id = p.id
) = (
    SELECT COUNT(*) 
    FROM submilestones
);
";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getMilestoneProgress()
    {
        $sql = "SELECT
        m.title,
        COUNT(DISTINCT d.project_id) AS total_submitted,
        (SELECT COUNT(*) FROM projects) AS total_projects
    FROM
        milestones m
    LEFT JOIN
        documents d ON d.milestone_id = m.id
    GROUP BY
        m.id, m.title";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle the error appropriately (log, display message, etc.)
            error_log("Database error: " . $e->getMessage());
            return []; // Or throw an exception
        }
    }

    public function projectGrade($project_id)
    {
        $sql = "SELECT 
    g.project_id,
    ROUND(SUM(g.grade) / (
        SELECT SUM(DISTINCT s.max_marks)
        FROM grades g2
        JOIN submilestones s ON g2.submilestone_id = s.id
        WHERE g2.project_id = g.project_id
    ) * 100, 2) AS performance_percentage
FROM grades g
WHERE g.project_id = 1
GROUP BY g.project_id;
";

        $stmt = $this->db->prepare($sql);
       // $stmt->bindParam(':project_id', $project_id);
        $stmt->execute();

        //return $stmt->fetch(PDO::FETCH_ASSOC);
        return null;

    }
}
