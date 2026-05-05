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

// 1. DELETE LOGIC
if(isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    
    // Image delete karne ke liye query (Optional)
    $img_res = mysqli_query($conn, "SELECT image FROM products WHERE prod_id = $id");
    $img_data = mysqli_fetch_assoc($img_res);
    
    $del_query = "DELETE FROM products WHERE prod_id = $id";
    if(mysqli_query($conn, $del_query)) {
        header("Location: manage_products.php?msg=Product Deleted Successfully");
        exit();
    }
}

// 2. FETCH ALL PRODUCTS WITH CATEGORY NAMES
$query = "SELECT p.*, c.cat_name FROM products p LEFT JOIN categories c ON p.cat_id = c.cat_id ORDER BY p.prod_id DESC";
$result = mysqli_query($conn, $query);

include 'backheader.php'; // Custom Header
?>

<style>
    .inventory-container {
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

    .btn-add {
        background: #ff4d94;
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-add:hover { background: #e63d83; transform: translateY(-2px); }

    .table-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    table { width: 100%; border-collapse: collapse; }
    th { text-align: left; padding: 15px; background: #f8f9fa; color: #7f8c8d; font-size: 13px; text-transform: uppercase; border-bottom: 2px solid #eee; }
    td { padding: 15px; border-bottom: 1px solid #eee; font-size: 14px; vertical-align: middle; }

    .product-info { display: flex; align-items: center; gap: 15px; }
    .product-img { width: 50px; height: 50px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; }
    .product-name { font-weight: 600; color: #2c3e50; display: block; }
    .product-id { font-size: 11px; color: #95a5a6; }

    .badge-cat { background: #eef2ff; color: #4f46e5; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
    
    /* Stock Status Colors */
    .stock-high { color: #2ecc71; font-weight: bold; }
    .stock-low { color: #f1c40f; font-weight: bold; }
    .stock-out { color: #e74c3c; font-weight: bold; }

    .actions { display: flex; gap: 8px; justify-content: flex-end; }
    .btn-action { 
        padding: 6px 10px; 
        border-radius: 6px; 
        text-decoration: none; 
        font-size: 13px; 
        transition: 0.3s;
    }
    .edit-link { background: #eef2ff; color: #4f46e5; }
    .edit-link:hover { background: #4f46e5; color: white; }
    .delete-link { background: #fff1f2; color: #e11d48; }
    .delete-link:hover { background: #e11d48; color: white; }

    .alert-success {
        background: #d4edda;
        color: #155724;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
        border: 1px solid #c3e6cb;
    }
</style>

<div class="inventory-container">
    <div class="page-header">
        <h2>Inventory Management</h2>
        <a href="add_product.php" class="btn-add">
            <i class="fas fa-plus"></i> Add New Product
        </a>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>Product Details</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="images/<?php echo $row['image'] ? $row['image'] : 'no-image.jpg'; ?>" class="product-img">
                            <div>
                                <span class="product-name"><?php echo $row['prod_name']; ?></span>
                                <span class="product-id">ID: #<?php echo $row['prod_id']; ?></span>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge-cat"><?php echo $row['cat_name'] ? $row['cat_name'] : 'Uncategorized'; ?></span>
                    </td>
                    <td style="font-weight: bold; color: #2c3e50;">
                        Rs. <?php echo number_format($row['price'], 0); ?>
                    </td>
                    <td>
                        <?php if($row['quantity'] > 10): ?>
                            <span class="stock-high"><i class="fas fa-check"></i> <?php echo $row['quantity']; ?></span>
                        <?php elseif($row['quantity'] > 0): ?>
                            <span class="stock-low"><i class="fas fa-exclamation-triangle"></i> <?php echo $row['quantity']; ?></span>
                        <?php else: ?>
                            <span class="stock-out"><i class="fas fa-times"></i> Out</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="actions">
                            <a href="edit_product.php?id=<?php echo $row['prod_id']; ?>" class="btn-action edit-link" title="Edit">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="manage_products.php?delete_id=<?php echo $row['prod_id']; ?>" 
                               class="btn-action delete-link" 
                               onclick="return confirm('Kya aap waqayi is product ko delete karna chahte hain?')" title="Delete">
                                <i class="fas fa-trash"></i> Delete
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #95a5a6;">
                        No products found in inventory.
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
