<?php
/**
 * Database Connection File
 * 
 * This file handles the connection to the MySQL database for the Healthgrade Pharmacy website.
 * It defines the database credentials and establishes a connection.
 */

// Define database connection parameters
$servername = "localhost";     // Server name or IP address
$username = "root";           // MySQL username
$password = "699883";               // MySQL password
$dbname = "healthgrade_pharmacy";  // Database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // If connection fails, log the error
    error_log("Database connection failed: " . $conn->connect_error);
    
    // You can choose to display a user-friendly error message
    // Comment this out in production to avoid showing sensitive information
    die("Connection failed: Database is currently unavailable. Please try again later.");
}

// Set character set to UTF-8
if (!$conn->set_charset("utf8")) {
    error_log("Error loading character set utf8: " . $conn->error);
}

/**
 * Note: In a production environment, you should:
 * 1. Store connection details in a separate configuration file
 * 2. Use environment variables for sensitive information
 * 3. Implement proper error handling that doesn't expose sensitive details
 */