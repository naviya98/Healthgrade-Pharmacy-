<?php
/**
 * Get Cart API Endpoint
 * Returns cart contents in JSON format
 */

// Include database connection and cart functions
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';
require_once '../includes/cart_functions.php';

// Set response content type to JSON
header('Content-Type: application/json');

// Get cart contents
$cart = get_cart_contents();

// Return JSON response
echo json_encode([
    'success' => true,
    'cart' => $cart
]);