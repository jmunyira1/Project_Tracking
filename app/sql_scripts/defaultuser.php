<?php
// Database connection
$host = 'localhost';
$dbname = 'project';
$username = 'root';  // Change this if using a different DB user
//$password = 'D@t@b@53';      // Change this if your DB has a password
$password = 'munyira';

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if admin already exists
    $checkStmt = $db->prepare("SELECT id FROM users WHERE role = 'admin' LIMIT 1");
    $checkStmt->execute();
    $existingAdmin = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($existingAdmin) {
        echo "Admin user already exists.\n";
    } else {
        // Default admin details
        $adminUsername = 'admin';
        $adminEmail = 'admin@mail.com';
        $adminPhone = '0711318428';
        $adminPassword = '20252025';  // Change this to a secure password
        $hashedPassword = password_hash($adminPassword, PASSWORD_BCRYPT);

        // Insert default admin
        $stmt = $db->prepare("INSERT INTO users (username, email, phone, password, role) 
                              VALUES (:username, :email, :phone, :password, :role)");

        $stmt->execute([
            ':username' => $adminUsername,
            ':email' => $adminEmail,
            ':phone' => $adminPhone,
            ':password' => $hashedPassword,
            ':role' => 'admin'
        ]);

        echo "Default admin user created successfully.\n";
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
