<?php
include_once 'includes/db.php';
session_start();

// Initialize response array
$response = [];

try {
    // Check if the request is a POST and the user is logged in
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
        // Get user ID from the session
        $userId = $_SESSION['user_id'];

        // Validate and sanitize input
        $task = filter_var($_POST['task'], FILTER_SANITIZE_STRING);

        // Use prepared statement to prevent SQL injection
        $query = "INSERT INTO tasks (user_id, task) VALUES (:user_id, :task)";
        $stmt = $dbConnection->getDb()->prepare($query);
        $stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
        $stmt->bindValue(':task', $task, SQLITE3_TEXT);

        // Execute the statement and handle errors
        $result = $stmt->execute();
        if ($result === false) {
            throw new Exception('Failed to execute the statement.');
        }

        // Task added successfully
        $taskId = $dbConnection->getDb()->lastInsertRowID();
        $response = [
            'success' => true,
            'taskId' => $taskId,
            'taskValue' => $task,
        ];
    } else {
        // User not logged in
        $response = [
            'success' => false,
            'message' => 'User not logged in.',
        ];
    }
} catch (Exception $e) {
    // Exception occurred, handle and log the error
    $response = [
        'success' => false,
        'message' => 'An error occurred: ' . $e->getMessage(),
    ];
}

// Clear any previous output
ob_clean();

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit();
