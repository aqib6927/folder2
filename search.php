<?php 
require_once 'config.php'; 
include 'header.php';

$results = null;
$search_term = '';

if(isset($_GET['search'])) {
    $term = mysqli_real_escape_string($conn, $_GET['search']);
    $search_term = htmlspecialchars($term);
    $results = mysqli_query($conn, "SELECT p.*, c.cat_name FROM products p LEFT JOIN categories c ON p.cat_id = c.cat_id WHERE p.prod_name LIKE '%$term%' OR p.prod_description LIKE '%$term%'");
}
?>

<style>
/* ========== SEARCH PAGE STYLES - SAME AS INDEX & PRODUCTS ========== */
.search-page {
    padding: 30px 0;
    background: #fef9f9;
    min-height: 70vh;
}

/* Search Header */
.search-header {
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    padding: 40px 0;
    border-radius: 30px;
    margin-bottom: 40px;
    color: white;
    text-align: center;
}

.search-header h2 {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 10px;
}

.search-header p {
    opacity: 0.9;
    font-size: 1rem;
}

/* Search Box Styling */
.search-wrapper {
    background: white;
    border-radius: 60px;
    padding: 5px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    max-width: 500px;
    margin: 0 auto;
}

.search-input-group {
    display: flex;
    align-items: center;
    background: white;
    border-radius: 60px;
    overflow: hidden;
}

.search-input-group input {
    flex: 1;
    border: none;
    padding: 15px 25px;
    font-size: 1rem;
    outline: none;
    background: transparent;
}

.search-input-group button {
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    border: none;
    color: white;
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    margin: 3px;
}

.search-input-group button:hover {
    transform: scale(1.02);
    box-shadow: 0 5px 15px rgba(111,66,193,0.3);
}

/* Results Header */
.results-header {
    display: flex;
    align-items: baseline;
    justify-content: space-between;
    flex-wrap: wrap;
    margin-bottom: 30px;
    padding-bottom: 15px;
    border-bottom: 2px solid #f0f0f0;
}

.results-header h3 {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a1a2e;
}

.results-header h3 span {
    color: #6f42c1;
}

