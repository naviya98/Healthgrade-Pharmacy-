<?php
/**
 * Admin Functions
 * 
 * This file contains functions used in the admin panel
 */

/**
 * Get count of rows from a table
 * 
 * @param mysqli $conn The database connection
 * @param string $table The table name
 * @param string $where Optional WHERE clause
 * @return int Number of rows
 */
function get_count($conn, $table, $where = '') {
    $table = $conn->real_escape_string($table);
    $sql = "SELECT COUNT(*) as count FROM $table";
    
    if (!empty($where)) {
        $sql .= " WHERE $where";
    }
    
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['count'];
    }
    
    return 0;
}

/**
 * Get appointments count by status
 * 
 * @param mysqli $conn The database connection
 * @param string $status The appointment status
 * @return int Number of appointments with the specified status
 */
function get_appointments_count($conn, $status) {
    $status = $conn->real_escape_string($status);
    return get_count($conn, 'appointments', "status = '$status'");
}

/**
 * Get recent appointments
 * 
 * @param mysqli $conn The database connection
 * @param int $limit Number of appointments to retrieve
 * @return array Array of recent appointments
 */
function get_recent_appointments($conn, $limit = 5) {
    $limit = (int)$limit;
    $sql = "SELECT * FROM appointments ORDER BY created_at DESC LIMIT $limit";
    
    $result = $conn->query($sql);
    $appointments = [];
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $appointments[] = $row;
        }
    }
    
    return $appointments;
}

/**
 * Get recent activity from log
 * 
 * @param mysqli $conn The database connection
 * @param int $limit Number of activity logs to retrieve
 * @return array Array of recent activity
 */
function get_recent_activity($conn, $limit = 10) {
    $limit = (int)$limit;
    
    // Check if activity_log table exists
    $check_table = $conn->query("SHOW TABLES LIKE 'activity_log'");
    if ($check_table->num_rows == 0) {
        // Create activity_log table if it doesn't exist
        $create_table_sql = "CREATE TABLE IF NOT EXISTS activity_log (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            activity TEXT NOT NULL,
            ip_address VARCHAR(45) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";
        
        $conn->query($create_table_sql);
    }
    
    $sql = "SELECT a.*, u.username 
            FROM activity_log a 
            LEFT JOIN admin_users u ON a.user_id = u.id 
            ORDER BY a.created_at DESC 
            LIMIT $limit";
    
    $result = $conn->query($sql);
    $activity = [];
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $activity[] = $row;
        }
    }
    
    return $activity;
}

/**
 * Check if user has permission
 * 
 * @param mysqli $conn The database connection
 * @param int $user_id The user ID
 * @param string $permission The permission to check
 * @return bool True if user has permission, false otherwise
 */
function has_permission($conn, $user_id, $permission) {
    // For now, all admin users have all permissions
    return true;
}

/**
 * Get product categories as associative array
 * 
 * @param mysqli $conn The database connection
 * @return array Array of categories with id => name
 */
function get_categories_array($conn) {
    $categories = [];
    
    $sql = "SELECT id, name FROM categories ORDER BY name ASC";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $categories[$row['id']] = $row['name'];
        }
    }
    
    return $categories;
}

/**
 * Get delivery areas as associative array
 * 
 * @param mysqli $conn The database connection
 * @return array Array of delivery areas with id => name
 */
function get_delivery_areas_array($conn) {
    $areas = [];
    
    $sql = "SELECT id, area_name FROM delivery_areas ORDER BY area_name ASC";
    $result = $conn->query($sql);
    
    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $areas[$row['id']] = $row['area_name'];
        }
    }
    
    return $areas;
}

/**
 * Format date for display
 * 
 * @param string $date Date in YYYY-MM-DD format
 * @param string $format Output format (default: 'M d, Y')
 * @return string Formatted date
 */
function format_date($date, $format = 'M d, Y') {
    return date($format, strtotime($date));
}

/**
 * Format time for display
 * 
 * @param string $time Time in HH:MM:SS format
 * @param string $format Output format (default: 'h:i A')
 * @return string Formatted time
 */
function format_time($time, $format = 'h:i A') {
    return date($format, strtotime($time));
}

/**
 * Get status badge HTML
 * 
 * @param string $status Status value
 * @return string HTML for status badge
 */
function get_status_badge($status) {
    $status_colors = [
        'pending' => 'yellow',
        'confirmed' => 'green',
        'cancelled' => 'red',
        'completed' => 'blue',
        'active' => 'green',
        'inactive' => 'gray'
    ];
    
    $color = $status_colors[strtolower($status)] ?? 'gray';
    
    return "<span class=\"px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-{$color}-100 text-{$color}-800\">" .
           ucfirst($status) .
           "</span>";
}

/**
 * Generate random string
 * 
 * @param int $length Length of random string
 * @return string Random string
 */
function generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $characters_length = strlen($characters);
    $random_string = '';
    
    for ($i = 0; $i < $length; $i++) {
        $random_string .= $characters[rand(0, $characters_length - 1)];
    }
    
    return $random_string;
}

/**
 * Upload image
 * 
 * @param array $file $_FILES array element
 * @param string $destination Destination directory
 * @param string $filename Optional filename (default: random)
 * @return array ['success' => bool, 'message' => string, 'filename' => string]
 */
function upload_image($file, $destination, $filename = '') {
    // Check if file was uploaded without errors
    if ($file['error'] !== UPLOAD_ERR_OK) {
        $upload_errors = [
            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded',
            UPLOAD_ERR_NO_FILE => 'No file was uploaded',
            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder',
            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload'
        ];
        
        $error_message = $upload_errors[$file['error']] ?? 'Unknown upload error';
        return ['success' => false, 'message' => $error_message, 'filename' => ''];
    }
    
    // Check if directory exists, create if not
    if (!file_exists($destination)) {
        mkdir($destination, 0755, true);
    }
    
    // Get file extension
    $file_extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    
    // Check file type
    $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($file_extension, $allowed_extensions)) {
        return ['success' => false, 'message' => 'Only JPG, JPEG, PNG and GIF files are allowed', 'filename' => ''];
    }
    
    // Generate filename if not provided
    if (empty($filename)) {
        $filename = generate_random_string() . '.' . $file_extension;
    } else {
        $filename = $filename . '.' . $file_extension;
    }
    
    // Set full path
    $target_file = $destination . '/' . $filename;
    
    // Upload file
    if (move_uploaded_file($file['tmp_name'], $target_file)) {
        return ['success' => true, 'message' => 'File uploaded successfully', 'filename' => $filename];
    } else {
        return ['success' => false, 'message' => 'Failed to upload file', 'filename' => ''];
    }
}