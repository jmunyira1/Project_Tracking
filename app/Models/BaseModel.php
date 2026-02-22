<?php
//require_once '../../config/Database.php';
require_once __DIR__ . '/../../config/Database.php';

class BaseModel
{
    protected $db; // Database connection
    protected $table; // Table name

    public function __construct($table)
    {
        $this->db = Database::getConnection();  // Get the DB connection from the Database class
        $this->table = $table;
    }

    // Fetch all rows from the table or rows that match a condition
    public function selectAll($condition = null)
    {
        if ($condition) {
            $sql = "SELECT * FROM {$this->table} WHERE $condition";
        } else {
            $sql = "SELECT * FROM {$this->table}";
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insert a new row into the table
    public function insert($data)
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";

        $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }

    // Update an existing row in the table
    public function update($data, $id)
    {
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = :$key";
        }
        $set = implode(", ", $set);

        $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
        $stmt = $this->db->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->bindValue(":id", $id);

        return $stmt->execute();
    }

    // Delete a row from the table by id
    public function delete($id)
    {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    // Get the latest inserted record
    public function getLatestRecord()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
