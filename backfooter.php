<style>
.admin-footer {
    background: linear-gradient(135deg, #141e30, #243b55);
    color: #fff;
    padding: 60px 0 20px 0;
    margin-top: 60px;
    position: relative;
    overflow: hidden;
}

/* Glow effect */
.admin-footer::before {
    content: "";
    position: absolute;
    width: 300px;
    height: 300px;
    background: #3498db;
    filter: blur(120px);
    top: -50px;
    left: -50px;
    opacity: 0.3;
}

/* Container */
.footer-container {
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    max-width: 1200px;
    margin: auto;
    padding: 0 20px;
    position: relative;
    z-index: 1;
}

/* Sections */
.footer-section {
    flex: 1;
    min-width: 260px;
    margin-bottom: 25px;
}

/* Logo */
.footer-section h4 {
    font-size: 26px;
    margin-bottom: 15px;
    font-weight: bold;
}

.footer-section h4 span {
    color: #00c6ff;
}

/* Headings */
.footer-section h5 {
    font-size: 18px;
    margin-bottom: 15px;
    position: relative;
}

.footer-section h5::after {
    content: "";
    width: 40px;
    height: 3px;
    background: #00c6ff;
    position: absolute;
    left: 0;
    bottom: -5px;
}

/* Links */
.footer-section ul {
    list-style: none;
    padding: 0;
}

.footer-section ul li {
    margin-bottom: 10px;
}

.footer-section ul li a {
    color: #ccc;
    text-decoration: none;
    transition: 0.3s;
}

.footer-section ul li a:hover {
    color: #00c6ff;
    padding-left: 8px;
}

/* Social Icons */
.social-icons a {
    display: inline-block;
    width: 40px;
    height: 40px;
    line-height: 40px;
    background: rgba(255,255,255,0.1);
    text-align: center;
    border-radius: 50%;
    margin-right: 10px;
    color: #fff;
    transition: 0.4s;
}

.social-icons a:hover {
    background: #00c6ff;
    transform: translateY(-5px) scale(1.1);
}

/* Bottom */
.footer-bottom {
    text-align: center;
    margin-top: 40px;
    padding-top: 20px;
    border-top: 1px solid rgba(255,255,255,0.2);
    font-size: 14px;
    color: #bbb;
}
</style>

<footer class="admin-footer">
    <div class="footer-container">

        <div class="footer-section">
            <h4>Admin<span>Pro</span></h4>
            <p>Manage your store with style, speed & control. Powerful admin panel experience.</p>
        </div>

        <div class="footer-section">
            <h5>Quick Links</h5>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="manage_products.php">Products</a></li>
                <li><a href="view_orders.php">Orders</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h5>Connect With Us</h5>
            <div class="social-icons">
                <a href="https://www.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/" target="_blank"><i class="fab fa-twitter"></i></a>
                <a href="https://www.instagram.com/"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; <?php echo date("Y"); ?> Admin Panel | Designed with ❤️</p>
    </div>
</footer>

<!-- Font Awesome (Correct CDN) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">