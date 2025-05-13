<?php include 'includes/header.php'; ?>

<!-- Page Header -->
<div class="bg-green-700 text-white py-16">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold mb-2">Our Products</h1>
        <p class="text-green-100">Browse our comprehensive range of pharmaceutical products</p>
    </div>
</div>

<!-- Products Section -->
<section class="py-12">
    <div class="container mx-auto px-6">
        <!-- Filters and Search -->
        <div class="bg-white rounded-lg shadow-md p-6 mb-8">
            <div class="flex flex-wrap justify-between items-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4 md:mb-0">Browse Products</h2>
                
                <!-- Search bar -->
                <div class="w-full md:w-auto mb-4 md:mb-0">
                    <form action="" method="GET" class="flex">
                        <input type="text" name="search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                            placeholder="Search products..." 
                            class="px-4 py-2 border border-gray-300 rounded-l focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent w-full">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-r hover:bg-green-700 transition duration-300">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Category filter -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-3">Filter by Category</h3>
                <div class="flex flex-wrap gap-2">
                    <a href="products.php" class="<?php echo !isset($_GET['category']) ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800'; ?> px-4 py-2 rounded hover:bg-green-700 hover:text-white transition duration-300">
                        All
                    </a>
                    
                    <?php
                    // Get all categories
                    $categories = get_all_categories($conn);
                    foreach ($categories as $category) {
                        $isActive = isset($_GET['category']) && $_GET['category'] == $category['id'];
                        $activeClass = $isActive ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-800';
                        echo '<a href="products.php?category=' . $category['id'] . '" class="' . $activeClass . ' px-4 py-2 rounded hover:bg-green-700 hover:text-white transition duration-300">' . $category['name'] . '</a>';
                    }
                    ?>
                </div>
            </div>
        </div>
        
        <!-- Products Grid -->
        <div id="products-container" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            // Get filter values
            $category_id = isset($_GET['category']) ? intval($_GET['category']) : null;
            $search = isset($_GET['search']) ? sanitize_input($_GET['search']) : null;
            
            // Build SQL query
            $sql = "SELECT p.*, c.name as category_name 
                    FROM products p 
                    LEFT JOIN categories c ON p.category_id = c.id 
                    WHERE p.is_active = 1";
            
            // Add category filter
            if ($category_id) {
                $sql .= " AND p.category_id = $category_id";
            }
            
            // Add search filter
            if ($search) {
                $search = $conn->real_escape_string($search);
                $sql .= " AND (p.name LIKE '%$search%' OR p.description LIKE '%$search%')";
            }
            
            // Order by featured first, then most recent
            $sql .= " ORDER BY p.is_featured DESC, p.id DESC";
            
            // Pagination
            $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
            $items_per_page = 12;
            $offset = ($page - 1) * $items_per_page;
            
            // Get total products count for pagination
            $count_result = $conn->query(str_replace("p.*, c.name as category_name", "COUNT(*) as total", $sql));
            $total_products = $count_result->fetch_assoc()['total'];
            $total_pages = ceil($total_products / $items_per_page);
            
            // Add limit for current page
            $sql .= " LIMIT $offset, $items_per_page";
            
            // Execute query
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while($product = $result->fetch_assoc()) {
                    ?>
                    <div class="product-card bg-white rounded-lg overflow-hidden shadow-md">
                        <div class="relative">
                            <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" class="w-full h-48 object-cover">
                            <?php if ($product['is_featured']): ?>
                                <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs px-2 py-1 rounded">Featured</span>
                            <?php endif; ?>
                        </div>
                        <div class="p-4">
                            <div class="text-xs text-green-600 mb-1"><?php echo $product['category_name']; ?></div>
                            <h3 class="text-xl font-semibold text-gray-800"><?php echo $product['name']; ?></h3>
                            <p class="text-gray-600 mt-2 text-sm h-12 overflow-hidden"><?php echo truncate_text($product['description'], 70); ?></p>
                            <div class="mt-4 flex justify-between items-center">
                                <span class="text-lg font-bold"><?php echo format_price($product['price']); ?></span>
                                
                                <!-- Updated Add to Cart button using data attributes instead of onclick -->
                                <button 
                                    class="add-to-cart-btn bg-green-600 hover:bg-green-700 text-white text-sm px-3 py-1 rounded transition duration-300 flex items-center"
                                    data-product-id="<?php echo $product['id']; ?>"
                                    data-product-name="<?php echo htmlspecialchars($product['name']); ?>"
                                    data-product-price="<?php echo (float)$product['price']; ?>"
                                    data-product-image="<?php echo htmlspecialchars($product['image']); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo '<div class="col-span-full text-center py-10"><p class="text-gray-600">No products found. Please try different search criteria.</p></div>';
            }
            ?>
        </div>
        
        <!-- Pagination -->
        <?php
        if ($total_pages > 1) {
            $url_params = [];
            if (isset($_GET['category'])) $url_params[] = 'category=' . $_GET['category'];
            if (isset($_GET['search'])) $url_params[] = 'search=' . urlencode($_GET['search']);
            
            $url_params = implode('&', $url_params);
            $url_pattern = 'products.php?' . ($url_params ? $url_params . '&' : '') . 'page=%d';
            
            echo generate_pagination($page, $total_pages, $url_pattern);
        }
        ?>
    </div>
