<?php 
require_once 'config.php'; 
include 'header.php';

$cat_filter = isset($_GET['cat_id']) ? "WHERE p.cat_id = " . intval($_GET['cat_id']) : "";
$search = isset($_GET['search']) ? "WHERE p.prod_name LIKE '%" . mysqli_real_escape_string($conn, $_GET['search']) . "%'" : $cat_filter;
$query = "SELECT p.*, c.cat_name FROM products p LEFT JOIN categories c ON p.cat_id = c.cat_id $search ORDER BY p.prod_id DESC";
$result = mysqli_query($conn, $query);
?>

<style>
/* ========== PRODUCTS PAGE STYLES - SAME AS INDEX ========== */
.products-page {
    padding: 30px 0;
    background: #fef9f9;
}

/* Sidebar Categories Styling */
.categories-sidebar {
    position: sticky;
    top: 100px;
}

.category-card-sidebar {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
}

.category-card-sidebar .card-header {
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    padding: 15px 20px;
    border: none;
}

.category-card-sidebar .card-header h5 {
    margin: 0;
    color: white;
    font-weight: 600;
}

.category-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.category-list li {
    border-bottom: 1px solid #f0f0f0;
}

.category-list li:last-child {
    border-bottom: none;
}

.category-list a {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 12px 20px;
    color: #333;
    text-decoration: none;
    transition: all 0.3s ease;
    font-weight: 500;
}

.category-list a i {
    color: #6f42c1;
    font-size: 14px;
    opacity: 0;
    transition: all 0.3s ease;
}

