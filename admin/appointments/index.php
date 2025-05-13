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

// Handle status update
if (isset($_GET['id']) && !empty($_GET['id']) && isset($_GET['action']) && in_array($_GET['action'], ['confirm', 'cancel', 'complete'])) {
    $appointment_id = (int)$_GET['id'];
    $action = $_GET['action'];
    
    $status_map = [
        'confirm' => 'confirmed',
        'cancel' => 'cancelled',
        'complete' => 'completed'
    ];
    
    $new_status = $status_map[$action];
    
    // Get appointment details before update for logging
    $sql = "SELECT * FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $appointment = $result->fetch_assoc();
        
        // Update appointment status
        $update_sql = "UPDATE appointments SET status = ?, updated_at = NOW() WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("si", $new_status, $appointment_id);
        
        if ($update_stmt->execute()) {
            // Log activity
            $action_text = ucfirst($action) . "ed";
            log_activity($conn, "$action_text appointment for {$appointment['name']} on " . date('Y-m-d', strtotime($appointment['appointment_date'])), $_SESSION['admin_id']);
            
            $_SESSION['success_message'] = "Appointment status updated to $new_status.";
        } else {
            $_SESSION['error_message'] = "Error updating appointment status: " . $conn->error;
        }
        
        $update_stmt->close();
    } else {
        $_SESSION['error_message'] = "Appointment not found.";
    }
    
    $stmt->close();
    
    // Redirect to appointments page
    header('Location: index.php');
    exit;
}

// Get filter values
$status = isset($_GET['status']) ? sanitize_input($_GET['status']) : '';
$date_from = isset($_GET['date_from']) ? sanitize_input($_GET['date_from']) : '';
$date_to = isset($_GET['date_to']) ? sanitize_input($_GET['date_to']) : '';
$search = isset($_GET['search']) ? sanitize_input($_GET['search']) : '';

// Build SQL query
$sql = "SELECT * FROM appointments WHERE 1=1";

// Add status filter
if (!empty($status)) {
    $sql .= " AND status = '$status'";
}

// Add date range filter
if (!empty($date_from)) {
    $sql .= " AND appointment_date >= '$date_from'";
}
if (!empty($date_to)) {
    $sql .= " AND appointment_date <= '$date_to'";
}

// Add search filter
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%')";
}

// Order by most recent appointment date first
$sql .= " ORDER BY appointment_date DESC, appointment_time DESC";

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$items_per_page = 10;
$offset = ($page - 1) * $items_per_page;

// Get total appointments count for pagination
$count_result = $conn->query("SELECT COUNT(*) as total FROM (" . $sql . ") as subquery");
$total_appointments = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_appointments / $items_per_page);

// Add limit for current page
$sql .= " LIMIT $offset, $items_per_page";

// Execute query
$result = $conn->query($sql);
$appointments = [];

if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

// Get counts for each status
$status_counts = [
    'all' => $total_appointments,
    'pending' => 0,
    'confirmed' => 0,
    'cancelled' => 0,
    'completed' => 0
];

$count_sql = "SELECT status, COUNT(*) as count FROM appointments GROUP BY status";
$count_result = $conn->query($count_sql);

