<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenny's Cosmetics & Imitation Jewelry</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #fef9f9;
            padding-top: 76px; /* Exact navbar height */
        }

        /* Navbar Styling */
        .navbar {
            background: linear-gradient(135deg, #2d1b4e, #1a1a2e);
            padding: 15px 0;
            box-shadow: 0 2px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-size: 28px;
            font-weight: bold;
            color: #ff6b6b !important;
            transition: 0.3s;
        }

        .navbar-brand:hover {
            transform: scale(1.02);
            color: #ff8787 !important;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            transition: 0.3s;
            position: relative;
        }

        .nav-link:hover {
            color: #ff6b6b !important;
            transform: translateY(-2px);
        }

        /* Active link indicator */
        .nav-link.active {
            color: #ff6b6b !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 50%;
            transform: translateX(-50%);
            width: 30px;
            height: 2px;
            background: #ff6b6b;
            border-radius: 2px;
        }

        /* Mobile toggler */
        .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
            background: transparent;
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: none;
        }

        .navbar-toggler-icon {
            filter: invert(1);
        }

        /* Dropdown Menu Styling */
        .dropdown-menu {
            background: #1a1a2e;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-top: 10px;
        }

        .dropdown-item {
            color: white;
            padding: 10px 20px;
            transition: 0.3s;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #2d1b4e, #1a1a2e);
            color: #ff6b6b;
            transform: translateX(5px);
        }

        /* Cart Badge */
        .cart-badge {
            position: absolute;
            top: -8px;
            right: -12px;
            background: linear-gradient(135deg, #ff6b6b, #ff8787);
            color: white;
            border-radius: 50%;
            padding: 2px 7px;
            font-size: 10px;
            font-weight: bold;
            min-width: 18px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.1);
            }
        }

        /* Messages Container */
        .message-container {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .alert {
            border-radius: 12px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        /* Hero Section Styling */
        .hero {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 80px 0;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="rgba(255,255,255,0.05)" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') repeat-x bottom;
            background-size: cover;
            opacity: 0.3;
            pointer-events: none;
        }

        .hero h1 {
            font-size: 56px;
            font-weight: 800;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease;
        }

        .hero p {
            font-size: 20px;
            margin-bottom: 30px;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        .hero .btn-group {
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Product Card */
        .product-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            margin-bottom: 30px;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .product-body {
            padding: 20px;
        }

        .product-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 24px;
            font-weight: bold;
            color: #ff6b6b;
        }

        .product-price small {
            font-size: 14px;
            color: #999;
        }

        /* Custom Buttons */
        .btn-primary-custom {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 30px;
            transition: 0.3s;
            font-weight: 600;
        }

        .btn-primary-custom:hover {
            transform: scale(1.05);
            background: linear-gradient(135deg, #764ba2, #667eea);
            color: white;
            box-shadow: 0 10px 20px rgba(102,126,234,0.3);
        }

        .btn-outline-light-custom {
            background: transparent;
            border: 2px solid white;
            color: white;
            padding: 12px 30px;
            border-radius: 30px;
            transition: 0.3s;
            font-weight: 600;
        }

        .btn-outline-light-custom:hover {
            background: white;
            color: #764ba2;
            transform: scale(1.05);
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #1a1a2e, #2d1b4e);
            color: white;
            padding: 50px 0 20px;
            margin-top: 50px;
        }

        .footer h5 {
            margin-bottom: 20px;
            font-weight: 600;
        }

        .footer a {
            color: #ccc;
            text-decoration: none;
            transition: 0.3s;
        }

        .footer a:hover {
            color: #ff6b6b;
            transform: translateX(5px);
            display: inline-block;
        }

        .footer .social-icons a {
            display: inline-block;
            margin: 0 10px;
            font-size: 20px;
        }

        .footer .social-icons a:hover {
            transform: translateY(-3px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding-top: 65px;
            }
            .navbar {
                padding: 10px 0;
            }
            .navbar-brand {
                font-size: 22px;
            }
            .hero h1 {
                font-size: 32px;
            }
            .hero p {
                font-size: 16px;
            }
            .hero {
                padding: 50px 0;
            }
            .btn-primary-custom, .btn-outline-light-custom {
                padding: 8px 20px;
                font-size: 14px;
            }
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
        }
    </style>

    <script>
        // Set active nav link based on current page
        document.addEventListener('DOMContentLoaded', function() {
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                if(href === currentPage || (currentPage === '' && href === 'index.php')) {
                    link.classList.add('active');
                }
            });
        });
    </script>
</head>

<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <i class="fas fa-gem"></i> Jenny's Store
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="products.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>

                <?php if(isset($_SESSION['user_id']) && isAdmin()): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Admin Panel</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="admin/dashboard.php"><i class="fas fa-chart-line me-2"></i> Dashboard</a></li>
                        <li><a class="dropdown-item" href="admin/products.php"><i class="fas fa-box me-2"></i> Manage Products</a></li>
                        <li><a class="dropdown-item" href="admin/categories.php"><i class="fas fa-tags me-2"></i> Manage Categories</a></li>
                        <li><a class="dropdown-item" href="admin/users.php"><i class="fas fa-users me-2"></i> Manage Users</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="admin/reports.php"><i class="fas fa-chart-bar me-2"></i> Reports</a></li>
                        <li><a class="dropdown-item" href="admin/backup.php"><i class="fas fa-database me-2"></i> Backup DB</a></li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>

            <ul class="navbar-nav">
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item position-relative">
                    <a class="nav-link" href="cart.php">
                        <i class="fas fa-shopping-cart"></i> Cart
                        <span class="cart-badge">
                            <?php echo getCartCount($_SESSION['user_id']); ?>
                        </span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="my_orders.php">
                        <i class="fas fa-receipt"></i> Orders
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="logout.php">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>

                <?php else: ?>

                <li class="nav-item">
                    <a class="nav-link" href="login.php">
                        <i class="fas fa-sign-in-alt"></i> Login
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="register.php">
                        <i class="fas fa-user-plus"></i> Register
                    </a>
                </li>

                <?php endif; ?>
            </ul>

        </div>
    </div>
</nav>

<!-- Messages Container -->
<div class="container message-container">
    <?php displayMessage(); ?>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>