<?php
ob_start();
session_start();
error_reporting(0);
require('config.php');

// Check if user is logged in (add your authentication check here)
// if (!isset($_SESSION['admin_id'])) {
//     header('Location: login.php');
//     exit;
// }

// Get filters from URL parameters
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';

// Build query
$where_conditions = [];
if ($search) {
    $where_conditions[] = "email LIKE '%$search%'";
}
if ($status_filter) {
    $where_conditions[] = "status = '$status_filter'";
}
if ($date_from) {
    $where_conditions[] = "DATE(subscribed_at) >= '$date_from'";
}
if ($date_to) {
    $where_conditions[] = "DATE(subscribed_at) <= '$date_to'";
}

$where_clause = $where_conditions ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Get all subscribers based on filters
$query = "SELECT id, email, status, subscribed_at, updated_at, ip_address, user_agent, source 
          FROM newsletter_subscribers $where_clause 
          ORDER BY subscribed_at DESC";
$result = mysqli_query($conn, $query);

// Set headers for CSV download
$filename = 'newsletter_subscribers_' . date('Y-m-d_H-i-s') . '.csv';
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Pragma: no-cache');
header('Expires: 0');

// Open output stream
$output = fopen('php://output', 'w');

// Add CSV headers
$headers = [
    'ID',
    'Email',
    'Status',
    'Subscribed Date',
    'Updated Date',
    'IP Address',
    'User Agent',
    'Source'
];
fputcsv($output, $headers);

// Add data rows
while ($row = mysqli_fetch_assoc($result)) {
    $data = [
        $row['id'],
        $row['email'],
        ucfirst($row['status']),
        $row['subscribed_at'],
        $row['updated_at'],
        $row['ip_address'],
        $row['user_agent'],
        $row['source']
    ];
    fputcsv($output, $data);
}

// Close output stream
fclose($output);

// Close database connection
mysqli_close($conn);
exit;
?>
