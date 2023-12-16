<?php

function logSecurityEvent($message) {
    // Specify the path to your access.log file
    $accessLogPath = __DIR__ . "/access.log";

    // Add timestamp to the message
    $logMessage = date('Y-m-d H:i:s') . ' ' . $message . PHP_EOL;

    // Use the same file for security events
    error_log($logMessage, 3, $accessLogPath);
}
