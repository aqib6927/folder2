<?php 
require_once 'config.php'; // Database Connection

// Session check (Security)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit();
}

$error = "";
$success = "";

if(isset($_POST['add_cat'])) {
    $cat_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $cat_desc = mysqli_real_escape_string($conn, $_POST['category_description']);
    
    if(!empty($cat_name)) {
        $query = "INSERT INTO categories (cat_name, cat_description) VALUES ('$cat_name', '$cat_desc')";
        if(mysqli_query($conn, $query)) {
            header("Location: manage_categories.php");
            exit(); 
        } else {
            $error = "Database error: Could not save category.";
        }
    } else {
        $error = "Please enter a category name!";
    }
}

include 'backheader.php'; // Custom Header
?>

<!-- Custom CSS for Form -->
<style>
    .form-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        display: flex;
        justify-content: center;
        min-height: 80vh;
    }

    .form-card {
        background: white;
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 500px;
        border-top: 5px solid #ff4d94;
    }

    .form-card h3 {
        color: #2c3e50;
        margin-bottom: 10px;
        text-align: center;
        font-size: 24px;
    }

    .form-card p {
        text-align: center;
        color: #7f8c8d;
        font-size: 14px;
        margin-bottom: 30px;
    }

    .error-box {
        background: #f8d7da;
        color: #721c24;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        text-align: center;
        border: 1px solid #f5c6cb;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        font-weight: bold;
        margin-bottom: 8px;
        color: #34495e;
        font-size: 14px;
    }

    .form-control {
        width: 100%;
        padding: 12px;
        border: 1px solid #ddd;
        border-radius: 8px;
        outline: none;
        font-size: 15px;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: #ff4d94;
        box-shadow: 0 0 5px rgba(255, 77, 148, 0.2);
    }

    textarea.form-control {
        resize: vertical;
        min-height: 100px;
    }

    .btn-submit {
        background: #ff4d94;
        color: white;
        border: none;
        padding: 14px;
        width: 100%;
        border-radius: 8px;
        font-weight: bold;
        font-size: 16px;
        cursor: pointer;
        transition: 0.3s;
        margin-top: 10px;
    }

    .btn-submit:hover {
        background: #e63d83;
        transform: translateY(-2px);
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 20px;
        color: #3498db;
        text-decoration: none;
        font-size: 14px;
        font-weight: bold;
    }

    .back-link:hover {
        text-decoration: underline;
    }
</style>

<div class="form-container">
    <div class="form-card">
        <h3>Add New Category</h3>
        <p>Create a group to organize your products</p>

        <?php if($error): ?>
            <div class="error-box"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" placeholder="e.g. Skin Care, Rings, Electronics" required>
            </div>

            <div class="form-group">
                <label>Short Description</label>
                <textarea name="category_description" class="form-control" placeholder="Briefly describe what this category contains..."></textarea>
            </div>

            <button type="submit" name="add_cat" class="btn-submit">
                <i class="fas fa-save"></i> Save Category
            </button>
        </form>

        <a href="manage_categories.php" class="back-link">
            <i class="fas fa-arrow-left"></i> View All Categories
        </a>
    </div>
</div>

<?php 
include 'backfooter.php'; // Custom Footer
?>
