<?php include 'includes/header.php'; ?>

<!-- Hero Section with 3D Pill Animation -->
<section class="hero relative h-screen flex items-center overflow-hidden">
    <!-- 3D Pills Canvas Background -->
    <div id="hero-canvas" class="absolute inset-0 z-0"></div>
    
    <!-- Gradient Overlay -->
    <div class="absolute inset-0 bg-gradient-to-r from-green-900/80 to-green-600/80 z-10"></div>
    
    <div class="container mx-auto px-6 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="hero-content text-white" data-aos="fade-right">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight hero-title">Your Health, <br><span class="text-green-300">Our Priority</span></h1>
                <p class="text-xl mb-8 max-w-xl hero-subtitle">Experience personalized healthcare solutions with Healthgrade Pharmacy - where science meets compassion.</p>
                <div class="flex flex-wrap gap-4">
                    <a href="products.php" class="btn-primary group">
                        <span>Browse Products</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </a>
                    <a href="appointment.php" class="btn-secondary group">
                        <span>Book Appointment</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </a>
                </div>
            </div>
            
            <div class="hidden lg:block" data-aos="fade-left">
                <div class="relative">
                    <div class="floating-capsule absolute -top-20 -left-10 w-32 h-16 bg-blue-100 rounded-full transform rotate-12 opacity-80"></div>
                    <div class="floating-pill absolute top-40 -right-10 w-24 h-10 bg-green-200 rounded-full transform -rotate-12 opacity-80"></div>
                    <div class="floating-tablet absolute bottom-10 left-10 w-16 h-16 bg-yellow-100 rounded-lg transform rotate-45 opacity-80"></div>
                    
                    <img src="assets/images/banners/pharmacist-hero.png" alt="Pharmacist" class="relative z-10 hero-image rounded-xl shadow-2xl transform hover:scale-105 transition-transform duration-700">
                    
                    <div class="absolute -bottom-4 -right-4 bg-white/90 backdrop-blur-sm p-4 rounded-lg shadow-xl z-20 max-w-xs pulse-element">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Floating Service Tabs Section -->
<section class="py-16 relative z-30">
    <div class="container mx-auto px-6">
        <div class="bg-white rounded-2xl shadow-xl p-2 -mt-20 relative z-20">
            <div class="service-tabs grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3" data-aos="fade-up">
                <!-- Tab 1 -->
                <div class="service-tab group relative overflow-hidden bg-green-50 hover:bg-green-600 rounded-xl p-6 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute top-0 right-0 h-32 w-32 bg-green-100 group-hover:bg-green-500 rounded-full -mr-16 -mt-16 transition-all duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="service-icon bg-white text-green-600 group-hover:text-white group-hover:bg-green-800 rounded-full p-3 inline-block mb-4 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-800 group-hover:text-white mb-2 transition-colors duration-300">Prescription Filling</h3>
                        <p class="text-green-700 group-hover:text-white/90 transition-colors duration-300">Fast and accurate prescription services with expert guidance</p>
                    </div>
                    
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
                
                <!-- Tab 2 -->
                <div class="service-tab group relative overflow-hidden bg-green-50 hover:bg-green-600 rounded-xl p-6 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute top-0 right-0 h-32 w-32 bg-green-100 group-hover:bg-green-500 rounded-full -mr-16 -mt-16 transition-all duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="service-icon bg-white text-green-600 group-hover:text-white group-hover:bg-green-800 rounded-full p-3 inline-block mb-4 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-800 group-hover:text-white mb-2 transition-colors duration-300">Home Delivery</h3>
                        <p class="text-green-700 group-hover:text-white/90 transition-colors duration-300">Convenient delivery of medications right to your doorstep</p>
                    </div>
                    
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
                
                <!-- Tab 3 -->
                <div class="service-tab group relative overflow-hidden bg-green-50 hover:bg-green-600 rounded-xl p-6 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute top-0 right-0 h-32 w-32 bg-green-100 group-hover:bg-green-500 rounded-full -mr-16 -mt-16 transition-all duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="service-icon bg-white text-green-600 group-hover:text-white group-hover:bg-green-800 rounded-full p-3 inline-block mb-4 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-800 group-hover:text-white mb-2 transition-colors duration-300">Expert Consultation</h3>
                        <p class="text-green-700 group-hover:text-white/90 transition-colors duration-300">Professional advice from our licensed pharmacists</p>
                    </div>
                    
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
                
                <!-- Tab 4 -->
                <div class="service-tab group relative overflow-hidden bg-green-50 hover:bg-green-600 rounded-xl p-6 transition-all duration-300 hover:shadow-lg">
                    <div class="absolute top-0 right-0 h-32 w-32 bg-green-100 group-hover:bg-green-500 rounded-full -mr-16 -mt-16 transition-all duration-300"></div>
                    
                    <div class="relative z-10">
                        <div class="service-icon bg-white text-green-600 group-hover:text-white group-hover:bg-green-800 rounded-full p-3 inline-block mb-4 transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-green-800 group-hover:text-white mb-2 transition-colors duration-300">Health Monitoring</h3>
                        <p class="text-green-700 group-hover:text-white/90 transition-colors duration-300">Regular monitoring services for chronic health conditions</p>
                    </div>
                    
                    <div class="absolute bottom-4 right-4 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- About Section with Parallax -->
