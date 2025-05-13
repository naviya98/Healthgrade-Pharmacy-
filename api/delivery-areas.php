<?php
/**
 * API endpoint for delivery areas
 * Returns delivery areas data in JSON format
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
    // Get all delivery areas
    $areas = get_delivery_areas($conn, true);
    
    // Return delivery areas as JSON
    echo json_encode($areas);
    
} catch (Exception $e) {
    // Log the error
    error_log("API Error (delivery-areas.php): " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode(['error' => 'An error occurred while fetching delivery areas']);
}

// Close database connection
$conn->close();