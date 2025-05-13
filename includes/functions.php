<?php
/**
 * Common functions for the Healthgrade Pharmacy website
 * 
 * This file contains utility functions that are used throughout the website
 */

/**
 * Sanitize input data to prevent XSS attacks
 * 
 * @param string $data The input data to sanitize
 * @return string Sanitized data
 */
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Get all products from the database
 * 
 * @param mysqli $conn The database connection
 * @param int $category_id Optional category ID to filter products
 * @param int $limit Optional limit for number of products to return
 * @return array Array of products
 */
function get_all_products($conn, $category_id = null, $limit = null) {
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.is_active = 1";
    
    // Add category filter if specified
    if ($category_id) {
        $category_id = (int)$category_id; // Cast to integer for security
        $sql .= " AND p.category_id = $category_id";
    }
    
    $sql .= " ORDER BY p.is_featured DESC, p.id DESC";
    
    // Add limit if specified
    if ($limit) {
        $limit = (int)$limit; // Cast to integer for security
        $sql .= " LIMIT $limit";
    }
    
    $result = $conn->query($sql);
    $products = [];
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            // Handle missing image
            if (empty($row['image']) || !file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $row['image'])) {
                $row['image'] = 'assets/images/products/placeholder.jpg';
            }
            $products[] = $row;
        }
    }
    
    return $products;
}

/**
 * Get product by ID
 * 
 * @param mysqli $conn The database connection
 * @param int $id The product ID
 * @return array|null Product data or null if not found
 */
function get_product_by_id($conn, $id) {
    $id = (int)$id; // Cast to integer for security
    $sql = "SELECT p.*, c.name as category_name 
            FROM products p 
            LEFT JOIN categories c ON p.category_id = c.id 
            WHERE p.id = $id AND p.is_active = 1";
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
        
        // Handle missing image
        if (empty($product['image']) || !file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $product['image'])) {
            $product['image'] = 'assets/images/products/placeholder.jpg';
        }
        
        return $product;
    }
    
    return null;
}

/**
 * Get all categories
 * 
 * @param mysqli $conn The database connection
 * @return array Array of categories
 */
function get_all_categories($conn) {
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    
    $result = $conn->query($sql);
    $categories = [];
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    
    return $categories;
}

/**
 * Get all delivery areas
 * 
 * @param mysqli $conn The database connection
 * @param bool $active_only Whether to get only active delivery areas
 * @return array Array of delivery areas
 */
function get_delivery_areas($conn, $active_only = true) {
    $sql = "SELECT * FROM delivery_areas";
    
    if ($active_only) {
        $sql .= " WHERE is_active = 1";
    }
    
    $sql .= " ORDER BY area_name ASC";
    
    $result = $conn->query($sql);
    $areas = [];
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $areas[] = $row;
        }
    }
    
    return $areas;
}

/**
 * Format price in Sri Lankan Rupees
 * 
 * @param float $price The price to format
 * @param bool $with_symbol Whether to include the Rs. symbol
 * @return string Formatted price
 */
function format_price($price, $with_symbol = true) {
    $formatted = number_format($price, 2, '.', ',');
    return $with_symbol ? 'Rs. ' . $formatted : $formatted;
}

/**
 * Generate pagination links
 * 
 * @param int $current_page Current page number
 * @param int $total_pages Total number of pages
 * @param string $url_pattern URL pattern with %d as page placeholder
 * @return string HTML for pagination links
 */
function generate_pagination($current_page, $total_pages, $url_pattern) {
    if ($total_pages <= 1) {
        return '';
    }
    
    $pagination = '<div class="flex justify-center mt-8"><ul class="flex space-x-1">';
    
    // Previous page link
    if ($current_page > 1) {
        $pagination .= '<li><a href="' . sprintf($url_pattern, $current_page - 1) . '" class="px-4 py-2 bg-white text-green-600 border border-gray-300 rounded hover:bg-gray-50">&laquo;</a></li>';
    } else {
        $pagination .= '<li><span class="px-4 py-2 bg-gray-100 text-gray-400 border border-gray-300 rounded">&laquo;</span></li>';
    }
    
    // Page number links
    $start_page = max(1, $current_page - 2);
    $end_page = min($total_pages, $current_page + 2);
    
    if ($start_page > 1) {
        $pagination .= '<li><a href="' . sprintf($url_pattern, 1) . '" class="px-4 py-2 bg-white text-green-600 border border-gray-300 rounded hover:bg-gray-50">1</a></li>';
        if ($start_page > 2) {
            $pagination .= '<li><span class="px-4 py-2 border border-gray-300 rounded">...</span></li>';
        }
    }
    
    for ($i = $start_page; $i <= $end_page; $i++) {
        if ($i == $current_page) {
            $pagination .= '<li><span class="px-4 py-2 bg-green-600 text-white border border-green-600 rounded">' . $i . '</span></li>';
        } else {
            $pagination .= '<li><a href="' . sprintf($url_pattern, $i) . '" class="px-4 py-2 bg-white text-green-600 border border-gray-300 rounded hover:bg-gray-50">' . $i . '</a></li>';
        }
    }
    
    if ($end_page < $total_pages) {
        if ($end_page < $total_pages - 1) {
            $pagination .= '<li><span class="px-4 py-2 border border-gray-300 rounded">...</span></li>';
        }
        $pagination .= '<li><a href="' . sprintf($url_pattern, $total_pages) . '" class="px-4 py-2 bg-white text-green-600 border border-gray-300 rounded hover:bg-gray-50">' . $total_pages . '</a></li>';
    }
    
    // Next page link
    if ($current_page < $total_pages) {
        $pagination .= '<li><a href="' . sprintf($url_pattern, $current_page + 1) . '" class="px-4 py-2 bg-white text-green-600 border border-gray-300 rounded hover:bg-gray-50">&raquo;</a></li>';
    } else {
        $pagination .= '<li><span class="px-4 py-2 bg-gray-100 text-gray-400 border border-gray-300 rounded">&raquo;</span></li>';
    }
    
    $pagination .= '</ul></div>';
    
    return $pagination;
}

