<?php
// Admin header included on all admin pages
?>
<!-- Admin Header -->
<header class="bg-white shadow">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="dashboard.php" class="flex items-center">
                    <i class="fas fa-clinic-medical text-green-600 text-2xl mr-2"></i>
                    <div>
                        <h1 class="text-xl font-bold text-gray-800">Healthgrade Pharmacy</h1>
                        <p class="text-xs text-gray-500">Admin Panel</p>
                    </div>
                </a>
            </div>
            
            <!-- User Menu -->
            <div class="relative">
                <button id="user-menu-button" class="flex items-center text-gray-600 focus:outline-none">
                    <span class="mr-2 text-sm hidden md:inline-block"><?php echo $_SESSION['admin_username']; ?></span>
                    <div class="w-8 h-8 bg-gray-200 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-gray-500"></i>
                    </div>
                </button>
                
                <!-- Dropdown Menu -->
                <div id="user-dropdown" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg hidden z-10">
                    <div class="py-1">
                        <a href="profile.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user-circle mr-2"></i> Profile
                        </a>
                        <a href="settings.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <div class="border-t border-gray-100"></div>
                        <a href="logout.php" class="block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- Admin Navigation -->
<nav class="bg-gray-800 text-white">
    <div class="container mx-auto px-4">
        <div class="flex items-center">
            <div class="flex flex-grow overflow-x-auto">
                <a href="dashboard.php" class="py-4 px-6 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
                <a href="products/index.php" class="py-4 px-6 hover:bg-gray-700 <?php echo strpos($_SERVER['PHP_SELF'], '/products/') !== false ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-pills mr-2"></i> Products
                </a>
                <a href="appointments/index.php" class="py-4 px-6 hover:bg-gray-700 <?php echo strpos($_SERVER['PHP_SELF'], '/appointments/') !== false ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-calendar-check mr-2"></i> Appointments
                </a>
                <a href="delivery/index.php" class="py-4 px-6 hover:bg-gray-700 <?php echo strpos($_SERVER['PHP_SELF'], '/delivery/') !== false ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-truck mr-2"></i> Delivery
                </a>
                <a href="users/index.php" class="py-4 px-6 hover:bg-gray-700 <?php echo strpos($_SERVER['PHP_SELF'], '/users/') !== false ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
                <a href="settings.php" class="py-4 px-6 hover:bg-gray-700 <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'bg-gray-700' : ''; ?>">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
            </div>
            <div>
                <a href="../index.php" target="_blank" class="py-4 px-6 hover:bg-gray-700 block">
                    <i class="fas fa-external-link-alt mr-2"></i> View Site
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Mobile Navigation Toggle -->
<div class="lg:hidden bg-white border-b">
    <div class="container mx-auto px-4 py-2">
        <button id="mobile-menu-button" class="text-gray-600 focus:outline-none">
            <i class="fas fa-bars text-xl"></i> Menu
        </button>
    </div>
</div>

<!-- Mobile Navigation Menu -->
<div id="mobile-menu" class="lg:hidden bg-white shadow-md hidden">
    <div class="container mx-auto px-4 py-2">
        <ul class="space-y-2 py-2">
            <li>
                <a href="dashboard.php" class="block py-2 px-4 hover:bg-gray-100 rounded <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'text-green-600 font-semibold' : 'text-gray-700'; ?>">
                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="products/index.php" class="block py-2 px-4 hover:bg-gray-100 rounded <?php echo strpos($_SERVER['PHP_SELF'], '/products/') !== false ? 'text-green-600 font-semibold' : 'text-gray-700'; ?>">
                    <i class="fas fa-pills mr-2"></i> Products
                </a>
            </li>
            <li>
                <a href="appointments/index.php" class="block py-2 px-4 hover:bg-gray-100 rounded <?php echo strpos($_SERVER['PHP_SELF'], '/appointments/') !== false ? 'text-green-600 font-semibold' : 'text-gray-700'; ?>">
                    <i class="fas fa-calendar-check mr-2"></i> Appointments
                </a>
            </li>
            <li>
                <a href="delivery/index.php" class="block py-2 px-4 hover:bg-gray-100 rounded <?php echo strpos($_SERVER['PHP_SELF'], '/delivery/') !== false ? 'text-green-600 font-semibold' : 'text-gray-700'; ?>">
                    <i class="fas fa-truck mr-2"></i> Delivery
                </a>
            </li>
            <li>
                <a href="users/index.php" class="block py-2 px-4 hover:bg-gray-100 rounded <?php echo strpos($_SERVER['PHP_SELF'], '/users/') !== false ? 'text-green-600 font-semibold' : 'text-gray-700'; ?>">
                    <i class="fas fa-users mr-2"></i> Users
                </a>
            </li>
            <li>
                <a href="settings.php" class="block py-2 px-4 hover:bg-gray-100 rounded <?php echo basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'text-green-600 font-semibold' : 'text-gray-700'; ?>">
                    <i class="fas fa-cog mr-2"></i> Settings
                </a>
            </li>
            <li class="border-t pt-2 mt-2">
                <a href="../index.php" target="_blank" class="block py-2 px-4 hover:bg-gray-100 rounded text-gray-700">
                    <i class="fas fa-external-link-alt mr-2"></i> View Site
                </a>
            </li>
            <li>
                <a href="logout.php" class="block py-2 px-4 hover:bg-gray-100 rounded text-red-600">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </a>
            </li>
        </ul>
    </div>
</div>