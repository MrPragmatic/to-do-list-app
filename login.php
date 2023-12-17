<?php
include_once 'includes/db.php';
include_once 'templates/header.php';
// include_once 'includes/logger.php';  // Remove logging from insecure version

if (session_status() == PHP_SESSION_NONE) {
    // Set session attributes securely before starting the session
    // remove session parameters from insecure version
    /*
    session_set_cookie_params([
    'lifetime' => 3600, // Session lifetime in seconds (1 hour)
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax',
    ]); */
    session_start();
}
/*
// Remove CSRF token generation and session ID creation to make app insecure

Reference for the code: https://levelup.gitconnected.com/top-15-best-practices-to-secure-php-apps-in-production-85be2b2f872e

// Function to generate CSRF token
function generate_csrf_token() {
    return bin2hex(random_bytes(32));
}

// Generate CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generate_csrf_token();
}

// Regenerate session ID after a successful login
if (isset($_SESSION['user_id'])) {
    session_regenerate_id(true);
}
*/ 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /*
    // Remove CSRF token validation, sanitazion and validation
    //
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        exit("Invalid CSRF token");
    }

    // Sanitize and validate inputs, remove from insecure version
    $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
    */
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use prepared statement to prevent SQL injection
    /*
    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $dbConnection->getDb()->prepare($query);
    $stmt->bindValue(':username', $username, SQLITE3_TEXT);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
    */
    // Instead of the above, let's use insecure DB statements
    // WARNING: This is insecure and susceptible to SQL injection! Concatenation
    // $query = "SELECT * FROM users WHERE username = '$username'";
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Use insecure concatenation to make it vulnerable to SQL injection
    $query = "SELECT * FROM users WHERE username = '" . $username . "'";
    $result = $dbConnection->getDb()->querySingle($query, true);

    // Remove hashed password hash verification to make it more insecure
    if (is_array($result) && array_key_exists('password_hash', $result) && password_verify($password, $result['password_hash'])) {
        // Login successful, set session and redirect to dashboard
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username'];

        // Log successful login, remove from insecure branch
        // logSecurityEvent("User $username logged in");

        header('Location: taskspace.php');
        exit();
    } else {
        // Login failed

        // Log failed login attempt, remove from insecure branch
        // logSecurityEvent("Failed login attempt for username $username");

        echo "Invalid username or password.";
    }

}

// Include login form
include_once 'templates/login.php';
