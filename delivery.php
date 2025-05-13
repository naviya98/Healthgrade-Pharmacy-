<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<div class="bg-green-700 text-white py-16">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold mb-2">Delivery Information</h1>
        <p class="text-green-100">Get your medications delivered right to your doorstep</p>
    </div>
</div>

<!-- Delivery Information Section -->
<section class="py-12">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
            <!-- Delivery Information Content -->
            <div class="lg:col-span-3">
                <div class="bg-white rounded-lg shadow-md p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Our Delivery Service</h2>
                    
                    <p class="text-gray-600 mb-6">At Healthgrade Pharmacy, we understand that getting to the pharmacy can sometimes be challenging. That's why we offer a convenient medication delivery service to ensure you never miss a dose of your important medications.</p>
                    
                    <div class="space-y-8">
                        <!-- How It Works -->
                        <div>
                            <h3 class="text-xl font-semibold text-green-700 mb-4">How It Works</h3>
                            <ol class="space-y-4">
                                <li class="flex">
                                    <span class="bg-green-600 text-white flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-4">1</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Place Your Order</h4>
                                        <p class="text-gray-600">Contact us via phone, WhatsApp, or through our website with your prescription or medication needs.</p>
                                    </div>
                                </li>
                                <li class="flex">
                                    <span class="bg-green-600 text-white flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-4">2</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Confirm Your Order</h4>
                                        <p class="text-gray-600">Our pharmacist will verify your prescription (if needed), prepare your medications, and confirm the total cost.</p>
                                    </div>
                                </li>
                                <li class="flex">
                                    <span class="bg-green-600 text-white flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-4">3</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Delivery Scheduling</h4>
                                        <p class="text-gray-600">We'll arrange a delivery time that's convenient for you and provide an estimated arrival time.</p>
                                    </div>
                                </li>
                                <li class="flex">
                                    <span class="bg-green-600 text-white flex-shrink-0 w-8 h-8 rounded-full flex items-center justify-center mr-4">4</span>
                                    <div>
                                        <h4 class="font-semibold text-gray-800">Receive Your Medications</h4>
                                        <p class="text-gray-600">Our delivery person will bring your medications directly to your doorstep. Payment can be made via cash on delivery or online payment.</p>
                                    </div>
                                </li>
                            </ol>
                        </div>
                        
                        <!-- Delivery Policy -->
                        <div>
                            <h3 class="text-xl font-semibold text-green-700 mb-4">Delivery Policy</h3>
                            <ul class="list-disc pl-6 text-gray-600 space-y-2">
                                <li>We deliver 7 days a week from 9:00 AM to 7:00 PM.</li>
                                <li>Orders placed before 2:00 PM can typically be delivered the same day (depending on your location).</li>
                                <li>Orders placed after 2:00 PM will be delivered the next day.</li>
                                <li>Delivery fee varies based on your location (see delivery fee chart).</li>
                                <li>Free delivery for orders above Rs. 3,000 within Colombo 1-15.</li>
                                <li>For emergency deliveries, additional charges may apply.</li>
                            </ul>
                        </div>
                        
                        <!-- Prescription Requirements -->
                        <div class="bg-yellow-50 p-6 rounded-lg border-l-4 border-yellow-500">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Prescription Requirements</h3>
                            <p class="text-gray-600 mb-4">For prescription medications, we require a valid prescription from a licensed physician. You can:</p>
                            <ul class="list-disc pl-6 text-gray-600 space-y-1">
                                <li>Send a clear photo of your prescription via WhatsApp</li>
                                <li>Email your prescription to info@healthgradepharmacy.lk</li>
                                <li>Have your doctor send the prescription directly to us</li>
                            </ul>
                            <p class="text-gray-600 mt-4">All prescriptions must be readable and show the doctor's registration number.</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Delivery Areas and Fees -->
            <div class="lg:col-span-2">
                <div class="bg-green-50 rounded-lg p-8 h-full">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Delivery Areas & Fees</h2>
                    
                    <div id="delivery-areas" class="mb-8">
                        <!-- Delivery areas will be loaded here -->
                        <div class="text-center py-4">
                            <i class="fas fa-spinner fa-spin text-green-600 text-3xl"></i>
                            <p class="mt-2 text-gray-600">Loading delivery information...</p>
                        </div>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-green-100 mb-8">
                        <h3 class="text-xl font-semibold text-green-700 mb-3">Estimated Delivery Times</h3>
                        <ul class="text-gray-600 space-y-3">
                            <li class="flex items-start">
                                <i class="fas fa-clock text-green-600 mt-1 mr-3"></i>
                                <div>
                                    <span class="font-semibold">Colombo 1-15:</span>
                                    <span> 1-3 hours</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-clock text-green-600 mt-1 mr-3"></i>
                                <div>
                                    <span class="font-semibold">Suburban areas:</span>
                                    <span> 2-4 hours</span>
                                </div>
                            </li>
                            <li class="flex items-start">
                                <i class="fas fa-clock text-green-600 mt-1 mr-3"></i>
                                <div>
                                    <span class="font-semibold">Other areas:</span>
                                    <span> Next day delivery</span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-green-100">
                        <h3 class="text-xl font-semibold text-green-700 mb-3">Contact Us</h3>
                        <p class="text-gray-600 mb-4">For any delivery inquiries or to place an order, contact us:</p>
                        <ul class="text-gray-600 space-y-3">
                            <li class="flex items-center">
                                <i class="fas fa-phone-alt text-green-600 mr-3"></i>
                                <a href="tel:+94112345678" class="hover:text-green-700">+94 11 234 5678</a>
                            </li>
                            <li class="flex items-center">
                                <i class="fab fa-whatsapp text-green-600 mr-3"></i>
                                <a href="https://wa.me/94XXXXXXXXX" target="_blank" class="hover:text-green-700">+94 XX XXX XXXX</a>
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-envelope text-green-600 mr-3"></i>
                                <a href="mailto:info@healthgradepharmacy.lk" class="hover:text-green-700">info@healthgradepharmacy.lk</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Delivery Benefits Section -->
