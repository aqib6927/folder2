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

$msg = "";
$error = "";

// 1. Categories fetch karna dropdown ke liye
$all_categories = mysqli_query($conn, "SELECT * FROM categories");

// 2. Data save karne ka logic (With Image Upload)
if(isset($_POST['add_product'])) {
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_price = $_POST['p_price'];
    $p_qty = $_POST['p_qty'];
    $p_desc = mysqli_real_escape_string($conn, $_POST['p_desc']);
    $cat_id = $_POST['cat_id'];
    
    // Image Upload Logic
    $image_name = $_FILES['p_image']['name'];
    $image_tmp = $_FILES['p_image']['tmp_name'];
    $target_dir = "images/"; // Frontend ke images folder ka path
    
    if(!empty($image_name)) {
        // Agar folder nahi bana hua to error se bachne ke liye image upload karein
        if(move_uploaded_file($image_tmp, $target_dir . $image_name)) {
            // Sahi Database Columns
            $insert_query = "INSERT INTO products (prod_name, prod_description, price, quantity, cat_id, image) 
                             VALUES ('$p_name', '$p_desc', '$p_price', '$p_qty', '$cat_id', '$image_name')";
            
            if(mysqli_query($conn, $insert_query)) {
                $msg = "Product Added Successfully! ✨";
            } else {
                $error = "Database Error: " . mysqli_error($conn);
            }
        } else {
            $error = "Image upload failed! Make sure the '../images/' folder exists.";
        }
    } else {
        $error = "Please select a product image.";
    }
}

include 'backheader.php'; // Custom Header
?>

<style>
    .add-product-container {
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
        border-top: 5px solid #ff4d94;
    }

    .form-card h3 {
        color: #2c3e50;
        margin-bottom: 25px;
        font-size: 22px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Grid layout for form fields */
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
        transition: 0.3s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #ff4d94;
    }

    textarea.form-control {
        resize: vertical;
        min-height: 120px;
    }

    .msg-box {
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        text-align: center;
        font-size: 14px;
    }

    .msg-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    .msg-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

    .btn-submit {
        background: #ff4d94;
        color: white;
        border: none;
        padding: 15px;
        width: 100%;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        box-shadow: 0 4px 15px rgba(255, 77, 148, 0.2);
    }

    .btn-submit:hover {
        background: #e63d83;
        transform: translateY(-2px);
    }

    @media (max-width: 768px) {
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<div class="add-product-container">
    <div class="form-card">
        <h3><i class="fas fa-plus-circle"></i> Add New Product</h3>

        <?php if($msg): ?>
            <div class="msg-box msg-success"><?php echo $msg; ?></div>
        <?php endif; ?>

        <?php if($error): ?>
            <div class="msg-box msg-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="p_name" class="form-control" placeholder="e.g. Silk Pearl Necklace" required>
                </div>
                <div class="form-group">
                    <label>Select Category</label>
                    <select name="cat_id" class="form-select" required>
                        <option value="">-- Choose Category --</option>
                        <?php while($row = mysqli_fetch_assoc($all_categories)): ?>
                            <option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Price (Rs.)</label>
                    <input type="number" name="p_price" class="form-control" placeholder="0.00" required>
                </div>
                <div class="form-group">
                    <label>Stock Quantity</label>
                    <input type="number" name="p_qty" class="form-control" placeholder="e.g. 50" required>
                </div>
            </div>

            <div class="form-group">
                <label>Product Image</label>
                <input type="file" name="p_image" class="form-control" accept="image/*" required>
                <small style="color: #7f8c8d; font-size: 12px;">Best size: Square (500x500 px)</small>
            </div>

            <div class="form-group">
                <label>Product Description</label>
                <textarea name="p_desc" class="form-control" placeholder="Write a short description about the product..."></textarea>
            </div>

            <button type="submit" name="add_product" class="btn-submit">
                <i class="fas fa-upload"></i> Publish Product
            </button>
        </form>
    </div>
</div>

<?php 
include 'backfooter.php'; // Custom Footer
?>
