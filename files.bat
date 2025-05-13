@echo off
echo Creating folder structure for Healthgrade Pharmacy Website...

REM Create main project directory
mkdir HealthgradePharmacy
cd HealthgradePharmacy

REM Create assets directories
mkdir assets
mkdir assets\css
mkdir assets\js
mkdir assets\images
mkdir assets\fonts
mkdir assets\images\products
mkdir assets\images\banners

REM Create includes directory
mkdir includes

REM Create admin section
mkdir admin
mkdir admin\products
mkdir admin\appointments
mkdir admin\users
mkdir admin\delivery

REM Create main PHP files
echo ^<?php include 'includes/header.php'; ?^> > index.php
echo ^<div class="container mx-auto px-4 py-8"^> >> index.php
echo ^<h1 class="text-3xl font-bold text-green-700 mb-6"^>Welcome to Healthgrade Pharmacy^</h1^> >> index.php
echo ^<p class="mb-4"^>Your trusted healthcare partner.^</p^> >> index.php
echo ^</div^> >> index.php
echo ^<?php include 'includes/footer.php'; ?^> >> index.php

echo ^<?php include 'includes/header.php'; ?^> > products.php
echo ^<div class="container mx-auto px-4 py-8"^> >> products.php
echo ^<h1 class="text-3xl font-bold text-green-700 mb-6"^>Our Products^</h1^> >> products.php
echo ^<div id="products-container" class="grid grid-cols-1 md:grid-cols-3 gap-6"^>^</div^> >> products.php
echo ^</div^> >> products.php
echo ^<?php include 'includes/footer.php'; ?^> >> products.php

echo ^<?php include 'includes/header.php'; ?^> > appointment.php
echo ^<div class="container mx-auto px-4 py-8"^> >> appointment.php
echo ^<h1 class="text-3xl font-bold text-green-700 mb-6"^>Book an Appointment^</h1^> >> appointment.php
echo ^<form id="appointment-form" class="max-w-lg mx-auto"^>^</form^> >> appointment.php
echo ^</div^> >> appointment.php
echo ^<?php include 'includes/footer.php'; ?^> >> appointment.php

echo ^<?php include 'includes/header.php'; ?^> > about.php
echo ^<div class="container mx-auto px-4 py-8"^> >> about.php
echo ^<h1 class="text-3xl font-bold text-green-700 mb-6"^>About Us^</h1^> >> about.php
echo ^</div^> >> about.php
echo ^<?php include 'includes/footer.php'; ?^> >> about.php

echo ^<?php include 'includes/header.php'; ?^> > contact.php
echo ^<div class="container mx-auto px-4 py-8"^> >> contact.php
echo ^<h1 class="text-3xl font-bold text-green-700 mb-6"^>Contact Us^</h1^> >> contact.php
echo ^</div^> >> contact.php
echo ^<?php include 'includes/footer.php'; ?^> >> contact.php

echo ^<?php include 'includes/header.php'; ?^> > delivery.php
echo ^<div class="container mx-auto px-4 py-8"^> >> delivery.php
echo ^<h1 class="text-3xl font-bold text-green-700 mb-6"^>Delivery Information^</h1^> >> delivery.php
echo ^</div^> >> delivery.php
echo ^<?php include 'includes/footer.php'; ?^> >> delivery.php

