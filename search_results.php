<?php 
require_once 'config.php';
include 'backheader.php'; // Header link kar diya

$search_query = "";
if(isset($_GET['query'])) {
    $search_query = mysqli_real_escape_string($conn, $_GET['query']);
}

// Database se product dhoondne ki query
$query = "SELECT p.*, c.cat_name 
          FROM products p 
          LEFT JOIN categories c ON p.cat_id = c.cat_id 
          WHERE p.prod_name LIKE '%$search_query%' 
          ORDER BY p.prod_id DESC";

$result = mysqli_query($conn, $query);
?>

<div class="container" style="max-width: 1200px; margin: 20px auto; padding: 20px;">
    <h2 style="margin-bottom: 20px; color: #2c3e50;">Search Results for: <span style="color: #3498db;"><?php echo htmlspecialchars($search_query); ?></span></h2>

    <div style="background: white; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: #f8f9fa; border-bottom: 2px solid #eee;">
                <tr>
                    <th style="padding: 15px; text-align: left;">Product</th>
                    <th style="padding: 15px; text-align: left;">Category</th>
                    <th style="padding: 15px; text-align: left;">Price</th>
                    <th style="padding: 15px; text-align: left;">Stock</th>
                    <th style="padding: 15px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($result) > 0): while($row = mysqli_fetch_assoc($result)): ?>
                <tr style="border-bottom: 1px solid #eee;">
                    <td style="padding: 15px;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <img src="images/<?php echo $row['image']; ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 5px;">
                            <span style="font-weight: 600;"><?php echo $row['prod_name']; ?></span>
                        </div>
                    </td>
                    <td style="padding: 15px; color: #7f8c8d;"><?php echo $row['cat_name']; ?></td>
                    <td style="padding: 15px; font-weight: bold;">Rs. <?php echo number_format($row['price'], 0); ?></td>
                    <td style="padding: 15px;"><?php echo $row['quantity']; ?></td>
                    <td style="padding: 15px; text-align: right;">
                        <a href="edit_product.php?id=<?php echo $row['prod_id']; ?>" style="color: #3498db; text-decoration: none; margin-right: 10px;"><i class="fas fa-edit"></i> Edit</a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="5" style="padding: 40px; text-align: center; color: #999;">No products found matching your search.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 20px;">
        <a href="manage_products.php" style="text-decoration: none; color: #7f8c8d;"><i class="fas fa-arrow-left"></i> Back to Inventory</a>
    </div>
</div>

<?php include 'backfooter.php'; ?>
