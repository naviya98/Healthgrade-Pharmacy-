<?php
/**
 * Cart Functions for HealthgradePharmacy
 * Contains all functions related to shopping cart operations
 */

// Start session if not started
function start_session_if_not() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Get or create a cart ID
function get_cart_id() {
    start_session_if_not();
    
    if (!isset($_SESSION['cart_id'])) {
        $_SESSION['cart_id'] = uniqid('cart_', true);
        
        // Create new cart in database
        global $conn;
        $cart_id = $_SESSION['cart_id'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        
        $stmt = $conn->prepare("INSERT INTO carts (cart_id, user_ip) VALUES (?, ?)");
        $stmt->bind_param("ss", $cart_id, $user_ip);
        $stmt->execute();
    }
    
    return $_SESSION['cart_id'];
}

// Add product to cart
function add_to_cart($product_id, $quantity = 1) {
    global $conn;
    $cart_id = get_cart_id();
    
    // Check if product already in cart
    $stmt = $conn->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ?");
    $stmt->bind_param("si", $cart_id, $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Update existing item quantity
        $row = $result->fetch_assoc();
        $new_quantity = $row['quantity'] + $quantity;
        
        $update_stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $update_stmt->bind_param("ii", $new_quantity, $row['id']);
        $success = $update_stmt->execute();
        return $success;
    } else {
        // Add new item to cart
        $stmt = $conn->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->bind_param("sii", $cart_id, $product_id, $quantity);
        $success = $stmt->execute();
        return $success;
    }
}

// Update cart item quantity
function update_cart_item($item_id, $quantity) {
    global $conn;
    $cart_id = get_cart_id();
    
    if ($quantity <= 0) {
        // Remove item if quantity is 0 or negative
        return remove_from_cart($item_id);
    }
    
    $stmt = $conn->prepare("UPDATE cart_items SET quantity = ? WHERE id = ? AND cart_id = ?");
    $stmt->bind_param("iis", $quantity, $item_id, $cart_id);
    return $stmt->execute();
}

// Remove item from cart
function remove_from_cart($item_id) {
    global $conn;
    $cart_id = get_cart_id();
    
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE id = ? AND cart_id = ?");
    $stmt->bind_param("is", $item_id, $cart_id);
    return $stmt->execute();
}

// Get cart contents
function get_cart_contents() {
    global $conn;
    $cart_id = get_cart_id();
    
    $query = "
        SELECT ci.id, ci.product_id, ci.quantity, p.name, p.price, p.image_url, p.image,
               (p.price * ci.quantity) as subtotal
        FROM cart_items ci
        LEFT JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?
        ORDER BY ci.id DESC
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $items = [];
    $total = 0;
    
    while ($row = $result->fetch_assoc()) {
        // If image_url is not available but image is, use image
        if (empty($row['image_url']) && !empty($row['image'])) {
            $row['image_url'] = $row['image'];
        }
        $items[] = $row;
        $total += $row['subtotal'];
    }
    
    return [
        'items' => $items,
        'total' => $total,
        'item_count' => count($items)
    ];
}

// Clear the entire cart
function clear_cart() {
    global $conn;
    $cart_id = get_cart_id();
    
    $stmt = $conn->prepare("DELETE FROM cart_items WHERE cart_id = ?");
    $stmt->bind_param("s", $cart_id);
    return $stmt->execute();
}

// Generate WhatsApp order message
function generate_whatsapp_order($phone_number = "94771234567") {
    $cart = get_cart_contents();
    $items = $cart['items'];
    
    $message = "Hello, I would like to place an order for:%0A";
    
    foreach ($items as $item) {
        $message .= "- " . $item['name'] . " x" . $item['quantity'] . " (Rs. " . number_format($item['price'], 2) . " each)%0A";
    }
    
    $message .= "%0ATotal: Rs. " . number_format($cart['total'], 2) . "%0A%0APlease confirm my order. Thank you!";
    
    return "https://wa.me/" . $phone_number . "?text=" . $message;
}

// Get cart item count
function get_cart_count() {
    global $conn;
    
    // If session hasn't started, return 0
    if (session_status() === PHP_SESSION_NONE) {
        return 0;
    }
    
    // If cart_id not set in session, return 0
    if (!isset($_SESSION['cart_id'])) {
        return 0;
    }
    
    $cart_id = $_SESSION['cart_id'];
    
    $stmt = $conn->prepare("SELECT SUM(quantity) as total FROM cart_items WHERE cart_id = ?");
    $stmt->bind_param("s", $cart_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    
    return $row['total'] ? $row['total'] : 0;
}