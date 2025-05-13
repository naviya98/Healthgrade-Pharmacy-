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

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error_message'] = "Product ID is required.";
    header('Location: index.php');
    exit;
}

$product_id = (int)$_GET['id'];

// Get product details
$sql = "SELECT * FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = "Product not found.";
    header('Location: index.php');
    exit;
}

$product = $result->fetch_assoc();
$stmt->close();

// Define variables and initialize with product data
$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$category_id = $product['category_id'];
$image = $product['image'];
$is_featured = $product['is_featured'];
$is_active = $product['is_active'];
$errors = [];

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $name = sanitize_input($_POST['name'] ?? '');
    $description = sanitize_input($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category_id = (int)($_POST['category_id'] ?? 0);
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    // Validate name
    if (empty($name)) {
        $errors[] = 'Product name is required';
    } elseif (strlen($name) > 255) {
        $errors[] = 'Product name cannot exceed 255 characters';
    }
    
    // Validate price
    if ($price <= 0) {
        $errors[] = 'Price must be greater than zero';
    }
    
    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        $upload_result = upload_image($_FILES['image'], '../../assets/images/products');
        
        if ($upload_result['success']) {
            $image = 'assets/images/products/' . $upload_result['filename'];
        } else {
            $errors[] = 'Image upload failed: ' . $upload_result['message'];
        }
    }
    
    // If no errors, update product in database
    if (empty($errors)) {
        $sql = "UPDATE products SET 
                name = ?, 
                description = ?, 
                price = ?, 
                category_id = ?, 
                image = ?, 
                is_featured = ?, 
                is_active = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssissii", $name, $description, $price, $category_id, $image, $is_featured, $is_active, $product_id);
        
        if ($stmt->execute()) {
            // Log activity
            log_activity($conn, "Updated product: $name", $_SESSION['admin_id']);
            
            // Set success message and redirect
            $_SESSION['success_message'] = "Product updated successfully.";
            header('Location: index.php');
            exit;
        } else {
            $errors[] = 'Error updating product: ' . $conn->error;
        }
        
        $stmt->close();
    }
}

// Get all categories for dropdown
$categories = get_categories_array($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Healthgrade Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-gray-100">
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Edit Product: <?php echo $name; ?></h1>
            <a href="index.php" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600 transition duration-300">
                <i class="fas fa-arrow-left mr-2"></i> Back to Products
            </a>
        </div>
        
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
        
        <div class="bg-white rounded-lg shadow p-6">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="name" name="name" value="<?php echo $name; ?>" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">
                                Category
                            </label>
                            <select id="category_id" name="category_id" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                                <option value="0">Select Category</option>
                                <?php foreach ($categories as $id => $category_name): ?>
                                    <option value="<?php echo $id; ?>" <?php echo $category_id == $id ? 'selected' : ''; ?>>
                                        <?php echo $category_name; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-4">
                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">
                                Price (Rs.) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" id="price" name="price" value="<?php echo $price; ?>" step="0.01" min="0" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                required>
                        </div>
                        
                        <div class="mb-4">
                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">
                                Product Image
                            </label>
                            <?php if (!empty($image) && $image != 'assets/images/products/placeholder.jpg'): ?>
                                <div class="mb-2">
                                    <img src="../../<?php echo $image; ?>" alt="<?php echo $name; ?>" class="h-32 w-32 object-cover border rounded">
                                    <p class="text-sm text-gray-500 mt-1">Current image</p>
                                </div>
                            <?php endif; ?>
                            <input type="file" id="image" name="image" accept="image/*" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                            <p class="text-sm text-gray-500 mt-1">
                                Recommended size: 600x600px. Max file size: 2MB. Leave empty to keep current image.
                            </p>
                        </div>
                        
                        <div class="mb-4 flex space-x-4">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_featured" value="1" <?php echo $is_featured ? 'checked' : ''; ?> 
                                        class="rounded text-green-600 focus:ring-green-500 h-5 w-5">
                                    <span class="ml-2 text-gray-700">Featured Product</span>
                                </label>
                            </div>
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" <?php echo $is_active ? 'checked' : ''; ?> 
                                        class="rounded text-green-600 focus:ring-green-500 h-5 w-5">
                                    <span class="ml-2 text-gray-700">Active</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                                Description
                            </label>
                            <textarea id="description" name="description" rows="12" 
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"><?php echo $description; ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 border-t pt-6 flex justify-between">
                    <a href="index.php" class="bg-gray-500 text-white px-6 py-2 rounded font-semibold hover:bg-gray-600 transition duration-300">
                        Cancel
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded font-semibold hover:bg-green-700 transition duration-300">
                        <i class="fas fa-save mr-2"></i> Update Product
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <?php include '../includes/admin_footer.php'; ?>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>