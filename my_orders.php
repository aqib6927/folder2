<?php require_once 'config.php'; include 'header.php';
if(!isLoggedIn()) redirect('login.php');
$orders = mysqli_query($conn, "SELECT * FROM orders WHERE user_id={$_SESSION['user_id']} ORDER BY order_date DESC");
?>
<h2>My Orders</h2>
<?php if(mysqli_num_rows($orders)>0): while($order=mysqli_fetch_assoc($orders)):
$items = mysqli_query($conn, "SELECT oi.*, p.prod_name FROM order_items oi JOIN products p ON oi.prod_id=p.prod_id WHERE oi.order_id={$order['order_id']}"); ?>
<div class="card mb-4"><div class="card-header"><strong>Order #<?php echo $order['order_id']; ?></strong> - <?php echo date('d-m-Y H:i',strtotime($order['order_date'])); ?>
<span class="badge bg-<?php echo $order['status']=='Pending'?'warning':'success'; ?> float-end"><?php echo $order['status']; ?></span></div>
<div class="card-body"><table class="table"><thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Subtotal</th></tr></thead><tbody>
<?php while($item=mysqli_fetch_assoc($items)): ?>
<tr><td><?php echo $item['prod_name']; ?></td><td><?php echo $item['quantity']; ?></td><td>₹<?php echo number_format($item['price'],2); ?></td>
<td>₹<?php echo number_format($item['quantity']*$item['price'],2); ?></td></tr>
<?php endwhile; ?></tbody><tfoot><tr><th colspan="3" class="text-end">Total:</th><th>₹<?php echo number_format($order['total_amount'],2); ?></th></tr></tfoot></table></div></div>
<?php endwhile; else: ?><div class="alert alert-info">No orders yet. <a href="products.php">Start Shopping</a></div><?php endif; ?>
<?php include 'footer.php'; ?>