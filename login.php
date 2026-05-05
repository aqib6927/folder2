<?php 
require_once 'config.php'; 
include 'header.php'; 

// Agar pehle se login hai to home page pe bhej do
if(isLoggedIn()) redirect('index.php');

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = md5($_POST['password']);
    
    $query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // Session mein data save karna
        $_SESSION['user_id'] = $user['user_id']; 
        $_SESSION['user_name'] = $user['name']; 
        $_SESSION['is_admin'] = $user['is_admin'];
        
        // Admin hai to dashboard, warna home page
        redirect($user['is_admin'] ? 'admin_dashboard.php' : 'index.php');
    } else { 
        $_SESSION['message'] = "Invalid Email or Password!"; 
        $_SESSION['message_type'] = "danger"; 
    }
}
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Customer Login</h4>
            </div>
            <div class="card-body">
                <?php displayMessage(); ?>
                <form method="POST">
                    <div class="mb-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                    <div class="text-center mt-3">
                        <a href="register.php" class="text-decoration-none">New customer? Register here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
