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

$error = "";
$success_msg = "";

// DELETE LOGIC
if(isset($_GET['del_id'])) {
    $id = intval($_GET['del_id']);
    
    // Check karein ke is category mein products toh nahi?
    $check = mysqli_query($conn, "SELECT * FROM products WHERE cat_id = '$id'");
    if(mysqli_num_rows($check) > 0) {
        $error = "Pehle is category ke products delete karein ya un ki category badlein!";
    } else {
        if(mysqli_query($conn, "DELETE FROM categories WHERE cat_id = '$id'")) {
            $success_msg = "Category successfully deleted!";
        }
    }
}

$cats = mysqli_query($conn, "SELECT * FROM categories ORDER BY cat_id DESC");

include 'backheader.php'; // Custom Header
?>

<style>
    .manage-container {
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
        background: #6f42c1;
        color: white;
        text-decoration: none;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: bold;
        font-size: 14px;
        transition: 0.3s;
    }

    .btn-add:hover { background: #5a32a3; transform: translateY(-2px); }

    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        font-size: 14px;
        text-align: center;
    }
    .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }

    .table-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    table {
        width: 100%;
        border-collapse: collapse;
    }

    thead { background: #f8f9fa; }

    th {
        text-align: left;
        padding: 15px;
        color: #7f8c8d;
        font-size: 13px;
        text-transform: uppercase;
        border-bottom: 2px solid #eee;
    }

    td {
        padding: 15px;
        border-bottom: 1px solid #eee;
        font-size: 14px;
        color: #333;
    }

    tr:hover { background-color: #fcfcfc; }

    .cat-id { color: #95a5a6; font-weight: bold; }
    .cat-name { font-weight: 600; color: #2c3e50; }
    .cat-desc { color: #7f8c8d; font-size: 13px; }

    .btn-delete {
        background: #fff1f2;
        color: #e11d48;
        padding: 8px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        transition: 0.3s;
        display: inline-block;
    }

    .btn-delete:hover {
        background: #e11d48;
        color: white;
    }

    @media (max-width: 768px) {
        .cat-desc { display: none; }
        th:nth-child(3), td:nth-child(3) { display: none; }
    }
</style>

<div class="manage-container">
    <div class="page-header">
        <h2>Manage Categories</h2>
        <a href="add_category.php" class="btn-add">
            <i class="fas fa-plus"></i> Add New Category
        </a>
    </div>

    <?php if($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if($success_msg || isset($_GET['msg'])): ?>
        <div class="alert alert-success">
            <?php echo $success_msg ? $success_msg : htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th style="width: 80px;">ID</th>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th style="text-align: right;">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if(mysqli_num_rows($cats) > 0): while($row = mysqli_fetch_assoc($cats)): ?>
                <tr>
                    <td class="cat-id">#<?php echo $row['cat_id']; ?></td>
                    <td class="cat-name"><?php echo $row['cat_name']; ?></td>
                    <td class="cat-desc">
                        <?php echo $row['cat_description'] ? (strlen($row['cat_description']) > 60 ? substr($row['cat_description'], 0, 60).'...' : $row['cat_description']) : '<span style="font-style:italic; color:#ccc;">No description</span>'; ?>
                    </td>
                    <td style="text-align: right;">
                        <a href="manage_categories.php?del_id=<?php echo $row['cat_id']; ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Kya aap waqai is category ko delete karna chahte hain?')">
                            <i class="fas fa-trash"></i> Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; else: ?>
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #95a5a6;">
                        No categories found.
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
