<?php
require_once 'BaseModel.php';

class DocumentModel extends BaseModel
{
    public function __construct()
    {
        // Pass the table name 'courses' to the parent constructor
        parent::__construct('documents');
    }

    public function getLatestVersion($projectId, $milestoneId)
    {
        $sql = "SELECT MAX(version) as version FROM documents WHERE project_id = :project_id AND milestone_id = :milestone_id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
        $stmt->bindParam(':milestone_id', $milestoneId, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result) {
            return $result['version'];
        } else {
            return 0;
        }
    }


    public function selectByStudent($project_id, $milestone_id)
    {
        $user_id = $_SESSION['user']['id'];
        // Now, use this 'id' to query the documents table
        $sql = "SELECT * FROM documents WHERE project_id = :project_id AND user_id = :user_id AND milestone_id = :milestone_id ORDER BY version DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':project_id', $project_id, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':milestone_id', $milestone_id, PDO::PARAM_INT);
        $stmt->execute();

        $document = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($document) {

            return $document;
        } else {
            return null;
        }
    }


    public function selectDetails($condition = null)
    {
        // Base SQL for latest documents, now including the refined total_grade subquery
        $baseSqlLatest = "SELECT
                            d.id,
                            d.project_id,
                            d.user_id,
                            d.milestone_id,
                            d.version,
                            d.path,
                            d.created_at,
                            d.updated_at,
                            m.title,
                            m.short,
                            (SELECT
                                -- Check if the count of grades entered matches the total submilestones for this milestone
                                CASE
                                    WHEN COUNT(g.id) = (SELECT COUNT(*) FROM submilestones sm_check WHERE sm_check.milestone_id = m.id)
                                    THEN SUM(g.grade) -- If counts match, show the sum
                                    ELSE NULL         -- Otherwise, return NULL
                                END
                             FROM grades g
                             JOIN submilestones sm ON g.submilestone_id = sm.id
                             WHERE g.project_id = d.project_id -- Match the project from the outer query
                               AND sm.milestone_id = m.id      -- Match the milestone from the outer query
                            ) AS total_grade
                          FROM documents d
                          JOIN milestones m ON d.milestone_id = m.id
                          WHERE d.version = (
                              SELECT MAX(d2.version)
                              FROM documents d2
                              WHERE d2.project_id = d.project_id
                                AND d2.milestone_id = d.milestone_id
                          )";

        // Base SQL for older documents (grade calculation not modified here)
        $baseSqlOlder = "SELECT
                            d.id,
                            d.project_id,
                            d.user_id,
                            d.milestone_id,
                            d.version,
                            d.path,
                            d.created_at,
                            d.updated_at,
                            m.title,
                            m.short
                          FROM documents d
                          JOIN milestones m ON d.milestone_id = m.id
                          WHERE d.version < (
                              SELECT MAX(d2.version)
                              FROM documents d2
                              WHERE d2.project_id = d.project_id
                                AND d2.milestone_id = d.milestone_id
                          )";

        if ($condition) {
            // !! SECURITY WARNING: Direct concatenation is unsafe !!
            // Refactor to use prepared statement parameters for $condition
            $sqlLatest = $baseSqlLatest . " AND $condition";
            $sqlOlder = $baseSqlOlder . " AND $condition";

            $stmtLatest = $this->db->prepare($sqlLatest);
            // Bind parameters for $condition here if using placeholders
            $stmtLatest->execute();
            $latestDocuments = $stmtLatest->fetchAll(PDO::FETCH_ASSOC);

            $stmtOlder = $this->db->prepare($sqlOlder);
            // Bind parameters for $condition here if using placeholders
            $stmtOlder->execute();
            $olderDocuments = $stmtOlder->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $sqlLatest = $baseSqlLatest; // Use the base query without extra conditions
            $sqlOlder = $baseSqlOlder;   // Use the base query without extra conditions

            $stmtLatest = $this->db->prepare($sqlLatest);
            $stmtLatest->execute();
            $latestDocuments = $stmtLatest->fetchAll(PDO::FETCH_ASSOC);

            $stmtOlder = $this->db->prepare($sqlOlder);
            $stmtOlder->execute();
            $olderDocuments = $stmtOlder->fetchAll(PDO::FETCH_ASSOC);
        }

        return [
            'latest' => $latestDocuments,
            'older' => $olderDocuments,
        ];
    }


    public function selectGrade($id)
    {
        $sql = "SELECT
    d.id,
    d.project_id,
    d.user_id,
    d.milestone_id,
    d.version,
    d.path,
    d.created_at,
    d.updated_at,
    m.title AS milestone_title,
    m.short AS milestone_short,
    (
        SELECT
            CASE
                WHEN COUNT(g.id) = (
                    SELECT COUNT(*) 
                    FROM submilestones sm_check 
                    WHERE sm_check.milestone_id = m.id
                )
                THEN SUM(g.grade)
                ELSE NULL
            END
        FROM grades g
        JOIN submilestones sm ON g.submilestone_id = sm.id
        WHERE g.project_id = d.project_id
          AND sm.milestone_id = m.id
    ) AS total_grade
FROM documents d
JOIN milestones m ON d.milestone_id = m.id
WHERE d.id = :id
";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
