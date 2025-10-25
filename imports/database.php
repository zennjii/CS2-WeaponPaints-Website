<?php

if(!function_exists("Path")) {
    return;
}

// Function to validate database connection
function validateDatabaseConnection($pdo) {
    if (!$pdo) {
        return false;
    }
    
    try {
        $pdo->query("SELECT 1");
        return true;
    } catch (Exception $e) {
        error_log("Database connection validation failed: " . $e->getMessage());
        return false;
    }
}

$host = $DatabaseInfo['host'];
$database = $DatabaseInfo['database'];
$username = $DatabaseInfo['username'];
$password = $DatabaseInfo['password'];
$port = $DatabaseInfo['port'] ?? '3306';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;port=$port", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Test the connection
    $pdo->query("SELECT 1");
    
    return true;
}catch(Exception $err) {
    // Log error securely without exposing credentials
    error_log("Database connection failed: " . $err->getMessage());
    return false;
}

?>