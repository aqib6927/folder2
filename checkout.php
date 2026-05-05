<?php require_once 'config.php'; include 'header.php';
if(!isLoggedIn()) redirect('login.php');
$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id=$user_id"));
$cart = mysqli_query($conn, "SELECT c.*, p.prod_name, p.price FROM cart c JOIN products p ON c.prod_id=p.prod_id WHERE c.user_id=$user_id");
if(mysqli_num_rows($cart)==0) redirect('cart.php');
if(isset($_POST['place_order'])) {
    $total=0; $items=[];
    while($item=mysqli_fetch_assoc($cart)) { $subtotal=$item['price']*$item['quantity']; $total+=$subtotal; $items[]=$item; }
    mysqli_query($conn, "INSERT INTO orders (user_id,total_amount) VALUES ($user_id,$total)");
    $order_id = mysqli_insert_id($conn);
    foreach($items as $item) {
        mysqli_query($conn, "INSERT INTO order_items (order_id,prod_id,quantity,price) VALUES ($order_id,{$item['prod_id']},{$item['quantity']},{$item['price']})");
        mysqli_query($conn, "UPDATE products SET quantity=quantity-{$item['quantity']} WHERE prod_id={$item['prod_id']}");
    }
    mysqli_query($conn, "DELETE FROM cart WHERE user_id=$user_id");
    $_SESSION['message'] = "Order placed successfully! Order ID: #$order_id"; $_SESSION['message_type'] = "success";
    redirect('my_orders.php');
}
mysqli_data_seek($cart,0); $total=0;
?>
<h2>Checkout</h2>
<div class="row"><div class="col-md-7"><div class="card"><div class="card-header"><h4>Billing Information</h4></div>
<div class="card-body"><table class="table"><tr><th>Name:</th><td><?php echo $user['name']; ?></td></tr>
<tr><th>Address:</th><td><?php echo $user['address']; ?></td></tr>
<tr><th>Email:</th><td><?php echo $user['email']; ?></td></tr>
<tr><th>Work Phone:</th><td><?php echo $user['work_phone']; ?></td></tr>
<tr><th>Cell No:</th><td><?php echo $user['cell_no']; ?></td></tr>
<tr><th>Date of Birth:</th><td><?php echo $user['dob']; ?></td></tr>
<tr><th>Category:</th><td><?php echo $user['category']; ?></td></tr>
<tr><th>Remarks:</th><td><?php echo $user['remarks']; ?></td></tr>
</table></div></div></div>
<div class="col-md-5"><div class="card"><div class="card-header"><h4>Order Summary</h4></div>
<div class="card-body"><table class="table"><?php while($item=mysqli_fetch_assoc($cart)): $subtotal=$item['price']*$item['quantity']; $total+=$subtotal; ?>
<tr><td><?php echo $item['prod_name']; ?> x<?php echo $item['quantity']; ?></td><td><?php echo number_format($subtotal,2); ?> rs</td></tr>
<?php endwhile; ?><tr class="table-active"><th>Total</th><th><?php echo number_format($total,2); ?> rs</th></tr></table>
<form method="POST"><button type="submit" name="place_order" class="btn btn-primary-custom w-100">Place Order</button></form>
</div></div></div></div>
<?php include 'footer.php'; ?>