<?php
/**
 * Cart Page
 * Display and manage shopping cart contents
 */

// Include necessary files
require_once 'includes/db_connect.php';
require_once 'includes/functions.php';
require_once 'includes/cart_functions.php';

// Get cart contents
$cart = get_cart_contents();
$items = $cart['items'];
$total = $cart['total'];
$item_count = $cart['item_count'];

// Pharmacy WhatsApp number (update with actual number)
$pharmacy_whatsapp = "94771234567";

// Include header
include 'includes/header.php';
?>

<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-green-700 mb-6">Your Shopping Cart</h1>
    
    <?php if (empty($items)): ?>
        <div class="bg-white shadow-md rounded-lg p-8 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <h2 class="text-xl font-semibold text-gray-700 mb-2">Your cart is empty</h2>
            <p class="text-gray-500 mb-6">Looks like you haven't added any products to your cart yet.</p>
            <a href="products.php" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition duration-300 ease-in-out">
                Browse Products
            </a>
        </div>
    <?php else: ?>
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($items as $item): ?>
                            <tr class="cart-item" data-item-id="<?php echo $item['id']; ?>">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <?php if (!empty($item['image_url'])): ?>
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-md object-cover" src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>">
                                            </div>
                                        <?php endif; ?>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900"><?php echo $item['name']; ?></div>
                                            <div class="text-sm text-gray-500">ID: <?php echo $item['product_id']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">Rs. <?php echo number_format($item['price'], 2); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <button 
                                            class="quantity-btn decrease bg-gray-200 px-2 py-1 rounded-l-md"
                                            onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] - 1; ?>)">
                                            -
                                        </button>
                                        <input 
                                            type="number" 
                                            class="quantity-input w-12 text-center border-t border-b border-gray-200 py-1" 
                                            value="<?php echo $item['quantity']; ?>" 
                                            min="1"
                                            onchange="updateQuantity(<?php echo $item['id']; ?>, this.value)">
                                        <button 
                                            class="quantity-btn increase bg-gray-200 px-2 py-1 rounded-r-md"
                                            onclick="updateQuantity(<?php echo $item['id']; ?>, <?php echo $item['quantity'] + 1; ?>)">
                                            +
                                        </button>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    Rs. <?php echo number_format($item['subtotal'], 2); ?>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button 
                                        class="text-red-600 hover:text-red-900"
                                        onclick="removeItem(<?php echo $item['id']; ?>)">
                                        Remove
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            
            <div class="border-t border-gray-200 px-6 py-4">
                <div class="flex justify-between items-center">
                    <div>
                        <span class="text-gray-700">Total (<?php echo $item_count; ?> items):</span>
                        <span class="ml-2 text-xl font-bold text-green-700">Rs. <?php echo number_format($total, 2); ?></span>
                    </div>
                    <div class="flex space-x-4">
                        <button 
                            class="bg-red-100 text-red-700 hover:bg-red-200 px-4 py-2 rounded-md transition duration-300 ease-in-out"
                            onclick="clearCart()">
                            Clear Cart
                        </button>
                        <a href="<?php echo generate_whatsapp_order($pharmacy_whatsapp); ?>" 
                           target="_blank"
                           class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md transition duration-300 ease-in-out flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            Order via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
    // Update item quantity
    function updateQuantity(itemId, quantity) {
        if (quantity < 1) quantity = 1;
        
        fetch('api/update_cart.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `item_id=${itemId}&quantity=${quantity}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload the page to show updated cart
                location.reload();
            } else {
                alert('Failed to update quantity: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    // Remove item from cart
    function removeItem(itemId) {
        if (confirm('Are you sure you want to remove this item?')) {
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
                    // Reload the page to show updated cart
                    location.reload();
                } else {
                    alert('Failed to remove item: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
    
    // Clear entire cart
    function clearCart() {
        if (confirm('Are you sure you want to clear your entire cart?')) {
            fetch('api/clear_cart.php', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Reload the page to show empty cart
                    location.reload();
                } else {
                    alert('Failed to clear cart: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }
    }
</script>

<?php
// Include footer
include 'includes/footer.php';
?>