if ($count_result && $count_result->num_rows > 0) {
    while($row = $count_result->fetch_assoc()) {
        $status_counts[$row['status']] = $row['count'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments - Healthgrade Pharmacy</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body class="bg-gray-100">
    <?php include '../includes/admin_header.php'; ?>
    
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manage Appointments</h1>
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
        
        <!-- Status Tabs -->
        <div class="mb-6 border-b border-gray-200">
            <ul class="flex flex-wrap -mb-px">
                <li class="mr-2">
                    <a href="index.php" class="inline-block py-2 px-4 <?php echo empty($status) ? 'text-green-600 border-b-2 border-green-600 font-semibold' : 'text-gray-500 hover:text-gray-700'; ?>">
                        All <span class="ml-1 bg-gray-200 text-gray-700 py-0.5 px-2 rounded-full text-xs"><?php echo $status_counts['all']; ?></span>
                    </a>
                </li>
                <li class="mr-2">
                    <a href="index.php?status=pending" class="inline-block py-2 px-4 <?php echo $status === 'pending' ? 'text-yellow-600 border-b-2 border-yellow-600 font-semibold' : 'text-gray-500 hover:text-gray-700'; ?>">
                        Pending <span class="ml-1 bg-yellow-100 text-yellow-800 py-0.5 px-2 rounded-full text-xs"><?php echo $status_counts['pending']; ?></span>
                    </a>
                </li>
                <li class="mr-2">
                    <a href="index.php?status=confirmed" class="inline-block py-2 px-4 <?php echo $status === 'confirmed' ? 'text-green-600 border-b-2 border-green-600 font-semibold' : 'text-gray-500 hover:text-gray-700'; ?>">
                        Confirmed <span class="ml-1 bg-green-100 text-green-800 py-0.5 px-2 rounded-full text-xs"><?php echo $status_counts['confirmed']; ?></span>
                    </a>
                </li>
                <li class="mr-2">
                    <a href="index.php?status=completed" class="inline-block py-2 px-4 <?php echo $status === 'completed' ? 'text-blue-600 border-b-2 border-blue-600 font-semibold' : 'text-gray-500 hover:text-gray-700'; ?>">
                        Completed <span class="ml-1 bg-blue-100 text-blue-800 py-0.5 px-2 rounded-full text-xs"><?php echo $status_counts['completed']; ?></span>
                    </a>
                </li>
                <li>
                    <a href="index.php?status=cancelled" class="inline-block py-2 px-4 <?php echo $status === 'cancelled' ? 'text-red-600 border-b-2 border-red-600 font-semibold' : 'text-gray-500 hover:text-gray-700'; ?>">
                        Cancelled <span class="ml-1 bg-red-100 text-red-800 py-0.5 px-2 rounded-full text-xs"><?php echo $status_counts['cancelled']; ?></span>
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Filter and Search -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <form action="" method="GET" class="flex flex-col md:flex-row gap-4">
                <?php if (!empty($status)): ?>
                    <input type="hidden" name="status" value="<?php echo $status; ?>">
                <?php endif; ?>
                
                <div class="w-full md:w-1/4">
                    <label for="date_from" class="block text-gray-700 text-sm font-bold mb-2">From Date</label>
                    <input type="date" id="date_from" name="date_from" value="<?php echo $date_from; ?>" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div class="w-full md:w-1/4">
                    <label for="date_to" class="block text-gray-700 text-sm font-bold mb-2">To Date</label>
                    <input type="date" id="date_to" name="date_to" value="<?php echo $date_to; ?>" 
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                </div>
                
                <div class="w-full md:w-2/4">
                    <label for="search" class="block text-gray-700 text-sm font-bold mb-2">Search</label>
                    <div class="flex">
                        <input type="text" id="search" name="search" value="<?php echo $search; ?>" 
                            placeholder="Search by name, email or phone" 
                            class="w-full border border-gray-300 rounded-l px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-r hover:bg-green-700">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <!-- Appointments Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="py-3 px-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                            <th class="py-3 px-4 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if (count($appointments) > 0): ?>
                            <?php foreach ($appointments as $appointment): ?>
                                <tr>
                                    <td class="py-3 px-4">
                                        <div class="font-medium text-gray-900"><?php echo $appointment['name']; ?></div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-gray-500 text-sm"><?php echo $appointment['email']; ?></div>
                                        <div class="text-gray-500 text-sm"><?php echo $appointment['phone']; ?></div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="text-gray-900"><?php echo date('M d, Y', strtotime($appointment['appointment_date'])); ?></div>
                                        <div class="text-gray-500 text-sm"><?php echo date('h:i A', strtotime($appointment['appointment_time'])); ?></div>
                                    </td>
                                    <td class="py-3 px-4">
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
                                    <td class="py-3 px-4">
                                        <div class="text-gray-500 text-sm truncate max-w-xs">
                                            <?php echo empty($appointment['notes']) ? '-' : $appointment['notes']; ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <!-- View Details -->
                                            <a href="view.php?id=<?php echo $appointment['id']; ?>" class="text-blue-600 hover:text-blue-900" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            
                                            <!-- Status Actions -->
                                            <?php if ($appointment['status'] === 'pending'): ?>
                                                <a href="index.php?id=<?php echo $appointment['id']; ?>&action=confirm" class="text-green-600 hover:text-green-900" title="Confirm Appointment">
                                                    <i class="fas fa-check"></i>
                                                </a>
                                                <a href="index.php?id=<?php echo $appointment['id']; ?>&action=cancel" class="text-red-600 hover:text-red-900" title="Cancel Appointment">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php elseif ($appointment['status'] === 'confirmed'): ?>
                                                <a href="index.php?id=<?php echo $appointment['id']; ?>&action=complete" class="text-blue-600 hover:text-blue-900" title="Mark as Completed">
                                                    <i class="fas fa-check-double"></i>
                                                </a>
                                                <a href="index.php?id=<?php echo $appointment['id']; ?>&action=cancel" class="text-red-600 hover:text-red-900" title="Cancel Appointment">
                                                    <i class="fas fa-times"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="py-6 px-4 text-center text-gray-500">
                                    No appointments found.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <?php if ($total_pages > 1): ?>
                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-700">
                            Showing <span class="font-medium"><?php echo $offset + 1; ?></span> to 
                            <span class="font-medium"><?php echo min($offset + $items_per_page, $total_appointments); ?></span> of 
                            <span class="font-medium"><?php echo $total_appointments; ?></span> appointments
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination">
                                <?php
                                // Build pagination URL
                                $pagination_url = 'index.php?';
                                if (!empty($status)) $pagination_url .= "status=$status&";
                                if (!empty($date_from)) $pagination_url .= "date_from=$date_from&";
                                if (!empty($date_to)) $pagination_url .= "date_to=$date_to&";
                                if (!empty($search)) $pagination_url .= "search=" . urlencode($search) . "&";
                                ?>
                                
                                <!-- Previous Page Link -->
                                <?php if ($page > 1): ?>
                                    <a href="<?php echo $pagination_url . 'page=' . ($page - 1); ?>" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <span class="sr-only">Previous</span>
                                        <i class="fas fa-chevron-left"></i>
                                    </span>
                                <?php endif; ?>
                                
                                <!-- Page Numbers -->
                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                    <?php if ($i == $page): ?>
                                        <span class="relative inline-flex items-center px-4 py-2 border border-green-500 bg-green-50 text-sm font-medium text-green-600">
                                            <?php echo $i; ?>
                                        </span>
                                    <?php else: ?>
                                        <a href="<?php echo $pagination_url . 'page=' . $i; ?>" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                                            <?php echo $i; ?>
                                        </a>
                                    <?php endif; ?>
                                <?php endfor; ?>
                                
                                <!-- Next Page Link -->
                                <?php if ($page < $total_pages): ?>
                                    <a href="<?php echo $pagination_url . 'page=' . ($page + 1); ?>" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400 cursor-not-allowed">
                                        <span class="sr-only">Next</span>
                                        <i class="fas fa-chevron-right"></i>
                                    </span>
                                <?php endif; ?>
                            </nav>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <?php include '../includes/admin_footer.php'; ?>
    
    <script src="../assets/js/admin.js"></script>
</body>
</html>