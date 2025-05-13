<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: ../index.php');
    exit;
}

// Include database connection
require_once '../../includes/db_connect.php';
require_once '../../includes/functions.php';
require_once '../includes/admin_functions.php';

// Define variables for add/edit form
$user_id = 0;
$username = '';
$email = '';
$full_name = '';
$password = '';
$confirm_password = '';
$is_active = 1;
$edit_mode = false;
$errors = [];

// Handle edit user (load user data)
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $user_id = (int)$_GET['edit'];
    $edit_mode = true;
    
    $sql = "SELECT * FROM admin_users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $username = $user['username'];
        $email = $user['email'];
        $full_name = $user['full_name'];
        $is_active = $user['is_active'];
    } else {
        $_SESSION['error_message'] = "User not found.";
        header('Location: index.php');
        exit;
    }
    
    $stmt->close();
}

// Handle toggle status
if (isset($_GET['toggle_status']) && !empty($_GET['toggle_status'])) {
    $user_id = (int)$_GET['toggle_status'];
    
    // Get current status
    $sql = "SELECT username, is_active FROM admin_users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $new_status = $user['is_active'] ? 0 : 1;
        $status_text = $new_status ? 'active' : 'inactive';
        
        // Update status
        $update_sql = "UPDATE admin_users SET is_active = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ii", $new_status, $user_id);
        
        if ($update_stmt->execute()) {
            // Log activity
            log_activity($conn, "Set user {$user['username']} to $status_text", $_SESSION['admin_id']);
            
            $_SESSION['success_message'] = "User status updated successfully.";
        } else {
            $_SESSION['error_message'] = "Error updating user status: " . $conn->error;
        }
        
        $update_stmt->close();
    } else {
        $_SESSION['error_message'] = "User not found.";
    }
    
    $stmt->close();
    
    // Redirect to users page
    header('Location: index.php');
    exit;
}

// Process form submission for add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $username = sanitize_input($_POST['username'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');
    $full_name = sanitize_input($_POST['full_name'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
    
    // Validate username
    if (empty($username)) {
        $errors[] = 'Username is required';
    } elseif (strlen($username) < 3 || strlen($username) > 50) {
        $errors[] = 'Username must be between 3 and 50 characters';
    } else {
        // Check if username exists (for new users or when changing username)
        $check_sql = "SELECT id FROM admin_users WHERE username = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $username, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $errors[] = 'Username already exists';
        }
        
        $check_stmt->close();
    }
    
    // Validate email
    if (empty($email)) {
        $errors[] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email format';
    } else {
        // Check if email exists (for new users or when changing email)
        $check_sql = "SELECT id FROM admin_users WHERE email = ? AND id != ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("si", $email, $user_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $errors[] = 'Email already exists';
        }
        
        $check_stmt->close();
    }
    
    // Validate full name
    if (empty($full_name)) {
        $errors[] = 'Full name is required';
    } elseif (strlen($full_name) > 100) {
        $errors[] = 'Full name cannot exceed 100 characters';
    }
    
    // Validate password (required for new users, optional for edit)
    if ($user_id === 0 || !empty($password)) {
        if (empty($password)) {
            $errors[] = 'Password is required';
        } elseif (strlen($password) < 6) {
            $errors[] = 'Password must be at least 6 characters';
        } elseif ($password !== $confirm_password) {
            $errors[] = 'Passwords do not match';
        }
    }
    
    // If no errors, add or update user
    if (empty($errors)) {
        if ($user_id > 0) {
            // Update existing user
            if (!empty($password)) {
                // Update with password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $sql = "UPDATE admin_users SET username = ?, email = ?, full_name = ?, password = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssiii", $username, $email, $full_name, $hashed_password, $is_active, $user_id);
            } else {
                // Update without password
                $sql = "UPDATE admin_users SET username = ?, email = ?, full_name = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssii", $username, $email, $full_name, $is_active, $user_id);
            }
            
            if ($stmt->execute()) {
                // Log activity
                log_activity($conn, "Updated user: $username", $_SESSION['admin_id']);
                
                $_SESSION['success_message'] = "User updated successfully.";
            } else {
                $_SESSION['error_message'] = "Error updating user: " . $conn->error;
            }
        } else {
            // Add new user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO admin_users (username, email, full_name, password, is_active, created_at) VALUES (?, ?, ?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $username, $email, $full_name, $hashed_password, $is_active);
            
            if ($stmt->execute()) {
                // Log activity
                log_activity($conn, "Added new user: $username", $_SESSION['admin_id']);
                
                $_SESSION['success_message'] = "User added successfully.";
            } else {
                $_SESSION['error_message'] = "Error adding user: " . $conn->error;
            }
        }
        
        $stmt->close();
        
        // Reset form and redirect
        $user_id = 0;
        $username = '';
        $email = '';
        $full_name = '';
        $password = '';
        $confirm_password = '';
        $is_active = 1;
        $edit_mode = false;
        
        header('Location: index.php');
        exit;
    }
}

// Get all admin users
$sql = "SELECT * FROM admin_users ORDER BY username ASC";
$result = $conn->query($sql);
$users = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

