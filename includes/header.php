<?php
// Only start the session if one doesn't already exist
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection and functions
require_once 'db_connect.php';
require_once 'functions.php';

// Include cart functions if file exists
if (file_exists('includes/cart_functions.php')) {
    require_once 'includes/cart_functions.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Healthgrade Pharmacy - Your Trusted Healthcare Partner</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/logo.png">
    
    <!-- Tailwind CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- GSAP for animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">

    <!-- Cart-specific styles -->
    <style>
        .cart-icon {
            position: relative;
            display: inline-flex;
            align-items: center;
        }
        .cart-counter {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: #ef4444;
            color: white;
            border-radius: 50%;
            font-size: 0.75rem;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        .scale-effect {
            animation: scale-pulse 0.3s ease-in-out;
        }
        @keyframes scale-pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.3); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="bg-gray-50 font-body text-gray-800">
    <!-- Top bar with contact info -->
    <div class="bg-green-800 text-white py-2 px-4">
        <div class="container mx-auto flex flex-wrap justify-between items-center text-sm">
            <div class="flex items-center space-x-4">
                <a href="tel:+94112345678" class="flex items-center hover:text-green-200">
                    <i class="fas fa-phone-alt mr-2"></i> +94 11 234 5678
                </a>
                <a href="mailto:info@healthgradepharmacy.lk" class="flex items-center hover:text-green-200">
                    <i class="fas fa-envelope mr-2"></i> info@healthgradepharmacy.lk
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="https://wa.me/94XXXXXXXXX" target="_blank" class="hover:text-green-200">
                    <i class="fab fa-whatsapp"></i> WhatsApp Us
                </a>
                <div class="hidden md:flex items-center">
                    <i class="fas fa-clock mr-2"></i> Open: 8:30 AM - 8:30 PM
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Navigation -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center">
                        <img src="assets/images/logo.png" alt="Healthgrade Pharmacy" class="h-12 mr-3">
                        <div>
                            <h1 class="text-xl font-bold text-green-700">Healthgrade Pharmacy</h1>
                            <p class="text-xs text-gray-500">Your Trusted Healthcare Partner</p>
                        </div>
                    </a>
                </div>
                
                <!-- Mobile menu button and cart icon for mobile -->
                <div class="flex items-center space-x-4 md:hidden">
                    <!-- Mobile Cart Icon -->
                    <a href="cart.php" class="cart-icon text-green-700 hover:text-green-900">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        <span id="cart-counter-mobile" class="cart-counter">
                            <?php 
                            echo function_exists('get_cart_count') ? get_cart_count() : '0'; 
                            ?>
                        </span>
                    </a>
                    
                    <!-- Mobile Menu Button -->
                    <button id="mobile-menu-button" class="text-gray-600 hover:text-green-700 focus:outline-none">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
                
                <!-- Desktop Navigation -->
                <nav class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Home</a>
                    <a href="products.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active' : ''; ?>">Products</a>
                    <a href="appointment.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'appointment.php') ? 'active' : ''; ?>">Appointments</a>
                    <a href="delivery.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'delivery.php') ? 'active' : ''; ?>">Delivery</a>
                    <a href="about.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">About</a>
                    <a href="contact.php" class="nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">Contact</a>
                    
                    <!-- Cart Icon with Counter -->
                    <a href="cart.php" class="cart-icon nav-link <?php echo (basename($_SERVER['PHP_SELF']) == 'cart.php') ? 'active' : ''; ?>">
                        <i class="fas fa-shopping-cart"></i>
                        <span id="cart-counter" class="cart-counter">
                            <?php 
                            echo function_exists('get_cart_count') ? get_cart_count() : '0'; 
                            ?>
                        </span>
                    </a>
                </nav>
            </div>
        </div>
        
        <!-- Mobile Navigation -->
        <nav id="mobile-menu" class="hidden bg-white px-4 py-4 md:hidden border-t border-gray-200">
            <div class="flex flex-col space-y-3">
                <a href="index.php" class="nav-link-mobile <?php echo (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : ''; ?>">Home</a>
                <a href="products.php" class="nav-link-mobile <?php echo (basename($_SERVER['PHP_SELF']) == 'products.php') ? 'active' : ''; ?>">Products</a>
                <a href="appointment.php" class="nav-link-mobile <?php echo (basename($_SERVER['PHP_SELF']) == 'appointment.php') ? 'active' : ''; ?>">Appointments</a>
                <a href="delivery.php" class="nav-link-mobile <?php echo (basename($_SERVER['PHP_SELF']) == 'delivery.php') ? 'active' : ''; ?>">Delivery</a>
                <a href="about.php" class="nav-link-mobile <?php echo (basename($_SERVER['PHP_SELF']) == 'about.php') ? 'active' : ''; ?>">About</a>
                <a href="contact.php" class="nav-link-mobile <?php echo (basename($_SERVER['PHP_SELF']) == 'contact.php') ? 'active' : ''; ?>">Contact</a>
                <a href="cart.php" class="nav-link-mobile <?php echo (basename($_SERVER['PHP_SELF']) == 'cart.php') ? 'active' : ''; ?>">
                    <i class="fas fa-shopping-cart mr-2"></i> Shopping Cart
                    <span class="bg-red-500 text-white rounded-full text-xs px-2 py-0.5 ml-2">
                        <?php 
                        echo function_exists('get_cart_count') ? get_cart_count() : '0'; 
                        ?>
                    </span>
                </a>
            </div>
        </nav>
    </header>
    
    <!-- Load Cart Modal -->
    <?php if (file_exists('includes/cart_modal.php')): ?>
        <?php include 'includes/cart_modal.php'; ?>
    <?php endif; ?>
    
    <main>