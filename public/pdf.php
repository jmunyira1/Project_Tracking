<?php
session_start();
if (!isset($_SESSION['user'])) {
    http_response_code(403);
    die("Access Denied");
}
if (!isset($_GET['file'])) {
    http_response_code(400);
    die("Bad Request");
}

$file = $_SERVER['DOCUMENT_ROOT'] . '/../uploads/' . $_GET['file']; // Prevent directory traversal
if (file_exists($file) && pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
    header('Content-Type: application/pdf');
    readfile($file);
} else {
    http_response_code(404);
    echo "File not found!";
}

