<?php
include_once 'includes/db.php';
include_once 'templates/header.php';

// Start the session only if it hasn't been started yet
// and ensure session is active
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
// Do not create CSRF token for the insecure version
//
// Function to generate CSRF token
function generate_csrf_token() {
    return bin2hex(random_bytes(32));
}

// Generate CSRF token and store it in the session
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = generate_csrf_token();
}
*/

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /* Disable CSRF token validation from insecure branch version
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        exit("Invalid CSRF token");
    }
    */

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "INSERT INTO users (username, password_hash) VALUES ('$username', '$password')";
    $result = $dbConnection->getDb()->exec($query);

    if ($result) {
        // Registration successful, redirect to login page

        // Log successful registration, disable logs for the insecure version
        // logSecurityEvent("User $username registered successfully");

        /*
        //
        // Disable session id management and secure attributes for the insecure version
        // Regenerate session ID
        session_regenerate_id(true);

        // Set session attributes securely
        session_set_cookie_params([
            'lifetime' => 3600, // Session lifetime in seconds 1 hour
            'path' => '/',
            'domain' => 'localhost', // Use the appropriate domain in production
            'secure' => false, // True for production when using https
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
        */

        header('Location: login.php');
        exit();
    } else {
        // Registration failed

        // Log failed registration attempt
        logSecurityEvent("Failed registration attempt for username $username");

        echo "Registration failed.";
    }
}

// Include registration form
include_once 'templates/register.php';