REM Create include files
echo ^<?php session_start(); ?^> > includes\header.php
echo ^<!DOCTYPE html^> >> includes\header.php
echo ^<html lang="en"^> >> includes\header.php
echo ^<head^> >> includes\header.php
echo     ^<meta charset="UTF-8"^> >> includes\header.php
echo     ^<meta name="viewport" content="width=device-width, initial-scale=1.0"^> >> includes\header.php
echo     ^<title^>Healthgrade Pharmacy^</title^> >> includes\header.php
echo     ^<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"^> >> includes\header.php
echo     ^<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"^>^</script^> >> includes\header.php
echo     ^<link rel="stylesheet" href="/assets/css/style.css"^> >> includes\header.php
echo ^</head^> >> includes\header.php
echo ^<body class="bg-white text-gray-800"^> >> includes\header.php
echo     ^<header class="bg-green-700 text-white shadow-md"^> >> includes\header.php
echo         ^<div class="container mx-auto px-4 py-4 flex flex-wrap items-center justify-between"^> >> includes\header.php
echo             ^<div class="flex items-center"^> >> includes\header.php
echo                 ^<a href="index.php" class="text-2xl font-bold"^>Healthgrade Pharmacy^</a^> >> includes\header.php
echo             ^</div^> >> includes\header.php
echo             ^<nav class="flex items-center"^> >> includes\header.php
echo                 ^<ul class="flex space-x-6"^> >> includes\header.php
echo                     ^<li^>^<a href="index.php" class="hover:text-green-200"^>Home^</a^>^</li^> >> includes\header.php
echo                     ^<li^>^<a href="products.php" class="hover:text-green-200"^>Products^</a^>^</li^> >> includes\header.php
echo                     ^<li^>^<a href="appointment.php" class="hover:text-green-200"^>Appointments^</a^>^</li^> >> includes\header.php
echo                     ^<li^>^<a href="delivery.php" class="hover:text-green-200"^>Delivery^</a^>^</li^> >> includes\header.php
echo                     ^<li^>^<a href="about.php" class="hover:text-green-200"^>About^</a^>^</li^> >> includes\header.php
echo                     ^<li^>^<a href="contact.php" class="hover:text-green-200"^>Contact^</a^>^</li^> >> includes\header.php
echo                 ^</ul^> >> includes\header.php
echo             ^</nav^> >> includes\header.php
echo         ^</div^> >> includes\header.php
echo     ^</header^> >> includes\header.php
echo     ^<main^> >> includes\header.php

echo     ^</main^> > includes\footer.php
echo     ^<footer class="bg-green-800 text-white mt-12 py-8"^> >> includes\footer.php
echo         ^<div class="container mx-auto px-4"^> >> includes\footer.php
echo             ^<div class="grid grid-cols-1 md:grid-cols-3 gap-8"^> >> includes\footer.php
echo                 ^<div^> >> includes\footer.php
echo                     ^<h3 class="text-xl font-bold mb-4"^>Healthgrade Pharmacy^</h3^> >> includes\footer.php
echo                     ^<p^>Your trusted healthcare partner in Sri Lanka.^</p^> >> includes\footer.php
echo                 ^</div^> >> includes\footer.php
echo                 ^<div^> >> includes\footer.php
echo                     ^<h3 class="text-xl font-bold mb-4"^>Quick Links^</h3^> >> includes\footer.php
echo                     ^<ul class="space-y-2"^> >> includes\footer.php
echo                         ^<li^>^<a href="products.php" class="hover:text-green-200"^>Products^</a^>^</li^> >> includes\footer.php
echo                         ^<li^>^<a href="appointment.php" class="hover:text-green-200"^>Appointments^</a^>^</li^> >> includes\footer.php
echo                         ^<li^>^<a href="delivery.php" class="hover:text-green-200"^>Delivery^</a^>^</li^> >> includes\footer.php
echo                     ^</ul^> >> includes\footer.php
echo                 ^</div^> >> includes\footer.php
echo                 ^<div^> >> includes\footer.php
echo                     ^<h3 class="text-xl font-bold mb-4"^>Contact Us^</h3^> >> includes\footer.php
echo                     ^<p^>123 Hospital Road, Colombo^</p^> >> includes\footer.php
echo                     ^<p^>Email: info@healthgradepharmacy.lk^</p^> >> includes\footer.php
echo                     ^<p^>Phone: +94 11 234 5678^</p^> >> includes\footer.php
echo                 ^</div^> >> includes\footer.php
echo             ^</div^> >> includes\footer.php
echo             ^<div class="mt-8 pt-8 border-t border-green-700 text-center"^> >> includes\footer.php
echo                 ^<p^>&copy; <?php echo date('Y'); ?> Healthgrade Pharmacy. All rights reserved.^</p^> >> includes\footer.php
echo             ^</div^> >> includes\footer.php
echo         ^</div^> >> includes\footer.php
echo     ^</footer^> >> includes\footer.php
echo     ^<script src="/assets/js/main.js"^>^</script^> >> includes\footer.php
echo ^</body^> >> includes\footer.php
echo ^</html^> >> includes\footer.php

