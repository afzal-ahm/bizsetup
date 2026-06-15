<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Database Connection Test</h2>";

// Test config file inclusion
if(file_exists('config.php')) {
    echo "✓ Config file exists<br>";
    include_once 'config.php';
    
    if(isset($conn)) {
        echo "✓ Database connection variable exists<br>";
        
        // Test connection
        if(mysqli_ping($conn)) {
            echo "✓ Database connection is working<br>";
            
            // Show database info
            echo "✓ Connected to database: " . mysqli_get_dbname($conn) . "<br>";
            echo "✓ Server info: " . mysqli_get_server_info($conn) . "<br>";
            
            // Test table creation
            $create_table = "CREATE TABLE IF NOT EXISTS `extra_content` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `heading1` varchar(255) NOT NULL,
                `heading2` varchar(255) DEFAULT NULL,
                `content` longtext,
                `link` varchar(500) DEFAULT NULL,
                `type` varchar(100) NOT NULL,
                `image` varchar(255) DEFAULT NULL,
                `position` int(11) DEFAULT 0,
                `is_active` tinyint(1) DEFAULT 1,
                `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
                `updated_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
            
            $result = mysqli_query($conn, $create_table);
            if($result) {
                echo "✓ Table created/verified successfully<br>";
                
                // Test insert
                $test_insert = "INSERT INTO `extra_content`(`heading1`, `heading2`, `content`, `type`, `position`, `is_active`) 
                               VALUES ('Test Heading', 'Test Subheading', 'Test content', 'heading', 1, 1)";
                $insert_result = mysqli_query($conn, $test_insert);
                
                if($insert_result) {
                    echo "✓ Test insert successful<br>";
                    
                    // Clean up test data
                    $delete_test = "DELETE FROM `extra_content` WHERE `heading1` = 'Test Heading'";
                    mysqli_query($conn, $delete_test);
                    echo "✓ Test data cleaned up<br>";
                } else {
                    echo "✗ Test insert failed: " . mysqli_error($conn) . "<br>";
                }
            } else {
                echo "✗ Table creation failed: " . mysqli_error($conn) . "<br>";
            }
        } else {
            echo "✗ Database connection failed: " . mysqli_error($conn) . "<br>";
        }
    } else {
        echo "✗ Database connection variable not found<br>";
    }
} else {
    echo "✗ Config file not found<br>";
}

echo "<br><a href='new_extra.php'>Go to Add Content Page</a>";
echo "<br><a href='test_db.php'>Refresh Test</a>";
?>
