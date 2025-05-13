<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<div class="bg-green-700 text-white py-16">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold mb-2">Contact Us</h1>
        <p class="text-green-100">Get in touch with our team for any inquiries or assistance</p>
    </div>
</div>

<!-- Contact Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Send Us a Message</h2>
                    
                    <?php
                    // Process form submission
                    $success_message = '';
                    $error_message = '';
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Validate and sanitize input
                        $name = sanitize_input($_POST['name'] ?? '');
                        $email = sanitize_input($_POST['email'] ?? '');
                        $phone = sanitize_input($_POST['phone'] ?? '');
                        $subject = sanitize_input($_POST['subject'] ?? '');
                        $message = sanitize_input($_POST['message'] ?? '');
                        
                        // Validate required fields
                        if (empty($name) || empty($email) || empty($message)) {
                            $error_message = 'All fields marked with * are required.';
                        } 
                        // Validate email format
                        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $error_message = 'Please enter a valid email address.';
                        }
                        else {
                            // In a real application, you would send an email or store in database
                            // For this example, we'll just show a success message
                            $success_message = 'Thank you for your message! We will get back to you shortly.';
                            
                            // Log the activity
                            log_activity($conn, "Contact form submitted by $name");
                            
                            // Clear form data
                            $name = $email = $phone = $subject = $message = '';
                        }
                    }
                    ?>
                    
                    <?php if (!empty($success_message)): ?>
                        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">
                            <p class="font-bold">Success!</p>
                            <p><?php echo $success_message; ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($error_message)): ?>
                        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6">
                            <p class="font-bold">Error</p>
                            <p><?php echo $error_message; ?></p>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" action="">
                        <div class="mb-4">
                            <label for="name" class="form-label">Full Name *</label>
                            <input type="text" id="name" name="name" required
                                value="<?php echo isset($name) ? $name : ''; ?>"
                                class="form-input">
                        </div>
                        <div class="mb-4">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" id="email" name="email" required
                                value="<?php echo isset($email) ? $email : ''; ?>"
                                class="form-input">
                        </div>
                        <div class="mb-4">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" id="phone" name="phone"
                                value="<?php echo isset($phone) ? $phone : ''; ?>"
                                class="form-input">
                        </div>
                        <div class="mb-4">
                            <label for="subject" class="form-label">Subject</label>
                            <input type="text" id="subject" name="subject"
                                value="<?php echo isset($subject) ? $subject : ''; ?>"
                                class="form-input">
                        </div>
                        <div class="mb-6">
                            <label for="message" class="form-label">Message *</label>
                            <textarea id="message" name="message" rows="5" required
                                class="form-input"><?php echo isset($message) ? $message : ''; ?></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-green-600 text-white px-6 py-3 rounded font-semibold hover:bg-green-700 transition duration-300">
                            Send Message
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div>
                <div class="bg-gray-50 rounded-lg p-8 h-full">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Contact Information</h2>
                    
                    <div class="space-y-8">
                        <!-- Contact Details -->
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-map-marker-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Address</h4>
                                    <p class="text-gray-600">123 Hospital Road, Colombo 10<br>Sri Lanka</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-phone-alt text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Phone</h4>
                                    <p class="text-gray-600">+94 11 234 5678</p>
                                    <p class="text-gray-600">+94 77 123 4567 (Mobile)</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-envelope text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Email</h4>
                                    <p class="text-gray-600">info@healthgradepharmacy.lk</p>
                                    <p class="text-gray-600">orders@healthgradepharmacy.lk</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-green-100 p-3 rounded-full mr-4">
                                    <i class="fas fa-clock text-green-600"></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-800 mb-1">Working Hours</h4>
                                    <p class="text-gray-600">Monday - Friday: 8:30 AM - 10:00 PM</p>
                                    <p class="text-gray-600">Saturday - Sunday: 9:00 AM - 10:00 PM</p>

                                </div>
                            </div>
                        </div>
                        
                        <!-- Map -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-4">Our Location</h4>
                            <div class="h-64 bg-gray-200 rounded-lg overflow-hidden">
                                <!-- In a real application, you would embed an actual Google Map here -->
                                <div class="w-full h-full flex items-center justify-center bg-gray-300 relative">
                                    <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/assets/images/map-placeholder.jpg');">
                                    </div>
                                    <div class="absolute inset-0 bg-black bg-opacity-10 flex items-center justify-center">
                                        <a href="https://maps.app.goo.gl/8B299NoaWno5T4ga7" target="_blank" class="bg-white hover:bg-green-50 text-green-700 px-4 py-2 rounded-lg shadow-md transition duration-300 z-10">
                                            <i class="fas fa-map-marked-alt mr-2"></i> Open in Google Maps
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Social Media -->
                        <div>
                            <h4 class="font-semibold text-gray-800 mb-4">Connect With Us</h4>
                            <div class="flex space-x-4">
                                <a href="#" class="bg-blue-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-700 transition duration-300">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#" class="bg-red-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-red-700 transition duration-300">
                                    <i class="fab fa-youtube"></i>
                                </a>
                                <a href="#" class="bg-pink-600 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-pink-700 transition duration-300">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#" class="bg-blue-400 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-blue-500 transition duration-300">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="#" class="bg-green-500 text-white w-10 h-10 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-300">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Frequently Asked Questions</h2>
        
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">How quickly do you respond to inquiries?</h3>
                <p class="text-gray-600">We strive to respond to all inquiries within 24 hours. For urgent matters, we recommend calling our pharmacy directly for immediate assistance.</p>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Can I request a specific medication not listed on your website?</h3>
                <p class="text-gray-600">Yes, you can request specific medications through our contact form or by calling us directly. If the medication is available in Sri Lanka, we will do our best to source it for you.</p>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Do you offer pharmaceutical consultations?</h3>
                <p class="text-gray-600">Yes, we offer professional pharmaceutical consultations. You can book an appointment through our website, by phone, or by visiting our pharmacy in person.</p>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">How can I provide feedback about your services?</h3>
                <p class="text-gray-600">We welcome your feedback! You can share your thoughts through our contact form, email us directly, or speak with our staff when you visit. Your input helps us improve our services.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="bg-green-100 py-12">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Get in Touch Today</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8">We're here to help with all your healthcare needs. Contact us for personalized service and professional advice.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="tel:+94112345678" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300">
                <i class="fas fa-phone-alt mr-2"></i> Call Now
            </a>
            <a href="https://wa.me/94XXXXXXXXX" target="_blank" class="bg-white hover:bg-gray-100 text-green-700 font-bold py-3 px-6 rounded-lg transition duration-300 border border-green-600">
                <i class="fab fa-whatsapp mr-2"></i> WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-3xl mx-auto bg-green-50 rounded-lg p-8 shadow-sm">
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-2">Subscribe to Our Newsletter</h2>
                <p class="text-gray-600">Stay updated with our latest products, health tips, and special offers.</p>
            </div>
            
            <form action="" method="POST" class="flex flex-col sm:flex-row gap-4">
                <input type="email" name="newsletter_email" placeholder="Your Email Address" required
                    class="flex-grow px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                <button type="submit" class="bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition duration-300">
                    Subscribe
                </button>
            </form>
            <p class="text-sm text-gray-500 mt-4 text-center">By subscribing, you agree to receive our newsletter emails. You can unsubscribe at any time.</p>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>