<section class="py-20 overflow-hidden relative" id="about-section">
    <!-- Parallax Background Elements -->
    <div class="parallax-bg absolute inset-0 opacity-5">
        <div class="parallax-element absolute left-10 top-10 bg-green-500 rounded-full h-64 w-64" data-parallax-speed="0.2"></div>
        <div class="parallax-element absolute right-20 bottom-20 bg-blue-500 rounded-full h-96 w-96" data-parallax-speed="0.4"></div>
        <div class="parallax-element absolute left-1/3 bottom-1/4 bg-yellow-500 rounded-full h-48 w-48" data-parallax-speed="0.3"></div>
    </div>

    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-green-600 font-semibold text-sm uppercase tracking-widest">About Us</span>
            <h2 class="text-4xl font-bold text-gray-800 mt-2 mb-4">Experience The Best <br class="hidden md:block"> Pharmaceutical Care</h2>
            <div class="w-20 h-1 bg-green-600 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Card 1 -->
    <div class="about-card" data-aos="fade-up" data-aos-delay="100">
        <div class="about-card-inner bg-white rounded-lg shadow overflow-hidden transform transition-transform duration-300 hover:scale-102 h-full">
            <div class="h-32 bg-green-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                </svg>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Quality Assurance</h3>
                <p class="text-gray-600 text-sm">We ensure all medications and health products meet the highest quality standards and are sourced from reputable suppliers.</p>
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div class="about-card" data-aos="fade-up" data-aos-delay="200">
        <div class="about-card-inner bg-white rounded-lg shadow overflow-hidden transform transition-transform duration-300 hover:scale-102 h-full">
            <div class="h-32 bg-green-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Expert Team</h3>
                <p class="text-gray-600 text-sm">Our pharmacy is staffed with licensed professionals who are committed to providing personalized care and expert guidance.</p>
            </div>
        </div>
    </div>

    <!-- Card 3 -->
    <div class="about-card" data-aos="fade-up" data-aos-delay="300">
        <div class="about-card-inner bg-white rounded-lg shadow overflow-hidden transform transition-transform duration-300 hover:scale-102 h-full">
            <div class="h-32 bg-green-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-bold text-gray-800 mb-2">Modern Technology</h3>
                <p class="text-gray-600 text-sm">We integrate the latest pharmacy technology and systems to ensure accurate prescriptions and efficient service.</p>
            </div>
        </div>
    </div>
