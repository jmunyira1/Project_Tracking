<?php
require_once 'BaseModel.php';

class UserModel extends BaseModel {
    public function __construct() {
        // Pass the table name 'users' to the parent constructor
        parent::__construct('users');
    }

    // Find a user by email
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = :email");
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
