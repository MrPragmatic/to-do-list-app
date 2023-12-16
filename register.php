<?php
include_once 'includes/db.php';
include_once 'templates/header.php';

if (session_status() == PHP_SESSION_NONE) {
    // Start the session only if it hasn't been started yet
    // and ensure session is active
    session_start();
}

// Function to generate CSRF token
function generate_csrf_token() {
    return bin2hex(random_bytes(32));
}

// Generate CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generate_csrf_token();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        exit("Invalid CSRF token");
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize inputs

    // Hash the password with Argon2ID
    $hashedPassword = password_hash($password, PASSWORD_ARGON2ID);

    // Insert user into the database
    $query = "INSERT INTO users (username, password_hash) VALUES ('$username', '$hashedPassword')";
    $result = $dbConnection->getDb()->exec($query);

    if ($result) {
        // Registration successful, redirect to login page
        header('Location: login.php');
        exit();
    } else {
        // Registration failed
        echo "Registration failed.";
    }
}

// Include registration form
include_once 'templates/register.php';