</div>

        <!-- Years of Service Badge -->
        <div class="mt-16 text-center" data-aos="zoom-in">
            <div class="inline-block relative">
                <div class="years-badge bg-green-600 text-white rounded-full h-48 w-48 flex flex-col items-center justify-center transform hover:scale-110 transition-transform duration-500">
                    <span class="text-6xl font-bold">12+</span>
                    <span class="text-lg">Years of</span>
                    <span class="text-xl font-semibold">Excellence</span>
                </div>
                <div class="absolute top-0 left-0 h-full w-full rounded-full border-4 border-dashed border-green-300 animate-spin-slow"></div>
            </div>
        </div>
    </div>
</section>

<!-- Featured Products Section with 3D Carousel -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <!-- Improved Decorative Elements -->
    <div class="absolute top-0 right-0 -mr-32 -mt-32 w-96 h-96 bg-green-100 rounded-full opacity-60 blur-2xl"></div>
    <div class="absolute top-40 left-10 w-20 h-20 bg-blue-100 rounded-full opacity-70 blur-sm"></div>
    <div class="absolute bottom-0 left-0 -ml-32 -mb-32 w-96 h-96 bg-blue-100 rounded-full opacity-60 blur-2xl"></div>
    <div class="absolute right-20 bottom-40 w-16 h-16 bg-yellow-100 rounded-full opacity-70 blur-sm"></div>
    
    <div class="container mx-auto px-4 sm:px-6 relative z-10">
        <!-- Enhanced Header Section -->
        <div class="text-center mb-12" data-aos="fade-up">
            <div class="inline-block px-3 py-1 bg-green-100 rounded-full mb-3">
                <span class="text-green-700 font-semibold text-sm tracking-wider">Our Products</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">Featured Healthcare Products</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-green-600 to-green-400 mx-auto rounded-full"></div>
            <p class="text-gray-600 max-w-2xl mx-auto mt-4 px-4">Explore our selection of premium healthcare products designed to support your wellbeing.</p>
        </div>

        <!-- Replace carousel with a 2-column grid layout -->
        <div class="mx-auto max-w-6xl" data-aos="fade-up">
            <!-- Product Grid (2 columns) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 px-2">
                <?php
                // Get exactly 6 featured products from the database
                $sql = "SELECT * FROM products WHERE is_featured = 1 AND is_active = 1 LIMIT 6";
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    while($product = $result->fetch_assoc()) {
                        ?>
                        <div class="p-2">
                            <div class="product-card group bg-green-100 rounded-lg overflow-hidden shadow-sm transform transition-all duration-300 hover:shadow hover:-translate-y-1">
                                <div class="relative overflow-hidden bg-gradient-to-b from-gray-50 to-white h-36">
                                    <!-- Improved image display -->
                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" 
                                         class="w-full h-36 object-contain transform transition-transform duration-500 group-hover:scale-105 filter drop-shadow-sm">
                                    <div class="absolute inset-0 bg-gradient-to-t from-green-800/30 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300 pointer-events-none"></div>
                                    <span class="absolute top-1 right-1 bg-yellow-500 text-white text-xs font-bold px-2 py-0.5 rounded-full shadow-sm">New</span>
                                </div>
                                <div class="p-2 relative">
                                    <div class="product-tag absolute -top-2 left-2 bg-green-600 text-white text-xs px-2 py-0.5 rounded-full shadow-sm">
                                    <?php echo isset($product['category']) ? $product['category'] : 'General'; ?>
                                    </div>
                                    <h3 class="text-base font-bold text-green-800 mb-0.5 mt-1 line-clamp-1"><?php echo $product['name']; ?></h3>
                                    <div class="flex items-center">
                                        <div class="flex text-yellow-400">
                                            <?php 
                                            $rating = isset($product['rating']) ? $product['rating'] : 5;
                                            echo '<svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>';
                                            ?>
                                            <span class="text-xs ml-0.5"><?php echo $rating; ?>.0</span>
                                        </div>
                                        <span class="text-xs text-gray-500 ml-1">(<?php echo rand(10, 100); ?>)</span>
                                    </div>
                                    <div class="mt-1 flex justify-between items-center">
                                        <span class="text-sm font-bold text-green-700">Rs. <?php echo $product['price']; ?></span>
                                        <a href="https://wa.me/94XXXXXXXXX?text=I'm interested in <?php echo urlencode($product['name']); ?>" target="_blank"
                                            class="bg-green-600 hover:bg-green-700 text-white text-xs px-2 py-0.5 rounded-full shadow-sm hover:shadow transition-all duration-300 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 mr-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                            </svg>
                                            Buy
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div class="col-span-2 text-center py-10"><p class="text-gray-600">No featured products found</p></div>';
                }
                ?>
            </div>
        </div>
        
        <!-- Enhanced Call-to-Action Button -->
        <div class="text-center mt-10">
            <a href="products.php" class="inline-flex items-center px-6 py-3 bg-white border-2 border-green-600 text-green-600 rounded-full hover:bg-green-600 hover:text-white transition-all duration-300 font-semibold shadow-md hover:shadow-lg group">
                <span>View All Products</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Stats Section with Animated Numbers -->
