<?php
/**
 * API endpoint for appointments
 * Handles appointment booking and returns JSON response
 */

// Include database connection and functions
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';

// Set headers for JSON response
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode(['success' => false, 'message' => 'Only POST requests are allowed']);
    exit;
}

try {
    // Validate and sanitize input
    $name = sanitize_input($_POST['name'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $phone = sanitize_input($_POST['phone'] ?? '');
    $date = sanitize_input($_POST['date'] ?? '');
    $time = sanitize_input($_POST['time'] ?? '');
    $notes = sanitize_input($_POST['notes'] ?? '');
    
    // Validate required fields
    if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'All required fields must be filled']);
        exit;
    }
    
    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Please enter a valid email address']);
        exit;
    }
    
    // Validate phone number (basic validation)
    if (!preg_match('/^[0-9+\-\s()]{7,15}$/', $phone)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Please enter a valid phone number']);
        exit;
    }
    
    // Validate date (must be present or future date)
    $current_date = date('Y-m-d');
    if ($date < $current_date) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Please select a present or future date']);
        exit;
    }
    
    // Validate time (must be a valid time slot)
    $valid_times = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];
    if (!in_array($time, $valid_times)) {
        http_response_code(400); // Bad Request
        echo json_encode(['success' => false, 'message' => 'Please select a valid time slot']);
        exit;
    }
    
    // Check if appointment slot is available
    if (!is_appointment_slot_available($conn, $date, $time)) {
        http_response_code(409); // Conflict
        echo json_encode(['success' => false, 'message' => 'This appointment slot is no longer available. Please select another time.']);
        exit;
    }
    
    // Insert into database
    $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, appointment_date, appointment_time, notes, status, created_at) 
                            VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
                            
    if (!$stmt) {
        throw new Exception("Prepare failed: " . $conn->error);
    }
    
    $stmt->bind_param("ssssss", $name, $email, $phone, $date, $time, $notes);
    
    if ($stmt->execute()) {
        // Success
        $appointment_id = $stmt->insert_id;
        
        // Log the activity
        log_activity($conn, "New appointment booked for $date at $time (API)");
        
        // Return success response
        echo json_encode([
            'success' => true, 
            'message' => 'Your appointment has been scheduled successfully! We will contact you to confirm.', 
            'appointment_id' => $appointment_id
        ]);
    } else {
        throw new Exception("Execute failed: " . $stmt->error);
    }
    
    $stmt->close();
    
} catch (Exception $e) {
    // Log the error
    error_log("API Error (appointments.php): " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'An error occurred while booking your appointment. Please try again.']);
}

// Close database connection
$conn->close();