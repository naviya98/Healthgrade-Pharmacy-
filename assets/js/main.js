/**
 * Main JavaScript for Healthgrade Pharmacy
 * Author: Your Name
 * Version: 2.0
 * Description: Enhanced interactive elements and animations for the Healthgrade Pharmacy website
 */

document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS animations - check if AOS exists first
    if (typeof AOS !== 'undefined') {
      AOS.init({
        duration: 800,
        easing: 'ease-out',
        once: true,
        offset: 50
      });
    } else {
      console.warn('AOS is not loaded. Include AOS library for animations.');
    }
    
    // Initialize GSAP animations if GSAP exists
    if (typeof gsap !== 'undefined') {
      initGSAPAnimations();
    } else {
      console.warn('GSAP is not loaded. Include GSAP library for animations.');
    }
    
    // Initialize Three.js elements if THREE exists
    if (typeof THREE !== 'undefined') {
      if (document.getElementById('hero-canvas')) {
        initHeroCanvas();
      }
      
      if (document.getElementById('cta-canvas')) {
        initCTACanvas();
      }
    } else {
      console.warn('Three.js is not loaded. Include Three.js library for 3D elements.');
    }
    
    // Initialize Swiper sliders if Swiper exists
    if (typeof Swiper !== 'undefined') {
      initSwiperSliders();
    }
    
    // Initialize parallax effects
    if (typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined') {
      initParallaxEffects();
    }
    
    // Setup hover animations
    setupHoverAnimations();
    
    // Setup page-specific functionality
    setupPageFunctionality();
  });
  
  /**
   * Initialize GSAP animations for various page elements
   */
  function initGSAPAnimations() {
    // Header animations
    gsap.from('header', { 
      duration: 1, 
      y: -50, 
      opacity: 0, 
      ease: 'power3.out'
    });
    
    // Hero section text animations
    if (document.querySelector('.hero-title')) {
      let heroTl = gsap.timeline();
      
      heroTl.from('.hero-title', {
        duration: 1,
        y: 50,
        opacity: 0,
        ease: 'power4.out'
      })
      .from('.hero-subtitle', {
        duration: 1,
        y: 30,
        opacity: 0,
        ease: 'power3.out'
      }, '-=0.6')
      .from('.hero .btn-primary, .hero .btn-secondary', {
        duration: 0.8,
        y: 20,
        opacity: 0,
        stagger: 0.2,
        ease: 'back.out(1.7)'
      }, '-=0.4')
      .from('.hero-image', {
        duration: 1.2,
        scale: 0.8,
        opacity: 0,
        ease: 'power3.out'
      }, '-=1')
      .from('.pulse-element', {
        duration: 0.8,
        scale: 0,
        opacity: 0,
        ease: 'back.out(2)'
      }, '-=0.5')
      .from('.floating-capsule, .floating-pill, .floating-tablet', {
        duration: 1,
        scale: 0,
        opacity: 0,
        stagger: 0.2,
        ease: 'elastic.out(1, 0.5)'
      }, '-=1');
    }
    
    // Floating capsules animation
    gsap.to('.floating-capsule', {
      y: -15,
      rotation: '+=5',
      duration: 3,
      yoyo: true,
      repeat: -1,
      ease: 'sine.inOut'
    });
    
    gsap.to('.floating-pill', {
      y: 15,
      rotation: '-=8',
      duration: 4,
      yoyo: true,
      repeat: -1,
      ease: 'sine.inOut',
      delay: 0.5
    });
    
    gsap.to('.floating-tablet', {
      y: -10,
      rotation: '+=15',
      duration: 5,
      yoyo: true,
      repeat: -1,
      ease: 'sine.inOut',
      delay: 1
    });
    
    // Pulse animation
    gsap.to('.pulse-element', {
      scale: 1.05,
      duration: 1.5,
      yoyo: true,
      repeat: -1,
      ease: 'sine.inOut'
    });
    
    // Years badge rotation
    gsap.to('.years-badge', {
      rotation: 360,
      duration: 40,
      repeat: -1,
      ease: 'none'
    });
    
    // Setup ScrollTrigger animations
    if (typeof ScrollTrigger !== 'undefined') {
      // Service tabs animation on scroll
      ScrollTrigger.batch('.service-tab', {
        interval: 0.1,
        batchMax: 4,
        onEnter: batch => {
          gsap.from(batch, {
            y: 30,
            opacity: 0,
            stagger: 0.15,
            duration: 0.6,
            ease: 'back.out(1.7)'
          });
        },
        start: "top 85%"
      });
      
      // Product cards animation on scroll
      ScrollTrigger.batch('.product-card', {
        interval: 0.1,
        onEnter: batch => {
          gsap.from(batch, {
            scale: 0.9,
            opacity: 0,
            stagger: 0.1,
            duration: 0.6,
            ease: 'back.out(1.5)'
          });
        },
        start: "top 85%"
      });
      
      // Stats counter animation
      const counterSection = document.querySelector('.stat-card');
      if (counterSection) {
        ScrollTrigger.create({
          trigger: counterSection,
          start: "top 80%",
          onEnter: () => animateCounters()
        });
      }
      
      // Animate section headings
      gsap.utils.toArray('section h2').forEach(heading => {
        gsap.from(heading, {
          scrollTrigger: {
            trigger: heading,
            start: "top 80%"
          },
          y: 30,
          opacity: 0,
          duration: 0.8,
          ease: 'power3.out'
        });
      });
    }
  }
  
  /**
   * Initialize Three.js hero canvas with floating pill objects
   */
  function initHeroCanvas() {
    if (typeof THREE === 'undefined') return;
    
    const canvas = document.getElementById('hero-canvas');
    
    // Create scene, camera, and renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0);
    canvas.appendChild(renderer.domElement);
    
    camera.position.z = 30;
    
    // Create pills and capsules
    const pills = [];
    const pillColors = [
      0x38B2AC, // teal-500
      0x319795, // teal-600
      0x2C7A7B, // teal-700
      0x81E6D9, // teal-300
      0xFFFFFF, // white
    ];
    
    // Create pill geometries
    const pillGeometry = new THREE.CapsuleGeometry(1, 2, 8, 16);
    const sphereGeometry = new THREE.SphereGeometry(1, 16, 16);
    const cylinderGeometry = new THREE.CylinderGeometry(1, 1, 3, 16);
    const torusGeometry = new THREE.TorusGeometry(1.5, 0.5, 16, 32);
    
    // Create 30 random pills
    for (let i = 0; i < 30; i++) {
      const geometry = [pillGeometry, sphereGeometry, cylinderGeometry, torusGeometry][Math.floor(Math.random() * 4)];
      const material = new THREE.MeshBasicMaterial({ 
        color: pillColors[Math.floor(Math.random() * pillColors.length)],
        transparent: true,
        opacity: 0.7
      });
      
      const pill = new THREE.Mesh(geometry, material);
      
      // Random position within the scene
      pill.position.x = Math.random() * 60 - 30;
      pill.position.y = Math.random() * 40 - 20;
      pill.position.z = Math.random() * 20 - 30;
      
      // Random rotation
      pill.rotation.x = Math.random() * Math.PI;
      pill.rotation.y = Math.random() * Math.PI;
      
      // Random scale
      const scale = Math.random() * 0.8 + 0.5;
      pill.scale.set(scale, scale, scale);
      
      // Add random movement properties
      pill.userData = {
        rotationSpeed: (Math.random() - 0.5) * 0.02,
        movementSpeed: (Math.random() - 0.5) * 0.05,
        floatDirection: new THREE.Vector3(
          (Math.random() - 0.5) * 0.01,
          (Math.random() - 0.5) * 0.01,
          (Math.random() - 0.5) * 0.01
        )
      };
      
      scene.add(pill);
      pills.push(pill);
    }
    
    // Handle window resize
    window.addEventListener('resize', () => {
      const width = window.innerWidth;
      const height = window.innerHeight;
      
      camera.aspect = width / height;
      camera.updateProjectionMatrix();
      
      renderer.setSize(width, height);
    });
    
    // Animation loop
    function animate() {
      requestAnimationFrame(animate);
      
      // Rotate and move pills
      pills.forEach(pill => {
        pill.rotation.x += pill.userData.rotationSpeed;
        pill.rotation.y += pill.userData.rotationSpeed;
        
        pill.position.x += pill.userData.floatDirection.x;
        pill.position.y += pill.userData.floatDirection.y;
        pill.position.z += pill.userData.floatDirection.z;
        
        // Reverse direction if pill goes too far
        if (Math.abs(pill.position.x) > 30) pill.userData.floatDirection.x *= -1;
        if (Math.abs(pill.position.y) > 20) pill.userData.floatDirection.y *= -1;
        if (Math.abs(pill.position.z) > 30) pill.userData.floatDirection.z *= -1;
      });
      
      renderer.render(scene, camera);
    }
    
    animate();
  }
  
  /**
   * Initialize Three.js CTA canvas with floating particles
   */
  function initCTACanvas() {
    if (typeof THREE === 'undefined') return;
    
    const canvas = document.getElementById('cta-canvas');
    
    // Create scene, camera, and renderer
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({ alpha: true });
    
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setClearColor(0x000000, 0);
    canvas.appendChild(renderer.domElement);
    
    camera.position.z = 20;
    
    // Create particles
    const particles = [];
    const particleCount = 100;
    
    // Create particle geometries
    const dotGeometry = new THREE.CircleGeometry(0.2, 16);
    const crossGeometry = new THREE.BufferGeometry();
    const crossPositions = new Float32Array([
      -0.2, 0.2, 0,
      0.2, -0.2, 0,
      -0.2, -0.2, 0,
      0.2, 0.2, 0,
    ]);
    crossGeometry.setAttribute('position', new THREE.BufferAttribute(crossPositions, 3));
    
    // Create materials
    const whiteMaterial = new THREE.MeshBasicMaterial({ 
      color: 0xFFFFFF,
      transparent: true,
      opacity: 0.6
    });
    
    // Create particles
    for (let i = 0; i < particleCount; i++) {
      const geometry = Math.random() > 0.5 ? dotGeometry : crossGeometry;
      const material = whiteMaterial.clone();
      
      const particle = Math.random() > 0.5 
        ? new THREE.Mesh(geometry, material)
        : new THREE.Line(crossGeometry, material);
      
      // Random position within the scene
      particle.position.x = Math.random() * 40 - 20;
      particle.position.y = Math.random() * 20 - 10;
      particle.position.z = Math.random() * 10 - 5;
      
      // Random scale
      const scale = Math.random() * 0.5 + 0.2;
      particle.scale.set(scale, scale, scale);
      
      // Add random movement properties
      particle.userData = {
        floatDirection: new THREE.Vector3(
          (Math.random() - 0.5) * 0.02,
          (Math.random() - 0.5) * 0.01,
          0
        ),
        rotationSpeed: Math.random() * 0.01
      };
      
      scene.add(particle);
      particles.push(particle);
    }
    
    // Handle window resize
    window.addEventListener('resize', () => {
      const width = window.innerWidth;
      const height = window.innerHeight;
      
      camera.aspect = width / height;
      camera.updateProjectionMatrix();
      
      renderer.setSize(width, height);
    });
    
    // Animation loop
    function animate() {
      requestAnimationFrame(animate);
      
      // Move particles
      particles.forEach(particle => {
        particle.position.x += particle.userData.floatDirection.x;
        particle.position.y += particle.userData.floatDirection.y;
        particle.rotation.z += particle.userData.rotationSpeed;
        
        // Reset position if particle goes out of view
        if (Math.abs(particle.position.x) > 20) {
          particle.position.x = -20 * Math.sign(particle.position.x);
        }
        
        if (Math.abs(particle.position.y) > 10) {
          particle.position.y = -10 * Math.sign(particle.position.y);
        }
      });
      
      renderer.render(scene, camera);
    }
    
    animate();
  }
  
  /**
   * Initialize all Swiper sliders used in the website
   */
  function initSwiperSliders() {
    if (typeof Swiper === 'undefined') return;
    
    // Product carousel
    if (document.querySelector('.product-carousel .swiper-container')) {
      new Swiper('.product-carousel .swiper-container', {
        slidesPerView: 1,
        spaceBetween: 20,
        centeredSlides: true,
        loop: true,
        grabCursor: true,
        effect: 'coverflow',
        coverflowEffect: {
          rotate: 5,
          stretch: 0,
          depth: 100,
          modifier: 1,
          slideShadows: true,
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        autoplay: {
          delay: 5000,
          disableOnInteraction: false,
        },
        breakpoints: {
          640: {
            slidesPerView: 2,
          },
          1024: {
            slidesPerView: 3,
          },
        }
      });
    }
    
    // Testimonials slider
    if (document.querySelector('.testimonials-slider .swiper-container')) {
      new Swiper('.testimonials-slider .swiper-container', {
        slidesPerView: 1,
        spaceBetween: 30,
        centeredSlides: true,
        loop: true,
        grabCursor: true,
        pagination: {
          el: '.swiper-pagination',
          clickable: true,
        },
        autoplay: {
          delay: 6000,
          disableOnInteraction: false,
        },
        breakpoints: {
          768: {
            slidesPerView: 2,
            spaceBetween: 20,
            centeredSlides: false,
          },
          1024: {
            slidesPerView: 3,
            spaceBetween: 30,
            centeredSlides: false,
          },
        }
      });
    }
  }
  
  /**
   * Initialize parallax effects for background elements
   */
  function initParallaxEffects() {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') return;
    
    const parallaxElements = document.querySelectorAll('.parallax-element');
    
    // Mouse move parallax
    document.addEventListener('mousemove', e => {
      const mouseX = e.clientX / window.innerWidth - 0.5;
      const mouseY = e.clientY / window.innerHeight - 0.5;
      
      parallaxElements.forEach(element => {
        const speed = parseFloat(element.getAttribute('data-parallax-speed')) || 0.2;
        const moveX = mouseX * speed * 100;
        const moveY = mouseY * speed * 100;
        
        gsap.to(element, {
          x: moveX,
          y: moveY,
          duration: 1,
          ease: 'power2.out'
        });
      });
    });
    
    // Scroll parallax for background elements
    const waveBg = document.querySelector('.wave-bg');
    if (waveBg) {
      ScrollTrigger.create({
        trigger: waveBg,
        start: 'top bottom',
        end: 'bottom top',
        scrub: true,
        onUpdate: self => {
          const progress = self.progress;
          waveBg.style.backgroundPosition = `center ${50 + progress * 20}%`;
        }
      });
    }
  }
  
  /**
   * Setup hover animations and interactions
   */
  function setupHoverAnimations() {
    if (typeof gsap === 'undefined') return;
    
    // Button hover effects
    const buttons = document.querySelectorAll('.btn-primary, .btn-secondary, .cta-btn-primary, .cta-btn-secondary');
    
    buttons.forEach(button => {
      const svg = button.querySelector('svg');
      if (svg) {
        button.addEventListener('mouseenter', e => {
          gsap.to(svg, {
            x: 3,
            duration: 0.3,
            ease: 'power2.out'
          });
        });
        
        button.addEventListener('mouseleave', e => {
          gsap.to(svg, {
            x: 0,
            duration: 0.3,
            ease: 'power2.out'
          });
        });
      }
    });
  }
  
  /**
   * Setup page-specific functionality based on current page
   */
  function setupPageFunctionality() {
    // Load products if on the products page
    if (document.getElementById('products-container')) {
      if (typeof loadProducts === 'function') {
        loadProducts();
      }
    }
    
    // Setup appointment form if on the appointment page
    if (document.getElementById('appointment-form')) {
      setupAppointmentForm();
    }
    
    // Setup delivery area information if on delivery page
    if (document.getElementById('delivery-areas')) {
      loadDeliveryAreas();
    }
  }
  
  /**
   * Animate counter elements with smooth counting effect
   */
  function animateCounters() {
    if (typeof gsap === 'undefined') return;
    
    const counters = document.querySelectorAll('.counter-number');
    
    counters.forEach(counter => {
      const target = parseInt(counter.getAttribute('data-target'));
      const duration = 3; // seconds
      
      // Use GSAP for smoother animation with easing
      gsap.to(counter, {
        innerText: target,
        duration: duration,
        ease: 'power2.out',
        snap: { innerText: 1 },
        onUpdate: function() {
          counter.innerText = formatNumber(Math.floor(this.targets()[0].innerText));
        }
      });
    });
  }
  
  /**
   * Format numbers with commas for thousands
   * @param {number} num - Number to format
   * @returns {string} Formatted number string
   */
  function formatNumber(num) {
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }
  
  /**
   * Load products from the API
   * @param {number} category_id - Optional category ID to filter products
   */
  function loadProducts(category_id = null) {
    const container = document.getElementById('products-container');
    if (!container) return;
    
    // Show loading indicator with animation
    container.innerHTML = `
      <div class="text-center py-16">
        <div class="inline-block relative">
          <div class="animate-spin inline-block w-12 h-12 border-4 border-teal-600 border-t-transparent rounded-full"></div>
        </div>
        <p class="mt-4 text-gray-600">Loading products...</p>
      </div>
    `;
    
    // Build API URL
    let apiUrl = 'api/products.php';
    if (category_id) {
      apiUrl += `?category=${category_id}`;
    }
    
    // Fetch products
    fetch(apiUrl)
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        if (data.length === 0) {
          container.innerHTML = `
            <div class="text-center py-16">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
              <p class="text-gray-600 text-lg">No products found</p>
              <p class="text-gray-500 mt-2">Please try a different category or check back later.</p>
            </div>
          `;
          return;
        }
        
        let html = '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">';
        data.forEach(product => {
          html += `
            <div class="product-card group bg-white rounded-2xl overflow-hidden shadow-lg transform transition-all duration-300 hover:shadow-2xl">
              <div class="relative overflow-hidden">
                <img src="${product.image}" alt="${product.name}" class="w-full h-64 object-cover transform transition-transform duration-500 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-teal-900/70 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                ${product.is_featured ? '<span class="absolute top-3 right-3 bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">Featured</span>' : ''}
              </div>
              <div class="p-6 relative">
                <div class="product-tag absolute -top-5 left-6 bg-teal-600 text-white text-xs px-3 py-1 rounded-full">
                  ${product.category || 'General'}
                </div>
                <h3 class="text-xl font-bold text-teal-800 mb-2 mt-2">${product.name}</h3>
                <div class="flex items-center mb-2">
                  <div class="flex text-yellow-400">
                    ${generateStarRating(product.rating || 5)}
                  </div>
                  <span class="text-xs text-gray-500 ml-2">(${Math.floor(Math.random() * 90) + 10} reviews)</span>
                </div>
                <p class="text-gray-600 text-sm h-12 overflow-hidden">${product.description}</p>
                <div class="mt-4 flex justify-between items-center">
                  <span class="text-lg font-bold text-teal-700">Rs. ${product.price}</span>
                  
                  <button 
                    class="add-to-cart-btn bg-teal-600 hover:bg-teal-700 text-white text-sm px-4 py-2 rounded-full shadow-md hover:shadow-lg transition-all duration-300 flex items-center"
                    data-product-id="${product.id}"
                    data-product-name="${product.name}"
                    data-product-price="${product.price}"
                    data-product-image="${product.image}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Add to Cart
                  </button>
                </div>
              </div>
            </div>
          `;
        });
        
        html += '</div>';
        container.innerHTML = html;
        
        // Animate products after loading
        if (typeof gsap !== 'undefined') {
          const productCards = container.querySelectorAll('.product-card');
          gsap.from(productCards, {
            y: 50,
            opacity: 0,
            duration: 0.8,
            stagger: 0.1,
            ease: 'power2.out'
          });
        }
      })
      .catch(error => {
        console.error('Error loading products:', error);
        container.innerHTML = `
          <div class="text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-red-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-red-600 text-lg">Error loading products</p>
            <p class="text-gray-600 mt-2">Please try again later.</p>
            <button class="mt-6 bg-teal-600 text-white px-6 py-2 rounded-lg shadow hover:bg-teal-700 transition-colors" onclick="loadProducts()">
              Try Again
            </button>
          </div>
        `;
      });
  }
  
  /**
   * Generate star rating HTML
   * @param {number} rating - Rating value (1-5)
   * @returns {string} HTML string for star rating
   */
  function generateStarRating(rating) {
    let stars = '';
    for (let i = 1; i <= 5; i++) {
      if (i <= rating) {
        stars += `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
          </svg>
        `;
      } else {
        stars += `
          <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
          </svg>
        `;
      }
    }
    return stars;
  }
  
  /**
   * Setup the appointment booking form with enhanced UI
   */
  function setupAppointmentForm() {
    const form = document.getElementById('appointment-form');
    if (!form) return;
    
    form.innerHTML = `
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="form-group">
          <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </div>
            <input type="text" id="name" name="name" required
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-600 focus:border-transparent transition-all" 
              placeholder="John Doe">
          </div>
        </div>
        
        <div class="form-group">
          <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
            <input type="email" id="email" name="email" required
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-600 focus:border-transparent transition-all" 
              placeholder="email@example.com">
          </div>
        </div>
        
        <div class="form-group">
          <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
              </svg>
            </div>
            <input type="tel" id="phone" name="phone" required
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-600 focus:border-transparent transition-all" 
              placeholder="+94 XX XXX XXXX">
          </div>
        </div>
        
        <div class="form-group">
          <label for="service" class="block text-sm font-medium text-gray-700 mb-1">Service Type</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
              </svg>
            </div>
            <select id="service" name="service" required
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-600 focus:border-transparent transition-all appearance-none bg-none">
              <option value="">Select Service</option>
              <option value="consultation">Pharmacist Consultation</option>
              <option value="prescription">Prescription Review</option>
              <option value="health_check">Health Check-up</option>
              <option value="medication_review">Medication Review</option>
              <option value="other">Other</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
        </div>
        
        <div class="form-group">
          <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Preferred Date</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <input type="date" id="date" name="date" required
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-600 focus:border-transparent transition-all">
          </div>
        </div>
        
        <div class="form-group">
          <label for="time" class="block text-sm font-medium text-gray-700 mb-1">Preferred Time</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <select id="time" name="time" required
              class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-600 focus:border-transparent transition-all appearance-none bg-none">
              <option value="">Select Time</option>
              <option value="09:00">09:00 AM</option>
              <option value="10:00">10:00 AM</option>
              <option value="11:00">11:00 AM</option>
              <option value="12:00">12:00 PM</option>
              <option value="14:00">02:00 PM</option>
              <option value="15:00">03:00 PM</option>
              <option value="16:00">04:00 PM</option>
              <option value="17:00">05:00 PM</option>
            </select>
            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
              <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </div>
          </div>
        </div>
      </div>
      
      <div class="form-group mt-6">
        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Notes (Optional)</label>
        <div class="relative">
          <div class="absolute top-3 left-3 flex items-start pointer-events-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
          </div>
          <textarea id="notes" name="notes" rows="4"
            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-teal-600 focus:border-transparent transition-all"
            placeholder="Any additional information that might be helpful..."></textarea>
        </div>
      </div>
      
      <div class="form-group mt-8">
        <button type="submit"
          class="w-full bg-teal-600 hover:bg-teal-700 text-white px-6 py-4 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all duration-300 flex items-center justify-center">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
          </svg>
          Book Appointment
        </button>
      </div>
    `;
    
    // Form input animations
    if (typeof gsap !== 'undefined') {
      const formInputs = form.querySelectorAll('input, select, textarea');
      formInputs.forEach(input => {
        // Focus animation
        input.addEventListener('focus', () => {
          const icon = input.parentElement.querySelector('svg');
          if (icon) {
            gsap.to(icon, {
              color: '#0D9488', // teal-600
              duration: 0.3,
              ease: 'power2.out'
            });
          }
        });
        
        // Blur animation
        input.addEventListener('blur', () => {
          const icon = input.parentElement.querySelector('svg');
          if (icon && !input.value) {
            gsap.to(icon, {
              color: '#9CA3AF', // gray-400
              duration: 0.3,
              ease: 'power2.out'
            });
          }
        });
      });
    }
    
    // Set minimum date to today
    const dateInput = document.getElementById('date');
    if (dateInput) {
      const today = new Date();
      const yyyy = today.getFullYear();
      const mm = String(today.getMonth() + 1).padStart(2, '0');
      const dd = String(today.getDate()).padStart(2, '0');
      const formattedDate = `${yyyy}-${mm}-${dd}`;
      dateInput.min = formattedDate;
    }
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      
      // Show loading state on button
      const submitButton = form.querySelector('button[type="submit"]');
      const originalButtonText = submitButton.innerHTML;
      submitButton.disabled = true;
      submitButton.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        Processing...
      `;
      
      // Simulate form submission (replace with actual API call)
      setTimeout(() => {
        const formData = new FormData(form);
        
        // Success scenario (simulated)
        const formResponse = {
          success: true,
          message: 'Appointment booked successfully!'
        };
        
        // Reset button state
        submitButton.disabled = false;
        submitButton.innerHTML = originalButtonText;
        
        if (formResponse.success) {
          // Show success message with animation
          const successMessage = document.createElement('div');
          successMessage.className = 'success-message mt-6 bg-teal-100 border-l-4 border-teal-500 text-teal-700 p-6 rounded-lg shadow-md';
          successMessage.innerHTML = `
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-teal-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-lg font-medium">Appointment Booked!</h3>
                <p class="mt-2">Thank you for booking an appointment. We will contact you shortly to confirm your appointment details.</p>
                <p class="mt-4 text-sm">
                  <strong>Date:</strong> ${formData.get('date')} at ${formData.get('time')}
                  <br>
                  <strong>Service:</strong> ${document.getElementById('service').options[document.getElementById('service').selectedIndex].text}
                </p>
              </div>
            </div>
          `;
          
          // Add to DOM with animation
          form.parentNode.insertBefore(successMessage, form.nextSibling);
          if (typeof gsap !== 'undefined') {
            gsap.from(successMessage, {
              y: 20,
              opacity: 0,
              duration: 0.5,
              ease: 'power3.out'
            });
            
            // Scroll to success message
            successMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
            
            // Hide the form
            gsap.to(form, {
              opacity: 0.5,
              duration: 0.5
            });
          }
          
          // Reset form
          form.reset();
          
          // Remove success message after 8 seconds
          setTimeout(() => {
            if (typeof gsap !== 'undefined') {
              gsap.to(successMessage, {
                opacity: 0,
                y: -20,
                duration: 0.5,
                ease: 'power3.in',
                onComplete: () => {
                  successMessage.remove();
                  gsap.to(form, {
                    opacity: 1,
                    duration: 0.5
                  });
                }
              });
            } else {
              successMessage.remove();
            }
          }, 8000);
        } else {
          // Show error message with animation
          const errorMessage = document.createElement('div');
          errorMessage.className = 'error-message mt-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-6 rounded-lg shadow-md';
          errorMessage.innerHTML = `
            <div class="flex items-start">
              <div class="flex-shrink-0">
                <svg class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
              </div>
              <div class="ml-3">
                <h3 class="text-lg font-medium">Error</h3>
                <p class="mt-2">${formResponse.message || 'An error occurred. Please try again.'}</p>
              </div>
            </div>
          `;
          
          // Add to DOM with animation
          form.parentNode.insertBefore(errorMessage, form.nextSibling);
          if (typeof gsap !== 'undefined') {
            gsap.from(errorMessage, {
              y: 20,
              opacity: 0,
              duration: 0.5,
              ease: 'power3.out'
            });
            
            // Scroll to error message
            errorMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
          
          // Remove error message after 5 seconds
          setTimeout(() => {
            if (typeof gsap !== 'undefined') {
              gsap.to(errorMessage, {
                opacity: 0,
                y: -20,
                duration: 0.5,
                ease: 'power3.in',
                onComplete: () => errorMessage.remove()
              });
            } else {
              errorMessage.remove();
            }
          }, 5000);
        }
      }, 2000); // Simulate network delay
    });
  }
  
  /**
   * Load delivery areas with enhanced UI
   */
  function loadDeliveryAreas() {
    const container = document.getElementById('delivery-areas');
    if (!container) return;
    
    // Show loading indicator
    container.innerHTML = `
      <div class="text-center py-16">
        <div class="inline-block relative">
          <div class="animate-spin inline-block w-12 h-12 border-4 border-teal-600 border-t-transparent rounded-full"></div>
        </div>
        <p class="mt-4 text-gray-600">Loading delivery information...</p>
      </div>
    `;
    
    // Fetch delivery areas (simulated)
    setTimeout(() => {
      // Sample data
      const areas = [
        { area_name: 'Colombo 1-5', delivery_fee: 150 },
        { area_name: 'Colombo 6-10', delivery_fee: 200 },
        { area_name: 'Colombo 11-15', delivery_fee: 250 },
        { area_name: 'Nugegoda', delivery_fee: 200 },
        { area_name: 'Dehiwala', delivery_fee: 250 },
        { area_name: 'Mount Lavinia', delivery_fee: 300 },
        { area_name: 'Ratmalana', delivery_fee: 350 },
        { area_name: 'Moratuwa', delivery_fee: 400 }
      ];
      
      if (areas.length === 0) {
        container.innerHTML = `
          <div class="text-center py-16">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="text-gray-600 text-lg">No delivery areas found</p>
            <p class="text-gray-500 mt-2">Please check back later for delivery information.</p>
          </div>
        `;
        return;
      }
      
      // Create a modern card-based layout
      let html = `
        <div class="delivery-areas-heading text-center mb-12">
          <h2 class="text-3xl font-bold text-gray-800 mb-4">Delivery Coverage Areas</h2>
          <p class="text-gray-600 max-w-2xl mx-auto">We deliver medications and healthcare products to the following areas. Delivery fees vary based on distance.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
      `;
      
      areas.forEach((area, index) => {
        html += `
          <div class="delivery-area-card bg-white rounded-xl shadow-md overflow-hidden transform transition-all duration-300 hover:shadow-lg hover:-translate-y-1" data-aos="fade-up" data-aos-delay="${index * 50}">
            <div class="p-6">
              <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-semibold text-gray-800">${area.area_name}</h3>
                <span class="bg-teal-100 text-teal-800 text-sm font-semibold px-3 py-1 rounded-full">Active</span>
              </div>
              <div class="flex items-center justify-between">
                <div class="flex items-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-600 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                  <span class="text-gray-600">Delivery Fee:</span>
                </div>
                <span class="text-lg font-bold text-teal-700">Rs. ${area.delivery_fee}</span>
              </div>
              <div class="mt-4 pt-4 border-t border-gray-100">
                <div class="flex justify-between items-center text-sm">
                  <span class="text-gray-500">Delivery Time:</span>
                  <span class="text-gray-800 font-medium">2-4 Hours</span>
                </div>
              </div>
            </div>
          </div>
        `;
      });
      
      html += `
        </div>
        
        <div class="delivery-note mt-12 bg-teal-50 border-l-4 border-teal-500 p-6 rounded-lg shadow-sm" data-aos="fade-up">
          <div class="flex">
            <div class="flex-shrink-0">
              <svg class="h-6 w-6 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
              </svg>
            </div>
            <div class="ml-4">
              <h4 class="text-lg font-medium text-teal-800">Delivery Information</h4>
              <p class="mt-2 text-teal-700">Free delivery for orders above Rs. 5,000. Deliveries are available 7 days a week from 8:00 AM to 8:00 PM. For urgent deliveries or areas not listed above, please contact us directly.</p>
            </div>
          </div>
        </div>
      `;
      
      container.innerHTML = html;
      
      // Initialize AOS animations for new elements
      if (typeof AOS !== 'undefined') {
        AOS.refresh();
      }
      
      // Animate elements
      if (typeof gsap !== 'undefined') {
        gsap.from('.delivery-areas-heading', {
          y: 30,
          opacity: 0,
          duration: 0.8,
          ease: 'power3.out'
        });
      }
    }, 1500); // Simulate network delay
  }