<section class="py-20 bg-green-700 relative">
    <!-- Animated Wave Background -->
    <div class="wave-bg absolute inset-0 opacity-10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-green-200 font-semibold text-sm uppercase tracking-widest">Our Impact</span>
            <h2 class="text-4xl font-bold text-white mt-2 mb-4">By The Numbers</h2>
            <div class="w-20 h-1 bg-green-300 mx-auto"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Stat 1 -->
            <div class="stat-card text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card-inner bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-colors duration-300">
                    <div class="stat-icon bg-white/20 text-white rounded-full p-4 inline-flex items-center justify-center mb-6 w-16 h-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="counter-number text-5xl font-bold text-white mb-2" data-target="15000">0</div>
                    <div class="counter-label text-xl text-green-100">Happy Customers</div>
                </div>
            </div>
            
            <!-- Stat 2 -->
            <div class="stat-card text-center" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card-inner bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-colors duration-300">
                    <div class="stat-icon bg-white/20 text-white rounded-full p-4 inline-flex items-center justify-center mb-6 w-16 h-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <div class="counter-number text-5xl font-bold text-white mb-2" data-target="5000">0</div>
                    <div class="counter-label text-xl text-green-100">Prescriptions Filled</div>
                </div>
            </div>
            
            <!-- Stat 3 -->
            <div class="stat-card text-center" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-card-inner bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-colors duration-300">
                    <div class="stat-icon bg-white/20 text-white rounded-full p-4 inline-flex items-center justify-center mb-6 w-16 h-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <div class="counter-number text-5xl font-bold text-white mb-2" data-target="1200">0</div>
                    <div class="counter-label text-xl text-green-100">Products Available</div>
                </div>
            </div>
            
            <!-- Stat 4 -->
            <div class="stat-card text-center" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-card-inner bg-white/10 backdrop-blur-sm rounded-2xl p-8 hover:bg-white/20 transition-colors duration-300">
                    <div class="stat-icon bg-white/20 text-white rounded-full p-4 inline-flex items-center justify-center mb-6 w-16 h-16">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="counter-number text-5xl font-bold text-white mb-2" data-target="12">0</div>
                    <div class="counter-label text-xl text-green-100">Years of Service</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials Section with 3D Cards -->
