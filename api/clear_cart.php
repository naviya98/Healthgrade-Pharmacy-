<?php
/**
 * Clear Cart API Endpoint
 * Handles AJAX requests to clear the entire cart
 */

// Include database connection and cart functions
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';
require_once '../includes/cart_functions.php';

// Set response content type to JSON
header('Content-Type: application/json');

// Check for POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Clear the cart
$result = clear_cart();

if ($result) {
    echo json_encode([
        'success' => true,
        'message' => 'Cart cleared successfully'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to clear cart'
    ]);
}