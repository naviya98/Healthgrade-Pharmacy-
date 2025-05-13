<?php
/**
 * Add to Cart API Endpoint
 * Handles AJAX requests to add products to the cart
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
if (!isset($_POST['product_id']) || !is_numeric($_POST['product_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid product ID'
    ]);
    exit;
}

$product_id = (int)$_POST['product_id'];
$quantity = isset($_POST['quantity']) && is_numeric($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

// Add to cart
$result = add_to_cart($product_id, $quantity);

if ($result) {
    // Get updated cart count
    $cart_count = get_cart_count();
    
    echo json_encode([
        'success' => true,
        'message' => 'Product added to cart',
        'cart_count' => $cart_count
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Failed to add product to cart'
    ]);
}