<?php
include_once 'includes/db.php';
include_once 'templates/header.php';

if (session_status() == PHP_SESSION_NONE) {
    // Start the session only if it hasn't been started yet
    // and ensure the session is active
    session_start();
}

if (isset($_SESSION['user_id'])) {
    // Fetch user tasks from the database
    $userId = $_SESSION['user_id'];

    // Use prepared statement to prevent SQL injection, removed from insecure version
    $query = "SELECT * FROM tasks WHERE user_id = :user_id";
    $stmt = $dbConnection->getDb()->prepare($query);
    $stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
    $result = $stmt->execute();

    // Fetch tasks as an associative array
    $tasks = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $tasks[] = $row;
    }

    // Display tasks and form for adding new tasks
    include_once 'templates/taskspace.php';
} else {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}
