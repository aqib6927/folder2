<?php 
require_once 'config.php'; 

// Session check (Security ke liye)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Agar admin login nahi hai to login page par bhej do
if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

include 'backheader.php'; // Aapka banaya hua custom header
require_once 'fake_visitor.php'; // Fake visitor counter include karo

// 1. QUERY: Top Selling Products
$top_products = mysqli_query($conn, "
    SELECT p.prod_name, COUNT(oi.prod_id) as total_sold 
    FROM order_items oi 
    JOIN products p ON oi.prod_id = p.prod_id 
    GROUP BY oi.prod_id 
    ORDER BY total_sold DESC 
    LIMIT 5
");

// 2. QUERY: Top Customers
$top_customers = mysqli_query($conn, "
    SELECT u.name, COUNT(o.order_id) as total_orders 
    FROM orders o 
    JOIN users u ON o.user_id = u.user_id 
    GROUP BY o.user_id 
    ORDER BY total_orders DESC 
    LIMIT 5
");

// 3. Stats for Cards
$total_prods_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM products");
$total_prods = mysqli_fetch_assoc($total_prods_res)['count'];

$total_orders_res = mysqli_query($conn, "SELECT COUNT(*) as count FROM orders");
$total_orders = mysqli_fetch_assoc($total_orders_res)['count'];

$revenue_res = mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders");
$total_revenue = mysqli_fetch_assoc($revenue_res)['total'] ?? 0;
?>

<!-- Custom CSS for Dashboard -->
<style>
    .dashboard-container { 
    padding: 30px; 
    max-width: 1200px; 
    margin: 0 auto; 
    min-height: 80vh; 
    animation: fadeInPage 0.8s ease;
}

@keyframes fadeInPage {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.page-title { 
    margin-bottom: 25px; 
    color: #2c3e50; 
    font-size: 28px; 
    animation: slideLeft 0.8s ease;
}

@keyframes slideLeft {
    from { transform: translateX(-40px); opacity: 0; }
    to { transform: translateX(0); opacity: 1; }
}

/* Stats Cards */
.stat-card { 
    background: white; 
    padding: 20px; 
    border-radius: 12px; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
    border-left: 5px solid #3498db; 
    transition: 0.4s;
    animation: zoomIn 0.6s ease;
}

@keyframes zoomIn {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

.stat-card:hover {
    transform: translateY(-8px) scale(1.02);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

/* Add Button Animation */
.stat-card.add:hover {
    background: #ff1a75;
    transform: scale(1.05);
}

/* Table Animation */
.table-card { 
    background: white; 
    padding: 20px; 
    border-radius: 12px; 
    box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
    animation: fadeUp 0.8s ease;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(40px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Table row hover */
tr:hover {
    background: #f9f9f9;
    transition: 0.3s;
}

/* Visitor Cards Animation */
.admin-visitor-card {
    display: flex;
    align-items: center;
    gap: 12px;
    background: rgba(255,255,255,0.08);
    padding: 8px 18px;
    border-radius: 50px;
    transition: all 0.4s ease;
    animation: floatUp 0.8s ease;
}

@keyframes floatUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.admin-visitor-card:hover {
    background: rgba(255,255,255,0.18);
    transform: translateY(-5px) scale(1.03);
}

/* Number animation glow */
.admin-visitor-number {
    font-size: 1.3rem;
    font-weight: 800;
    color: #fff;
    animation: glow 2s infinite alternate;
}

@keyframes glow {
    from { text-shadow: 0 0 5px rgba(255,255,255,0.2); }
    to { text-shadow: 0 0 15px rgba(16,185,129,0.8); }
}
    .dashboard-container { padding: 30px; max-width: 1200px; margin: 0 auto; min-height: 80vh; }
    .page-title { margin-bottom: 25px; color: #2c3e50; font-size: 28px; }
    
    /* Stats Cards Grid */
    .stats-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); 
        gap: 20px; 
        margin-bottom: 30px; 
    }
    .stat-card { 
        background: white; 
        padding: 20px; 
        border-radius: 12px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        border-left: 5px solid #3498db; 
    }
    .stat-card.revenue { border-left-color: #2ecc71; }
    .stat-card.orders { border-left-color: #f1c40f; }
    .stat-card.add { 
        background: #ff4d94; 
        border: none; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        cursor: pointer;
        text-decoration: none;
    }
    .stat-card.add h3 { color: white; font-size: 18px; }

    .stat-card small { color: #7f8c8d; text-transform: uppercase; font-size: 11px; font-weight: bold; }
    .stat-card h3 { margin-top: 5px; font-size: 24px; color: #2c3e50; }

    /* Tables Grid */
    .tables-grid { 
        display: grid; 
        grid-template-columns: repeat(auto-fit, minmax(450px, 1fr)); 
        gap: 25px; 
    }
    .table-card { 
        background: white; 
        padding: 20px; 
        border-radius: 12px; 
        box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
    }
    .table-card h5 { margin-bottom: 15px; color: #2c3e50; font-size: 18px; }
    
    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
    th { text-align: left; background: #f8f9fa; padding: 12px; font-size: 13px; color: #7f8c8d; }
    td { padding: 12px; border-bottom: 1px solid #eee; font-size: 14px; color: #333; }
    
    .badge { 
        background: #34495e; 
        color: white; 
        padding: 4px 12px; 
        border-radius: 20px; 
        font-size: 12px; 
    }
    .badge-blue { background: #3498db; }

    /* Admin Visitor Counter Styles - Same as frontend but adjusted for admin */
    .admin-visitor-bar {
        background: linear-gradient(135deg, #1a1a2e, #16213e);
        padding: 12px 20px;
        border-radius: 12px;
        margin-bottom: 25px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .admin-visitor-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        flex-wrap: wrap;
    }
    .admin-visitor-card {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255,255,255,0.08);
        padding: 8px 18px;
        border-radius: 50px;
        transition: all 0.3s ease;
    }
    .admin-visitor-card:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-2px);
    }
    .admin-visitor-icon {
        width: 40px;
        height: 40px;
        background: rgba(111,66,193,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #fff;
        position: relative;
    }
    .pulse-dot-admin {
        position: absolute;
        top: -2px;
        right: -2px;
        width: 10px;
        height: 10px;
        background: #10b981;
        border-radius: 50%;
        animation: pulseAdmin 1.5s infinite;
        border: 2px solid #1a1a2e;
    }
    @keyframes pulseAdmin {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.3); opacity: 0.5; }
    }
    .admin-visitor-info {
        display: flex;
        flex-direction: column;
    }
    .admin-visitor-number {
        font-size: 1.3rem;
        font-weight: 800;
        color: #fff;
        line-height: 1.2;
    }
    .admin-visitor-text {
        font-size: 0.65rem;
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
    }
    .admin-activity {
        margin-top: 12px;
        padding-top: 12px;
        border-top: 1px solid rgba(255,255,255,0.1);
        font-size: 0.75rem;
        color: rgba(255,255,255,0.7);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .admin-activity i {
        color: #10b981;
    }

    @media (max-width: 768px) {
        .admin-visitor-wrapper {
            justify-content: center;
        }
        .admin-visitor-card {
            padding: 5px 12px;
        }
        .admin-visitor-icon {
            width: 32px;
            height: 32px;
            font-size: 14px;
        }
        .admin-visitor-number {
            font-size: 1rem;
        }
    }
</style>

<div class="dashboard-container">
    <h2 class="page-title">📊 Store Insights</h2>

    <!-- FAKE VISITOR COUNTER FOR ADMIN PANEL -->
    <div class="admin-visitor-bar">
        <div class="admin-visitor-wrapper">
            <div class="admin-visitor-card">
                <div class="admin-visitor-icon">
                    <div class="pulse-dot-admin"></div>
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="admin-visitor-info">
                    <span class="admin-visitor-number" id="adminOnlineCount"><?php echo $_SESSION['fake_online']; ?></span>
                    <span class="admin-visitor-text">Live Visitors</span>
                </div>
                <span style="background: rgba(16,185,129,0.2); padding: 2px 10px; border-radius: 30px; font-size: 11px; color: #10b981; margin-left: 5px;">
                    <i class="fas fa-chart-line"></i> Active Now
                </span>
            </div>
            <div class="admin-visitor-card">
                <div class="admin-visitor-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="admin-visitor-info">
                    <span class="admin-visitor-number" id="adminTodayCount"><?php echo $_SESSION['fake_today']; ?></span>
                    <span class="admin-visitor-text">Today's Visits</span>
                </div>
            </div>
            <div class="admin-visitor-card">
                <div class="admin-visitor-icon">
                    <i class="fas fa-globe"></i>
                </div>
                <div class="admin-visitor-info">
                    <span class="admin-visitor-number" id="adminTotalCount"><?php echo getFakeTotalVisitors(); ?></span>
                    <span class="admin-visitor-text">Total Visitors</span>
                </div>
            </div>
            <div class="admin-visitor-card" style="background: linear-gradient(135deg, rgba(111,66,193,0.3), rgba(232,62,140,0.3));">
                <div class="admin-visitor-icon">
                    <i class="fas fa-fire"></i>
                </div>
                <div class="admin-visitor-info">
                    <span class="admin-visitor-number">🔥 Hot</span>
                    <span class="admin-visitor-text">Trending</span>
                </div>
            </div>
        </div>
        <div class="admin-activity" id="adminActivity">
            <i class="fas fa-shopping-cart"></i>
            <span>Someone from Karachi just bought Lipstick</span>
        </div>
    </div>

    <!-- QUICK STATS -->
    <div class="stats-grid">
        <div class="stat-card">
            <small>Total Products</small>
            <h3><?php echo $total_prods; ?></h3>
        </div>
        <div class="stat-card orders">
            <small>Active Orders</small>
            <h3><?php echo $total_orders; ?></h3>
        </div>
        <div class="stat-card revenue">
            <small>Total Revenue</small>
            <h3>Rs. <?php echo number_format($total_revenue, 0); ?></h3>
        </div>
        <a href="add_product.php" class="stat-card add">
            <h3><i class="fas fa-plus"></i> Add New Product</h3>
        </a>
    </div>

    <div class="tables-grid">
        <!-- Top Products Table -->
        <div class="table-card">
            <h5><i class="fas fa-fire" style="color: #e74c3c;"></i> Best Selling Products</h5>
            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th style="text-align: center;">Items Sold</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($top_products) > 0): while($row = mysqli_fetch_assoc($top_products)): ?>
                    <tr>
                        <td><?php echo $row['prod_name']; ?></td>
                        <td style="text-align: center;"><span class="badge"><?php echo $row['total_sold']; ?></span></td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="2" style="text-align:center;">No sales data available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Top Customers Table -->
        <div class="table-card">
            <h5><i class="fas fa-crown" style="color: #f1c40f;"></i> VIP Customers</h5>
            <table>
                <thead>
                    <tr>
                        <th>Customer Name</th>
                        <th style="text-align: center;">Total Orders</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(mysqli_num_rows($top_customers) > 0): while($crow = mysqli_fetch_assoc($top_customers)): ?>
                    <tr>
                        <td><?php echo $crow['name']; ?></td>
                        <td style="text-align: center;"><span class="badge badge-blue"><?php echo $crow['total_orders']; ?></span></td>
                    </tr>
                    <?php endwhile; else: ?>
                    <tr><td colspan="2" style="text-align:center;">No customers found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
// Fake real-time updates for admin panel
function updateAdminFakeCounts() {
    fetch('fake_visitor.php?ajax=1')
        .then(response => response.json())
        .then(data => {
            document.getElementById('adminOnlineCount').innerText = data.online;
            document.getElementById('adminTodayCount').innerText = data.today;
            document.getElementById('adminTotalCount').innerText = data.total;
        })
        .catch(error => console.log('Error:', error));
}

// Fake activity messages
const adminNames = ['Ayesha', 'Fatima', 'Omar', 'Zara', 'Hassan', 'Mariam', 'Ali', 'Sana', 'Bilal', 'Iman', 'Usman', 'Hina'];
const adminCities = ['Karachi', 'Lahore', 'Islamabad', 'Rawalpindi', 'Multan', 'Faisalabad', 'Peshawar', 'Quetta', 'Gujranwala'];
const adminProducts = ['Lipstick', 'Foundation', 'Mascara', 'Eyeliner', 'Blush', 'Concealer', 'Lip Gloss', 'Compact Powder', 'Nail Polish', 'Perfume'];

function updateAdminActivity() {
    const randomName = adminNames[Math.floor(Math.random() * adminNames.length)];
    const randomCity = adminCities[Math.floor(Math.random() * adminCities.length)];
    const randomProduct = adminProducts[Math.floor(Math.random() * adminProducts.length)];
    
    const activityElement = document.getElementById('adminActivity');
    if(activityElement) {
        activityElement.innerHTML = `<i class="fas fa-shopping-cart"></i> ${randomName} from ${randomCity} just bought <strong>${randomProduct}</strong>`;
    }
}

// Update numbers every 10 seconds
setInterval(updateAdminFakeCounts, 10000);

// Update activity every 15 seconds
setInterval(updateAdminActivity, 15000);
</script>

<?php 
include 'backfooter.php';
?>