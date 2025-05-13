<?php
/**
 * Update Cart API Endpoint
 * Handles AJAX requests to update cart item quantities
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

// Validate input
if (!isset($_POST['item_id']) || !is_numeric($_POST['item_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid item ID'
    ]);
    exit;
}

if (!isset($_POST['quantity']) || !is_numeric($_POST['quantity'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid quantity'
    ]);
    exit;
}

$item_id = (int)$_POST['item_id'];
$quantity = (int)$_POST['quantity'];

// Update cart item
$result = update_cart_item($item_id, $quantity);

if ($result) {
    // Get updated cart information
    $cart = get_cart_contents();
    
    echo json_encode([
        'success' => true,
        'message' => 'Cart updated successfully',
        'cart_count' => get_cart_count(),
        'cart_total' => $cart['total'],
        'item_count' => $cart['item_count']
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to update cart'
    ]);
}