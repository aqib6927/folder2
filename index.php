<?php 
require_once 'config.php'; 
include 'header.php'; 
?>

<style>
/* ========== GAP FIX - Header aur Marquee ke beech ka gap hatane ke liye ========== */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body, html {
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* Header ke saare possible classes se margin hatao */
header, 
.navbar, 
.site-header, 
.main-header, 
.header-section,
nav,
[class*="header"],
[class*="Header"] {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
    border-bottom: none !important;
}

/* Container gaps remove */
.container, 
.container-fluid,
[class*="container"] {
    padding-top: 0 !important;
    margin-top: 0 !important;
}

/* Hero section se pehle koi gap nahi hona chahiye */
.hero {
    margin-top: 0 !important;
    padding-top: 100px !important;
}
</style>

<!-- Stock Market Style Ticker - Gap Free -->
<div class="ticker-wrap">
    <div class="ticker">
        <div class="ticker__item">
            <span class="ticker-icon">🔥</span> HOT DEAL: Lipstick Rs. 299 only!
        </div>
        <div class="ticker__item">
            <span class="ticker-icon">💎</span> Premium Foundation - 40% OFF
        </div>
        <div class="ticker__item">
            <span class="ticker-icon">🚚</span> Free Delivery on Rs. 2000+
        </div>
        <div class="ticker__item">
            <span class="ticker-icon">✨</span> New Arrivals: Imitation Jewelry
        </div>
        <div class="ticker__item">
            <span class="ticker-icon">🎁</span> Gift with every purchase
        </div>
        <div class="ticker__item">
            <span class="ticker-icon">💄</span> Buy 1 Get 1 on Mascara
        </div>
    </div>
</div>

<style>
.ticker-wrap {
    width: 100%;
    overflow: hidden;
    background: linear-gradient(90deg, #6f42c1, #8b5cf6, #6f42c1);
    padding: 10px 0;
    position: relative;
    margin-top: 0 !important;  /* Gap fix */
    top: 0;
}

.ticker {
    display: inline-block;
    white-space: nowrap;
    animation: ticker 25s linear infinite;
}

.ticker__item {
    display: inline-block;
    padding: 0 30px;
    color: white;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0.5px;
}

.ticker-icon {
    margin-right: 8px;
    font-size: 16px;
}

@keyframes ticker {
    0% {
        transform: translateX(0);
    }
    100% {
        transform: translateX(-50%);
    }
}

.ticker-wrap:hover .ticker {
    animation-play-state: paused;
}

/* Gradient edges */
.ticker-wrap::before,
.ticker-wrap::after {
    content: '';
    position: absolute;
    top: 0;
    bottom: 0;
    width: 50px;
    z-index: 1;
    pointer-events: none;
}

.ticker-wrap::before {
    left: 0;
    background: linear-gradient(90deg, #6f42c1, transparent);
}

.ticker-wrap::after {
    right: 0;
    background: linear-gradient(270deg, #6f42c1, transparent);
}

/* Responsive */
@media (max-width: 768px) {
    .ticker-wrap {
        padding: 8px 0;
    }
    .ticker__item {
        padding: 0 15px;
        font-size: 11px;
    }
    .ticker-icon {
        font-size: 12px;
    }
}
</style>

<!-- Hero Section -->
<div class="hero" style="background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('images/hero-bg.jpg'); background-size: cover; padding: 100px 0; color: white; text-align: center; margin-top: 0;">
    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to Jenny's Store</h1>
        <p class="lead">Discover premium cosmetics & exquisite imitation jewelry</p>
        <div class="mt-4">
            <a href="products.php" class="btn btn-primary btn-lg px-4 me-2" style="background: #6f42c1; border: none;">Shop Now <i class="fas fa-arrow-right ms-2"></i></a>
            <a href="register.php" class="btn btn-outline-light btn-lg px-4">Get 10% OFF</a>
        </div>
    </div>
</div>

<!-- Categories Section - Premium Design -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold" style="font-size: 2.5rem;">Shop by Category</h2>
        <p class="text-muted" style="font-size: 1.1rem;">Explore our curated collections</p>
    </div>
    
    <div class="row g-4">
        <?php
        // Define icons and colors for different categories
        $category_styles = [
            1 => ['icon' => 'fa-magic', 'color' => '#6f42c1', 'bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'],
            2 => ['icon' => 'fa-gem', 'color' => '#e83e8c', 'bg' => 'linear-gradient(135deg, #f093fb 0%, #f5576c 100%)'],
            3 => ['icon' => 'fa-leaf', 'color' => '#20c997', 'bg' => 'linear-gradient(135deg, #43e97b 0%, #38f9d7 100%)'],
        ];
        
        $categories = mysqli_query($conn, "SELECT * FROM categories");
        $cat_index = 1;
        while($cat = mysqli_fetch_assoc($categories)):
            $style = $category_styles[$cat_index] ?? ['icon' => 'fa-tag', 'color' => '#6f42c1', 'bg' => 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)'];
        ?>
        <div class="col-md-4 col-sm-6 category-col" data-cat-id="<?php echo $cat['cat_id']; ?>">
            <div class="category-card" onclick="location.href='products.php?cat_id=<?php echo $cat['cat_id']; ?>'">
                <div class="category-bg" style="background: <?php echo $style['bg']; ?>;"></div>
                <div class="category-content">
                    <div class="category-icon">
                        <i class="fas <?php echo $style['icon']; ?>"></i>
                    </div>
                    <h3 class="category-title"><?php echo $cat['cat_name']; ?></h3>
                    <p class="category-desc"><?php echo substr($cat['cat_description'], 0, 50); ?></p>
                    <div class="category-stats">
                        <?php
                        $cat_id = $cat['cat_id'];
                        $count_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM products WHERE cat_id = '$cat_id'");
                        $count_data = mysqli_fetch_assoc($count_query);
                        ?>
                        <span class="product-count"><?php echo $count_data['total']; ?>+ Products</span>
                    </div>
                    <div class="category-btn">
                        <span>Browse Collection</span>
                        <i class="fas fa-arrow-right"></i>
                    </div>
                </div>
                <div class="category-overlay"></div>
            </div>
        </div>
        <?php 
        $cat_index++;
        endwhile; 
        ?>
    </div>
</div>

<!-- Featured Products Section -->
<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold" style="font-size: 2.5rem;">Featured Products</h2>
        <p class="text-muted" style="font-size: 1.1rem;">Handpicked just for you — <span style="color: #6f42c1;">✨ scroll to discover</span></p>
    </div>
    
    <div class="row g-4">
        <?php
        $products = mysqli_query($conn, "SELECT p.*, c.cat_name FROM products p LEFT JOIN categories c ON p.cat_id = c.cat_id LIMIT 8");
        $counter = 0;
        while($product = mysqli_fetch_assoc($products)):
            $counter++;
            $animationClass = ($counter % 2 == 0) ? 'slide-from-right' : 'slide-from-left';
        ?>
        <div class="col-md-3 mb-4 scroll-animate <?php echo $animationClass; ?>">
            <div class="card h-100 shadow-sm border-0 product-card" style="border-radius: 20px; overflow: hidden; transition: all 0.3s ease;">
                
                <div class="product-img-wrapper" style="height: 220px; background: linear-gradient(145deg, #faf5ff 0%, #f3e8ff 100%); display: flex; align-items: center; justify-content: center; padding: 20px; position: relative; overflow: hidden;">
                    <?php if(!empty($product['image'])): ?>
                        <img src="images/<?php echo $product['image']; ?>" class="product-img" style="max-height: 100%; max-width: 100%; object-fit: contain; transition: transform 0.5s ease;" alt="Product Image">
                    <?php else: ?>
                        <div class="text-muted small text-center">
                            <i class="fas fa-box-open fa-3x mb-2"></i><br>No Image
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-body text-center" style="padding: 1.25rem;">
                    <h5 class="card-title fw-bold" style="font-size: 1.1rem; margin-bottom: 0.75rem; color: #1a1a2e;"><?php echo $product['prod_name']; ?></h5>
                    
                    <div class="mb-2">
                        <i class="fas fa-star text-warning" style="font-size: 0.7rem;"></i>
                        <i class="fas fa-star text-warning" style="font-size: 0.7rem;"></i>
                        <i class="fas fa-star text-warning" style="font-size: 0.7rem;"></i>
                        <i class="fas fa-star text-warning" style="font-size: 0.7rem;"></i>
                        <i class="fas fa-star-half-alt text-warning" style="font-size: 0.7rem;"></i>
                        <span class="text-muted" style="font-size: 0.7rem;"> (24)</span>
                    </div>
                    
                    <h5 class="text-danger fw-bold" style="font-size: 1.4rem;"><?php echo number_format($product['price'], 2); ?> <span style="font-size: 0.8rem;">rs</span></h5>
                    
                    <?php if(isLoggedIn() && $product['quantity'] > 0): ?>
                    <form method="POST" action="add_to_cart.php" class="mt-3">
                        <input type="hidden" name="prod_id" value="<?php echo $product['prod_id']; ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" name="add_to_cart" class="btn w-100 add-to-cart-btn" style="background: linear-gradient(135deg, #6f42c1, #8b5cf6); border: none; border-radius: 40px; color: white; font-weight: 600; padding: 10px; transition: all 0.3s ease;">
                            <i class="fas fa-shopping-cart me-1"></i> Add to Cart
                        </button>
                    </form>
                    <?php elseif(!isLoggedIn()): ?>
                    <a href="login.php" class="btn btn-outline-primary w-100 mt-3" style="border-radius: 40px; border: 1.5px solid #6f42c1; color: #6f42c1; font-weight: 600; padding: 10px; transition: all 0.3s ease;">
                        <i class="fas fa-lock me-1"></i> Login to Buy
                    </a>
                    <?php else: ?>
                    <button class="btn btn-secondary w-100 mt-3" disabled style="border-radius: 40px; background: #e9ecef; border: none; color: #6c757d; font-weight: 600; padding: 10px;">
                        <i class="fas fa-times-circle me-1"></i> Out of Stock
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
    
    <div class="text-center mt-5">
        <a href="products.php" class="btn btn-dark btn-lg px-5" style="border-radius: 30px; transition: all 0.3s ease;">Explore All Products <i class="fas fa-arrow-right ms-2"></i></a>
    </div>
</div>

<style>
/* ========== CATEGORY CARDS - PREMIUM DESIGN ========== */
.category-col {
    cursor: pointer;
}

.category-card {
    position: relative;
    border-radius: 24px;
    overflow: hidden;
    height: 320px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.category-card:hover {
    transform: translateY(-12px);
    box-shadow: 0 25px 45px rgba(0,0,0,0.2);
}

.category-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 0;
    transition: transform 0.5s ease;
}

.category-card:hover .category-bg {
    transform: scale(1.05);
}

.category-content {
    position: relative;
    z-index: 2;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding: 30px;
    color: white;
}

.category-icon {
    width: 80px;
    height: 80px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 20px;
    backdrop-filter: blur(5px);
    transition: all 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1);
    background: rgba(255,255,255,0.3);
}

.category-icon i {
    font-size: 40px;
    color: white;
}

.category-title {
    font-size: 1.8rem;
    font-weight: 800;
    margin-bottom: 12px;
    letter-spacing: -0.5px;
}

.category-desc {
    font-size: 0.9rem;
    opacity: 0.9;
    margin-bottom: 20px;
    max-width: 80%;
}

.category-stats {
    margin-bottom: 25px;
}

.product-count {
    background: rgba(255,255,255,0.2);
    padding: 5px 15px;
    border-radius: 30px;
    font-size: 0.8rem;
    font-weight: 600;
    backdrop-filter: blur(4px);
}

.category-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    background: white;
    color: #333;
    padding: 10px 25px;
    border-radius: 40px;
    font-weight: 600;
    font-size: 0.9rem;
    transition: all 0.3s ease;
    text-decoration: none;
}

.category-card:hover .category-btn {
    gap: 15px;
    padding: 10px 30px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.category-btn i {
    transition: transform 0.3s ease;
}

.category-card:hover .category-btn i {
    transform: translateX(5px);
}

.category-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(to bottom, rgba(0,0,0,0.2), rgba(0,0,0,0.4));
    z-index: 1;
}

/* Category entrance animation */
.category-col {
    opacity: 0;
    transform: translateY(30px);
    animation: fadeInUp 0.6s forwards;
}

.category-col:nth-child(1) { animation-delay: 0.1s; }
.category-col:nth-child(2) { animation-delay: 0.2s; }
.category-col:nth-child(3) { animation-delay: 0.3s; }

@keyframes fadeInUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* ========== PRODUCT SIDE SCROLL ANIMATIONS ========== */
.scroll-animate {
    opacity: 0;
    transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    will-change: transform, opacity;
}

.scroll-animate.slide-from-left {
    transform: translateX(-60px);
}

.scroll-animate.slide-from-right {
    transform: translateX(60px);
}

.scroll-animate.animated {
    opacity: 1;
    transform: translateX(0);
}

/* Staggered animation */
.col-md-3:nth-child(1).scroll-animate.animated { transition-delay: 0.05s; }
.col-md-3:nth-child(2).scroll-animate.animated { transition-delay: 0.1s; }
.col-md-3:nth-child(3).scroll-animate.animated { transition-delay: 0.15s; }
.col-md-3:nth-child(4).scroll-animate.animated { transition-delay: 0.2s; }
.col-md-3:nth-child(5).scroll-animate.animated { transition-delay: 0.25s; }
.col-md-3:nth-child(6).scroll-animate.animated { transition-delay: 0.3s; }
.col-md-3:nth-child(7).scroll-animate.animated { transition-delay: 0.35s; }
.col-md-3:nth-child(8).scroll-animate.animated { transition-delay: 0.4s; }

/* ========== PRODUCT CARD STYLES ========== */
.product-card {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 25px 35px -12px rgba(111, 66, 193, 0.25) !important;
}

.product-img-wrapper {
    position: relative;
    overflow: hidden;
}

.product-card:hover .product-img {
    transform: scale(1.1);
}

.add-to-cart-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(111, 66, 193, 0.35);
    background: linear-gradient(135deg, #5a32a3, #7c3aed) !important;
}

.btn-outline-primary:hover {
    background: #6f42c1 !important;
    border-color: #6f42c1 !important;
    color: white !important;
}

/* ========== EXTRA GAP FIXES ========== */
/* Ensure no margin on body and first elements */
body > :first-child,
body > :first-child > :first-child {
    margin-top: 0 !important;
    padding-top: 0 !important;
}

/* Remove any unexpected margins */
h1, h2, h3, h4, h5, h6, p, div {
    margin-top: 0;
}

/* Responsive */
@media (max-width: 768px) {
    .category-card {
        height: 280px;
    }
    .category-title {
        font-size: 1.5rem;
    }
    .category-icon {
        width: 60px;
        height: 60px;
    }
    .category-icon i {
        font-size: 30px;
    }
    .scroll-animate.slide-from-left,
    .scroll-animate.slide-from-right {
        transform: translateY(30px);
    }
}
</style>

<script>
// Intersection Observer for scroll animations
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.scroll-animate');
    
    const observerOptions = {
        threshold: 0.2,
        rootMargin: '0px 0px -30px 0px'
    };
    
    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);
    
    animatedElements.forEach(element => {
        observer.observe(element);
    });
    
    // Add hover effect for product cards
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        card.addEventListener('click', function(e) {
            if(e.target.tagName === 'BUTTON' || 
               e.target.tagName === 'A' || 
               e.target.closest('form')) {
                return;
            }
            const productName = this.querySelector('.card-title').innerText;
            console.log('View product:', productName);
        });
    });
});
</script>

<?php include 'footer.php'; ?>