.results-count {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Product Card Styling - Same as Index */
.product-card {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    height: 100%;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 35px -12px rgba(111, 66, 193, 0.2);
}

.product-img-wrapper {
    height: 200px;
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
}

.product-info {
    padding: 20px;
    text-align: center;
}

.product-title {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 10px;
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
    margin-bottom: 15px;
}

.product-price .currency {
    font-size: 0.8rem;
    font-weight: 500;
}

.search-term-highlight {
    background: #f3e8ff;
    padding: 2px 8px;
    border-radius: 20px;
    color: #6f42c1;
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

/* Empty State */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: white;
    border-radius: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.empty-state i {
    font-size: 4rem;
    color: #cbd5e1;
    margin-bottom: 20px;
}

.empty-state h4 {
    font-size: 1.5rem;
    color: #1a1a2e;
    margin-bottom: 10px;
}

.empty-state p {
    color: #6c757d;
    margin-bottom: 25px;
}

.empty-state .btn-shop {
    background: linear-gradient(135deg, #6f42c1, #8b5cf6);
    color: white;
    padding: 12px 30px;
    border-radius: 40px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    display: inline-block;
}

.empty-state .btn-shop:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(111,66,193,0.3);
}

/* Scroll reveal animation */
.scroll-animate {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.scroll-animate.revealed {
    opacity: 1;
    transform: translateY(0);
}

/* Responsive */
@media (max-width: 768px) {
    .search-header {
        padding: 25px 0;
        border-radius: 20px;
    }
    .search-header h2 {
        font-size: 1.5rem;
    }
    .search-input-group input {
        padding: 12px 18px;
        font-size: 0.9rem;
    }
    .search-input-group button {
        padding: 12px 20px;
    }
    .results-header h3 {
        font-size: 1.2rem;
    }
    .product-img-wrapper {
        height: 160px;
    }
    .product-title {
        font-size: 0.9rem;
    }
    .product-price {
        font-size: 1.1rem;
    }
}
</style>

<div class="search-page">
    <div class="container">
        
        <!-- Search Header -->
        <div class="search-header">
            <div class="container">
                <h2><i class="fas fa-search me-2"></i> Find Your Perfect Product</h2>
                <p>Search from our wide range of cosmetics & imitation jewelry</p>
                
                <div class="search-wrapper">
                    <form method="GET" class="search-input-group">
                        <input type="text" name="search" placeholder="Search by product name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" autocomplete="off">
                        <button type="submit"><i class="fas fa-search me-2"></i> Search</button>
                    </form>
                </div>
            </div>
        </div>

        <?php if(isset($_GET['search'])): 
            $result_count = ($results && mysqli_num_rows($results) > 0) ? mysqli_num_rows($results) : 0;
        ?>
            <!-- Results Header -->
            <div class="results-header">
                <h3>
                    Search Results for 
                    <span class="search-term-highlight">
                        <i class="fas fa-quote-left me-1"></i><?php echo $search_term; ?><i class="fas fa-quote-right ms-1"></i>
                    </span>
                </h3>
                <div class="results-count">
                    <i class="fas fa-box me-1"></i> <?php echo $result_count; ?> product<?php echo ($result_count != 1) ? 's' : ''; ?> found
                </div>
            </div>

            <!-- Results Grid -->
            <div class="row g-4">
                <?php if($results && mysqli_num_rows($results) > 0): 
                    $counter = 0;
                    while($product = mysqli_fetch_assoc($results)): 
                        $counter++;
                ?>
                <div class="col-md-6 col-lg-3 scroll-animate" data-delay="<?php echo $counter * 0.05; ?>">
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
                                <span class="product-badge">🔥 Limited Stock</span>
                            <?php elseif($product['quantity'] > 0): ?>
                                <span class="product-badge">✨ Available</span>
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
                                <span class="rating-count">(89)</span>
                            </div>
                            
                            <!-- Price -->
                            <div class="product-price">
                                <?php echo number_format($product['price'], 2); ?> <span class="currency">rs</span>
                            </div>
                            
                            <?php if(isLoggedIn() && $product['quantity'] > 0): ?>
                            <form method="POST" action="add_to_cart.php">
                                <input type="hidden" name="prod_id" value="<?php echo $product['prod_id']; ?>">
                                <input type="hidden" name="quantity" value="1">
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
                <?php endwhile; else: ?>
                <div class="col-12">
                    <div class="empty-state">
                        <i class="fas fa-search"></i>
                        <h4>No products found</h4>
                        <p>We couldn't find any products matching "<strong><?php echo $search_term; ?></strong>"</p>
                        <a href="products.php" class="btn-shop">
                            <i class="fas fa-shopping-bag me-2"></i> Browse All Products
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
        
        <!-- If no search performed yet - Show suggestions -->
        <?php if(!isset($_GET['search'])): ?>
        <div class="empty-state" style="margin-top: 20px;">
            <i class="fas fa-arrow-up"></i>
            <h4>Start Searching</h4>
            <p>Type a product name above to find what you're looking for!</p>
            <div class="mt-3">
                <span class="badge bg-light text-dark p-2 m-1">💄 Lipstick</span>
                <span class="badge bg-light text-dark p-2 m-1">💎 Jewelry</span>
                <span class="badge bg-light text-dark p-2 m-1">✨ Foundation</span>
                <span class="badge bg-light text-dark p-2 m-1">💅 Nail Polish</span>
                <span class="badge bg-light text-dark p-2 m-1">👄 Lip Gloss</span>
            </div>
        </div>
        <?php endif; ?>
        
    </div>
</div>

<script>
// Scroll reveal animation
document.addEventListener('DOMContentLoaded', function() {
    const revealElements = document.querySelectorAll('.scroll-animate');
    
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