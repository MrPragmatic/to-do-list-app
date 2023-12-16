<?php
include_once 'includes/db.php';
include_once 'templates/header.php';
if (session_status() == PHP_SESSION_NONE) {
    // Start the session only if it hasn't been started yet
    // and ensure session is active
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate inputs
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $dbConnection->getDb()->prepare($query);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

    if ($result && password_verify($password, $result['password_hash'])) {
        // Login successful, set session and redirect to dashboard
        session_start();
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username']; // Set 'username' in the session
        header('Location: taskspace.php');
        exit();
    } else {
        // Login failed
        echo "Invalid username or password.";
    }
}

// Include login form
include_once 'templates/login.php';
