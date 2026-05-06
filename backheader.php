<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jenny's Store | Elite Admin Panel</title>
    
    <!-- Font Awesome 6 (Professional Icons) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Google Fonts: Inter + Playfair Display for VIP Feel -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f0f2f8;
            font-family: 'Inter', sans-serif;
        }

        /* VIP Premium Color Palette */
        :root {
            --primary-dark: #0a0c15;
            --primary-gold: #c9a03d;
            --primary-gold-light: #e6c87a;
            --primary-glow: rgba(201, 160, 61, 0.3);
            --secondary-bg: #11131f;
            --card-bg: #ffffff;
            --text-light: #eef2ff;
            --text-muted: #a0a8c0;
            --border-glow: rgba(201, 160, 61, 0.4);
            --shadow-premium: 0 20px 35px -12px rgba(0, 0, 0, 0.25);
            --transition-smooth: all 0.25s cubic-bezier(0.2, 0.9, 0.4, 1.1);
        }

        /* --- GLASS MORPHISM HEADER (VIP STYLE) --- */
        .admin-header {
            background: rgba(10, 12, 21, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 2px solid var(--primary-gold);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 0.75rem 2rem;
        }

        .header-container {
            max-width: 1600px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        /* --- ELITE LOGO with shimmer effect --- */
        .vip-logo a {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            font-size: 1.9rem;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #ffffff 20%, var(--primary-gold) 70%, #ffdf8c 100%);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            transition: var(--transition-smooth);
            text-shadow: 0 2px 8px rgba(0,0,0,0.2);
        }

        .vip-logo a:hover {
            transform: scale(1.02);
            filter: drop-shadow(0 0 8px var(--primary-gold-light));
        }

        .vip-logo i {
            background: linear-gradient(145deg, #c9a03d, #f3d382);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            font-size: 2rem;
        }

        .logo-badge {
            font-size: 0.75rem;
            background: linear-gradient(135deg, #c9a03d, #9e7628);
            padding: 2px 8px;
            border-radius: 40px;
            color: #0a0c15;
            font-weight: 700;
            margin-left: 8px;
            letter-spacing: 0.5px;
            vertical-align: middle;
            font-family: 'Inter', sans-serif;
        }

        /* --- SEARCH BAR (Advanced Validation & VIP Feel) --- */
        .search-wrapper {
            flex: 1;
            max-width: 520px;
            min-width: 260px;
            position: relative;
        }

        .vip-search-form {
            display: flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 60px;
            border: 1px solid rgba(201, 160, 61, 0.5);
            backdrop-filter: blur(4px);
            transition: var(--transition-smooth);
        }

        .vip-search-form:focus-within {
            border-color: var(--primary-gold);
            box-shadow: 0 0 0 3px var(--primary-glow);
            background: rgba(20, 22, 36, 0.9);
        }

        .vip-search-input {
            background: transparent;
            border: none;
            padding: 0.85rem 1.2rem;
            width: 100%;
            font-size: 0.95rem;
            font-weight: 500;
            color: white;
            outline: none;
            font-family: 'Inter', sans-serif;
        }

        .vip-search-input::placeholder {
            color: var(--text-muted);
            font-weight: 400;
            letter-spacing: 0.2px;
        }

        .search-btn-vip {
            background: linear-gradient(145deg, #c9a03d, #b3872b);
            border: none;
            border-radius: 60px;
            padding: 0.7rem 1.5rem;
            margin: 4px;
            cursor: pointer;
            color: #0a0c15;
            font-size: 1.1rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: var(--transition-smooth);
            font-family: 'Inter', sans-serif;
        }

        .search-btn-vip i {
            font-size: 1rem;
        }

        .search-btn-vip:hover {
            background: linear-gradient(145deg, #e0b350, #c69c2e);
            transform: scale(0.97);
            box-shadow: 0 2px 10px rgba(201,160,61,0.5);
        }

        /* validate message */
        .validation-message {
            position: absolute;
            bottom: -28px;
            left: 18px;
            font-size: 0.7rem;
            color: #ffbb77;
            background: rgba(0,0,0,0.6);
            padding: 2px 12px;
            border-radius: 20px;
            backdrop-filter: blur(4px);
            pointer-events: none;
            font-weight: 500;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .validation-message.show {
            opacity: 1;
        }

        /* --- VIP Navigation --- */
        .vip-nav-items {
            display: flex;
            list-style: none;
            align-items: center;
            gap: 0.25rem;
        }

        .nav-link-vip {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0.7rem 1.2rem;
            font-weight: 600;
            font-size: 0.9rem;
            color: var(--text-light);
            text-decoration: none;
            border-radius: 40px;
            transition: var(--transition-smooth);
            letter-spacing: 0.2px;
            position: relative;
        }

        .nav-link-vip i {
            font-size: 1.1rem;
            color: var(--primary-gold);
        }

        .nav-link-vip:hover {
            background: rgba(201, 160, 61, 0.15);
            color: white;
            transform: translateY(-2px);
        }

        /* Premium Dropdown (Airlift style) */
        .premium-dropdown {
            position: relative;
        }

        .dropdown-trigger {
            cursor: pointer;
            background: rgba(255,255,255,0.02);
            border-radius: 40px;
        }

        .dropdown-trigger i.fa-caret-down {
            font-size: 0.8rem;
            transition: transform 0.2s;
        }

        .premium-dropdown.open .dropdown-trigger i.fa-caret-down {
            transform: rotate(180deg);
        }

        .dropdown-menu-vip {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            background: rgba(20, 22, 40, 0.98);
            backdrop-filter: blur(16px);
            border-radius: 20px;
            min-width: 240px;
            padding: 0.8rem 0;
            border: 1px solid rgba(201, 160, 61, 0.4);
            box-shadow: 0 20px 35px -12px black;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.2s ease;
            z-index: 1050;
        }

        .premium-dropdown.open .dropdown-menu-vip {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu-vip a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 0.8rem 1.5rem;
            color: #eceeff;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s;
            border-left: 3px solid transparent;
        }

        .dropdown-menu-vip a i {
            width: 22px;
            color: var(--primary-gold);
            font-size: 1rem;
        }

        .dropdown-menu-vip a:hover {
            background: rgba(201, 160, 61, 0.2);
            border-left-color: var(--primary-gold);
            padding-left: 1.8rem;
            color: #fff;
        }

        /* VIP Logout Button */
        .logout-btn-vip {
            background: linear-gradient(135deg, rgba(220, 50, 50, 0.9), #b91c1c);
            border-radius: 40px;
            padding: 0.7rem 1.2rem;
            font-weight: 700;
            box-shadow: 0 2px 6px rgba(0,0,0,0.3);
        }

        .logout-btn-vip:hover {
            background: linear-gradient(135deg, #e05a5a, #c53030);
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(220, 50, 50, 0.3);
        }

        /* responsive */
        @media (max-width: 1100px) {
            .header-container {
                gap: 1rem;
            }
            .nav-link-vip span:not(.badge-text) {
                display: none;
            }
            .nav-link-vip i {
                margin: 0;
            }
            .nav-link-vip {
                padding: 0.7rem 0.9rem;
            }
            .logout-btn-vip span {
                display: inline-block !important;
            }
        }

        @media (max-width: 800px) {
            .admin-header {
                padding: 0.6rem 1rem;
            }
            .search-wrapper {
                order: 3;
                width: 100%;
                max-width: 100%;
                margin-top: 8px;
            }
            .validation-message {
                bottom: -22px;
            }
        }

        /* backdrop shimmer effect for VIP */
        .vip-logo a::after {
            content: "★";
            font-size: 14px;
            margin-left: 5px;
            color: var(--primary-gold);
            background: none;
            -webkit-background-clip: unset;
            background-clip: unset;
        }

        /* demo content styling */
        .demo-content {
            padding: 2rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
            color: #1e1f2c;
        }

        .welcome-card {
            background: white;
            border-radius: 28px;
            padding: 2rem;
            box-shadow: var(--shadow-premium);
            border-top: 4px solid var(--primary-gold);
        }

        .welcome-card h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            background: linear-gradient(145deg, #0a0c15, #2a2e4a);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }

        .stat-badge {
            background: #f8f4ea;
            border-radius: 32px;
            padding: 0.5rem 1rem;
        }
    </style>
</head>
<body>

<header class="admin-header">
    <div class="header-container">
        <!-- VIP Logo Section with shimmer -->
        <div class="vip-logo">
            <a href="admin_dashboard.php">
                <i class="fas fa-crown"></i> 
                Jenny<span style="background: none; -webkit-background-clip: unset; background-clip: unset; color: #c9a03d;">Elite</span>
                <span class="logo-badge">ADMIN</span>
            </a>
        </div>

        <!-- SEARCH SECTION with REAL-TIME VALIDATION -->
        <div class="search-wrapper">
            <form id="vipSearchForm" action="search_results.php" method="GET" class="vip-search-form">
                <input type="text" name="query" id="searchInput" class="vip-search-input" 
                       placeholder="🔍 Search products, orders, customers..." autocomplete="off" required>
                <button type="submit" class="search-btn-vip" id="searchSubmitBtn">
                    <i class="fas fa-search"></i> <span>Search</span>
                </button>
            </form>
            <div id="searchValidationMsg" class="validation-message">
                <i class="fas fa-exclamation-triangle"></i> Please enter search keyword
            </div>
        </div>

        <!-- Navigation VIP -->
        <nav>
            <ul class="vip-nav-items">
                <li><a href="admin_dashboard.php" class="nav-link-vip"><i class="fas fa-chart-line"></i> <span>Dashboard</span></a></li>
                <li><a href="manage_products.php" class="nav-link-vip"><i class="fas fa-boxes"></i> <span>Products</span></a></li>
                <li><a href="manage_categories.php" class="nav-link-vip"><i class="fas fa-layer-group"></i> <span>Categories</span></a></li>
                
                <!-- Premium Dropdown Management -->
                <li class="premium-dropdown" id="managementDropdown">
                    <a href="javascript:void(0)" class="nav-link-vip dropdown-trigger" id="vipDropBtn">
                        <i class="fas fa-sliders-h"></i> <span>Management</span> <i class="fas fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu-vip" id="vipDropdownMenu">
                        <a href="add_product.php"><i class="fas fa-plus-circle"></i> Add Product</a>
                        <a href="add_category.php"><i class="fas fa-folder-plus"></i> Add Category</a>
                        <a href="view_orders.php"><i class="fas fa-shopping-bag"></i> View Orders</a>
                        <a href="edit_product.php"><i class="fas fa-pen-fancy"></i> Quick Edit</a>
                  
                    </div>
                </li>

                <li><a href="admin_login.php" class="nav-link-vip logout-btn-vip"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a></li>
            </ul>
        </nav>
    </div>
</header>



<script>
    (function() {
        // ---------- PROFESSIONAL VALIDATION FOR SEARCH ----------
        const searchForm = document.getElementById('vipSearchForm');
        const searchInput = document.getElementById('searchInput');
        const validationMsg = document.getElementById('searchValidationMsg');
        const submitBtn = document.getElementById('searchSubmitBtn');

        // Helper to show validation message
        function showValidation(show, customMessage = null) {
            if (show) {
                if (customMessage) {
                    validationMsg.innerHTML = `<i class="fas fa-exclamation-triangle"></i> ${customMessage}`;
                } else {
                    validationMsg.innerHTML = `<i class="fas fa-exclamation-triangle"></i> Please enter search keyword`;
                }
                validationMsg.classList.add('show');
            } else {
                validationMsg.classList.remove('show');
            }
        }

        // Real-time validation listener (on input)
        searchInput.addEventListener('input', function(e) {
            const val = e.target.value.trim();
            if (val.length === 0) {
                showValidation(true, "🔍 Keyword required before search");
            } else if (val.length < 2) {
                showValidation(true, "Search term must be at least 2 characters");
            } else {
                showValidation(false);
            }
        });

        // On form submit, check validation and trim spaces
        searchForm.addEventListener('submit', function(event) {
            let rawValue = searchInput.value;
            let trimmed = rawValue.trim();
            
            if (trimmed === "") {
                event.preventDefault();
                showValidation(true, "⛔ Search field cannot be empty!");
                searchInput.value = ""; // clear whitespace only input
                searchInput.focus();
                return false;
            }
            
            if (trimmed.length < 2) {
                event.preventDefault();
                showValidation(true, "⚠️ Minimum 2 characters required for VIP search");
                searchInput.value = trimmed;
                searchInput.focus();
                return false;
            }
            
            // success! Update input value to trimmed version for clean request
            searchInput.value = trimmed;
            showValidation(false);
            // optional: add loading effect
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-pulse"></i> Searching...';
            // form will submit normally, but we let it go.
            // You could also preventDefault and do fetch, but we keep GET action
            setTimeout(() => {
                // Reset btn if needed (if form takes time, but it's fine)
            }, 200);
            return true;
        });

        // Additional blur validation
        searchInput.addEventListener('blur', function() {
            const val = searchInput.value.trim();
            if (val === "") {
                showValidation(true, "Please fill search field");
            } else if (val.length < 2 && val.length > 0) {
                showValidation(true, "At least 2 characters");
            } else {
                showValidation(false);
            }
        });

        // ---------- PREMIUM DROPDOWN WITH BETTER INTERACTION (close on outside, esc) ----------
        const dropdownContainer = document.getElementById('managementDropdown');
        const dropBtn = document.getElementById('vipDropBtn');
        
        function toggleDropdown(e) {
            e.stopPropagation();
            dropdownContainer.classList.toggle('open');
        }
        
        if (dropBtn && dropdownContainer) {
            dropBtn.addEventListener('click', toggleDropdown);
            
            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdownContainer.contains(event.target)) {
                    dropdownContainer.classList.remove('open');
                }
            });
            
            // Optional: Close on ESC key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && dropdownContainer.classList.contains('open')) {
                    dropdownContainer.classList.remove('open');
                }
            });
            
            // prevent dropdown from closing when clicking inside dropdown menu links? actually we want it to close after navigation
            const dropdownMenu = document.querySelector('#vipDropdownMenu');
            if (dropdownMenu) {
                dropdownMenu.addEventListener('click', function(e) {
                    // user clicks a link -> close dropdown before navigating (nice UX)
                    dropdownContainer.classList.remove('open');
                });
            }
        }
        
        // ---------- ADDITIONAL PROFESSIONAL TOUCH: Navigation Active State highlighting (optional)
        const currentLocation = window.location.pathname;
        const allNavLinks = document.querySelectorAll('.nav-link-vip, .dropdown-menu-vip a');
        allNavLinks.forEach(link => {
            if (link.getAttribute('href') && link.getAttribute('href') !== 'javascript:void(0)') {
                const href = link.getAttribute('href');
                if (currentLocation.includes(href) && href !== 'admin_dashboard.php') {
                    link.style.background = 'rgba(201, 160, 61, 0.2)';
                    link.style.borderRadius = '40px';
                } else if (currentLocation.endsWith('admin_dashboard.php') && href === 'admin_dashboard.php') {
                    link.style.background = 'rgba(201, 160, 61, 0.2)';
                }
            }
        });
        
        // Extra: ENTER key validation enhancement for search
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const val = searchInput.value.trim();
                if(val.length >= 2) {
                    searchForm.dispatchEvent(new Event('submit'));
                } else {
                    showValidation(true, "Use at least 2 characters before searching");
                }
            }
        });
        
        // Dynamic welcome effect: Just to make it look more VIP - small console greeting (silent)
        console.log("%c✨ Jenny's Elite Admin Panel v3.0 | Professional Validation Active ✨", "color: #c9a03d; font-size: 14px; font-weight: bold;");
        
        // Hover animation on search button - subtle
        const searchBtn = document.querySelector('.search-btn-vip');
        if(searchBtn) {
            searchBtn.addEventListener('mouseenter', () => {
                searchBtn.style.transition = '0.2s';
            });
        }
    })();
</script>

<!-- Tiny additional style for glowing outline VIP (optional) -->
<style>
    .vip-search-input:focus {
        background: rgba(30, 32, 50, 0.7);
    }
    .premium-dropdown.open .dropdown-trigger {
        background: rgba(201, 160, 61, 0.2);
        border-radius: 40px;
    }
    ::selection {
        background: #c9a03d;
        color: #0a0c15;
    }
</style>
</body>
</html>