.category-list a:hover {
    background: linear-gradient(135deg, #f3e8ff, #faf5ff);
    color: #6f42c1;
    padding-left: 25px;
}

.category-list a:hover i {
    opacity: 1;
    transform: translateX(5px);
}

.category-list a.active {
    background: linear-gradient(135deg, #f3e8ff, #faf5ff);
    color: #6f42c1;
    font-weight: 600;
}

/* Product Card Styling - Same as Index */
.product-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    height: 100%;
    position: relative;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 35px -12px rgba(111, 66, 193, 0.2);
}

.product-img-wrapper {
    height: 220px;
    background: linear-gradient(145deg, #faf5ff 0%, #f3e8ff 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    position: relative;
    overflow: hidden;
}

.product-img {
    max-height: 100%;
    max-width: 100%;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.product-card:hover .product-img {
    transform: scale(1.08);
}

.product-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    color: white;
    font-size: 0.7rem;
    font-weight: bold;
    padding: 4px 12px;
    border-radius: 30px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.product-info {
    padding: 20px;
    text-align: center;
}

.product-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: #1a1a2e;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.product-rating {
    margin-bottom: 10px;
}

.product-rating i {
    font-size: 0.7rem;
    margin: 0 1px;
}

.rating-count {
    font-size: 0.7rem;
    color: #999;
    margin-left: 5px;
}

.product-price {
    font-size: 1.3rem;
    font-weight: 800;
    color: #dc2626;
    margin-bottom: 10px;
}

.product-price .currency {
    font-size: 0.8rem;
    font-weight: 500;
}

.stock-badge {
    display: inline-block;
    padding: 3px 10px;
    border-radius: 30px;
    font-size: 0.7rem;
    font-weight: 600;
    margin-bottom: 12px;
}

.stock-in {
    background: #d1fae5;
    color: #059669;
}

.stock-low {
    background: #fed7aa;
    color: #ea580c;
}

.stock-out {
    background: #fee2e2;
    color: #dc2626;
}

.add-to-cart-btn {
    width: 100%;
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    border: none;
    color: white;
    padding: 10px 0;
    border-radius: 40px;
    font-weight: 600;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.add-to-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(111, 66, 193, 0.3);
    background: linear-gradient(135deg, #5a32a3, #7c3aed);
}

.btn-login-to-buy {
    display: block;
    width: 100%;
    background: transparent;
    border: 1.5px solid #6f42c1;
    color: #6f42c1;
    padding: 8px 0;
    border-radius: 40px;
    font-weight: 600;
    font-size: 0.85rem;
    text-align: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-login-to-buy:hover {
    background: #6f42c1;
    color: white;
    text-decoration: none;
}

.btn-out-of-stock {
    width: 100%;
    background: #e9ecef;
    border: none;
    color: #6c757d;
    padding: 10px 0;
    border-radius: 40px;
    font-weight: 600;
    font-size: 0.85rem;
    cursor: not-allowed;
}

.quantity-input-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    margin-bottom: 12px;
}

.quantity-input {
    width: 70px;
    text-align: center;
    border: 1px solid #e5e7eb;
    border-radius: 40px;
    padding: 6px;
    font-size: 0.85rem;
}

/* Scroll reveal animation */
.scroll-animate-prod {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-animate-prod.revealed {
    opacity: 1;
    transform: translateY(0);
}

/* Page Title */
.page-title {
    font-size: 2rem;
    font-weight: 800;
    color: #1a1a2e;
    margin-bottom: 5px;
}

.page-subtitle {
    color: #6c757d;
    margin-bottom: 25px;
}

/* Responsive */
@media (max-width: 768px) {
    .products-page {
        padding: 15px 0;
    }
    .product-img-wrapper {
        height: 180px;
    }
    .product-title {
        font-size: 0.9rem;
    }
    .product-price {
        font-size: 1.1rem;
    }
}
</style>

<div class="products-page">
    <div class="container">
        
        <!-- Page Header -->
        <div class="text-center mb-4">
            <h2 class="page-title">✨ Our Premium Collection</h2>
            <p class="page-subtitle">Discover the finest cosmetics & imitation jewelry</p>
        </div>

        <div class="row">
            <!-- Sidebar: Categories -->
            <div class="col-md-3 mb-4">
                <div class="categories-sidebar">
                    <div class="category-card-sidebar">
                        <div class="card-header">
                            <h5><i class="fas fa-list me-2"></i> Categories</h5>
                        </div>
                        <ul class="category-list">
                            <li>
                                <a href="products.php" class="<?php echo (!isset($_GET['cat_id']) && !isset($_GET['search'])) ? 'active' : ''; ?>">
                                    All Products <i class="fas fa-arrow-right"></i>
                                </a>
                            </li>
                            <?php 
                            $cats = mysqli_query($conn, "SELECT * FROM categories");
                            while($cat = mysqli_fetch_assoc($cats)): 
                                $active = (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat['cat_id']) ? 'active' : '';
                            ?>
                            <li>
                                <a href="products.php?cat_id=<?php echo $cat['cat_id']; ?>" class="<?php echo $active; ?>">
                                    <?php echo $cat['cat_name']; ?> <i class="fas fa-arrow-right"></i>
                                </a>
                            </li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Section: Products -->
            <div class="col-md-9">
                <?php if(mysqli_num_rows($result) > 0): ?>
                    <div class="row g-4">
                        <?php 
                        $counter = 0;
                        while($product = mysqli_fetch_assoc($result)): 
                            $counter++;
                            // Stock status
                            $stock_class = '';
                            $stock_text = '';
                            if($product['quantity'] > 10) {
                                $stock_class = 'stock-in';
                                $stock_text = 'In Stock';
                            } elseif($product['quantity'] > 0) {
                                $stock_class = 'stock-low';
                                $stock_text = 'Low Stock';
                            } else {
                                $stock_class = 'stock-out';
                                $stock_text = 'Out of Stock';
                            }
                        ?>
                        <div class="col-md-6 col-lg-4 scroll-animate-prod" data-delay="<?php echo $counter * 0.05; ?>">
                            <div class="product-card">
                                
                                <!-- Product Image -->
                                <div class="product-img-wrapper">
                                    <?php if(!empty($product['image'])): ?>
                                        <img src="images/<?php echo $product['image']; ?>" class="product-img" alt="Product Image">
                                    <?php else: ?>
                                        <div class="text-muted small text-center">
                                            <i class="fas fa-box-open fa-3x mb-2"></i><br>No Image
                                        </div>
                                    <?php endif; ?>
                                    <?php if($product['quantity'] > 0 && $product['quantity'] <= 5): ?>
                                        <span class="product-badge">🔥 Almost Gone</span>
                                    <?php elseif($product['quantity'] > 0): ?>
                                        <span class="product-badge">✨ New</span>
                                    <?php endif; ?>
                                </div>

                                <div class="product-info">
                                    <h5 class="product-title"><?php echo $product['prod_name']; ?></h5>
                                    
                                    <!-- Rating Stars -->
                                    <div class="product-rating">
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star text-warning"></i>
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                        <span class="rating-count">(128)</span>
                                    </div>
                                    
                                    <!-- Price -->
                                    <div class="product-price">
                                        <?php echo number_format($product['price'], 2); ?> <span class="currency">rs</span>
                                    </div>
                                    
                                    <!-- Stock Badge -->
                                    <div class="stock-badge <?php echo $stock_class; ?>">
                                        <i class="fas <?php echo ($product['quantity'] > 0) ? 'fa-check-circle' : 'fa-times-circle'; ?> me-1"></i>
                                        <?php echo $stock_text; ?> (<?php echo $product['quantity']; ?>)
                                    </div>
                                    
                                    <?php if(isLoggedIn() && $product['quantity'] > 0): ?>
                                    <form method="POST" action="add_to_cart.php">
                                        <input type="hidden" name="prod_id" value="<?php echo $product['prod_id']; ?>">
                                        <div class="quantity-input-wrapper">
                                            <input type="number" name="quantity" value="1" min="1" max="<?php echo $product['quantity']; ?>" class="quantity-input">
                                        </div>
                                        <button type="submit" name="add_to_cart" class="add-to-cart-btn">
                                            <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                                        </button>
                                    </form>
                                    <?php elseif(!isLoggedIn()): ?>
                                    <a href="login.php" class="btn-login-to-buy">
                                        <i class="fas fa-lock me-1"></i> Login to Buy
                                    </a>
                                    <?php else: ?>
                                    <button class="btn-out-of-stock" disabled>
                                        <i class="fas fa-times-circle me-1"></i> Out of Stock
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No products found</h4>
                        <p class="text-muted">Try a different category or check back later!</p>
                        <a href="products.php" class="btn btn-primary-custom mt-3">View All Products</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
// Scroll reveal animation for products
document.addEventListener('DOMContentLoaded', function() {
    const revealElements = document.querySelectorAll('.scroll-animate-prod');
    
    const observerOptions = {
        threshold: 0.15,
        rootMargin: '0px 0px -20px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const delay = entry.target.getAttribute('data-delay') || 0;
                entry.target.style.transitionDelay = delay + 's';
                entry.target.classList.add('revealed');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    revealElements.forEach(element => {
        observer.observe(element);
    });
});
</script>

<?php include 'footer.php'; ?>