<?php
/**
 * Cart Modal
 * Mini cart preview that can be included in any page
 */

// Include cart functions if not already included
if (!function_exists('get_cart_contents')) {
    require_once 'cart_functions.php';
}

// Get cart contents
$cart = get_cart_contents();
$items = $cart['items'];
$total = $cart['total'];
$item_count = $cart['item_count'];
?>

<!-- Cart Modal -->
<div id="cart-modal" class="fixed inset-0 z-50 hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-black bg-opacity-50 transition-opacity" id="cart-modal-backdrop"></div>
    
    <!-- Modal Content -->
    <div class="absolute right-0 top-0 h-full w-full max-w-md transform transition-transform translate-x-full" id="cart-modal-content">
        <div class="h-full bg-white shadow-xl flex flex-col">
            <!-- Header -->
            <div class="flex items-center justify-between p-4 border-b">
                <h2 class="text-lg font-medium text-gray-900">Your Cart (<?php echo $item_count; ?> items)</h2>
                <button id="close-cart-modal" class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="flex-1 overflow-y-auto p-4">
                <?php if (empty($items)): ?>
                    <div class="text-center py-8">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <p class="text-gray-500">Your cart is empty</p>
                    </div>
                <?php else: ?>
                    <ul class="divide-y divide-gray-200">
                        <?php foreach ($items as $item): ?>
                            <li class="py-4 flex">
                                <?php if (!empty($item['image_url'])): ?>
                                    <div class="flex-shrink-0 w-16 h-16">
                                        <img class="w-16 h-16 rounded-md object-cover" src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="ml-4 flex-1">
                                    <div class="flex items-center justify-between">
                                        <h3 class="text-sm font-medium text-gray-900"><?php echo $item['name']; ?></h3>
                                        <button 
                                            class="text-sm text-red-500 hover:text-red-700"
                                            onclick="removeItemFromModal(<?php echo $item['id']; ?>)">
                                            Remove
                                        </button>
                                    </div>
                                    <div class="flex items-center justify-between mt-2">
                                        <div class="text-sm text-gray-500">
                                            <span>Qty: <?php echo $item['quantity']; ?></span>
                                        </div>
                                        <div class="text-sm font-medium text-gray-900">
                                            Rs. <?php echo number_format($item['subtotal'], 2); ?>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
            
            <!-- Footer -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex justify-between text-base font-medium text-gray-900 mb-4">
                    <p>Subtotal</p>
                    <p>Rs. <?php echo number_format($total, 2); ?></p>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <a href="cart.php" class="text-center bg-white border border-gray-300 rounded-md py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        View Cart
                    </a>
                    <?php if (!empty($items)): ?>
                        <a href="<?php echo generate_whatsapp_order(); ?>" 
                           target="_blank"
                           class="text-center bg-green-600 border border-transparent rounded-md py-2 text-sm font-medium text-white hover:bg-green-700">
                            Order via WhatsApp
                        </a>
                    <?php else: ?>
                        <a href="products.php" class="text-center bg-green-600 border border-transparent rounded-md py-2 text-sm font-medium text-white hover:bg-green-700">
                            Shop Now
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Toggle cart modal
    function toggleCartModal() {
        const modal = document.getElementById('cart-modal');
        const content = document.getElementById('cart-modal-content');
        
        modal.classList.toggle('hidden');
        
        if (!modal.classList.contains('hidden')) {
            // Show modal
            setTimeout(() => {
                content.classList.remove('translate-x-full');
            }, 10);
        } else {
            // Hide modal
            content.classList.add('translate-x-full');
        }
    }
    
    // Remove item from modal
    function removeItemFromModal(itemId) {
        fetch('api/remove_from_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `item_id=${itemId}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the modal
                location.reload();
            } else {
                alert('Failed to remove item: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Add event listeners when document is loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Close modal when clicking backdrop
        const backdrop = document.getElementById('cart-modal-backdrop');
        if (backdrop) {
            backdrop.addEventListener('click', toggleCartModal);
        }
        
        // Close modal when clicking close button
        const closeButton = document.getElementById('close-cart-modal');
        if (closeButton) {
            closeButton.addEventListener('click', toggleCartModal);
        }
        
        // Add click listener to cart icon in header
        const cartIcon = document.querySelector('[href="cart.php"]'); // Adjust selector as needed
        if (cartIcon) {
            cartIcon.addEventListener('click', function(e) {
                e.preventDefault();
                toggleCartModal();
            });
        }
    });
</script>