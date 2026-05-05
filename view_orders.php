<?php 
require_once 'config.php'; // Database Connection

// Session check
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

// Query: Orders, Users aur Products ko JOIN karke details nikalna
$query = "SELECT o.order_id, u.name as cust_name, u.cell_no, u.address, p.prod_name, oi.quantity, o.order_date, o.total_amount
          FROM orders o
          JOIN users u ON o.user_id = u.user_id
          JOIN order_items oi ON o.order_id = oi.order_id
          JOIN products p ON oi.prod_id = p.prod_id
          ORDER BY o.order_date DESC";

$result = mysqli_query($conn, $query);

include 'backheader.php'; // Custom Header
?>

<style>
    .orders-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        min-height: 80vh;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-header h2 { color: #2c3e50; font-size: 26px; }

    .btn-print {
        background: #34495e;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-print:hover { background: #2c3e50; transform: translateY(-2px); }

    .table-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 15px; background: #f8f9fa; color: #7f8c8d; font-size: 13px; text-transform: uppercase; border-bottom: 2px solid #eee; }
    td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; vertical-align: middle; }

    .order-id {
        background: #eef2ff;
        color: #4f46e5;
        font-weight: bold;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 12px;
    }

    .cust-info .name { font-weight: 600; color: #2c3e50; display: block; }
    .cust-info .detail { font-size: 12px; color: #7f8c8d; display: block; margin-top: 2px; }

    .prod-info .name { font-weight: 500; color: #333; }
    .prod-info .qty { 
        background: #f1f1f1; 
        padding: 2px 6px; 
        border-radius: 4px; 
        font-size: 11px; 
        margin-left: 5px; 
        border: 1px solid #ddd;
    }

    .amount { font-weight: bold; color: #27ae60; }
    .date { font-size: 12px; color: #7f8c8d; }

    .status-badge {
        background: #fff8e1;
        color: #f39c12;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: bold;
        border: 1px solid #fde68a;
    }

    /* Print styling */
    @media print {
        .admin-header, .admin-footer, .btn-print { display: none; }
        .orders-container { padding: 0; margin: 0; }
        .table-card { box-shadow: none; border: 1px solid #eee; }
    }
</style>

<div class="orders-container">
    <div class="page-header">
        <h2>Customer Orders</h2>
        <button class="btn-print" onclick="window.print()">
            <i class="fas fa-print"></i> Print Report
        </button>
    </div>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Product & Qty</th>
                    <th>Total Amount</th>
                    <th>Date</th>
                    <th style="text-align: right;">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><span class="order-id">ORD-<?php echo $row['order_id']; ?></span></td>
                    <td class="cust-info">
                        <span class="name"><?php echo $row['cust_name']; ?></span>
                        <span class="detail"><i class="fas fa-phone"></i> <?php echo $row['cell_no']; ?></span>
                        <span class="detail"><i class="fas fa-map-marker-alt"></i> <?php echo $row['address']; ?></span>
                    </td>
                    <td class="prod-info">
                        <span class="name"><?php echo $row['prod_name']; ?></span>
                        <span class="qty">x<?php echo $row['quantity']; ?></span>
                    </td>
                    <td class="amount">
                        Rs. <?php echo number_format($row['total_amount'], 0); ?>
                    </td>
                    <td class="date">
                        <?php echo date('d M, Y', strtotime($row['order_date'])); ?>
                    </td>
                    <td style="text-align: right;">
                        <span class="status-badge">
                            <i class="fas fa-clock"></i> PENDING
                        </span>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="6" style="text-align: center; padding: 50px; color: #95a5a6;">
                        <i class="fas fa-box-open" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                        Abhi tak koi order nahi aaya hai.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include 'backfooter.php'; // Custom Footer
?>
