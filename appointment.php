<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<div class="bg-green-700 text-white py-16">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold mb-2">Book an Appointment</h1>
        <p class="text-green-100">Schedule a consultation with our professional pharmacists</p>
    </div>
</div>

<!-- Appointment Section -->
<section class="py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Appointment Form -->
            <div>
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Schedule Your Visit</h2>
                    
                    <?php
                    // Process form submission
                    $success_message = '';
                    $error_message = '';
                    
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        // Validate and sanitize input
                        $name = sanitize_input($_POST['name'] ?? '');
                        $email = sanitize_input($_POST['email'] ?? '');
                        $phone = sanitize_input($_POST['phone'] ?? '');
                        $date = sanitize_input($_POST['date'] ?? '');
                        $time = sanitize_input($_POST['time'] ?? '');
                        $notes = sanitize_input($_POST['notes'] ?? '');
                        
                        // Validate required fields
                        if (empty($name) || empty($email) || empty($phone) || empty($date) || empty($time)) {
                            $error_message = 'All fields marked with * are required.';
                        } 
                        // Validate email format
                        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                            $error_message = 'Please enter a valid email address.';
                        }
                        // Validate phone number (basic validation)
                        elseif (!preg_match('/^[0-9+\-\s()]{7,15}$/', $phone)) {
                            $error_message = 'Please enter a valid phone number.';
                        }
                        // Check if appointment slot is available
                        elseif (!is_appointment_slot_available($conn, $date, $time)) {
                            $error_message = 'Sorry, this appointment slot is no longer available. Please select another time.';
                        }
                        else {
                            // Insert into database
                            $stmt = $conn->prepare("INSERT INTO appointments (name, email, phone, appointment_date, appointment_time, notes, status, created_at) 
                                                    VALUES (?, ?, ?, ?, ?, ?, 'pending', NOW())");
                            $stmt->bind_param("ssssss", $name, $email, $phone, $date, $time, $notes);
                            
                            if ($stmt->execute()) {
                                $success_message = 'Your appointment has been scheduled successfully! We will contact you to confirm.';
                                
                                // Log the activity
                                log_activity($conn, "New appointment booked for $date at $time");
                                
                                // Clear form data
                                $name = $email = $phone = $date = $time = $notes = '';
                            } else {
                                $error_message = 'Sorry, there was an error booking your appointment. Please try again.';
                            }
                            
                            $stmt->close();
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
                    
                    <form id="appointment-form" method="POST" action="">
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
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" id="phone" name="phone" required
                                value="<?php echo isset($phone) ? $phone : ''; ?>"
                                class="form-input">
                        </div>
                        <div class="mb-4">
                            <label for="date" class="form-label">Preferred Date *</label>
                            <input type="date" id="date" name="date" required
                                value="<?php echo isset($date) ? $date : ''; ?>"
                                min="<?php echo date('Y-m-d'); ?>"
                                class="form-input">
                        </div>
                        <div class="mb-4">
                            <label for="time" class="form-label">Preferred Time *</label>
                            <select id="time" name="time" required
                                class="form-input">
                                <option value="">Select Time</option>
                                <?php
                                $times = ['09:00' => '09:00 AM', '10:00' => '10:00 AM', '11:00' => '11:00 AM', 
                                          '12:00' => '12:00 PM', '14:00' => '02:00 PM', '15:00' => '03:00 PM', 
                                          '16:00' => '04:00 PM', '17:00' => '05:00 PM'];
                                
                                foreach ($times as $value => $display) {
                                    $selected = (isset($time) && $time == $value) ? 'selected' : '';
                                    $disabled = '';
                                    
                                    // Check availability if date is selected
                                    if (isset($date) && !empty($date)) {
                                        if (!is_appointment_slot_available($conn, $date, $value)) {
                                            $disabled = 'disabled';
                                            $display .= ' (Not Available)';
                                        }
                                    }
                                    
                                    echo "<option value=\"$value\" $selected $disabled>$display</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-6">
                            <label for="notes" class="form-label">Notes (Optional)</label>
                            <textarea id="notes" name="notes" rows="3"
                                class="form-input"><?php echo isset($notes) ? $notes : ''; ?></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-green-600 text-white px-6 py-3 rounded font-semibold hover:bg-green-700 transition duration-300">
                            Book Appointment
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Appointment Information -->
            <div>
                <div class="bg-green-50 rounded-lg p-8 h-full">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Consultation Services</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-semibold text-green-700 mb-2">Why Book a Consultation?</h3>
                            <p class="text-gray-600 mb-2">Our experienced pharmacists can provide personalized advice for:</p>
                            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                                <li>Medication review and counselling</li>
                                <li>Chronic disease management</li>
                                <li>Health monitoring and assessment</li>
                                <li>Wellness and nutrition advice</li>
                                <li>Prescription clarification</li>
                            </ul>
                        </div>
                        
                        <div>
                            <h3 class="text-xl font-semibold text-green-700 mb-2">What to Expect</h3>
                            <p class="text-gray-600 mb-2">During your appointment:</p>
                            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                                <li>Private consultation in a comfortable setting</li>
                                <li>Comprehensive review of your medications</li>
                                <li>Personalized advice from our professional pharmacists</li>
                                <li>Opportunity to ask any health-related questions</li>
                                <li>Follow-up plan if necessary</li>
                            </ul>
                        </div>
                        
                        <div class="bg-white p-6 rounded-lg shadow-sm border border-green-100">
                            <h3 class="text-xl font-semibold text-green-700 mb-3">Important Information</h3>
                            <ul class="text-gray-600 space-y-3">
                                <li class="flex items-start">
                                    <i class="fas fa-clock text-green-600 mt-1 mr-3"></i>
                                    <span>Appointments typically last 20-30 minutes</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-file-medical text-green-600 mt-1 mr-3"></i>
                                    <span>Please bring a list of all your current medications</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-phone-alt text-green-600 mt-1 mr-3"></i>
                                    <span>We'll call to confirm your appointment within 24 hours</span>
                                </li>
                                <li class="flex items-start">
                                    <i class="fas fa-ban text-green-600 mt-1 mr-3"></i>
                                    <span>If you need to cancel, please give at least 4 hours notice</span>
                                </li>
                            </ul>
                        </div>
                        
                        <div class="text-center mt-6">
                            <p class="text-green-700 font-semibold">Need immediate assistance?</p>
                            <p class="text-gray-600 mb-4">Call us directly or reach out via WhatsApp</p>
                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <a href="tel:+94112345678" class="bg-white border border-green-600 text-green-700 px-4 py-2 rounded-full flex items-center justify-center hover:bg-green-50 transition duration-300">
                                    <i class="fas fa-phone-alt mr-2"></i> +94 11 234 5678
                                </a>
                                <a href="https://wa.me/94XXXXXXXXX" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded-full flex items-center justify-center hover:bg-green-600 transition duration-300">
                                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
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
<section class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Frequently Asked Questions</h2>
        
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- FAQ Item 1 -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Is there a fee for consultations?</h3>
                <p class="text-gray-600">Most of our basic consultations are complimentary. However, specialized services like comprehensive medication reviews may have a nominal fee. Our staff will inform you of any charges when you schedule your appointment.</p>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">How long do appointments usually last?</h3>
                <p class="text-gray-600">Most consultations last between 20-30 minutes, depending on the complexity of your healthcare needs. For more comprehensive reviews, please let us know in advance so we can allocate sufficient time.</p>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">What should I bring to my appointment?</h3>
                <p class="text-gray-600">Please bring a list of all medications you're currently taking (including over-the-counter medicines and supplements), any recent lab results, and any questions you'd like to discuss with our pharmacist.</p>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Can I reschedule my appointment?</h3>
                <p class="text-gray-600">Yes, you can reschedule by calling us at least 4 hours before your appointment time. You can also send us a message through WhatsApp to reschedule, and our team will confirm the new time with you.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="bg-green-100 py-12">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Take Control of Your Health Today</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8">Our pharmacists are here to help you understand your medications and improve your health outcomes.</p>
        <a href="#appointment-form" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-lg transition duration-300">
            Book Your Appointment Now
        </a>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('date');
    const timeSelect = document.getElementById('time');
    
    // Update available times when date changes
    dateInput.addEventListener('change', function() {
        const selectedDate = this.value;
        
        if (selectedDate) {
            // Reset time selection
            timeSelect.innerHTML = '<option value="">Select Time</option>';
            
            // Show loading indicator
            timeSelect.innerHTML += '<option value="" disabled>Loading available times...</option>';
            timeSelect.disabled = true;
            
            // Fetch available times for the selected date
            fetch('api/available-times.php?date=' + selectedDate)
                .then(response => response.json())
                .then(data => {
                    // Reset time selection
                    timeSelect.innerHTML = '<option value="">Select Time</option>';
                    
                    const times = {
                        '09:00': '09:00 AM',
                        '10:00': '10:00 AM',
                        '11:00': '11:00 AM',
                        '12:00': '12:00 PM',
                        '14:00': '02:00 PM',
                        '15:00': '03:00 PM',
                        '16:00': '04:00 PM',
                        '17:00': '05:00 PM'
                    };
                    
                    // Add available times
                    for (const [value, display] of Object.entries(times)) {
                        const option = document.createElement('option');
                        option.value = value;
                        
                        if (data.available_times.includes(value)) {
                            option.textContent = display;
                        } else {
                            option.textContent = display + ' (Not Available)';
                            option.disabled = true;
                        }
                        
                        timeSelect.appendChild(option);
                    }
                    
                    timeSelect.disabled = false;
                })
                .catch(error => {
                    console.error('Error fetching available times:', error);
                    timeSelect.innerHTML = '<option value="">Error loading times. Please try again.</option>';
                    timeSelect.disabled = false;
                });
        }
    });
});
</script>

<?php include 'includes/footer.php'; ?>