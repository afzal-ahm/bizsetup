<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include "data.php";

// Set proper headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Log function for debugging
function logDebug($message) {
    error_log("[SEARCH-API] " . $message);
}

logDebug("API called with parameters: " . json_encode($_GET));

try {
    // Check database connection
    if (!isset($conn) || !$conn) {
        logDebug("Database connection failed");
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }
    
    // Check if search query is provided
    if (!isset($_GET['q']) || empty(trim($_GET['q']))) {
        logDebug("Empty search query");
        echo json_encode([]);
        exit;
    }
    
    $search_term_raw = trim($_GET['q']);
    $search_term = mysqli_real_escape_string($conn, $search_term_raw);
    logDebug("Searching for: " . $search_term);
    
    // Debug mode
    if (isset($_GET['debug'])) {
        echo json_encode([
            'debug' => true,
            'search_term' => $search_term,
            'db_connection' => isset($conn) ? 'OK' : 'FAILED',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
    
    // Synonym mapping / keyword expansions for common queries
    $synonyms = [
        'company registration' => ['private limited company', 'company registration', 'one person company', 'nidhi company', 'producer company', 'company name search'],
        'accounting & business compliance' => ['accounting and book-keeping', 'payroll maintenance', 'tds return filing', 'gst filing', 'compliance'],
        'accounting and business compliance' => ['accounting and book-keeping', 'payroll maintenance', 'tds return filing', 'gst filing', 'compliance'],
        'business registration' => ['private limited company', 'partnership firm', 'sole proprietorship', 'llp', 'limited liability partnership'],
        'company incorporation' => ['private limited company', 'company incorporation', 'one person company'],
        'after search content' => ['private limited company', 'gst registration', 'trademark registration', 'limited liability partnership']
    ];
    
    $search_terms = [$search_term_raw];
    $lower_search = strtolower($search_term_raw);
    foreach ($synonyms as $key => $replacements) {
        if ($lower_search === $key || strpos($lower_search, $key) !== false) {
            $search_terms = array_merge($search_terms, $replacements);
        }
    }
    $search_terms = array_unique($search_terms);
    
    // Build SQL condition clauses
    $where_clauses = [];
    foreach ($search_terms as $term) {
        $term_escaped = mysqli_real_escape_string($conn, $term);
        $where_clauses[] = "ssc.sub_subcategory_name LIKE '%$term_escaped%'";
        $where_clauses[] = "c.category_name LIKE '%$term_escaped%'";
        $where_clauses[] = "sc.subcategory_name LIKE '%$term_escaped%'";
    }
    $where_sql = implode(' OR ', $where_clauses);
    
    // Build search query
    $query = "SELECT 
        ssc.sub_subcategory_id,
        ssc.sub_subcategory_name,
        c.category_name,
        c.url as category_url,
        sc.subcategory_name,
        sc.url as subcategory_url
    FROM sub_subcategory ssc 
    LEFT JOIN category c ON ssc.category_id = c.category_id 
    LEFT JOIN subcategory sc ON ssc.subcategory_id = sc.subcategory_id 
    WHERE ($where_sql)
    ORDER BY 
        CASE 
            WHEN ssc.sub_subcategory_name LIKE '$search_term%' THEN 1
            WHEN ssc.sub_subcategory_name LIKE '%$search_term%' THEN 2
            ELSE 3
        END,
        ssc.sub_subcategory_name ASC
    LIMIT 10";
    
    logDebug("Executing query: " . $query);
    
    $result = mysqli_query($conn, $query);
    
    if (!$result) {
        $error = mysqli_error($conn);
        logDebug("Query failed: " . $error);
        echo json_encode(['error' => 'Database query failed: ' . $error]);
        exit;
    }
    
    $suggestions = [];
    $count = 0;
    
    while ($row = mysqli_fetch_assoc($result)) {
        $count++;
        
        // Build URL
        $category_url = $row['category_url'] ?: 'unknown';
        $subcategory_url = $row['subcategory_url'] ?: 'unknown';
        $subsub_id = $row['sub_subcategory_id'];
        
        $url = "service_detail.php?cat_url=" . urlencode($category_url) . 
               "&sub_url=" . urlencode($subcategory_url) . 
               "&subsub_url=" . urlencode($subsub_id);
        
        $suggestions[] = [
            'id' => $subsub_id,
            'name' => $row['sub_subcategory_name'] ?: 'Unnamed Service',
            'category' => $row['category_name'] ?: 'General',
            'subcategory' => $row['subcategory_name'] ?: 'Services',
            'url' => $url,
            'display' => ($row['sub_subcategory_name'] ?: 'Unnamed Service') . 
                        " - " . ($row['category_name'] ?: 'General') . 
                        " > " . ($row['subcategory_name'] ?: 'Services')
        ];
    }
    
    logDebug("Found $count results");
    
    echo json_encode($suggestions);
    
} catch (Exception $e) {
    $error = 'Server error: ' . $e->getMessage();
    logDebug($error);
    echo json_encode(['error' => $error]);
}
?>
