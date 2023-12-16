<?php
include_once 'includes/db.php';
include_once 'templates/header.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate and sanitize inputs

    // Hash the password with Argon2ID as recommended by OWASP:
    // https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html
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
