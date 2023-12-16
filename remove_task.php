<?php
include_once 'includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $taskId = $_POST['taskId'];

    // Validate and sanitize input
    $taskId = filter_var($taskId, FILTER_VALIDATE_INT);

    if ($taskId !== false) {
        // Remove task from the database
        $query = "DELETE FROM tasks WHERE user_id = :user_id AND id = :task_id";
        $stmt = $dbConnection->getDb()->prepare($query);
        $stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
        $stmt->bindValue(':task_id', $taskId, SQLITE3_INTEGER);
        $result = $stmt->execute();

        if ($result) {
            // Task removed successfully, return success response
            echo json_encode(['success' => true]);
            exit();
        } else {
            // Task removal failed, return failure response
            echo json_encode(['success' => false, 'message' => 'Failed to remove task.']);
            exit();
        }
    } else {
        // Invalid task ID, return failure response
        echo json_encode(['success' => false, 'message' => 'Invalid task ID.']);
        exit();
    }
} else {
    // Redirect to login page if not logged in
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit();
}
