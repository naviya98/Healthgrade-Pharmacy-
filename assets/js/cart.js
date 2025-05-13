/**
 * Cart functionality for Healthgrade Pharmacy
 * Handles adding products to cart, updating cart count, and displaying notifications
 */

// Wait for the DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Cart.js loaded successfully');
    
    // Initialize cart in localStorage if it doesn't exist
    if (!localStorage.getItem('healthgrade_cart')) {
        localStorage.setItem('healthgrade_cart', JSON.stringify([]));
    }
    
    // Update cart count on page load
    updateCartCounter();
    
    // Add event listeners to all "Add to Cart" buttons
    setupAddToCartButtons();
});

/**
 * Set up event listeners for all Add to Cart buttons
 */
function setupAddToCartButtons() {
    // Find all Add to Cart buttons with the class
    const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
    console.log('Found', addToCartButtons.length, 'Add to Cart buttons');
    
    // Add click event listener to each button
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Get product details from data attributes
            const productId = this.getAttribute('data-product-id');
            const productName = this.getAttribute('data-product-name');
            const productPrice = this.getAttribute('data-product-price');
            const productImage = this.getAttribute('data-product-image');
            
            console.log('Adding to cart:', productId, productName, productPrice);
            
            // Add to cart
            addToCart(productId, productName, productPrice, productImage);
        });
    });
}

/**
 * Add a product to the cart
 * @param {string} productId - Product ID
 * @param {string} productName - Product name
 * @param {string} productPrice - Product price
 * @param {string} productImage - Product image URL
 * @param {number} quantity - Quantity to add (default: 1)
 */
function addToCart(productId, productName, productPrice, productImage, quantity = 1) {
    // Get current cart from localStorage
    let cart = JSON.parse(localStorage.getItem('healthgrade_cart')) || [];
    
    // Check if product already exists in cart
    const existingProductIndex = cart.findIndex(item => item.id === productId);
    
    if (existingProductIndex > -1) {
        // Product exists, increase quantity
        cart[existingProductIndex].quantity += quantity;
    } else {
        // Product doesn't exist, add new product
        cart.push({
            id: productId,
            name: productName,
            price: parseFloat(productPrice),
            image: productImage,
            quantity: quantity
        });
    }
    
    // Save cart back to localStorage
    localStorage.setItem('healthgrade_cart', JSON.stringify(cart));
    
    // Update cart counter
    updateCartCounter();
    
    // Show success notification
    showNotification(`${productName} added to cart`, 'success');
    
    // Optional: If using server-side cart, sync with server
    // syncCartWithServer(cart);
}

/**
 * Update the cart counter in the header
 */
function updateCartCounter() {
    // Get cart from localStorage
    const cart = JSON.parse(localStorage.getItem('healthgrade_cart')) || [];
    
    // Calculate total quantity
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    
    // Find all cart counter elements
    const cartCounters = document.querySelectorAll('.cart-count');
    console.log('Updating cart counters:', cartCounters.length, 'Total items:', totalItems);
    
    // Update each counter
    cartCounters.forEach(counter => {
        counter.textContent = totalItems;
        
        // Add a small animation effect
        counter.classList.add('scale-effect');
        setTimeout(() => {
            counter.classList.remove('scale-effect');
        }, 300);
    });
}

/**
 * Show a notification message
 * @param {string} message - Message to display
 * @param {string} type - Notification type ('success' or 'error')
 */
function showNotification(message, type = 'success') {
    // Get or create notification container
    let notification = document.getElementById('cart-notification');
    
    if (!notification) {
        notification = document.createElement('div');
        notification.id = 'cart-notification';
        notification.className = 'fixed top-4 right-4 p-4 rounded-md shadow-lg transition-all duration-300 transform translate-x-full z-50';
        document.body.appendChild(notification);
    }
    
    // Set notification style based on type
    if (type === 'success') {
        notification.className = 'fixed top-4 right-4 p-4 rounded-md shadow-lg transition-all duration-300 transform z-50 bg-green-100 text-green-800 border-l-4 border-green-500';
    } else {
        notification.className = 'fixed top-4 right-4 p-4 rounded-md shadow-lg transition-all duration-300 transform z-50 bg-red-100 text-red-800 border-l-4 border-red-500';
    }
    
    // Set notification content
    notification.innerHTML = `
        <div class="flex">
            <div class="flex-shrink-0">
                ${type === 'success' 
                    ? '<svg class="h-5 w-5 text-green-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>'
                    : '<svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path></svg>'
                }
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium">${message}</p>
            </div>
        </div>
    `;
    
    // Slide in the notification
    notification.style.transform = 'translateX(0)';
    
    // Slide out after 3 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
    }, 3000);
}

/**
 * Remove a product from the cart
 * @param {string} productId - Product ID to remove
 */
function removeFromCart(productId) {
    // Get current cart
    let cart = JSON.parse(localStorage.getItem('healthgrade_cart')) || [];
    
    // Filter out the product
    cart = cart.filter(item => item.id !== productId);
    
    // Save cart back to localStorage
    localStorage.setItem('healthgrade_cart', JSON.stringify(cart));
    
    // Update cart counter
    updateCartCounter();
    
    // Show notification
    showNotification('Product removed from cart', 'success');
    
    // If on cart page, update the cart display
    if (document.getElementById('cart-items')) {
        displayCartItems();
    }
}

/**
 * Update the quantity of a product in the cart
 * @param {string} productId - Product ID
 * @param {number} change - Amount to change quantity by (+1 or -1)
 */
