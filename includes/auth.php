<?php

if (session_status() == PHP_SESSION_NONE) {
    // Start the session only if it hasn't been started yet
    session_start();
}

if (!function_exists('isUserLoggedIn')) {
    function isUserLoggedIn() {
        return isset($_SESSION['user_id']);
    }
}

if (!function_exists('redirectIfNotLoggedIn')) {
    function redirectIfNotLoggedIn() {
        if (!isUserLoggedIn()) {
            header('Location: login.php');
            exit();
        }
    }
}

?>