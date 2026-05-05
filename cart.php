<?php require_once 'config.php'; include 'header.php';
if(!isLoggedIn()) redirect('login.php');
$user_id = $_SESSION['user_id'];
if(isset($_GET['remove'])) { mysqli_query($conn, "DELETE FROM cart WHERE cart_id=".intval($_GET['remove'])." AND user_id=$user_id"); redirect('cart.php'); }
if(isset($_POST['update_cart'])) {
    foreach($_POST['quantity'] as $cart_id=>$qty) { $qty=intval($qty);
        if($qty<=0) mysqli_query($conn, "DELETE FROM cart WHERE cart_id=$cart_id AND user_id=$user_id");
        else mysqli_query($conn, "UPDATE cart SET quantity=$qty WHERE cart_id=$cart_id AND user_id=$user_id");
    } redirect('cart.php');
}
$cart = mysqli_query($conn, "SELECT c.*, p.prod_name, p.price, p.quantity as stock FROM cart c JOIN products p ON c.prod_id=p.prod_id WHERE c.user_id=$user_id");
$total = 0;
?>
<h2>Shopping Cart</h2><?php 
require_once 'config.php'; 

// Logic hamesha header se pehle honi chahiye taake redirect kaam kare
if(!isLoggedIn()) redirect('login.php');
$user_id = $_SESSION['user_id'];

// Item Remove karne ki logic
if(isset($_GET['remove'])) { 
    mysqli_query($conn, "DELETE FROM cart WHERE cart_id=".intval($_GET['remove'])." AND user_id=$user_id"); 
    redirect('cart.php'); 
}

// Cart Update karne ki logic
if(isset($_POST['update_cart'])) {
    foreach($_POST['quantity'] as $cart_id => $qty) { 
        $qty = intval($qty);
        $cart_id = intval($cart_id);
        if($qty <= 0) {
            mysqli_query($conn, "DELETE FROM cart WHERE cart_id=$cart_id AND user_id=$user_id");
        } else {
            mysqli_query($conn, "UPDATE cart SET quantity=$qty WHERE cart_id=$cart_id AND user_id=$user_id");
        }
    } 
    redirect('cart.php'); // Ab ye redirect sahi kaam karega
}

// Header ko yahan include karein
include 'header.php'; 

$cart = mysqli_query($conn, "SELECT c.*, p.prod_name, p.price, p.quantity as stock FROM cart c JOIN products p ON c.prod_id=p.prod_id WHERE c.user_id=$user_id");
$total = 0;
?>

<div class="container mt-4">
    <h2>Shopping Cart</h2>
    <?php if(mysqli_num_rows($cart) > 0): ?>
    <form method="POST" action="cart.php">
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-light">
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($cart)): 
                    $subtotal = $item['price'] * $item['quantity']; 
                    $total += $subtotal; 
                ?>
                <tr>
                    <td><?php echo $item['prod_name']; ?></td>
                    <td><?php echo number_format($item['price'], 2); ?> rs</td>
                    <td>
                        <input type="number" name="quantity[<?php echo $item['cart_id']; ?>]" 
                               value="<?php echo $item['quantity']; ?>" 
                               min="1" max="<?php echo $item['stock']; ?>" 
                               class="form-control" style="width:80px">
                    </td>
                    <td><?php echo number_format($subtotal, 2); ?> rs</td>
                    <td>
                        <a href="cart.php?remove=<?php echo $item['cart_id']; ?>" 
                           class="btn btn-danger btn-sm" 
                           onclick="return confirm('Remove this item?')">Remove</a>
                    </td>
                </tr>
                <?php endwhile; ?>
                <tr class="table-light">
                    <td colspan="3" class="text-end"><strong>Total Amount:</strong></td>
                    <td colspan="2"><strong><?php echo number_format($total, 2); ?> rs</strong></td>
                </tr>
            </tbody>
        </table>
        <div class="mt-3">
            <button type="submit" name="update_cart" class="btn btn-warning">Update Cart</button>
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout</a>
        </div>
    </form>
    <?php else: ?>
        <div class="alert alert-info">Your cart is empty. <a href="index.php">Continue Shopping</a></div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>

<?php if(mysqli_num_rows($cart)>0): ?>
<form method="POST">
<table class="table table-bordered"><thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr></thead><tbody>
<?php while($item=mysqli_fetch_assoc($cart)): $subtotal=$item['price']*$item['quantity']; $total+=$subtotal; ?>
<tr><td><?php echo $item['prod_name']; ?></td><td><?php echo number_format($item['price'],2); ?> rs</td>
<td><input type="number" name="quantity[<?php echo $item['cart_id']; ?>]" value="<?php echo $item['quantity']; ?>" min="1" max="<?php echo $item['stock']; ?>" style="width:70px"></td>
<td>₹<?php echo number_format($subtotal,2); ?></td>
<td><a href="cart.php?remove=<?php echo $item['cart_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Remove?')">Remove</a></td></tr>
<?php endwhile; ?>
<tr><td colspan="3" class="text-end"><strong>Total:</strong></td><td colspan="2"><strong>₹<?php echo number_format($total,2); ?></strong></td></tr>
</tbody></table>
<button type="submit" name="update_cart" class="btn btn-warning">Update Cart</button>
<a href="checkout.php" class="btn btn-primary-custom">Proceed to Checkout</a>
</form>
<?php else: ?>
<div class="alert alert-info">Your cart is empty. <a href="products.php">Continue Shopping</a></div>
<?php endif; ?>
<?php include 'footer.php'; ?>