<section class="py-16 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
    <!-- Decorative Elements -->
    <div class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-1/2 w-96 h-96 bg-green-100 rounded-full opacity-60 blur-xl"></div>
    <div class="absolute top-1/4 right-0 transform -translate-x-1/2 w-64 h-64 bg-blue-100 rounded-full opacity-60 blur-xl"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="text-center mb-10" data-aos="fade-up">
            <div class="inline-block px-3 py-1 bg-green-100 rounded-full mb-3">
                <span class="text-green-700 font-semibold text-sm tracking-wider">Testimonials</span>
            </div>
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-4">What Our Customers Say</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-green-600 to-green-400 mx-auto rounded-full"></div>
            <p class="text-gray-600 max-w-2xl mx-auto mt-4">Hear from our satisfied customers about their experience with Healthgrade Pharmacy.</p>
        </div>

        <!-- Preserve the testimonials-slider class for JS -->
        <div class="testimonials-slider relative" data-aos="fade-up">
            <!-- Preserve swiper-container for JS -->
            <div class="swiper-container">
                <!-- Preserve swiper-wrapper for JS -->
                <div class="swiper-wrapper">
                    <!-- Single swiper-slide containing all 4 cards in a grid -->
                    <div class="swiper-slide">
                        <!-- Grid layout for 4 cards in a row -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Testimonial 1 -->
                            <div class="testimonial-card group bg-white rounded-xl shadow-md p-4 transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="mb-4">
                                    <div class="flex text-yellow-400 mb-2">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        <?php } ?>
                                    </div>
                                    <div class="relative">
                                        <svg class="absolute top-0 left-0 transform -translate-x-2 -translate-y-2 h-6 w-6 text-green-500 opacity-40" fill="currentColor" viewBox="0 0 32 32">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                        </svg>
                                        <p class="text-gray-600 text-sm relative z-10 line-clamp-4">I've been using Healthgrade Pharmacy for all my medication needs. Their service is exceptionally good and the staff are very knowledgeable. The home delivery option has been a lifesaver!</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 overflow-hidden border-2 border-green-500">
                                        <span class="text-green-700 font-bold text-sm">RS</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-base">Rajith Silva</h4>
                                        <p class="text-gray-500 text-xs">Regular Customer</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Testimonial 2 -->
                            <div class="testimonial-card group bg-white rounded-xl shadow-md p-4 transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="mb-4">
                                    <div class="flex text-yellow-400 mb-2">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        <?php } ?>
                                    </div>
                                    <div class="relative">
                                        <svg class="absolute top-0 left-0 transform -translate-x-2 -translate-y-2 h-6 w-6 text-green-500 opacity-40" fill="currentColor" viewBox="0 0 32 32">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                        </svg>
                                        <p class="text-gray-600 text-sm relative z-10 line-clamp-4">Their home delivery service is a lifesaver for me. Medications always arrive on time and the pharmacists are always available for consultation. The online ordering system is very convenient.</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 overflow-hidden border-2 border-green-500">
                                        <span class="text-green-700 font-bold text-sm">MF</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-base">Malini Fernando</h4>
                                        <p class="text-gray-500 text-xs">Senior Customer</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Testimonial 3 -->
                            <div class="testimonial-card group bg-white rounded-xl shadow-md p-4 transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="mb-4">
                                    <div class="flex text-yellow-400 mb-2">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        <?php } ?>
                                    </div>
                                    <div class="relative">
                                        <svg class="absolute top-0 left-0 transform -translate-x-2 -translate-y-2 h-6 w-6 text-green-500 opacity-40" fill="currentColor" viewBox="0 0 32 32">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                        </svg>
                                        <p class="text-gray-600 text-sm relative z-10 line-clamp-4">I appreciate the professional advice I receive from the pharmacists. They always take time to explain medication details thoroughly. The website makes it easy to refill prescriptions and check information.</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 overflow-hidden border-2 border-green-500">
                                        <span class="text-green-700 font-bold text-sm">KP</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-base">Kamal Perera</h4>
                                        <p class="text-gray-500 text-xs">New Customer</p>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Testimonial 4 -->
                            <div class="testimonial-card group bg-white rounded-xl shadow-md p-4 transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1">
                                <div class="mb-4">
                                    <div class="flex text-yellow-400 mb-2">
                                        <?php for ($i = 0; $i < 5; $i++) { ?>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        <?php } ?>
                                    </div>
                                    <div class="relative">
                                        <svg class="absolute top-0 left-0 transform -translate-x-2 -translate-y-2 h-6 w-6 text-green-500 opacity-40" fill="currentColor" viewBox="0 0 32 32">
                                            <path d="M9.352 4C4.456 7.456 1 13.12 1 19.36c0 5.088 3.072 8.064 6.624 8.064 3.36 0 5.856-2.688 5.856-5.856 0-3.168-2.208-5.472-5.088-5.472-.576 0-1.344.096-1.536.192.48-3.264 3.552-7.104 6.624-9.024L9.352 4zm16.512 0c-4.8 3.456-8.256 9.12-8.256 15.36 0 5.088 3.072 8.064 6.624 8.064 3.264 0 5.856-2.688 5.856-5.856 0-3.168-2.304-5.472-5.184-5.472-.576 0-1.248.096-1.44.192.48-3.264 3.456-7.104 6.528-9.024L25.864 4z" />
                                        </svg>
                                        <p class="text-gray-600 text-sm relative z-10 line-clamp-4">The attention to detail at Healthgrade Pharmacy is remarkable. From explaining drug interactions to following up after delivery, they've set a new standard for pharmaceutical care in our area.</p>
                                    </div>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center mr-3 overflow-hidden border-2 border-green-500">
                                        <span class="text-green-700 font-bold text-sm">DW</span>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-800 text-base">Dinesh Wijesinghe</h4>
                                        <p class="text-gray-500 text-xs">Loyal Customer</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Keep pagination for JS, but hide it visually -->
                <div class="swiper-pagination mt-8 hidden"></div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section with Parallax -->
