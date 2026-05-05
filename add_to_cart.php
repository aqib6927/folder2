<?php require_once 'config.php';
if(!isLoggedIn()) { $_SESSION['message'] = "Please login first"; $_SESSION['message_type'] = "warning"; redirect('login.php'); }
if(isset($_POST['add_to_cart'])) {
    $prod_id = intval($_POST['prod_id']); $quantity = intval($_POST['quantity']); $user_id = $_SESSION['user_id'];
    $check = mysqli_query($conn, "SELECT * FROM cart WHERE user_id=$user_id AND prod_id=$prod_id");
    if(mysqli_num_rows($check) > 0) mysqli_query($conn, "UPDATE cart SET quantity=quantity+$quantity WHERE user_id=$user_id AND prod_id=$prod_id");
    else mysqli_query($conn, "INSERT INTO cart (user_id,prod_id,quantity) VALUES ($user_id,$prod_id,$quantity)");
    $_SESSION['message'] = "Product added to cart!"; $_SESSION['message_type'] = "success";
}
redirect($_SERVER['HTTP_REFERER'] ?? 'products.php');
?>