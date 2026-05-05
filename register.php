<?php require_once 'config.php'; include 'header.php'; if(isLoggedIn()) redirect('index.php');

if(isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $work_phone = mysqli_real_escape_string($conn, $_POST['work_phone']);
    $cell_no = mysqli_real_escape_string($conn, $_POST['cell_no']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
    
    // Passwords pick karein
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    // --- CHECK: Password Match ho rahay hain? ---
    if($password !== $cpassword) {
        $_SESSION['message'] = "Passwords do not match!"; 
        $_SESSION['message_type'] = "danger";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($check) > 0) {
            $_SESSION['message'] = "Email already registered!"; 
            $_SESSION['message_type'] = "danger";
        } else {
            // Password ko hash/encrypt karein (MD5 purana hai par aap ke code ke mutabiq)
            $secure_pass = md5($password);
            
            $query = "INSERT INTO users (name,address,email,work_phone,cell_no,dob,category,remarks,password) 
                      VALUES ('$name','$address','$email','$work_phone','$cell_no','$dob','$category','$remarks','$secure_pass')";
            
            if(mysqli_query($conn, $query)) {
                $_SESSION['message'] = "Registration successful! Please login."; 
                $_SESSION['message_type'] = "success";
                redirect('login.php');
            } else {
                $_SESSION['message'] = "Error: Could not register."; 
                $_SESSION['message_type'] = "danger";
            }
        }
    }
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow">
            <div class="card-header bg-primary text-white"><h4 class="mb-0">Customer Registration</h4></div>
            <div class="card-body">
                
                <!-- Display Session Messages -->
                <?php if(isset($_SESSION['message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['message_type']; ?>">
                        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Full Name *</label><input type="text" name="name" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Email *</label><input type="email" name="email" class="form-control" required></div>
                    </div>
                    <div class="mb-3"><label>Address *</label><textarea name="address" class="form-control" rows="2" required></textarea></div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Work Phone</label><input type="text" name="work_phone" class="form-control"></div>
                        <div class="col-md-6 mb-3"><label>Cell No *</label><input type="text" name="cell_no" class="form-control" required></div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Date of Birth</label><input type="date" name="dob" class="form-control"></div>
                        <div class="col-md-6 mb-3">
                            <label>Category</label>
                            <select name="category" class="form-control">
                                <option value="">Select</option>
                                <option>Regular Customer</option><option>Premium Customer</option><option>Wholesale</option><option>Distributor</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3"><label>Remarks</label><textarea name="remarks" class="form-control" rows="2" placeholder="Any additional information..."></textarea></div>
                    <div class="row">
                        <div class="col-md-6 mb-3"><label>Password *</label><input type="password" name="password" class="form-control" required></div>
                        <div class="col-md-6 mb-3"><label>Confirm Password *</label><input type="password" name="cpassword" class="form-control" required></div>
                    </div>
                    <button type="submit" name="register" class="btn btn-primary w-100">Register</button>
                    <div class="text-center mt-3">
                        <a href="login.php" class="btn btn-link">Already have account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include 'footer.php'; ?>
