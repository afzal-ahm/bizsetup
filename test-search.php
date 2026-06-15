<?php
include "data.php";

echo "<h2>Database Connection Test</h2>";

// Test database connection
if ($conn) {
    echo "✓ Database connection successful<br><br>";
} else {
    echo "✗ Database connection failed: " . mysqli_connect_error() . "<br><br>";
    exit;
}

// Test sub_subcategory table structure
echo "<h3>Sub_subcategory Table Structure:</h3>";
$structure_query = "DESCRIBE sub_subcategory";
$structure_result = mysqli_query($conn, $structure_query);

if ($structure_result) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
    while ($row = mysqli_fetch_assoc($structure_result)) {
        echo "<tr>";
        echo "<td>" . $row['Field'] . "</td>";
        echo "<td>" . $row['Type'] . "</td>";
        echo "<td>" . $row['Null'] . "</td>";
        echo "<td>" . $row['Key'] . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "Error describing table: " . mysqli_error($conn) . "<br><br>";
}

// Test sample data
echo "<h3>Sample Sub_subcategory Data (First 5 records):</h3>";
$sample_query = "SELECT ssc.*, c.category_name, sc.subcategory_name 
                FROM sub_subcategory ssc 
                LEFT JOIN category c ON ssc.category_id = c.category_id 
                LEFT JOIN subcategory sc ON ssc.subcategory_id = sc.subcategory_id 
                LIMIT 5";
$sample_result = mysqli_query($conn, $sample_query);

if ($sample_result && mysqli_num_rows($sample_result) > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Sub_subcategory Name</th><th>Category</th><th>Subcategory</th></tr>";
    while ($row = mysqli_fetch_assoc($sample_result)) {
        echo "<tr>";
        echo "<td>" . $row['sub_subcategory_id'] . "</td>";
        echo "<td>" . $row['sub_subcategory_name'] . "</td>";
        echo "<td>" . ($row['category_name'] ?: 'NULL') . "</td>";
        echo "<td>" . ($row['subcategory_name'] ?: 'NULL') . "</td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "No data found or error: " . mysqli_error($conn) . "<br><br>";
}

// Test search functionality
echo "<h3>Test Search for 'Business':</h3>";
$test_search = "Business";
$search_query = "SELECT 
    ssc.sub_subcategory_id,
    ssc.sub_subcategory_name,
    c.category_name,
    c.url as category_url,
    sc.subcategory_name,
    sc.url as subcategory_url
FROM sub_subcategory ssc 
LEFT JOIN category c ON ssc.category_id = c.category_id 
LEFT JOIN subcategory sc ON ssc.subcategory_id = sc.subcategory_id 
WHERE ssc.sub_subcategory_name LIKE '%$test_search%' 
   OR c.category_name LIKE '%$test_search%'
   OR sc.subcategory_name LIKE '%$test_search%'
ORDER BY ssc.sub_subcategory_name ASC
LIMIT 5";

$search_result = mysqli_query($conn, $search_query);

if ($search_result && mysqli_num_rows($search_result) > 0) {
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>Service Name</th><th>Category</th><th>Subcategory</th><th>Generated URL</th></tr>";
    while ($row = mysqli_fetch_assoc($search_result)) {
        $url = "service_detail.php?cat_url=" . urlencode($row['category_url']) . 
               "&sub_url=" . urlencode($row['subcategory_url']) . 
               "&subsub_url=" . urlencode($row['sub_subcategory_id']);
        
        echo "<tr>";
        echo "<td>" . $row['sub_subcategory_name'] . "</td>";
        echo "<td>" . ($row['category_name'] ?: 'NULL') . "</td>";
        echo "<td>" . ($row['subcategory_name'] ?: 'NULL') . "</td>";
        echo "<td><a href='" . $url . "'>" . $url . "</a></td>";
        echo "</tr>";
    }
    echo "</table><br>";
} else {
    echo "No search results found or error: " . mysqli_error($conn) . "<br><br>";
}

echo "<h3>Direct API Test:</h3>";
echo "<a href='search-api.php?q=business' target='_blank'>Test API: search-api.php?q=business</a><br>";
echo "<a href='search-api.php?debug=1&q=test' target='_blank'>Debug API: search-api.php?debug=1&q=test</a><br>";
?>

<script>
// Test AJAX call
console.log('Testing AJAX call...');
fetch('search-api.php?q=business')
    .then(response => response.json())
    .then(data => {
        console.log('API Response:', data);
        document.body.innerHTML += '<h3>AJAX Test Result:</h3><pre>' + JSON.stringify(data, null, 2) + '</pre>';
    })
    .catch(error => {
        console.error('AJAX Error:', error);
        document.body.innerHTML += '<h3>AJAX Test Error:</h3><pre>' + error + '</pre>';
    });
</script>
