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

// Handle delete delivery area
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $area_id = (int)$_GET['delete'];
    
    // Get area name for logging
    $sql = "SELECT area_name FROM delivery_areas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $area_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $area = $result->fetch_assoc();
        
        // Delete area
        $delete_sql = "DELETE FROM delivery_areas WHERE id = ?";
        $delete_stmt = $conn->prepare($delete_sql);
        $delete_stmt->bind_param("i", $area_id);
        
        if ($delete_stmt->execute()) {
            // Log activity
            log_activity($conn, "Deleted delivery area: {$area['area_name']}", $_SESSION['admin_id']);
            
            $_SESSION['success_message'] = "Delivery area '{$area['area_name']}' deleted successfully.";
        } else {
            $_SESSION['error_message'] = "Error deleting delivery area: " . $conn->error;
        }
        
        $delete_stmt->close();
    } else {
        $_SESSION['error_message'] = "Delivery area not found.";
    }
    
    $stmt->close();
    
    // Redirect to delivery areas page
    header('Location: index.php');
    exit;
}

// Define variables for add/edit form
$area_id = 0;
$area_name = '';
$delivery_fee = 0;
$is_active = 1;
$edit_mode = false;
$errors = [];

// Handle edit area (load area data)
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $area_id = (int)$_GET['edit'];
    $edit_mode = true;
    
    $sql = "SELECT * FROM delivery_areas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $area_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $area = $result->fetch_assoc();
        $area_name = $area['area_name'];
        $delivery_fee = $area['delivery_fee'];
        $is_active = $area['is_active'];
    } else {
        $_SESSION['error_message'] = "Delivery area not found.";
        header('Location: index.php');
        exit;
    }
    
    $stmt->close();
}

// Process form submission for add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $area_name = sanitize_input($_POST['area_name'] ?? '');
    $delivery_fee = floatval($_POST['delivery_fee'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    $area_id = isset($_POST['area_id']) ? (int)$_POST['area_id'] : 0;
    
    // Validate area name
    if (empty($area_name)) {
        $errors[] = 'Area name is required';
    } elseif (strlen($area_name) > 100) {
        $errors[] = 'Area name cannot exceed 100 characters';
    }
    
    // Validate delivery fee
    if ($delivery_fee <= 0) {
        $errors[] = 'Delivery fee must be greater than zero';
    }
    
    // If no errors, add or update delivery area
    if (empty($errors)) {
        if ($area_id > 0) {
            // Update existing area
            $sql = "UPDATE delivery_areas SET area_name = ?, delivery_fee = ?, is_active = ?, updated_at = NOW() WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdii", $area_name, $delivery_fee, $is_active, $area_id);
            
            if ($stmt->execute()) {
                // Log activity
                log_activity($conn, "Updated delivery area: $area_name", $_SESSION['admin_id']);
                
                $_SESSION['success_message'] = "Delivery area updated successfully.";
            } else {
                $_SESSION['error_message'] = "Error updating delivery area: " . $conn->error;
            }
        } else {
            // Add new area
            $sql = "INSERT INTO delivery_areas (area_name, delivery_fee, is_active, created_at) VALUES (?, ?, ?, NOW())";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sdi", $area_name, $delivery_fee, $is_active);
            
            if ($stmt->execute()) {
                // Log activity
                log_activity($conn, "Added new delivery area: $area_name", $_SESSION['admin_id']);
                
                $_SESSION['success_message'] = "Delivery area added successfully.";
            } else {
                $_SESSION['error_message'] = "Error adding delivery area: " . $conn->error;
            }
        }
        
        $stmt->close();
        
        // Reset form and redirect
        $area_id = 0;
        $area_name = '';
        $delivery_fee = 0;
        $is_active = 1;
        $edit_mode = false;
        
        header('Location: index.php');
        exit;
    }
}

// Get all delivery areas
$sql = "SELECT * FROM delivery_areas ORDER BY area_name ASC";
$result = $conn->query($sql);
$delivery_areas = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $delivery_areas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Delivery Areas - Healthgrade Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-gray-100">
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Delivery Areas</h1>
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
            <!-- Delivery Area Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <?php echo $edit_mode ? 'Edit Delivery Area' : 'Add New Delivery Area'; ?>
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
                            <input type="hidden" name="area_id" value="<?php echo $area_id; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <label for="area_name" class="block text-gray-700 text-sm font-bold mb-2">
                                Area Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="area_name" name="area_name" value="<?php echo $area_name; ?>" 
                                placeholder="e.g. Colombo 7" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="delivery_fee" class="block text-gray-700 text-sm font-bold mb-2">
                                Delivery Fee (Rs.) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="delivery_fee" name="delivery_fee" value="<?php echo $delivery_fee; ?>" 
                                step="0.01" min="0" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
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
                                    <i class="fas fa-save mr-2"></i> Update Area
                                </button>
                            <?php else: ?>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-plus mr-2"></i> Add Area
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
                
                <!-- Delivery Information -->
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Delivery Information</h2>
                    <div class="text-gray-600">
                        <p class="mb-2">Delivery areas are used to calculate delivery fees based on customer location.</p>
                        <ul class="list-disc list-inside space-y-1 text-sm">
                            <li>Delivery areas should be properly named for easy identification.</li>
                            <li>Set appropriate delivery fees based on distance.</li>
                            <li>Inactive areas will not be shown to customers.</li>
                            <li>Orders over Rs. 3,000 qualify for free delivery (set in settings).</li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <!-- Delivery Areas List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Area Name</th>
                                <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Delivery Fee</th>
                                <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (count($delivery_areas) > 0): ?>
                                <?php foreach ($delivery_areas as $area): ?>
                                    <tr>
                                        <td class="py-3 px-4">
                                            <div class="font-medium text-gray-900"><?php echo $area['area_name']; ?></div>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <div class="font-medium text-gray-900">Rs. <?php echo number_format($area['delivery_fee'], 2); ?></div>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <?php echo $area['is_active'] ? get_status_badge('active') : get_status_badge('inactive'); ?>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="index.php?edit=<?php echo $area['id']; ?>" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="index.php?delete=<?php echo $area['id']; ?>" class="text-red-600 hover:text-red-900 delete-confirm">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="py-6 px-4 text-center text-gray-500">
                                        No delivery areas found. Add a new area to get started.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Delivery Rates Table -->
                <div class="bg-white rounded-lg shadow mt-8 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">Free Delivery Thresholds</h2>
                    
                    <form action="update_settings.php" method="POST" class="mb-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="free_delivery_threshold" class="block text-gray-700 text-sm font-bold mb-2">
                                    Free Delivery Threshold (Rs.)
                                </label>
                                <input type="number" id="free_delivery_threshold" name="free_delivery_threshold" 
                                    value="3000" min="0" step="100"
                                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            </div>
                            <div class="flex items-end">
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-save mr-2"></i> Update Threshold
                                </button>
                            </div>
                        </div>
                    </form>
                    
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-700">
                                    Orders over Rs. 3,000 qualify for free delivery within Colombo. 
                                    For other areas, a discounted delivery fee may apply for large orders.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/admin_footer.php'; ?>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>