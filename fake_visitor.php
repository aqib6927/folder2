<?php
// fake_visitor.php - Smart fake visitor counter

// Check if session is already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize counter if not exists
if(!isset($_SESSION['fake_visitor_started'])) {
    $_SESSION['fake_visitor_started'] = time();
}

// Function to get fake online count (changes randomly but naturally)
function getFakeOnlineCount() {
    // Base between 15-45 visitors
    $base = rand(18, 42);
    
    // Add variation based on time of day (more visitors during day)
    $hour = date('H');
    if($hour >= 10 && $hour <= 22) {
        // Peak hours: add 20-50 more
        $peak = rand(20, 50);
    } elseif($hour >= 6 && $hour < 10) {
        // Morning: add 5-20
        $peak = rand(5, 20);
    } else {
        // Night: add 0-10
        $peak = rand(0, 10);
    }
    
    // Add random fluctuation
    $fluctuation = rand(-3, 5);
    
    $total = $base + $peak + $fluctuation;
    return max(5, min(150, $total)); // Keep between 5-150
}

// Function to get fake today's visitors
function getFakeTodayVisitors() {
    $hour = date('H');
    $minute = date('i');
    
    // Calculate based on time of day
    $timeFactor = ($hour * 60 + $minute) / 1440;
    $baseToday = 150 + ($timeFactor * 850);
    
    // Add randomness
    $random = rand(-20, 35);
    
    return floor(max(50, $baseToday + $random));
}

// Function to get fake total visitors (all time)
function getFakeTotalVisitors() {
    $base_total = 28450;
    $daily_avg = 320;
    
    // Add some fake growth
    $random_growth = rand(0, 45);
    
    return number_format($base_total + $daily_avg + $random_growth);
}

// For AJAX updates - return JSON
if(isset($_GET['ajax'])) {
    header('Content-Type: application/json');
    echo json_encode([
        'online' => getFakeOnlineCount(),
        'today' => getFakeTodayVisitors(),
        'total' => getFakeTotalVisitors()
    ]);
    exit;
}

// Store current values in session for consistency
if(!isset($_SESSION['fake_online'])) {
    $_SESSION['fake_online'] = getFakeOnlineCount();
}
if(!isset($_SESSION['fake_today'])) {
    $_SESSION['fake_today'] = getFakeTodayVisitors();
}

// Slightly update values on each page load
if(rand(1, 3) == 1) {
    $_SESSION['fake_online'] += rand(-2, 3);
    $_SESSION['fake_online'] = max(8, min(120, $_SESSION['fake_online']));
}
if(rand(1, 5) == 1) {
    $_SESSION['fake_today'] += rand(1, 4);
}
?>