echo ^<?php > includes\db_connect.php
echo // Database connection parameters >> includes\db_connect.php
echo $servername = "localhost"; >> includes\db_connect.php
echo $username = "root"; >> includes\db_connect.php
echo $password = ""; >> includes\db_connect.php
echo $dbname = "healthgrade_pharmacy"; >> includes\db_connect.php
echo  >> includes\db_connect.php
echo // Create connection >> includes\db_connect.php
echo $conn = new mysqli($servername, $username, $password, $dbname); >> includes\db_connect.php
echo  >> includes\db_connect.php
echo // Check connection >> includes\db_connect.php
echo if ($conn-^>connect_error) { >> includes\db_connect.php
echo     die("Connection failed: " . $conn-^>connect_error); >> includes\db_connect.php
echo } >> includes\db_connect.php
echo ?^> >> includes\db_connect.php

echo ^<?php > includes\functions.php
echo // Common functions for the website >> includes\functions.php
echo  >> includes\functions.php
echo // Function to sanitize input data >> includes\functions.php
echo function sanitize_input($data) { >> includes\functions.php
echo     $data = trim($data); >> includes\functions.php
echo     $data = stripslashes($data); >> includes\functions.php
echo     $data = htmlspecialchars($data); >> includes\functions.php
echo     return $data; >> includes\functions.php
echo } >> includes\functions.php
echo  >> includes\functions.php
echo // Function to get all products >> includes\functions.php
echo function get_all_products($conn) { >> includes\functions.php
echo     $sql = "SELECT * FROM products ORDER BY id DESC"; >> includes\functions.php
echo     $result = $conn-^>query($sql); >> includes\functions.php
echo     $products = []; >> includes\functions.php
echo     if ($result-^>num_rows > 0) { >> includes\functions.php
echo         while($row = $result-^>fetch_assoc()) { >> includes\functions.php
echo             $products[] = $row; >> includes\functions.php
echo         } >> includes\functions.php
echo     } >> includes\functions.php
echo     return $products; >> includes\functions.php
echo } >> includes\functions.php
echo  >> includes\functions.php
echo // Function to get product by ID >> includes\functions.php
echo function get_product_by_id($conn, $id) { >> includes\functions.php
echo     $id = (int)$id; >> includes\functions.php
echo     $sql = "SELECT * FROM products WHERE id = $id"; >> includes\functions.php
echo     $result = $conn-^>query($sql); >> includes\functions.php
echo     if ($result-^>num_rows > 0) { >> includes\functions.php
echo         return $result-^>fetch_assoc(); >> includes\functions.php
echo     } >> includes\functions.php
echo     return null; >> includes\functions.php
echo } >> includes\functions.php
echo ?^> >> includes\functions.php

REM Create CSS file
echo /* Main Stylesheet for Healthgrade Pharmacy */ > assets\css\style.css
echo  >> assets\css\style.css
echo /* Custom properties */ >> assets\css\style.css
echo :root { >> assets\css\style.css
echo   --primary-color: #15803d; /* green-700 */ >> assets\css\style.css
echo   --primary-dark: #166534; /* green-800 */ >> assets\css\style.css
echo   --primary-light: #bbf7d0; /* green-200 */ >> assets\css\style.css
echo   --white: #ffffff; >> assets\css\style.css
echo   --light-gray: #f3f4f6; /* gray-100 */ >> assets\css\style.css
echo } >> assets\css\style.css
echo  >> assets\css\style.css
echo /* Additional custom styles beyond Tailwind */ >> assets\css\style.css
echo .product-card { >> assets\css\style.css
echo   transition: transform 0.3s ease, box-shadow 0.3s ease; >> assets\css\style.css
echo } >> assets\css\style.css
echo  >> assets\css\style.css
echo .product-card:hover { >> assets\css\style.css
echo   transform: translateY(-5px); >> assets\css\style.css
echo   box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05); >> assets\css\style.css
echo } >> assets\css\style.css

