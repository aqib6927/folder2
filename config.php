<?php
ob_start();

session_start();

// Database configuration
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'store';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Set timezone
date_default_timezone_set('Asia/Karachi');

// Site configuration
$site_name = "Jenny's Cosmetics & Jewelry";

// Function to check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Function to check if user is admin
function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == true;
}

// Function to redirect
function redirect($url) {
    header("Location: $url");
    exit();
}

// Function to display messages
function displayMessage() {
    if(isset($_SESSION['message'])) {
        echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert">
                ' . $_SESSION['message'] . '
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>';
        unset($_SESSION['message']);
        unset($_SESSION['message_type']);
    }
}

// Function to get cart count
function getCartCount($user_id) {
    global $conn;
    $result = mysqli_query($conn, "SELECT SUM(quantity) as total FROM cart WHERE user_id = $user_id");
    $data = mysqli_fetch_assoc($result);
    return $data['total'] ? $data['total'] : 0;
}
?>