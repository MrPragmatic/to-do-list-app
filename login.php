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

// Set session attributes securely
session_set_cookie_params([
    'lifetime' => 3600, // Session lifetime in seconds 1 hour
    'path' => '/',
    'domain' => 'localhost', // Use the appropriate domain in production
    'secure' => false, // True for production when using https
    'httponly' => true,
    'samesite' => 'Lax',
]);

// Regenerate session ID after a successful login
if (isset($_SESSION['user_id'])) {
    session_regenerate_id(true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        exit("Invalid CSRF token");
    }

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
