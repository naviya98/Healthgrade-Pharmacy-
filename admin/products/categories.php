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

// Handle delete category
if (isset($_GET['delete']) && !empty($_GET['delete'])) {
    $category_id = (int)$_GET['delete'];
    
    // Get category name for logging
    $sql = "SELECT name FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        
        // Check if category has products
        $check_sql = "SELECT COUNT(*) as count FROM products WHERE category_id = ?";
        $check_stmt = $conn->prepare($check_sql);
        $check_stmt->bind_param("i", $category_id);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        $product_count = $check_result->fetch_assoc()['count'];
        
        if ($product_count > 0) {
            $_SESSION['error_message'] = "Cannot delete category '{$category['name']}' because it contains products. Please reassign these products to another category first.";
        } else {
            // Delete category
            $delete_sql = "DELETE FROM categories WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $category_id);
            
            if ($delete_stmt->execute()) {
                // Log activity
                log_activity($conn, "Deleted category: {$category['name']}", $_SESSION['admin_id']);
                
                $_SESSION['success_message'] = "Category '{$category['name']}' deleted successfully.";
            } else {
                $_SESSION['error_message'] = "Error deleting category: " . $conn->error;
            }
            
            $delete_stmt->close();
        }
        
        $check_stmt->close();
    } else {
        $_SESSION['error_message'] = "Category not found.";
    }
    
    $stmt->close();
    
    // Redirect to categories page
    header('Location: categories.php');
    exit;
}

// Define variables for add/edit form
$category_id = 0;
$name = '';
$description = '';
$edit_mode = false;
$errors = [];

// Handle edit category (load category data)
if (isset($_GET['edit']) && !empty($_GET['edit'])) {
    $category_id = (int)$_GET['edit'];
    $edit_mode = true;
    
    $sql = "SELECT * FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        $name = $category['name'];
        $description = $category['description'];
    } else {
        $_SESSION['error_message'] = "Category not found.";
        header('Location: categories.php');
        exit;
    }
    
    $stmt->close();
}

// Process form submission for add/edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $name = sanitize_input($_POST['name'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');
    $category_id = isset($_POST['category_id']) ? (int)$_POST['category_id'] : 0;
    
    // Validate name
    if (empty($name)) {
        $errors[] = 'Category name is required';
    } elseif (strlen($name) > 100) {
        $errors[] = 'Category name cannot exceed 100 characters';
    }
    
    // If no errors, add or update category
    if (empty($errors)) {
        if ($category_id > 0) {
            // Update existing category
            $sql = "UPDATE categories SET name = ?, description = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $name, $description, $category_id);
            
            if ($stmt->execute()) {
                // Log activity
                log_activity($conn, "Updated category: $name", $_SESSION['admin_id']);
                
                $_SESSION['success_message'] = "Category updated successfully.";
            } else {
                $_SESSION['error_message'] = "Error updating category: " . $conn->error;
            }
        } else {
            // Add new category
            $sql = "INSERT INTO categories (name, description) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $name, $description);
            
            if ($stmt->execute()) {
                // Log activity
                log_activity($conn, "Added new category: $name", $_SESSION['admin_id']);
                
                $_SESSION['success_message'] = "Category added successfully.";
            } else {
                $_SESSION['error_message'] = "Error adding category: " . $conn->error;
            }
        }
        
        $stmt->close();
        
        // Reset form and redirect
        $category_id = 0;
        $name = '';
        $description = '';
        $edit_mode = false;
        
        header('Location: categories.php');
        exit;
    }
}

// Get all categories
$sql = "SELECT c.*, COUNT(p.id) as product_count 
        FROM categories c 
        LEFT JOIN products p ON c.id = p.category_id 
        GROUP BY c.id 
        ORDER BY c.name ASC";
$result = $conn->query($sql);
$categories = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Healthgrade Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-gray-100">
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Categories</h1>
            <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Products
            </a>
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
            <!-- Category Form -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-4">
                        <?php echo $edit_mode ? 'Edit Category' : 'Add New Category'; ?>
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
                            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                Category Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="<?php echo $name; ?>" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="5" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo $description; ?></textarea>
                        </div>
                        
                        <div class="flex justify-between">
                            <?php if ($edit_mode): ?>
                                <a href="categories.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-300">
                                    Cancel
                                </a>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-save mr-2"></i> Update Category
                                </button>
                            <?php else: ?>
                                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition duration-300">
                                    <i class="fas fa-plus mr-2"></i> Add Category
                                </button>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Categories List -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <table class="min-w-full bg-white">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                                <th class="py-3 px-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <?php if (count($categories) > 0): ?>
                                <?php foreach ($categories as $category): ?>
                                    <tr>
                                        <td class="py-3 px-4">
                                            <div class="font-medium text-gray-900"><?php echo $category['name']; ?></div>
                                        </td>
                                        <td class="py-3 px-4">
                                            <div class="text-gray-500 text-sm truncate max-w-xs"><?php echo truncate_text($category['description'], 80); ?></div>
                                        </td>
                                        <td class="py-3 px-4 text-center">
                                            <a href="index.php?category=<?php echo $category['id']; ?>" class="text-blue-600 hover:underline">
                                                <?php echo $category['product_count']; ?> product<?php echo $category['product_count'] != 1 ? 's' : ''; ?>
                                            </a>
                                        </td>
                                        <td class="py-3 px-4 text-right">
                                            <a href="categories.php?edit=<?php echo $category['id']; ?>" class="text-yellow-600 hover:text-yellow-900 mr-3">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php if ($category['product_count'] == 0): ?>
                                                <a href="categories.php?delete=<?php echo $category['id']; ?>" class="text-red-600 hover:text-red-900 delete-confirm">
                                                    <i class="fas fa-trash-alt"></i>
                                                </a>
                                            <?php else: ?>
                                                <span class="text-gray-400 cursor-not-allowed" title="Cannot delete category with products">
                                                    <i class="fas fa-trash-alt"></i>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="py-6 px-4 text-center text-gray-500">
                                        No categories found. Add a new category to get started.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <?php include '../includes/admin_footer.php'; ?>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>