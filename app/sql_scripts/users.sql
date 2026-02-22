CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20) UNIQUE NOT NULL,  -- Added phone field
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'supervisor', 'student') NOT NULL,
    gender ENUM('Male', 'Female') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
