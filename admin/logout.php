<?php
session_start();

// Log the logout activity if user was logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    require_once '../includes/db_connect.php';
    require_once '../includes/functions.php';
    
    $username = $_SESSION['admin_username'] ?? 'Unknown';
    $user_id = $_SESSION['admin_id'] ?? 0;
    
    // Log activity
    log_activity($conn, "Admin logout: $username", $user_id);
}

// Destroy all session data
$_SESSION = array();

// If a session cookie is used, destroy it
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destroy the session
session_destroy();

// Redirect to login page
header('Location: index.php');
exit;