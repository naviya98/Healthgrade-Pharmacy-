</main>

    <!-- Back to top button -->
    <button id="back-to-top" class="fixed bottom-5 right-5 bg-green-600 text-white w-10 h-10 rounded-full shadow-lg flex items-center justify-center opacity-0 transition-opacity duration-300">
        <i class="fas fa-chevron-up"></i>
    </button>

    <!-- WhatsApp floating button -->
    <a href="https://wa.me/94XXXXXXXXX" target="_blank" class="fixed bottom-5 left-5 bg-green-500 text-white w-12 h-12 rounded-full shadow-lg flex items-center justify-center hover:bg-green-600 transition-colors z-20">
        <i class="fab fa-whatsapp text-xl"></i>
    </a>

    <!-- Footer -->
    <footer class="bg-green-800 text-white mt-12">
        <!-- Footer top -->
        <div class="container mx-auto px-6 pt-10 pb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- About column -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">About Us</h4>
                    <p class="text-green-100 mb-4">Healthgrade Pharmacy is your trusted healthcare partner in Sri Lanka, offering quality pharmaceutical products and exceptional service.</p>
                    <div class="flex space-x-4 mt-4">
                        <a href="#" class="text-white hover:text-green-200">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="text-white hover:text-green-200">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="text-white hover:text-green-200">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links with added Cart Link -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="products.php" class="text-green-100 hover:text-white">Products</a></li>
                        <li><a href="cart.php" class="text-green-100 hover:text-white flex items-center">
                            <i class="fas fa-shopping-cart mr-2"></i> Shopping Cart
                            <?php if (function_exists('get_cart_count') && get_cart_count() > 0): ?>
                                <span class="ml-2 bg-green-600 text-white text-xs rounded-full px-2 py-0.5">
                                    <?php echo get_cart_count(); ?>
                                </span>
                            <?php endif; ?>
                        </a></li>
                        <li><a href="appointment.php" class="text-green-100 hover:text-white">Book Appointment</a></li>
                        <li><a href="delivery.php" class="text-green-100 hover:text-white">Delivery Areas</a></li>
                        <li><a href="about.php" class="text-green-100 hover:text-white">About Us</a></li>
                        <li><a href="contact.php" class="text-green-100 hover:text-white">Contact Us</a></li>
                    </ul>
                </div>
                
                <!-- Categories -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Product Categories</h4>
                    <ul class="space-y-2">
                        <?php
                        // Get categories from the database
                        $sql = "SELECT id, name FROM categories LIMIT 5";
                        $result = $conn->query($sql);
                        
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo '<li><a href="products.php?category=' . $row['id'] . '" class="text-green-100 hover:text-white">' . $row['name'] . '</a></li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                
                <!-- Contact Info with added Cart Summary -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">Contact Us</h4>
                    <div class="space-y-3">
                        <p class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-green-300"></i>
                            <span>123 Hospital Road,<br>Colombo, Sri Lanka</span>
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-phone-alt mr-3 text-green-300"></i>
                            <span>+94 11 234 5678</span>
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-envelope mr-3 text-green-300"></i>
                            <span>info@healthgradepharmacy.lk</span>
                        </p>
                        <p class="flex items-center">
                            <i class="fas fa-clock mr-3 text-green-300"></i>
                            <span>Open: 8:30 AM - 8:30 PM</span>
                        </p>
                        
                        <!-- Cart Summary -->
                        <?php if (function_exists('get_cart_contents')): 
                            $cart = get_cart_contents();
                            if (!empty($cart['items'])):
                        ?>
                        <div class="mt-4 pt-4 border-t border-green-700">
                            <h5 class="font-semibold mb-2 flex items-center">
                                <i class="fas fa-shopping-cart mr-2 text-green-300"></i> Your Cart
                            </h5>
                            <p class="text-sm"><?php echo count($cart['items']); ?> items - Rs. <?php echo number_format($cart['total'], 2); ?></p>
                            <a href="cart.php" class="inline-block mt-2 bg-green-600 hover:bg-green-700 text-white text-xs px-3 py-1 rounded-full transition duration-300">
                                View Cart
                            </a>
                        </div>
                        <?php endif; endif; ?>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Footer bottom -->
        <div class="py-4 bg-green-900">
            <div class="container mx-auto px-6 text-center text-sm">
                <p>&copy; <?php echo date('Y'); ?> Healthgrade Pharmacy. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    
    <!-- Mobile menu toggle script -->
    <script>
        // Mobile menu toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
            
            // Change icon based on menu state
            const iconElement = mobileMenuButton.querySelector('i');
            if (mobileMenu.classList.contains('hidden')) {
                iconElement.classList.remove('fa-times');
                iconElement.classList.add('fa-bars');
            } else {
                iconElement.classList.remove('fa-bars');
                iconElement.classList.add('fa-times');
            }
        });
        
        // Back to top button
        const backToTopButton = document.getElementById('back-to-top');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.classList.remove('opacity-0');
                backToTopButton.classList.add('opacity-100');
            } else {
                backToTopButton.classList.remove('opacity-100');
                backToTopButton.classList.add('opacity-0');
            }
        });
        
        backToTopButton.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>
    
    <!-- Load cart.js -->
    <script src="js/cart.js"></script>
    
    <!-- Cart notification element -->
    <div id="cart-notification" class="fixed top-4 right-4 p-4 rounded-md shadow-lg transition-all duration-300 transform translate-x-full z-50"></div>
</body>
</html>