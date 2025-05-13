<?php
/**
 * API endpoint for available appointment times
 * Returns available time slots for a specific date in JSON format
 */

// Include database connection and functions
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');

// Check if request method is GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['error' => 'Only GET requests are allowed']);
    exit;
}

try {
    // Get date parameter from request
    $date = isset($_GET['date']) ? sanitize_input($_GET['date']) : null;
    
    // Validate date
    if (empty($date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Invalid date format. Please use YYYY-MM-DD format.']);
        exit;
    }
    
    // Check if date is in the past
    if ($date < date('Y-m-d')) {
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Please select a present or future date.']);
        exit;
    }
    
    // Get available time slots for the date
    $available_times = get_available_appointment_times($conn, $date);
    
    // Return available times as JSON
    echo json_encode(['date' => $date, 'available_times' => $available_times]);
    
} catch (Exception $e) {
    // Log the error
    error_log("API Error (available-times.php): " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while fetching available times']);
}

// Close database connection
$conn->close();