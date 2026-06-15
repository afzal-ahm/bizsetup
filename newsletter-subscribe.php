<?php
// Newsletter Subscription Handler
header('Content-Type: application/json');

// Database configuration (same as main config)
$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "ca_website";

try {
    // Create database connection using the same settings as main application
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Check if the newsletter_subscribers table exists, if not create it
    $createTableSQL = "CREATE TABLE IF NOT EXISTS newsletter_subscribers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL UNIQUE,
        status ENUM('active', 'inactive', 'unsubscribed') DEFAULT 'active',
        subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        ip_address VARCHAR(45),
        user_agent TEXT,
        source VARCHAR(100) DEFAULT 'footer_form'
    )";
    
    $pdo->exec($createTableSQL);
    
} catch(PDOException $e) {
    error_log("Database connection failed: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'Database connection failed. Please try again later.'
    ]);
    exit;
}

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

// Get and validate email
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if (empty($email)) {
    echo json_encode([
        'success' => false,
        'message' => 'Email address is required.'
    ]);
    exit;
}

// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode([
        'success' => false,
        'message' => 'Please enter a valid email address.'
    ]);
    exit;
}

// Sanitize email
$email = filter_var($email, FILTER_SANITIZE_EMAIL);

// Get additional information
$ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
$user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$source = 'footer_form';

try {
    // Check if email already exists
    $checkStmt = $pdo->prepare("SELECT id, status FROM newsletter_subscribers WHERE email = ?");
    $checkStmt->execute([$email]);
    $existingSubscriber = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingSubscriber) {
        if ($existingSubscriber['status'] === 'unsubscribed') {
            // Reactivate unsubscribed user
            $updateStmt = $pdo->prepare("UPDATE newsletter_subscribers SET status = 'active', updated_at = CURRENT_TIMESTAMP, ip_address = ?, user_agent = ?, source = ? WHERE id = ?");
            $updateStmt->execute([$ip_address, $user_agent, $source, $existingSubscriber['id']]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Welcome back! Your subscription has been reactivated successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'This email address is already subscribed to our newsletter.'
            ]);
        }
        exit;
    }
    
    // Insert new subscriber
    $insertStmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email, ip_address, user_agent, source) VALUES (?, ?, ?, ?)");
    $insertStmt->execute([$email, $ip_address, $user_agent, $source]);
    
    // Log successful subscription (optional)
    error_log("New newsletter subscriber: $email from IP: $ip_address");
    
    echo json_encode([
        'success' => true,
        'message' => 'Thank you! You have been successfully subscribed to our newsletter.'
    ]);
    
} catch(PDOException $e) {
    error_log("Newsletter subscription error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your subscription. Please try again later.'
    ]);
} catch(Exception $e) {
    error_log("Unexpected error: " . $e->getMessage());
    echo json_encode([
        'success' => false,
        'message' => 'An unexpected error occurred. Please try again later.'
    ]);
}
?>
