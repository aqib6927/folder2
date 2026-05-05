<?php 
require_once 'config.php';

// Session Error Fix: Pehle check karo ke session chal to nahi raha
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$error = "";

if(isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    // MD5 Password logic
    $password = md5($_POST['password']); 

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' AND is_admin=1";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1) {
        $admin_data = mysqli_fetch_assoc($result);
        $_SESSION['admin_id'] = $admin_data['user_id'];
        $_SESSION['admin_name'] = $admin_data['name'];
        
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Ghalat Email/Password ya aap Admin nahi hain!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Jenny's Store</title>
    <!-- No External Links - Fast Loading -->
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, sans-serif; }
        
        body { 
            background: #2c3e50; 
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
        }

        .login-card { 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.4); 
            width: 90%; 
            max-width: 400px; 
        }

        .login-card h2 { 
            text-align: center; 
            margin-bottom: 25px; 
            color: #333;
            font-size: 24px;
            letter-spacing: 1px;
        }

        .pink-text { color: #ff4d94; }

        .error-msg {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            font-size: 14px;
            text-align: center;
            margin-bottom: 15px;
            border: 1px solid #f5c6cb;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label { 
            display: block; 
            font-size: 13px; 
            font-weight: bold; 
            margin-bottom: 8px; 
            color: #555;
        }

        .form-control { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #eee; 
            border-radius: 10px; 
            outline: none; 
            transition: 0.3s;
        }

        .form-control:focus { border-color: #ff4d94; }

        .btn-admin { 
            background: #ff4d94; 
            color: white; 
            border: none; 
            border-radius: 10px; 
            padding: 14px; 
            font-weight: bold; 
            width: 100%; 
            cursor: pointer; 
            font-size: 16px;
            box-shadow: 0 4px 15px rgba(255, 77, 148, 0.3);
            transition: 0.3s;
        }

        .btn-admin:hover { 
            background: #e63d83; 
            transform: translateY(-2px);
        }

        .back-link { 
            display: block; 
            text-align: center; 
            margin-top: 20px; 
            color: #777; 
            text-decoration: none; 
            font-size: 14px;
        }

        .back-link:hover { color: #ff4d94; }
    </style>
</head>
<body>

<div class="login-card">
    <h2>ADMIN <span class="pink-text">LOGIN</span></h2>
    
    <?php if($error): ?>
        <div class="error-msg"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="form-group">
            <label>Admin Email</label>
            <input type="email" name="email" class="form-control" placeholder="admin@example.com" required>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" name="login" class="btn-admin">Enter Dashboard</button>
    </form>
    
    <a href="index.php" class="back-link">← Back to Shop</a>
</div>

</body>
</html>