<section class="bg-white py-12">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Benefits of Our Delivery Service</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Benefit 1 -->
            <div class="bg-green-50 p-6 rounded-lg text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-clock text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Saves Time</h3>
                <p class="text-gray-600">No need to travel to the pharmacy. We bring your medications to you.</p>
            </div>
            
            <!-- Benefit 2 -->
            <div class="bg-green-50 p-6 rounded-lg text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Contactless Option</h3>
                <p class="text-gray-600">Minimize exposure to illness with our contactless delivery option.</p>
            </div>
            
            <!-- Benefit 3 -->
            <div class="bg-green-50 p-6 rounded-lg text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-pills text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Never Miss a Dose</h3>
                <p class="text-gray-600">Regular delivery ensures you always have your medications on hand.</p>
            </div>
            
            <!-- Benefit 4 -->
            <div class="bg-green-50 p-6 rounded-lg text-center">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-md text-2xl text-green-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Professional Service</h3>
                <p class="text-gray-600">Our trained staff ensures your medications are handled properly.</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Frequently Asked Questions</h2>
        
        <div class="max-w-3xl mx-auto space-y-6">
            <!-- FAQ Item 1 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">How do I place a delivery order?</h3>
                <p class="text-gray-600">You can place an order by calling our pharmacy at +94 11 234 5678, messaging us on WhatsApp, or selecting items from our website and choosing the delivery option.</p>
            </div>
            
            <!-- FAQ Item 2 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">What payment methods are accepted?</h3>
                <p class="text-gray-600">We accept cash on delivery, credit/debit cards, and bank transfers. Our delivery personnel can process card payments at your doorstep if required.</p>
            </div>
            
            <!-- FAQ Item 3 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">What if I'm not available during delivery?</h3>
                <p class="text-gray-600">When placing your order, you can provide alternative delivery instructions or reschedule for a more convenient time. We'll contact you before delivery to ensure you're available.</p>
            </div>
            
            <!-- FAQ Item 4 -->
            <div class="bg-white rounded-lg p-6 shadow-sm">
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Do you deliver outside the listed areas?</h3>
                <p class="text-gray-600">Yes, we can arrange delivery to areas outside our standard delivery zones for an additional fee. Please contact us directly to discuss your specific location and delivery needs.</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="bg-green-100 py-12">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Ready to Order?</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8">Contact us now to place your order for fast and reliable medication delivery to your doorstep.</p>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Load delivery areas
    const deliveryAreasContainer = document.getElementById('delivery-areas');
    
    fetch('api/delivery-areas.php')
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                deliveryAreasContainer.innerHTML = '<p class="text-center text-gray-600">No delivery areas currently available.</p>';
                return;
            }
            
            let html = '<div class="overflow-x-auto"><table class="min-w-full bg-white border border-gray-200">';
            html += `
                <thead>
                    <tr>
                        <th class="px-4 py-2 border-b border-gray-200 bg-green-50 text-left text-xs leading-4 font-semibold text-green-700 uppercase tracking-wider">
                            Area
                        </th>
                        <th class="px-4 py-2 border-b border-gray-200 bg-green-50 text-right text-xs leading-4 font-semibold text-green-700 uppercase tracking-wider">
                            Delivery Fee
                        </th>
                    </tr>
                </thead>
                <tbody>
            `;
            
            data.forEach((area, index) => {
                html += `
                    <tr class="${index % 2 === 0 ? 'bg-white' : 'bg-gray-50'}">
                        <td class="px-4 py-2 whitespace-nowrap border-b border-gray-200">
                            <div class="text-sm leading-5 font-medium text-gray-900">${area.area_name}</div>
                        </td>
                        <td class="px-4 py-2 whitespace-nowrap border-b border-gray-200 text-right">
                            <div class="text-sm leading-5 text-gray-900">Rs. ${parseFloat(area.delivery_fee).toFixed(2)}</div>
                        </td>
                    </tr>
                `;
            });
            
            html += '</tbody></table></div>';
            
            deliveryAreasContainer.innerHTML = html;
        })
        .catch(error => {
            console.error('Error loading delivery areas:', error);
            deliveryAreasContainer.innerHTML = '<p class="text-center text-red-600">Error loading delivery information. Please try again later.</p>';
        });
});
</script>

<?php include 'includes/footer.php'; ?>