</section>

<!-- Featured Categories -->
<section class="bg-gray-50 py-12">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Shop by Category</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php
            // Get the top 3 categories
            $sql = "SELECT c.*, COUNT(p.id) as product_count 
                    FROM categories c 
                    LEFT JOIN products p ON c.id = p.category_id 
                    GROUP BY c.id 
                    ORDER BY product_count DESC, c.name ASC 
                    LIMIT 3";
            
            $result = $conn->query($sql);
            
            if ($result && $result->num_rows > 0) {
                while($category = $result->fetch_assoc()) {
                    // Get a sample product image for the category
                    $image_sql = "SELECT image FROM products WHERE category_id = {$category['id']} AND is_active = 1 LIMIT 1";
                    $image_result = $conn->query($image_sql);
                    $image = 'assets/images/products/images.jpg';
                    
                    if ($image_result && $image_result->num_rows > 0) {
                        $image_row = $image_result->fetch_assoc();
                        $image = $image_row['image'];
                    }
                    ?>
                    <a href="products.php?category=<?php echo $category['id']; ?>" class="block group">
                        <div class="bg-white rounded-lg overflow-hidden shadow-md transition duration-300 transform group-hover:-translate-y-2 group-hover:shadow-xl">
                            <div class="relative">
                                <img src="<?php echo $image; ?>" alt="<?php echo $category['name']; ?>" class="w-full h-48 object-cover">
                                <div class="absolute inset-0 bg-green-700 bg-opacity-60 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <span class="text-white font-bold text-lg">Browse Category</span>
                                </div>
                            </div>
                            <div class="p-4 text-center">
                                <h3 class="text-xl font-semibold text-gray-800 mb-1"><?php echo $category['name']; ?></h3>
                                <p class="text-green-600 text-sm"><?php echo $category['product_count']; ?> Products</p>
                            </div>
                        </div>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<!-- Modified Call to Action Section -->
<section class="bg-green-100 py-12">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-gray-800 mb-4">Ready to Place Your Order?</h2>
        <p class="text-gray-600 max-w-2xl mx-auto mb-8">Add items to your cart and proceed to checkout for a hassle-free ordering experience.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="cart.php" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
                View Cart
            </a>
            <a href="/contact.php" class="bg-white hover:bg-gray-100 text-green-700 font-bold py-3 px-6 rounded-lg transition duration-300 border border-green-600">
                Need Help?
            </a>
        </div>
    </div>
</section>

<!-- Cart Notification -->
<div id="cart-notification" class="fixed top-4 right-4 p-4 rounded-md shadow-lg transition-all duration-300 transform translate-x-full bg-green-100 text-green-800 border-l-4 border-green-500 z-50"></div>

<!-- Always include cart.js (removed conditional loading) -->
<script src="assets/js/cart.js"></script>

<?php include 'includes/footer.php'; ?>