function updateQuantity(productId, change) {
    // Get current cart
    let cart = JSON.parse(localStorage.getItem('healthgrade_cart')) || [];
    
    // Find the product
    const index = cart.findIndex(item => item.id === productId);
    
    if (index > -1) {
        // Update quantity
        cart[index].quantity += change;
        
        // If quantity is 0 or less, remove the product
        if (cart[index].quantity <= 0) {
            cart.splice(index, 1);
        }
        
        // Save cart back to localStorage
        localStorage.setItem('healthgrade_cart', JSON.stringify(cart));
        
        // Update cart counter
        updateCartCounter();
        
        // If on cart page, update the cart display
        if (document.getElementById('cart-items')) {
            displayCartItems();
        }
    }
}

/**
 * Display cart items on the cart page
 */
function displayCartItems() {
    const cartContainer = document.getElementById('cart-items');
    if (!cartContainer) return;
    
    // Get cart from localStorage
    const cart = JSON.parse(localStorage.getItem('healthgrade_cart')) || [];
    
    if (cart.length === 0) {
        // Show empty cart message
        cartContainer.innerHTML = `
            <div class="text-center py-12">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                <h3 class="text-2xl font-semibold text-gray-700 mb-2">Your cart is empty</h3>
                <p class="text-gray-500 mb-6">Looks like you haven't added any products to your cart yet.</p>
                <a href="products.php" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-md hover:shadow-lg transition-all">
                    Browse Products
                </a>
            </div>
        `;
        return;
    }
    
    // Calculate total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    // Generate cart items HTML
    let html = '<div class="space-y-6">';
    
    // Add each cart item
    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        
        html += `
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 flex items-center">
                    <div class="flex-shrink-0 w-20 h-20 bg-gray-100 rounded overflow-hidden">
                        <img src="${item.image}" alt="${item.name}" class="w-full h-full object-cover">
                    </div>
                    <div class="ml-4 flex-grow">
                        <h3 class="font-semibold text-lg text-gray-800">${item.name}</h3>
                        <p class="text-gray-600">Rs. ${item.price.toFixed(2)}</p>
                    </div>
                    <div class="flex items-center">
                        <button 
                            onclick="updateQuantity('${item.id}', -1)" 
                            class="text-gray-500 hover:text-gray-700 focus:outline-none bg-gray-200 hover:bg-gray-300 h-8 w-8 rounded-full flex items-center justify-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                            </svg>
                        </button>
                        <span class="mx-3 text-gray-700 w-5 text-center">${item.quantity}</span>
                        <button 
                            onclick="updateQuantity('${item.id}', 1)" 
                            class="text-gray-500 hover:text-gray-700 focus:outline-none bg-gray-200 hover:bg-gray-300 h-8 w-8 rounded-full flex items-center justify-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </button>
                    </div>
                    <div class="ml-6 text-right">
                        <p class="font-bold text-lg text-gray-800">Rs. ${itemTotal.toFixed(2)}</p>
                        <button 
                            onclick="removeFromCart('${item.id}')" 
                            class="text-red-500 hover:text-red-700 text-sm flex items-center mt-1 focus:outline-none"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Remove
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    
    // Add order summary
    html += `
        <div class="mt-8 bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Order Summary</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">Rs. ${total.toFixed(2)}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Delivery Fee</span>
                        <span class="font-medium">Calculated at checkout</span>
                    </div>
                    <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between">
                        <span class="text-lg font-semibold">Total</span>
                        <span class="text-lg font-bold text-green-700">Rs. ${total.toFixed(2)}</span>
                    </div>
                </div>
                <div class="mt-6 space-y-3">
                    <button 
                        id="checkout-btn" 
                        onclick="checkoutViaWhatsApp()"
                        class="w-full bg-green-600 hover:bg-green-700 text-white py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        Checkout via WhatsApp
                    </button>
                    <button 
                        onclick="clearCart()"
                        class="w-full bg-white hover:bg-gray-100 text-gray-700 border border-gray-300 py-3 px-4 rounded-lg transition-all"
                    >
                        Clear Cart
                    </button>
                </div>
            </div>
        </div>
    `;
    
    // Update the cart container
    cartContainer.innerHTML = html;
}

/**
 * Clear the entire cart
 */
function clearCart() {
    // Clear cart in localStorage
    localStorage.setItem('healthgrade_cart', JSON.stringify([]));
    
    // Update cart counter
    updateCartCounter();
    
    // Show notification
    showNotification('Cart cleared', 'success');
    
    // If on cart page, update the cart display
    if (document.getElementById('cart-items')) {
        displayCartItems();
    }
}

/**
 * Checkout via WhatsApp with cart contents
 */
function checkoutViaWhatsApp() {
    // Get cart from localStorage
    const cart = JSON.parse(localStorage.getItem('healthgrade_cart')) || [];
    
    if (cart.length === 0) {
        showNotification('Your cart is empty', 'error');
        return;
    }
    
    // Calculate total
    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    
    // Create WhatsApp message
    let message = 'Hello, I would like to place an order for:\n\n';
    
    // Add each item to the message
    cart.forEach(item => {
        message += `${item.quantity}x ${item.name} - Rs. ${(item.price * item.quantity).toFixed(2)}\n`;
    });
    
    // Add total
    message += `\nTotal: Rs. ${total.toFixed(2)}\n\n`;
    
    // Add customer note
    message += 'Please let me know the delivery details and payment options. Thank you!';
    
    // Create WhatsApp URL
    // Replace 94XXXXXXXXX with your actual WhatsApp number
    const phoneNumber = '94XXXXXXXXX';
    const whatsappUrl = `https://wa.me/${phoneNumber}?text=${encodeURIComponent(message)}`;
    
    // Open WhatsApp in a new tab
    window.open(whatsappUrl, '_blank');
}