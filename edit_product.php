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

// 1. Purana data uthana (Fetch existing data)
if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = mysqli_query($conn, "SELECT * FROM products WHERE prod_id = $id");
    $p_data = mysqli_fetch_assoc($res);
    
    if(!$p_data) {
        header("Location: manage_products.php");
        exit();
    }
} else {
    header("Location: manage_products.php");
    exit();
}

// 2. Data Update karne ka logic (With Image Handling)
if(isset($_POST['update_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $price = $_POST['p_price'];
    $qty = $_POST['p_qty'];
    $desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
    $cat_id = $_POST['cat_id'];

    // Image Handle karein
    $new_image = $_FILES['p_image']['name'];
    if(!empty($new_image)) {
        $image_tmp = $_FILES['p_image']['tmp_name'];
        move_uploaded_file($image_tmp, "../images/" . $new_image);
        $image_to_save = $new_image;
    } else {
        $image_to_save = $p_data['image']; // Purani image hi rehne dein
    }

    // Database Update Query
    $update_query = "UPDATE products SET 
                     prod_name='$name', 
                     price='$price', 
                     quantity='$qty', 
                     prod_description='$desc', 
                     cat_id='$cat_id', 
                     image='$image_to_save' 
                     WHERE prod_id=$id";
    
    if(mysqli_query($conn, $update_query)) {
        header("Location: manage_products.php?msg=Product Updated Successfully! ✨");
        exit();
    }
}

// Categories fetch karna dropdown ke liye
$categories = mysqli_query($conn, "SELECT * FROM categories");

include 'backheader.php'; // Custom Header
?>

<style>
    .edit-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        min-height: 85vh;
    }

    .form-card {
        background: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        border-top: 5px solid #3498db;
        max-width: 800px;
        margin: 0 auto;
    }

    .form-card h3 {
        color: #2c3e50;
        margin-bottom: 25px;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    .form-group { margin-bottom: 15px; }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #34495e;
        font-size: 14px;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        font-size: 14px;
    }

    /* Image Preview Section */
    .image-edit-section {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
        border: 1px solid #eee;
    }

    .preview-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border-radius: 8px;
        border: 2px solid #fff;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    .btn-update {
        background: #ff4d94;
        color: white;
        border: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
    }

    .btn-update:hover { background: #e63d83; transform: translateY(-2px); }

    .btn-cancel {
        background: #95a5a6;
        color: white;
        text-decoration: none;
        padding: 15px 30px;
        border-radius: 8px;
        font-weight: bold;
        display: inline-block;
        transition: 0.3s;
    }

    .btn-cancel:hover { background: #7f8c8d; }

    .button-group {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
        .image-edit-section { flex-direction: column; align-items: flex-start; }
    }
</style>

<div class="edit-container">
    <div class="form-card">
        <h3><i class="fas fa-edit"></i> Edit Product Details</h3>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="p_name" class="form-control" value="<?php echo $p_data['prod_name']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Category</label>
                    <select name="cat_id" class="form-select" required>
                        <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                            <option value="<?php echo $cat['cat_id']; ?>" <?php if($cat['cat_id'] == $p_data['cat_id']) echo "selected"; ?>>
                                <?php echo $cat['cat_name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price (Rs.)</label>
                    <input type="number" name="p_price" class="form-control" value="<?php echo $p_data['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" name="p_qty" class="form-control" value="<?php echo $p_data['quantity']; ?>" required>
                </div>
            </div>

            <div class="image-edit-section">
                <div>
                    <label style="display:block; font-size:12px; color:#7f8c8d; margin-bottom:5px;">Current Image:</label>
                    <img src="images/<?php echo $p_data['image']; ?>" class="preview-img" alt="current">
                </div>
                <div style="flex-grow: 1; width: 100%;">
                    <label style="font-weight:bold; font-size:14px; color:#34495e;">Change Product Image (Optional)</label>
                    <input type="file" name="p_image" class="form-control" accept="image/*" style="margin-top:8px;">
                </div>
            </div>

            <div class="form-group">
                <label>Product Description</label>
                <textarea name="p_desc" class="form-control" rows="4"><?php echo $p_data['prod_description']; ?></textarea>
            </div>

            <div class="button-group">
                <a href="manage_products.php" class="btn-cancel">Cancel</a>
                <button type="submit" name="update_product" class="btn-update">Save Changes</button>
            </div>
        </form>
    </div>
</div>

<?php 
include 'backfooter.php'; // Custom Footer
?>
