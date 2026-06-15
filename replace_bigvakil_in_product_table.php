<?php
/**
 * Script to replace "Bigvakil" with "BizSetup" in all rows of the product table
 * This script will update all text columns in the product table
 */

// Include database connection
include "data.php";

// Check if connection exists
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

echo "<h2>Product Table Text Replacement Script</h2>";
echo "<p>Replacing 'Bigvakil' with 'BizSetup' in all product table rows...</p>";

// First, let's check current data to see what needs to be replaced
echo "<h3>Step 1: Checking current data...</h3>";

$check_query = "SELECT COUNT(*) as total_products FROM product";
$result = mysqli_query($conn, $check_query);
$total = mysqli_fetch_assoc($result)['total_products'];
echo "<p>Total products in table: " . $total . "</p>";

// Check for existing "Bigvakil" occurrences in various text columns
$text_columns = [
    'product_name',
    'description', 
    'brand',
    'seo_title',
    'seo_keyword', 
    'seo_metatag',
    'seo_discription',
    'category',
    'subcategory',
    'subsubcategory',
    'theme',
    'type',
    'design',
    'material',
    'demo1',
    'demo2'
];

$found_bigvakil = false;
$update_queries = [];

foreach ($text_columns as $column) {
    $check_column_query = "SELECT COUNT(*) as count FROM product WHERE $column LIKE '%Bigvakil%'";
    $result = mysqli_query($conn, $check_column_query);
    
    if ($result) {
        $count = mysqli_fetch_assoc($result)['count'];
        if ($count > 0) {
            echo "<p>Found 'Bigvakil' in column '$column': $count occurrences</p>";
            $found_bigvakil = true;
            
            // Prepare update query for this column
            $update_queries[] = "UPDATE product SET $column = REPLACE($column, 'Bigvakil', 'BizSetup') WHERE $column LIKE '%Bigvakil%'";
        }
    }
}

// Also check for case variations
$case_variations = ['bigvakil', 'BIGVAKIL', 'BigVakil'];
foreach ($case_variations as $variation) {
    foreach ($text_columns as $column) {
        $check_column_query = "SELECT COUNT(*) as count FROM product WHERE $column LIKE '%$variation%'";
        $result = mysqli_query($conn, $check_column_query);
        
        if ($result) {
            $count = mysqli_fetch_assoc($result)['count'];
            if ($count > 0) {
                echo "<p>Found '$variation' in column '$column': $count occurrences</p>";
                $found_bigvakil = true;
                
                // Prepare update query for this variation
                $replacement = ($variation === 'bigvakil') ? 'bizsetup' : 
                              (($variation === 'BIGVAKIL') ? 'BIZSETUP' : 'BizSetup');
                $update_queries[] = "UPDATE product SET $column = REPLACE($column, '$variation', '$replacement') WHERE $column LIKE '%$variation%'";
            }
        }
    }
}

if (!$found_bigvakil) {
    echo "<p style='color: green;'>✓ No 'Bigvakil' occurrences found in product table!</p>";
} else {
    echo "<h3>Step 2: Executing replacement queries...</h3>";
    
    $total_updates = 0;
    $successful_updates = 0;
    
    // Execute all update queries
    foreach ($update_queries as $query) {
        echo "<p>Executing: " . htmlspecialchars($query) . "</p>";
        
        $result = mysqli_query($conn, $query);
        if ($result) {
            $affected_rows = mysqli_affected_rows($conn);
            echo "<p style='color: green;'>✓ Success: $affected_rows rows updated</p>";
            $total_updates += $affected_rows;
            $successful_updates++;
        } else {
            echo "<p style='color: red;'>✗ Error: " . mysqli_error($conn) . "</p>";
        }
    }
    
    echo "<h3>Step 3: Replacement Summary</h3>";
    echo "<p><strong>Total update queries executed:</strong> " . count($update_queries) . "</p>";
    echo "<p><strong>Successful updates:</strong> $successful_updates</p>";
    echo "<p><strong>Total rows affected:</strong> $total_updates</p>";
    
    // Final verification
    echo "<h3>Step 4: Final Verification</h3>";
    $remaining_bigvakil = false;
    
    foreach ($text_columns as $column) {
        $check_query = "SELECT COUNT(*) as count FROM product WHERE $column LIKE '%Bigvakil%' OR $column LIKE '%bigvakil%' OR $column LIKE '%BIGVAKIL%'";
        $result = mysqli_query($conn, $check_query);
        
        if ($result) {
            $count = mysqli_fetch_assoc($result)['count'];
            if ($count > 0) {
                echo "<p style='color: orange;'>⚠ Still found 'Bigvakil' variations in column '$column': $count occurrences</p>";
                $remaining_bigvakil = true;
            }
        }
    }
    
    if (!$remaining_bigvakil) {
        echo "<p style='color: green; font-weight: bold;'>✓ SUCCESS: All 'Bigvakil' occurrences have been replaced with 'BizSetup'!</p>";
    } else {
        echo "<p style='color: orange; font-weight: bold;'>⚠ Some occurrences may still remain. Please check manually.</p>";
    }
}

echo "<h3>Step 5: Sample Data Check</h3>";
echo "<p>Showing first 5 products to verify changes:</p>";

$sample_query = "SELECT id, product_name, brand, seo_title FROM product LIMIT 5";
$result = mysqli_query($conn, $sample_query);

if ($result && mysqli_num_rows($result) > 0) {
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
    echo "<tr><th>ID</th><th>Product Name</th><th>Brand</th><th>SEO Title</th></tr>";
    
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['product_name']) . "</td>";
        echo "<td>" . htmlspecialchars($row['brand']) . "</td>";
        echo "<td>" . htmlspecialchars($row['seo_title']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No product data found for sample display.</p>";
}

// Close database connection
mysqli_close($conn);

echo "<hr>";
echo "<p><strong>Script completed!</strong> Please review the results above.</p>";
echo "<p><em>Note: This script can be run multiple times safely. It will only update rows that contain 'Bigvakil'.</em></p>";
?>