REM Create JavaScript file
echo // Main JavaScript for Healthgrade Pharmacy > assets\js\main.js
echo document.addEventListener('DOMContentLoaded', function() { >> assets\js\main.js
echo   // GSAP animations for page elements >> assets\js\main.js
echo   gsap.from('header', { duration: 1, y: -50, opacity: 0, ease: 'power3.out' }); >> assets\js\main.js
echo   gsap.from('main h1', { duration: 1, delay: 0.5, y: 20, opacity: 0, ease: 'power3.out' }); >> assets\js\main.js
echo   gsap.from('main p, main .grid', { duration: 1, delay: 0.8, y: 20, opacity: 0, ease: 'power3.out' }); >> assets\js\main.js
echo  >> assets\js\main.js
echo   // Load products if on the products page >> assets\js\main.js
echo   if (document.getElementById('products-container')) { >> assets\js\main.js
echo     loadProducts(); >> assets\js\main.js
echo   } >> assets\js\main.js
echo  >> assets\js\main.js
echo   // Setup appointment form if on the appointment page >> assets\js\main.js
echo   if (document.getElementById('appointment-form')) { >> assets\js\main.js
echo     setupAppointmentForm(); >> assets\js\main.js
echo   } >> assets\js\main.js
echo }); >> assets\js\main.js
echo  >> assets\js\main.js
echo // Function to load products >> assets\js\main.js
echo function loadProducts() { >> assets\js\main.js
echo   fetch('api/products.php') >> assets\js\main.js
echo     .then(response => response.json()) >> assets\js\main.js
echo     .then(data => { >> assets\js\main.js
echo       const container = document.getElementById('products-container'); >> assets\js\main.js
echo       let html = ''; >> assets\js\main.js
echo  >> assets\js\main.js
echo       data.forEach(product => { >> assets\js\main.js
echo         html += ` >> assets\js\main.js
echo           <div class="product-card bg-white rounded-lg overflow-hidden shadow-md"> >> assets\js\main.js
echo             <img src="${product.image}" alt="${product.name}" class="w-full h-48 object-cover"> >> assets\js\main.js
echo             <div class="p-4"> >> assets\js\main.js
echo               <h3 class="text-xl font-semibold text-green-700">${product.name}</h3> >> assets\js\main.js
echo               <p class="text-gray-600 mt-2">${product.description}</p> >> assets\js\main.js
echo               <div class="mt-4 flex justify-between items-center"> >> assets\js\main.js
echo                 <span class="text-lg font-bold">Rs. ${product.price}</span> >> assets\js\main.js
echo                 <a href="https://wa.me/94XXXXXXXXX?text=I'm interested in ${product.name}" target="_blank" >> assets\js\main.js
echo                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700"> >> assets\js\main.js
echo                   Order via WhatsApp >> assets\js\main.js
echo                 </a> >> assets\js\main.js
echo               </div> >> assets\js\main.js
echo             </div> >> assets\js\main.js
echo           </div> >> assets\js\main.js
echo         `; >> assets\js\main.js
echo       }); >> assets\js\main.js
echo  >> assets\js\main.js
echo       container.innerHTML = html; >> assets\js\main.js
echo     }) >> assets\js\main.js
echo     .catch(error => { >> assets\js\main.js
echo       console.error('Error loading products:', error); >> assets\js\main.js
echo     }); >> assets\js\main.js
echo } >> assets\js\main.js
echo  >> assets\js\main.js
echo // Function to setup appointment form >> assets\js\main.js
echo function setupAppointmentForm() { >> assets\js\main.js
echo   const form = document.getElementById('appointment-form'); >> assets\js\main.js
echo   form.innerHTML = ` >> assets\js\main.js
echo     <div class="mb-4"> >> assets\js\main.js
echo       <label for="name" class="block text-gray-700 mb-2">Full Name</label> >> assets\js\main.js
echo       <input type="text" id="name" name="name" required >> assets\js\main.js
echo         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"> >> assets\js\main.js
echo     </div> >> assets\js\main.js
echo     <div class="mb-4"> >> assets\js\main.js
echo       <label for="email" class="block text-gray-700 mb-2">Email</label> >> assets\js\main.js
echo       <input type="email" id="email" name="email" required >> assets\js\main.js
echo         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"> >> assets\js\main.js
echo     </div> >> assets\js\main.js
echo     <div class="mb-4"> >> assets\js\main.js
echo       <label for="phone" class="block text-gray-700 mb-2">Phone Number</label> >> assets\js\main.js
echo       <input type="tel" id="phone" name="phone" required >> assets\js\main.js
echo         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"> >> assets\js\main.js
echo     </div> >> assets\js\main.js
echo     <div class="mb-4"> >> assets\js\main.js
echo       <label for="date" class="block text-gray-700 mb-2">Preferred Date</label> >> assets\js\main.js
echo       <input type="date" id="date" name="date" required >> assets\js\main.js
echo         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"> >> assets\js\main.js
echo     </div> >> assets\js\main.js
echo     <div class="mb-4"> >> assets\js\main.js
echo       <label for="time" class="block text-gray-700 mb-2">Preferred Time</label> >> assets\js\main.js
echo       <select id="time" name="time" required >> assets\js\main.js
echo         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"> >> assets\js\main.js
echo         <option value="">Select Time</option> >> assets\js\main.js
echo         <option value="09:00">09:00 AM</option> >> assets\js\main.js
echo         <option value="10:00">10:00 AM</option> >> assets\js\main.js
echo         <option value="11:00">11:00 AM</option> >> assets\js\main.js
echo         <option value="12:00">12:00 PM</option> >> assets\js\main.js
echo         <option value="14:00">02:00 PM</option> >> assets\js\main.js
echo         <option value="15:00">03:00 PM</option> >> assets\js\main.js
echo         <option value="16:00">04:00 PM</option> >> assets\js\main.js
echo         <option value="17:00">05:00 PM</option> >> assets\js\main.js
echo       </select> >> assets\js\main.js
echo     </div> >> assets\js\main.js
echo     <div class="mb-4"> >> assets\js\main.js
echo       <label for="notes" class="block text-gray-700 mb-2">Notes (Optional)</label> >> assets\js\main.js
echo       <textarea id="notes" name="notes" rows="3" >> assets\js\main.js
echo         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"></textarea> >> assets\js\main.js
echo     </div> >> assets\js\main.js
echo     <button type="submit" >> assets\js\main.js
echo       class="bg-green-600 text-white px-6 py-3 rounded font-semibold hover:bg-green-700 transition duration-300"> >> assets\js\main.js
echo       Book Appointment >> assets\js\main.js
echo     </button> >> assets\js\main.js
echo   `; >> assets\js\main.js
echo  >> assets\js\main.js
echo   form.addEventListener('submit', function(e) { >> assets\js\main.js
echo     e.preventDefault(); >> assets\js\main.js
echo  >> assets\js\main.js
echo     const formData = new FormData(form); >> assets\js\main.js
echo     fetch('api/appointments.php', { >> assets\js\main.js
echo       method: 'POST', >> assets\js\main.js
echo       body: formData >> assets\js\main.js
echo     }) >> assets\js\main.js
echo     .then(response => response.json()) >> assets\js\main.js
echo     .then(data => { >> assets\js\main.js
echo       if (data.success) { >> assets\js\main.js
echo         alert('Appointment booked successfully! We will contact you to confirm.'); >> assets\js\main.js
echo         form.reset(); >> assets\js\main.js
echo       } else { >> assets\js\main.js
echo         alert('Error: ' + data.message); >> assets\js\main.js
echo       } >> assets\js\main.js
echo     }) >> assets\js\main.js
echo     .catch(error => { >> assets\js\main.js
echo       console.error('Error booking appointment:', error); >> assets\js\main.js
echo       alert('An error occurred. Please try again.'); >> assets\js\main.js
echo     }); >> assets\js\main.js
echo   }); >> assets\js\main.js
echo } >> assets\js\main.js

