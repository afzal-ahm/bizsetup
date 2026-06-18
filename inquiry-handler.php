<?php
/**
 * Contact Inquiry Handler
 * Processes contact form submissions and stores them in database
 * Includes spam protection and validation
 */

// Include database connection first
include "data.php";

// Start session for CSRF protection (if not already started)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Set content type for JSON response
header('Content-Type: application/json');

// Function to sanitize input
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Function to validate email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Function to validate phone number
function isValidPhone($phone) {
    // Allow various phone number formats
    $phone = preg_replace('/[^0-9+\-\(\)\s]/', '', $phone);
    return strlen($phone) >= 7 && strlen($phone) <= 20; // More flexible phone validation
}

// Function to detect spam (basic honeypot and rate limiting)
function isSpam($data) {
    // Honeypot field check
    if (!empty($data['honeypot'])) {
        return true;
    }
    
    // Check for common spam keywords
    $spamKeywords = ['viagra', 'casino', 'lottery', 'winner', 'congratulations', 'click here', 'buy now'];
    $message = strtolower($data['message']);
    
    foreach ($spamKeywords as $keyword) {
        if (strpos($message, $keyword) !== false) {
            return true;
        }
    }
    
    // Rate limiting - check if same IP submitted in last 5 minutes
    $ip = $_SERVER['REMOTE_ADDR'];
    $fiveMinutesAgo = date('Y-m-d H:i:s', strtotime('-5 minutes'));
    
    $rateQuery = "SELECT COUNT(*) as count FROM contact_inquiries WHERE ip_address = ? AND created_at > ?";
    global $conn;
    $stmt = mysqli_prepare($conn, $rateQuery);
    mysqli_stmt_bind_param($stmt, 'ss', $ip, $fiveMinutesAgo);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    
    if ($row['count'] > 3) { // Max 3 submissions per 5 minutes
        return true;
    }
    
    return false;
}

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
    exit;
}

try {
    // Create inquiries table if it doesn't exist
    $createTableQuery = "CREATE TABLE IF NOT EXISTS `contact_inquiries` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `first_name` varchar(100) NOT NULL,
        `last_name` varchar(100) DEFAULT NULL,
        `email` varchar(255) NOT NULL,
        `phone` varchar(20) DEFAULT NULL,
        `message` text NOT NULL,
        `source` enum('contact_page','service_detail') DEFAULT 'contact_page',
        `service_name` varchar(255) DEFAULT NULL,
        `service_category` varchar(255) DEFAULT NULL,
        `ip_address` varchar(45) DEFAULT NULL,
        `user_agent` text DEFAULT NULL,
        `status` enum('new','read','responded','closed') DEFAULT 'new',
        `priority` enum('low','medium','high','urgent') DEFAULT 'medium',
        `assigned_to` int(11) DEFAULT NULL,
        `notes` text DEFAULT NULL,
        `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        `responded_at` timestamp NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `email_index` (`email`),
        KEY `status_index` (`status`),
        KEY `source_index` (`source`),
        KEY `created_at_index` (`created_at`),
        KEY `priority_index` (`priority`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    mysqli_query($conn, $createTableQuery);

    // Get and sanitize form data
    $firstName = isset($_POST['first_name']) ? sanitizeInput($_POST['first_name']) : '';
    $lastName = isset($_POST['last_name']) ? sanitizeInput($_POST['last_name']) : '';
    $email = isset($_POST['email']) ? sanitizeInput($_POST['email']) : '';
    $countryCode = isset($_POST['country_code']) ? sanitizeInput($_POST['country_code']) : '';
    $phone = isset($_POST['phone']) ? sanitizeInput($_POST['phone']) : '';
    
    // Prepend country code if present and phone doesn't already start with '+'
    if (!empty($countryCode) && !empty($phone)) {
        if (strpos($phone, '+') !== 0) {
            $phone = $countryCode . ' ' . $phone;
        }
    }

    $message = isset($_POST['message']) ? sanitizeInput($_POST['message']) : '';
    $source = isset($_POST['source']) ? sanitizeInput($_POST['source']) : 'contact_page';
    $serviceName = isset($_POST['service_name']) ? sanitizeInput($_POST['service_name']) : null;
    $serviceCategory = isset($_POST['service_category']) ? sanitizeInput($_POST['service_category']) : null;
    $honeypot = isset($_POST['honeypot']) ? $_POST['honeypot'] : '';
    
    // Validation
    $errors = [];
    
    if (empty($firstName)) {
        $errors[] = 'First name is required.';
    }
    
    if (empty($email)) {
        $errors[] = 'Email address is required.';
    } elseif (!isValidEmail($email)) {
        $errors[] = 'Please enter a valid email address.';
    }
    
    if (!empty($phone) && !isValidPhone($phone)) {
        $errors[] = 'Please enter a valid phone number (7-20 digits).';
    }
    
    if (empty($message)) {
        $errors[] = 'Message is required.';
    } elseif (strlen($message) < 5) {
        $errors[] = 'Message must be at least 5 characters long.';
    }
    
    if (!empty($errors)) {
        echo json_encode([
            'success' => false,
            'message' => 'Validation errors occurred.',
            'errors' => $errors
        ]);
        exit;
    }
    
    // Spam detection
    $formData = [
        'first_name' => $firstName,
        'last_name' => $lastName,
        'email' => $email,
        'phone' => $phone,
        'message' => $message,
        'honeypot' => $honeypot
    ];
    
    if (isSpam($formData)) {
        echo json_encode([
            'success' => false,
            'message' => 'Your submission was flagged as spam. Please try again later.'
        ]);
        exit;
    }
    
    // Get client information
    $ipAddress = $_SERVER['REMOTE_ADDR'];
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    
    // Determine priority based on keywords
    $priority = 'medium';
    $urgentKeywords = ['urgent', 'asap', 'immediately', 'emergency'];
    $highKeywords = ['important', 'deadline', 'tomorrow'];
    
    $messageLower = strtolower($message);
    foreach ($urgentKeywords as $keyword) {
        if (strpos($messageLower, $keyword) !== false) {
            $priority = 'urgent';
            break;
        }
    }
    
    if ($priority === 'medium') {
        foreach ($highKeywords as $keyword) {
            if (strpos($messageLower, $keyword) !== false) {
                $priority = 'high';
                break;
            }
        }
    }
    
    // Insert inquiry into database
    $insertQuery = "INSERT INTO contact_inquiries (first_name, last_name, email, phone, message, source, service_name, service_category, ip_address, user_agent, priority) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $insertQuery);
    if (!$stmt) {
        throw new Exception('Database prepare failed: ' . mysqli_error($conn));
    }
    
    mysqli_stmt_bind_param($stmt, 'sssssssssss', $firstName, $lastName, $email, $phone, $message, $source, $serviceName, $serviceCategory, $ipAddress, $userAgent, $priority);
    
    if (mysqli_stmt_execute($stmt)) {
        $inquiryId = mysqli_insert_id($conn);
        
        echo json_encode([
            'success' => true,
            'message' => 'Thank you for your inquiry! We will get back to you soon.',
            'inquiry_id' => $inquiryId
        ]);
    } else {
        throw new Exception('Failed to save inquiry: ' . mysqli_stmt_error($stmt));
    }
    
    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    error_log("Inquiry Handler Error: " . $e->getMessage());
    
    echo json_encode([
        'success' => false,
        'message' => 'An error occurred while processing your request. Please try again later.'
    ]);
}
?>
