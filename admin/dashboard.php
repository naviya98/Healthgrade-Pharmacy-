<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

// Include database connection
require_once '../includes/db_connect.php';
require_once '../includes/functions.php';
require_once 'includes/admin_functions.php';

// Get counts for dashboard
$products_count = get_count($conn, 'products');
$categories_count = get_count($conn, 'categories');
$pending_appointments = get_appointments_count($conn, 'pending');
$total_appointments = get_count($conn, 'appointments');
$delivery_areas_count = get_count($conn, 'delivery_areas');
$admin_users_count = get_count($conn, 'admin_users');

// Get recent appointments
$recent_appointments = get_recent_appointments($conn, 5);

// Get recent activity from log
$recent_activity = get_recent_activity($conn, 10);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Healthgrade Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Custom styles for admin panel */
        .stats-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>
<body class="bg-gray-100">
    <?php include 'includes/admin_header.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
            <div class="text-sm text-gray-600">
                <span>Welcome, <?php echo $_SESSION['admin_full_name']; ?></span>
                <span class="mx-2">|</span>
                <span><?php echo date('l, F j, Y'); ?></span>
            </div>
        </div>
        
        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            <!-- Products Stats -->
            <div class="stats-card bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <i class="fas fa-pills text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Products</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $products_count; ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="products/index.php" class="text-blue-500 hover:text-blue-600 text-sm font-medium">
                        Manage Products <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <!-- Categories Stats -->
            <div class="stats-card bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Categories</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $categories_count; ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="products/categories.php" class="text-green-500 hover:text-green-600 text-sm font-medium">
                        Manage Categories <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <!-- Appointments Stats -->
            <div class="stats-card bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Pending Appointments</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $pending_appointments; ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="appointments/index.php" class="text-yellow-500 hover:text-yellow-600 text-sm font-medium">
                        Manage Appointments <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <!-- Delivery Areas Stats -->
            <div class="stats-card bg-white rounded-lg shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-purple-100 text-purple-500 mr-4">
                        <i class="fas fa-truck text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Delivery Areas</p>
                        <p class="text-2xl font-bold text-gray-800"><?php echo $delivery_areas_count; ?></p>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="delivery/index.php" class="text-purple-500 hover:text-purple-600 text-sm font-medium">
                        Manage Delivery Areas <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Appointments -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Recent Appointments</h2>
                    <a href="appointments/index.php" class="text-blue-500 hover:underline text-sm">View All</a>
                </div>
                
                <?php if (count($recent_appointments) > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                    <th class="py-2 px-4 border-b text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($recent_appointments as $appointment): ?>
                                    <tr>
                                        <td class="py-2 px-4 border-b text-sm"><?php echo $appointment['name']; ?></td>
                                        <td class="py-2 px-4 border-b text-sm"><?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?></td>
                                        <td class="py-2 px-4 border-b text-sm"><?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></td>
                                        <td class="py-2 px-4 border-b text-sm">
                                            <?php
                                            $status_colors = [
                                                'pending' => 'yellow',
                                                'confirmed' => 'green',
                                                'cancelled' => 'red',
                                                'completed' => 'blue'
                                            ];
                                            $color = $status_colors[$appointment['status']] ?? 'gray';
                                            ?>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-<?php echo $color; ?>-100 text-<?php echo $color; ?>-800">
                                                <?php echo ucfirst($appointment['status']); ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <p class="text-gray-500 text-center py-4">No recent appointments</p>
                <?php endif; ?>
            </div>
            
            <!-- Recent Activity -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-bold text-gray-800">Recent Activity</h2>
                </div>
                
                <?php if (count($recent_activity) > 0): ?>
                    <div class="space-y-4">
                        <?php foreach ($recent_activity as $activity): ?>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 mr-3">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-clock text-blue-500"></i>
                                    </div>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-800"><?php echo $activity['activity']; ?></p>
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
        
        <!-- Quick Actions Section -->
        <div class="bg-white rounded-lg shadow p-6 mt-8">
            <h2 class="text-lg font-bold text-gray-800 mb-6">Quick Actions</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <a href="products/add.php" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-green-50 hover:border-green-200 transition duration-300">
                    <div class="p-2 rounded-full bg-green-100 text-green-500 mr-3">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="text-gray-700">Add Product</span>
                </a>
                
                <a href="appointments/index.php?status=pending" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-yellow-50 hover:border-yellow-200 transition duration-300">
                    <div class="p-2 rounded-full bg-yellow-100 text-yellow-500 mr-3">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <span class="text-gray-700">Pending Appointments</span>
                </a>
                
                <a href="products/categories.php" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-blue-50 hover:border-blue-200 transition duration-300">
                    <div class="p-2 rounded-full bg-blue-100 text-blue-500 mr-3">
                        <i class="fas fa-tags"></i>
                    </div>
                    <span class="text-gray-700">Manage Categories</span>
                </a>
                
                <a href="users/index.php" class="flex items-center p-4 border border-gray-200 rounded-lg hover:bg-purple-50 hover:border-purple-200 transition duration-300">
                    <div class="p-2 rounded-full bg-purple-100 text-purple-500 mr-3">
                        <i class="fas fa-users"></i>
                    </div>
                    <span class="text-gray-700">Manage Users</span>
                </a>
            </div>
        </div>
    </div>
    
    <?php include 'includes/admin_footer.php'; ?>
    
    <script>
        // Add any dashboard-specific JavaScript here
        document.addEventListener('DOMContentLoaded', function() {
            // Animation for stats cards
            const statsCards = document.querySelectorAll('.stats-card');
            
            statsCards.forEach((card, index) => {
                setTimeout(() => {
                    card.style.opacity = '1';
                }, index * 100);
            });
        });
    </script>
</body>
</html>