REM Create API folder and files
mkdir api
echo ^<?php > api\products.php
echo // Include database connection >> api\products.php
echo require_once '../includes/db_connect.php'; >> api\products.php
echo require_once '../includes/functions.php'; >> api\products.php
echo  >> api\products.php
echo // Set headers for JSON response >> api\products.php
echo header('Content-Type: application/json'); >> api\products.php
echo  >> api\products.php
echo // Get all products >> api\products.php
echo $products = get_all_products($conn); >> api\products.php
echo  >> api\products.php
echo // Return as JSON >> api\products.php
echo echo json_encode($products); >> api\products.php
echo ?^> >> api\products.php

echo ^<?php > api\appointments.php
echo // Include database connection >> api\appointments.php
echo require_once '../includes/db_connect.php'; >> api\appointments.php
echo require_once '../includes/functions.php'; >> api\appointments.php
echo  >> api\appointments.php
echo // Set headers for JSON response >> api\appointments.php
echo header('Content-Type: application/json'); >> api\appointments.php
echo  >> api\appointments.php
echo // Process only POST requests >> api\appointments.php
echo if ($_SERVER['REQUEST_METHOD'] !== 'POST') { >> api\appointments.php
echo     echo json_encode(['success' => false, 'message' => 'Invalid request method']); >> api\appointments.php
echo     exit; >> api\appointments.php
echo } >> api\appointments.php
echo  >> api\appointments.php
echo // Validate and sanitize input >> api\appointments.php
echo $name = sanitize_input($_POST['name'] ?? ''); >> api\appointments.php
echo $email = sanitize_input($_POST['email'] ?? ''); >> api\appointments.php
echo $phone = sanitize_input($_POST['phone'] ?? ''); >> api\appointments.php
echo $date = sanitize_input($_POST['date'] ?? ''); >> api\appointments.php
echo $time = sanitize_input($_POST['time'] ?? ''); >> api\appointments.php
echo $notes = sanitize_input($_POST['notes'] ?? ''); >> api\appointments.php
echo  >> api\appointments.php
echo // Validate required fields >> api\appointments.php
echo if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time)) { >> api\appointments.php
echo     echo json_encode(['success' => false, 'message' => 'All fields are required']); >> api\appointments.php
echo     exit; >> api\appointments.php
echo } >> api\appointments.php
echo  >> api\appointments.php
echo // Insert into database >> api\appointments.php
echo $sql = "INSERT INTO appointments (name, email, phone, appointment_date, appointment_time, notes, status, created_at) >> api\appointments.php
echo         VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())"; >> api\appointments.php
echo  >> api\appointments.php
echo $stmt = $conn->prepare($sql); >> api\appointments.php
echo $stmt->bind_param("ssssss", $name, $email, $phone, $date, $time, $notes); >> api\appointments.php
echo  >> api\appointments.php
echo if ($stmt->execute()) { >> api\appointments.php
echo     echo json_encode(['success' => true, 'message' => 'Appointment booked successfully']); >> api\appointments.php
echo } else { >> api\appointments.php
echo     echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]); >> api\appointments.php
echo } >> api\appointments.php
echo  >> api\appointments.php
echo $stmt->close(); >> api\appointments.php
echo $conn->close(); >> api\appointments.php
echo ?^> >> api\appointments.php