<section class="py-10 bg-gradient-to-r from-green-800 to-green-600 relative overflow-hidden">
    <!-- Parallax Pills Background -->
    <div id="cta-canvas" class="absolute inset-0 opacity-10"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <h2 class="text-4xl md:text-5xl font-bold text-white mb-6" data-aos="fade-up">Ready to Experience Our Services?</h2>
            <p class="text-xl text-green-100 mb-10 leading-relaxed" data-aos="fade-up" data-aos-delay="100">Visit our pharmacy today or book an appointment with our pharmacist for a personalized consultation. We're here to support your health journey.</p>
            
            <div class="flex flex-wrap justify-center gap-6" data-aos="fade-up" data-aos-delay="200">
                <a href="products.php" class="cta-btn-primary group">
                    <span>Browse Products</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                </a>
                <a href="appointment.php" class="cta-btn-secondary group">
                    <span>Book Appointment</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </a>
            </div>
            
            <!-- Contact Information Pills -->
            <div class="mt-16 grid grid-cols-1 md:grid-cols-3 gap-6" data-aos="fade-up" data-aos-delay="300">
                <!-- Phone Pill -->
                <div class="bg-white/10 backdrop-blur-sm rounded-full py-4 px-6 flex items-center justify-center gap-3 hover:bg-white/20 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-300" fill="none" viewBox="0 0 24 24" stroke="black">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <span class="text-green-300 font-medium">+94 11 234 5678</span>
                </div>
                
                <!-- Email Pill -->
                <div class="bg-white/10 backdrop-blur-sm rounded-full py-4 px-6 flex items-center justify-center gap-3 hover:bg-white/20 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-300" fill="none" viewBox="0 0 24 24" stroke="black">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <span class="text-green-300 font-medium">info@healthgradepharmacy.lk</span>
                </div>
                
                <!-- Location Pill -->
                <div class="bg-white/10 backdrop-blur-sm rounded-full py-4 px-6 flex items-center justify-center gap-3 hover:bg-white/20 transition-colors duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-300" fill="none" viewBox="0 0 24 24" stroke="black">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="text-green-300 font-medium">123 Health St, Colombo</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Wave Bottom Shape -->
    <div class="absolute bottom-0 left-0 right-0">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-auto">
            <path fill="#f9fafb" fill-opacity="1" d="M0,128L48,144C96,160,192,192,288,186.7C384,181,480,139,576,144C672,149,768,203,864,202.7C960,203,1056,149,1152,144C1248,139,1344,181,1392,202.7L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div>
</section>

<!-- Load AOS Animation Library -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<!-- Load Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<!-- Load Three.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
<!-- Load GSAP -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/ScrollTrigger.min.js"></script>

<?php include 'includes/footer.php'; ?>