/**
 * Get a setting value from the database
 * 
 * @param mysqli $conn The database connection
 * @param string $key The setting key
 * @param string $default Default value if setting not found
 * @return string Setting value
 */
function get_setting($conn, $key, $default = '') {
    $key = $conn->real_escape_string($key);
    $sql = "SELECT setting_value FROM settings WHERE setting_key = '$key' LIMIT 1";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['setting_value'];
    }
    
    return $default;
}

/**
 * Truncate text to a specified length and append ellipsis
 * 
 * @param string $text The text to truncate
 * @param int $length Maximum length
 * @param string $append String to append if truncated
 * @return string Truncated text
 */
function truncate_text($text, $length = 100, $append = '...') {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Generate WhatsApp order link
 * 
 * @param string $product_name Product name
 * @param float $price Product price
 * @return string WhatsApp link
 */
function get_whatsapp_order_link($product_name, $price) {
    global $conn;
    
    // Get WhatsApp number from settings
    $whatsapp_number = get_setting($conn, 'whatsapp_number', '94XXXXXXXXX');
    
    // Prepare message
    $message = "Hello, I would like to order: {$product_name} (Rs. {$price})";
    
    // Generate link
    return "https://wa.me/{$whatsapp_number}?text=" . urlencode($message);
}

/**
 * Check if appointment date and time is available
 * 
 * @param mysqli $conn The database connection
 * @param string $date Appointment date (YYYY-MM-DD)
 * @param string $time Appointment time (HH:MM)
 * @return bool True if slot is available, false otherwise
 */
function is_appointment_slot_available($conn, $date, $time) {
    $date = $conn->real_escape_string($date);
    $time = $conn->real_escape_string($time);
    
    $sql = "SELECT COUNT(*) as count FROM appointments 
            WHERE appointment_date = '$date' 
            AND appointment_time = '$time' 
            AND status != 'cancelled'";
    
    $result = $conn->query($sql);
    
    if ($result) {
        $row = $result->fetch_assoc();
        // Assume we allow a maximum of 2 appointments per time slot
        return $row['count'] < 2;
    }
    
    return false;
}

/**
 * Get all available appointment times for a specific date
 * 
 * @param mysqli $conn The database connection
 * @param string $date Appointment date (YYYY-MM-DD)
 * @return array Available time slots
 */
function get_available_appointment_times($conn, $date) {
    // Define all possible time slots
    $all_times = ['09:00', '10:00', '11:00', '12:00', '14:00', '15:00', '16:00', '17:00'];
    $available_times = [];
    
    foreach ($all_times as $time) {
        if (is_appointment_slot_available($conn, $date, $time)) {
            $available_times[] = $time;
        }
    }
    
    return $available_times;
}

/**
 * Log user activity
 * 
 * @param mysqli $conn The database connection
 * @param string $activity Description of the activity
 * @param int $user_id User ID (0 for guests)
 */
function log_activity($conn, $activity, $user_id = 0) {
    $activity = $conn->real_escape_string($activity);
    $user_id = (int)$user_id;
    $ip = $_SERVER['REMOTE_ADDR'];
    
    // Check if activity_log table exists
    $check_table = $conn->query("SHOW TABLES LIKE 'activity_log'");
    if ($check_table->num_rows == 0) {
        // Table doesn't exist, don't try to log
        return;
    }
    
    $sql = "INSERT INTO activity_log (user_id, activity, ip_address, created_at) 
            VALUES ($user_id, '$activity', '$ip', NOW())";
    
    $conn->query($sql);
}