REM Create admin login page
echo ^<?php > admin\index.php
echo session_start(); >> admin\index.php
echo  >> admin\index.php
echo // Check if already logged in >> admin\index.php
echo if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) { >> admin\index.php
echo     header('Location: products/index.php'); >> admin\index.php
echo     exit; >> admin\index.php
echo } >> admin\index.php
echo  >> admin\index.php
echo // Process login form >> admin\index.php
echo $error = ''; >> admin\index.php
echo if ($_SERVER['REQUEST_METHOD'] === 'POST') { >> admin\index.php
echo     // Include database connection >> admin\index.php
echo     require_once '../includes/db_connect.php'; >> admin\index.php
echo     require_once '../includes/functions.php'; >> admin\index.php
echo  >> admin\index.php
echo     $username = sanitize_input($_POST['username'] ?? ''); >> admin\index.php
echo     $password = $_POST['password'] ?? ''; >> admin\index.php
echo  >> admin\index.php
echo     if (empty($username) || empty($password)) { >> admin\index.php
echo         $error = 'Both username and password are required'; >> admin\index.php
echo     } else { >> admin\index.php
echo         // Check credentials >> admin\index.php
echo         $sql = "SELECT * FROM admin_users WHERE username = ?"; >> admin\index.php
echo         $stmt = $conn->prepare($sql); >> admin\index.php
echo         $stmt->bind_param("s", $username); >> admin\index.php
echo         $stmt->execute(); >> admin\index.php
echo         $result = $stmt->get_result(); >> admin\index.php
echo  >> admin\index.php
echo         if ($result->num_rows === 1) { >> admin\index.php
echo             $user = $result->fetch_assoc(); >> admin\index.php
echo             if (password_verify($password, $user['password'])) { >> admin\index.php
echo                 // Login successful >> admin\index.php
echo                 $_SESSION['admin_logged_in'] = true; >> admin\index.php
echo                 $_SESSION['admin_id'] = $user['id']; >> admin\index.php
echo                 $_SESSION['admin_username'] = $user['username']; >> admin\index.php
echo  >> admin\index.php
echo                 header('Location: products/index.php'); >> admin\index.php
echo                 exit; >> admin\index.php
echo             } else { >> admin\index.php
echo                 $error = 'Invalid username or password'; >> admin\index.php
echo             } >> admin\index.php
echo         } else { >> admin\index.php
echo             $error = 'Invalid username or password'; >> admin\index.php
echo         } >> admin\index.php
echo  >> admin\index.php
echo         $stmt->close(); >> admin\index.php
echo     } >> admin\index.php
echo  >> admin\index.php
echo     $conn->close(); >> admin\index.php
echo } >> admin\index.php
echo ?^> >> admin\index.php
echo ^<!DOCTYPE html^> >> admin\index.php
echo ^<html lang="en"^> >> admin\index.php
echo ^<head^> >> admin\index.php
echo     ^<meta charset="UTF-8"^> >> admin\index.php
echo     ^<meta name="viewport" content="width=device-width, initial-scale=1.0"^> >> admin\index.php
echo     ^<title^>Admin Login - Healthgrade Pharmacy^</title^> >> admin\index.php
echo     ^<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"^> >> admin\index.php
echo ^</head^> >> admin\index.php
echo ^<body class="bg-gray-100"^> >> admin\index.php
echo     ^<div class="min-h-screen flex items-center justify-center"^> >> admin\index.php
echo         ^<div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md"^> >> admin\index.php
echo             ^<div class="text-center mb-8"^> >> admin\index.php
echo                 ^<h1 class="text-2xl font-bold text-green-700"^>Healthgrade Pharmacy^</h1^> >> admin\index.php
echo                 ^<p class="text-gray-600"^>Admin Panel Login^</p^> >> admin\index.php
echo             ^</div^> >> admin\index.php
echo  >> admin\index.php
echo             ^<?php if (!empty($error)): ?^> >> admin\index.php
echo                 ^<div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert"^> >> admin\index.php
echo                     ^<p^><?php echo $error; ?^>^</p^> >> admin\index.php
echo                 ^</div^> >> admin\index.php
echo             ^<?php endif; ?^> >> admin\index.php
echo  >> admin\index.php
echo             ^<form method="POST" action=""^> >> admin\index.php
echo                 ^<div class="mb-6"^> >> admin\index.php
echo                     ^<label for="username" class="block text-gray-700 mb-2"^>Username^</label^> >> admin\index.php
echo                     ^<input type="text" id="username" name="username" required >> admin\index.php
echo                         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"^> >> admin\index.php
echo                 ^</div^> >> admin\index.php
echo                 ^<div class="mb-6"^> >> admin\index.php
echo                     ^<label for="password" class="block text-gray-700 mb-2"^>Password^</label^> >> admin\index.php
echo                     ^<input type="password" id="password" name="password" required >> admin\index.php
echo                         class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:border-green-500"^> >> admin\index.php
echo                 ^</div^> >> admin\index.php
echo                 ^<button type="submit" >> admin\index.php
echo                     class="w-full bg-green-600 text-white px-4 py-2 rounded font-semibold hover:bg-green-700 transition duration-300"^> >> admin\index.php
echo                     Login >> admin\index.php
echo                 ^</button^> >> admin\index.php
echo             ^</form^> >> admin\index.php
echo             ^<div class="mt-6 text-center"^> >> admin\index.php
echo                 ^<a href="../index.php" class="text-green-600 hover:underline"^>Back to Website^</a^> >> admin\index.php
echo             ^</div^> >> admin\index.php
echo         ^</div^> >> admin\index.php
echo     ^</div^> >> admin\index.php
echo ^</body^> >> admin\index.php
echo ^</html^> >> admin\index.php

echo Successfully created the basic structure for Healthgrade Pharmacy website!
echo Now you can set up your database using the SQL script.

cd ..