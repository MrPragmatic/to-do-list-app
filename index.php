<?php
include_once 'templates/header.php';
// include authentication
include_once 'includes/auth.php';

// If the user is not logged in, redirect from root to login.php
if (!isUserLoggedIn()) {
    header('Location: login.php');
    exit();
}

// Check whether user is logged in
if (isUserLoggedIn()) {
    include_once 'templates/taskspace.php'; // Include the template for the task space
} else {
    include_once 'templates/login.php'; // Include the login template
}

include_once 'templates/footer.php';