// Check if current user is the only active admin
$sql = "SELECT COUNT(*) as count FROM admin_users WHERE is_active = 1";
$result = $conn->query($sql);
$active_admins_count = $result->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Admin Users - Healthgrade Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-gray-100">
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Admin Users</h1>
        </div>
        
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                <?php echo $_SESSION['success_message']; ?>
                <?php unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                <?php echo $_SESSION['error_message']; ?>
                <?php unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <?php echo $edit_mode ? 'Edit User' : 'Add New User'; ?>
                    </h2>
                    
                    <?php if (!empty($errors)): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                            <p class="font-bold">Please fix the following errors:</p>
                            <ul class="list-disc list-inside">
                                <?php foreach ($errors as $error): ?>
                                    <li><?php echo $error; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    
                    <form action="" method="POST">
                        <?php if ($edit_mode): ?>
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <label for="username" class="block text-gray-700 text-sm font-bold mb-2">
                                Username <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="username" name="username" value="<?php echo $username; ?>" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" id="email" name="email" value="<?php echo $email; ?>" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="full_name" class="block text-gray-700 text-sm font-bold mb-2">
                                Full Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="full_name" name="full_name" value="<?php echo $full_name; ?>" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                                Password <?php echo $edit_mode ? '' : '<span class="text-red-500">*</span>'; ?>
                            </label>
                            <input type="password" id="password" name="password" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                <?php echo $edit_mode ? '' : 'required'; ?>>
                            <?php if ($edit_mode): ?>
                                <p class="text-sm text-gray-500 mt-1">Leave blank to keep current password</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="mb-4">
                            <label for="confirm_password" class="block text-gray-700 text-sm font-bold mb-2">
                                Confirm Password <?php echo $edit_mode ? '' : '<span class="text-red-500">*</span>'; ?>
                            </label>
                            <input type="password" id="confirm_password" name="confirm_password" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                <?php echo $edit_mode ? '' : 'required'; ?>>
                        </div>
                        
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" <?php echo $is_active ? 'checked' : ''; ?> 
                                    class="rounded text-green-600 focus:ring-green-500 h-5 w-5">
                                <span class="ml-2 text-gray-700">Active</span>
                            </label>
                        </div>
                        
                        <div class="flex justify-between">
                            <?php if ($edit_mode): ?>
                                <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-300">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-save mr-2"></i> Update User
                                </button>
                            <?php else: ?>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-plus mr-2"></i> Add User
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <!-- Security Information -->
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Security Information</h2>
                    <div class="text-gray-600 text-sm">
                        <ul class="space-y-2">
                            <li><i class="fas fa-info-circle text-blue-500 mr-2"></i> Passwords should be at least 6 characters.</li>
                            <li><i class="fas fa-info-circle text-blue-500 mr-2"></i> Use a combination of letters, numbers, and special characters.</li>
                            <li><i class="fas fa-info-circle text-blue-500 mr-2"></i> Each administrator should have their own account.</li>
                            <li><i class="fas fa-info-circle text-blue-500 mr-2"></i> Inactive users cannot log in to the admin panel.</li>
                            <li><i class="fas fa-exclamation-triangle text-yellow-500 mr-2"></i> There must be at least one active admin user.</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Users List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Full Name</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Last Login</th>
                                <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (count($users) > 0): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td class="py-3 px-4">
                                            <div class="font-medium text-gray-900"><?php echo $user['username']; ?></div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="text-gray-900"><?php echo $user['full_name']; ?></div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="text-gray-500"><?php echo $user['email']; ?></div>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <?php echo $user['is_active'] ? get_status_badge('active') : get_status_badge('inactive'); ?>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <div class="text-gray-500 text-sm">
                                                <?php echo $user['last_login'] ? date('M d, Y H:i', strtotime($user['last_login'])) : 'Never'; ?>
                                            </div>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="flex justify-end space-x-2">
                                                <a href="index.php?edit=<?php echo $user['id']; ?>" class="text-yellow-600 hover:text-yellow-900" title="Edit User">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                
                                                <?php if ($user['id'] != $_SESSION['admin_id']): ?>
                                                    <?php if (!($user['is_active'] && $active_admins_count <= 1)): ?>
                                                        <a href="index.php?toggle_status=<?php echo $user['id']; ?>" class="<?php echo $user['is_active'] ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900'; ?>" title="<?php echo $user['is_active'] ? 'Deactivate User' : 'Activate User'; ?>">
                                                            <i class="fas <?php echo $user['is_active'] ? 'fa-user-times' : 'fa-user-check'; ?>"></i>
                                                        </a>
                                                    <?php else: ?>
                                                        <span class="text-gray-400 cursor-not-allowed" title="Cannot deactivate last admin">
                                                            <i class="fas fa-user-times"></i>
                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-gray-400 cursor-not-allowed" title="Cannot modify your own status">
                                                        <i class="fas <?php echo $user['is_active'] ? 'fa-user-times' : 'fa-user-check'; ?>"></i>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" class="py-6 px-4 text-center text-gray-500">
                                        No users found. Add a new user to get started.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Recent Admin Activity -->
                <div class="bg-white rounded-lg shadow p-6 mt-8">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Recent Admin Activity</h2>
                    
                    <?php
                    // Get recent admin activity
                    $activity_sql = "SELECT a.*, u.username 
                                    FROM activity_log a 
                                    LEFT JOIN admin_users u ON a.user_id = u.id 
                                    ORDER BY a.created_at DESC 
                                    LIMIT 5";
                    $activity_result = $conn->query($activity_sql);
                    $activities = [];
                    
                    if ($activity_result && $activity_result->num_rows > 0) {
                        while($row = $activity_result->fetch_assoc()) {
                            $activities[] = $row;
                        }
                    }
                    ?>
                    
                    <?php if (count($activities) > 0): ?>
                        <div class="space-y-4">
                            <?php foreach ($activities as $activity): ?>
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 mr-3">
                                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user-clock text-blue-500"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-800">
                                            <span class="font-semibold"><?php echo $activity['username'] ?? 'System'; ?>:</span> 
                                            <?php echo $activity['activity']; ?>
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php echo date('M d, Y h:i A', strtotime($activity['created_at'])); ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p class="text-gray-500 text-center py-4">No recent activity</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/admin_footer.php'; ?>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>