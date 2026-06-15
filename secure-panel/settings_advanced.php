<?php
error_reporting(0);
ob_start();
session_start();
include_once 'config.php';

// Check if user is logged in
if(!isset($_SESSION['email'])){
    header("Location: login.php");
    exit();
}

// Create locations table if it doesn't exist
$create_locations_table = "CREATE TABLE IF NOT EXISTS company_locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    location_name VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    address TEXT,
    email VARCHAR(255),
    image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    sort_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create_locations_table);

// Handle form submissions
if(isset($_POST['save_company'])) {
    $website_name = mysqli_real_escape_string($conn, $_POST['website_name']);
    $whatsapp_no = mysqli_real_escape_string($conn, $_POST['whatsapp_no']);
    $enquiry_email = mysqli_real_escape_string($conn, $_POST['enquiry_email']);
    $copyright = mysqli_real_escape_string($conn, $_POST['copyright']);
    
    // Handle logo upload
    if(isset($_FILES['logo']) && $_FILES['logo']['name'] != '') {
        $logo_name = $_FILES['logo']['name'];
        $logo_tmp = $_FILES['logo']['tmp_name'];
        $logo_ext = pathinfo($logo_name, PATHINFO_EXTENSION);
        $logo_new_name = 'logo_' . time() . '.' . $logo_ext;
        move_uploaded_file($logo_tmp, "../images/" . $logo_new_name);
        
        $query = "UPDATE settings SET value = '$logo_new_name' WHERE setting_key = 'company_logo'";
        mysqli_query($conn, $query);
    }
    
    // Handle favicon upload
    if(isset($_FILES['favicon']) && $_FILES['favicon']['name'] != '') {
        $favicon_name = $_FILES['favicon']['name'];
        $favicon_tmp = $_FILES['favicon']['tmp_name'];
        $favicon_ext = pathinfo($favicon_name, PATHINFO_EXTENSION);
        $favicon_new_name = 'favicon_' . time() . '.' . $favicon_ext;
        move_uploaded_file($favicon_tmp, "../images/" . $favicon_new_name);
        
        $query = "UPDATE settings SET value = '$favicon_new_name' WHERE setting_key = 'company_favicon'";
        mysqli_query($conn, $query);
    }
    
    // Update other company settings
    $settings = [
        'website_name' => $website_name,
        'whatsapp_no' => $whatsapp_no,
        'enquiry_email' => $enquiry_email,
        'copyright' => $copyright
    ];
    
    foreach($settings as $key => $value) {
        $query = "UPDATE settings SET value = '$value' WHERE setting_key = 'company_$key'";
        mysqli_query($conn, $query);
    }
    
    $success_msg = "Company settings updated successfully!";
}

if(isset($_POST['save_contact'])) {
    $contact_heading = mysqli_real_escape_string($conn, $_POST['contact_heading']);
    
    // Update contact heading
    $query = "UPDATE settings SET value = '$contact_heading' WHERE setting_key = 'contact_heading'";
    mysqli_query($conn, $query);
    
    $success_msg = "Contact settings updated successfully!";
}

if(isset($_POST['add_location'])) {
    $location_name = mysqli_real_escape_string($conn, $_POST['location_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Handle image upload
    $image_name = '';
    if(isset($_FILES['location_image']) && $_FILES['location_image']['name'] != '') {
        $img_name = $_FILES['location_image']['name'];
        $img_tmp = $_FILES['location_image']['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $image_name = 'location_' . time() . '.' . $img_ext;
        move_uploaded_file($img_tmp, "../images/" . $image_name);
    }
    
    $query = "INSERT INTO company_locations (location_name, phone, address, email, image) VALUES ('$location_name', '$phone', '$address', '$email', '$image_name')";
    if(mysqli_query($conn, $query)) {
        $success_msg = "Location added successfully!";
    } else {
        $error_msg = "Error adding location: " . mysqli_error($conn);
    }
}

if(isset($_POST['update_location'])) {
    $location_id = mysqli_real_escape_string($conn, $_POST['location_id']);
    $location_name = mysqli_real_escape_string($conn, $_POST['location_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Handle image upload
    if(isset($_FILES['location_image']) && $_FILES['location_image']['name'] != '') {
        $img_name = $_FILES['location_image']['name'];
        $img_tmp = $_FILES['location_image']['tmp_name'];
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $image_name = 'location_' . time() . '.' . $img_ext;
        move_uploaded_file($img_tmp, "../images/" . $image_name);
        
        $query = "UPDATE company_locations SET location_name='$location_name', phone='$phone', address='$address', email='$email', image='$image_name' WHERE id='$location_id'";
    } else {
        $query = "UPDATE company_locations SET location_name='$location_name', phone='$phone', address='$address', email='$email' WHERE id='$location_id'";
    }
    
    if(mysqli_query($conn, $query)) {
        $success_msg = "Location updated successfully!";
    } else {
        $error_msg = "Error updating location: " . mysqli_error($conn);
    }
}

if(isset($_GET['delete_location'])) {
    $location_id = mysqli_real_escape_string($conn, $_GET['delete_location']);
    $query = "DELETE FROM company_locations WHERE id='$location_id'";
    if(mysqli_query($conn, $query)) {
        $success_msg = "Location deleted successfully!";
    } else {
        $error_msg = "Error deleting location: " . mysqli_error($conn);
    }
}

if(isset($_POST['save_seo'])) {
    $seo_title = mysqli_real_escape_string($conn, $_POST['seo_title']);
    $seo_keywords = mysqli_real_escape_string($conn, $_POST['seo_keywords']);
    $seo_description = mysqli_real_escape_string($conn, $_POST['seo_description']);
    
    $seo_settings = [
        'title' => $seo_title,
        'keywords' => $seo_keywords,
        'description' => $seo_description
    ];
    
    foreach($seo_settings as $key => $value) {
        $query = "UPDATE settings SET value = '$value' WHERE setting_key = 'seo_$key'";
        mysqli_query($conn, $query);
    }
    
    $success_msg = "SEO settings updated successfully!";
}

if(isset($_POST['save_code'])) {
    $google_analytics = mysqli_real_escape_string($conn, $_POST['google_analytics']);
    $chat_code = mysqli_real_escape_string($conn, $_POST['chat_code']);
    $header_code = mysqli_real_escape_string($conn, $_POST['header_code']);
    
    $code_settings = [
        'google_analytics' => $google_analytics,
        'chat_code' => $chat_code,
        'header_code' => $header_code
    ];
    
    foreach($code_settings as $key => $value) {
        $query = "UPDATE settings SET value = '$value' WHERE setting_key = 'code_$key'";
        mysqli_query($conn, $query);
    }
    
    $success_msg = "Code injection settings updated successfully!";
}

// Get current settings
function getSetting($conn, $key) {
    $query = "SELECT value FROM settings WHERE setting_key = '$key'";
    $result = mysqli_query($conn, $query);
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return '';
}

// Get all locations
function getLocations($conn) {
    $locations = [];
    $query = "SELECT * FROM company_locations ORDER BY sort_order, location_name";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $locations[] = $row;
        }
    }
    
    return $locations;
}

// Initialize settings table if it doesn't exist
$create_table = "CREATE TABLE IF NOT EXISTS settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
mysqli_query($conn, $create_table);

// Insert default settings if they don't exist
$default_settings = [
    'company_logo', 'company_favicon', 'company_website_name', 'company_whatsapp_no', 
    'company_enquiry_email', 'company_copyright', 'contact_heading', 'contact_phone', 
    'contact_address', 'contact_email', 'contact_location', 'contact_image', 
    'seo_title', 'seo_keywords', 'seo_description', 'code_google_analytics', 
    'code_chat_code', 'code_header_code'
];

foreach($default_settings as $setting) {
    $check = "SELECT id FROM settings WHERE setting_key = '$setting'";
    $result = mysqli_query($conn, $check);
    if(mysqli_num_rows($result) == 0) {
        $insert = "INSERT INTO settings (setting_key, value) VALUES ('$setting', '')";
        mysqli_query($conn, $insert);
    }
}

$locations = getLocations($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Advanced Settings - Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" href="img/ico/favicon.png">
    
    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/font-entypo.css" rel="stylesheet" type="text/css">
    <link href="css/fonts.css" rel="stylesheet" type="text/css">
    <link href="plugins/jquery-ui/jquery-ui.custom.min.css" rel="stylesheet" type="text/css">
    <link href="plugins/pnotify/css/jquery.pnotify.css" media="screen" rel="stylesheet" type="text/css">
    <link href="css/theme.min.css" rel="stylesheet" type="text/css">
    <link href="css/theme-responsive.min.css" rel="stylesheet" type="text/css">
    <link href="custom/custom.css" rel="stylesheet" type="text/css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .settings-container { padding: 20px; }
        .nav-tabs > li > a { font-family: 'Poppins', sans-serif; font-weight: 500; }
        .form-group label { font-weight: 500; color: #333; }
        .btn-primary { background-color: #008e93; border-color: #008e93; }
        .btn-primary:hover { background-color: #007a7e; border-color: #007a7e; }
        .alert { border-radius: 8px; }
        .card { border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .card-header { background: linear-gradient(135deg, #008e93, #00a8ae); color: white; border-radius: 12px 12px 0 0; }
        .upload-preview { max-width: 200px; max-height: 200px; border-radius: 8px; }
        .location-item { background: #f8f9fa; padding: 15px; border-radius: 8px; margin-bottom: 15px; border: 1px solid #e9ecef; }
        .location-image { max-width: 100px; max-height: 100px; border-radius: 4px; }
        .modal-header { background: linear-gradient(135deg, #008e93, #00a8ae); color: white; }
        .btn-danger { background-color: #dc3545; border-color: #dc3545; }
        .btn-success { background-color: #28a745; border-color: #28a745; }
        .btn-warning { background-color: #ffc107; border-color: #ffc107; color: #212529; }
    </style>
</head>

<body id="dashboard" class="full-layout nav-right-hide nav-right-start-hide nav-top-fixed responsive clearfix" data-active="dashboard" data-smooth-scrolling="1">
    
    <?php include 'header.php'; ?>
    
    <div class="vd_body">
        <div class="content">
            <div class="vd_content-wrapper">
                <div class="vd_container">
                    <div class="vd_content clearfix">
                        <div class="vd_head-section clearfix">
                            <div class="vd_panel-header">
                                <ul class="breadcrumb">
                                    <li><a href="index.php">Dashboard</a></li>
                                    <li class="active">Advanced Settings</li>
                                </ul>
                                <div class="vd_panel-menu">
                                    <div class="menu">
                                        <a href="index.php" class="btn btn-primary">
                                            <i class="fa fa-arrow-left"></i> Back to Dashboard
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="vd_content-section clearfix">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel widget light-widget">
                                        <div class="panel-heading no-title">
                                            <h3 class="panel-title">Advanced Website Settings</h3>
                                        </div>
                                        <div class="panel-body">
                                            <?php if(isset($success_msg)): ?>
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <i class="fa fa-check-circle"></i> <?php echo $success_msg; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if(isset($error_msg)): ?>
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <i class="fa fa-exclamation-circle"></i> <?php echo $error_msg; ?>
                                                </div>
                                            <?php endif; ?>
                                            
                                                                                         <!-- Settings Tabs -->
                                             <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                                                 <li class="active">
                                                     <a href="#company" data-toggle="tab">
                                                         <i class="fa fa-building"></i> Company
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a href="#contact" data-toggle="tab">
                                                         <i class="fa fa-phone"></i> Contact & Locations
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a href="#seo" data-toggle="tab">
                                                         <i class="fa fa-search"></i> SEO
                                                     </a>
                                                 </li>
                                                 <li>
                                                     <a href="#code" data-toggle="tab">
                                                         <i class="fa fa-code"></i> Code Injection
                                                     </a>
                                                 </li>
                                             </ul>
                                            
                                                                                         <div class="tab-content" id="settingsTabContent">
                                                 <!-- Company Tab -->
                                                 <div class="tab-pane active" id="company">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-building"></i> Company Information</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="POST" enctype="multipart/form-data">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Website Name</label>
                                                                            <input type="text" class="form-control" name="website_name" value="<?php echo getSetting($conn, 'company_website_name'); ?>" required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>WhatsApp Number</label>
                                                                            <input type="text" class="form-control" name="whatsapp_no" value="<?php echo getSetting($conn, 'company_whatsapp_no'); ?>" placeholder="+91 98765 43210">
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Enquiry Email</label>
                                                                            <input type="email" class="form-control" name="enquiry_email" value="<?php echo getSetting($conn, 'company_enquiry_email'); ?>" required>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Copyright Text</label>
                                                                            <input type="text" class="form-control" name="copyright" value="<?php echo getSetting($conn, 'company_copyright'); ?>" placeholder="© 2024 Company Name. All rights reserved.">
                                                                        </div>
                                                                    </div>
                                                                    
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Company Logo</label>
                                                                            <input type="file" class="form-control" name="logo" accept="image/*">
                                                                            <?php 
                                                                            $current_logo = getSetting($conn, 'company_logo');
                                                                            if($current_logo): ?>
                                                                                <div class="mt-2">
                                                                                    <img src="../images/<?php echo $current_logo; ?>" class="upload-preview" alt="Current Logo">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                        
                                                                        <div class="form-group">
                                                                            <label>Favicon</label>
                                                                            <input type="file" class="form-control" name="favicon" accept="image/*">
                                                                            <?php 
                                                                            $current_favicon = getSetting($conn, 'company_favicon');
                                                                            if($current_favicon): ?>
                                                                                <div class="mt-2">
                                                                                    <img src="../images/<?php echo $current_favicon; ?>" class="upload-preview" alt="Current Favicon">
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="text-right">
                                                                    <button type="submit" name="save_company" class="btn btn-primary">
                                                                        <i class="fa fa-save"></i> Save Company Settings
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Contact Tab -->
                                                <div class="tab-pane fade" id="contact" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-phone"></i> Contact Information & Locations</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <!-- Contact Heading -->
                                                            <form method="POST" class="mb-4">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
                                                                            <label>Contact Section Heading</label>
                                                                            <input type="text" class="form-control" name="contact_heading" value="<?php echo getSetting($conn, 'contact_heading'); ?>" placeholder="Get In Touch">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="text-right" style="margin-top: 25px;">
                                                                            <button type="submit" name="save_contact" class="btn btn-success">
                                                                                <i class="fa fa-save"></i> Save Heading
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            
                                                            <hr>
                                                            
                                                            <!-- Locations Management -->
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                                        <h5><i class="fa fa-map-marker"></i> Company Locations</h5>
                                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addLocationModal">
                                                                            <i class="fa fa-plus"></i> Add New Location
                                                                        </button>
                                                                    </div>
                                                                    
                                                                    <?php if(empty($locations)): ?>
                                                                        <div class="alert alert-info">
                                                                            <i class="fa fa-info-circle"></i> No locations added yet. Click "Add New Location" to get started.
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="row">
                                                                            <?php foreach($locations as $location): ?>
                                                                                <div class="col-md-6 mb-3">
                                                                                    <div class="location-item">
                                                                                        <div class="d-flex justify-content-between align-items-start">
                                                                                            <div class="flex-grow-1">
                                                                                                <h6 class="mb-2">
                                                                                                    <i class="fa fa-map-marker"></i> <?php echo htmlspecialchars($location['location_name']); ?>
                                                                                                </h6>
                                                                                                <?php if($location['phone']): ?>
                                                                                                    <p class="mb-1"><i class="fa fa-phone"></i> <?php echo htmlspecialchars($location['phone']); ?></p>
                                                                                                <?php endif; ?>
                                                                                                <?php if($location['email']): ?>
                                                                                                    <p class="mb-1"><i class="fa fa-envelope"></i> <?php echo htmlspecialchars($location['email']); ?></p>
                                                                                                <?php endif; ?>
                                                                                                <?php if($location['address']): ?>
                                                                                                    <p class="mb-1"><i class="fa fa-map"></i> <?php echo htmlspecialchars($location['address']); ?></p>
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                            <div class="ml-3">
                                                                                                <?php if($location['image']): ?>
                                                                                                    <img src="../images/<?php echo $location['image']; ?>" class="location-image" alt="Location Image">
                                                                                                <?php endif; ?>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="mt-3">
                                                                                            <button type="button" class="btn btn-warning btn-sm" onclick="editLocation(<?php echo htmlspecialchars(json_encode($location)); ?>)">
                                                                                                <i class="fa fa-edit"></i> Edit
                                                                                            </button>
                                                                                            <a href="?delete_location=<?php echo $location['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this location?')">
                                                                                                <i class="fa fa-trash"></i> Delete
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            <?php endforeach; ?>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- SEO Tab -->
                                                <div class="tab-pane fade" id="seo" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-search"></i> SEO Settings</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="POST">
                                                                <div class="form-group">
                                                                    <label>Default SEO Title</label>
                                                                    <input type="text" class="form-control" name="seo_title" value="<?php echo getSetting($conn, 'seo_title'); ?>" placeholder="Default page title for your website">
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Default Meta Keywords</label>
                                                                    <textarea class="form-control" name="seo_keywords" rows="3" placeholder="Enter keywords separated by commas"><?php echo getSetting($conn, 'seo_keywords'); ?></textarea>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Default Meta Description</label>
                                                                    <textarea class="form-control" name="seo_description" rows="4" placeholder="Enter a compelling description of your website (150-160 characters recommended)"><?php echo getSetting($conn, 'seo_description'); ?></textarea>
                                                                    <small class="form-text text-muted">This description will appear in search engine results.</small>
                                                                </div>
                                                                
                                                                <div class="text-right">
                                                                    <button type="submit" name="save_seo" class="btn btn-primary">
                                                                        <i class="fa fa-save"></i> Save SEO Settings
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!-- Code Injection Tab -->
                                                <div class="tab-pane fade" id="code" role="tabpanel">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4><i class="fa fa-code"></i> Code Injection</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <form method="POST">
                                                                <div class="form-group">
                                                                    <label>Google Analytics Code</label>
                                                                    <textarea class="form-control" name="google_analytics" rows="6" placeholder="Paste your Google Analytics tracking code here (e.g., gtag.js or ga.js)"><?php echo getSetting($conn, 'code_google_analytics'); ?></textarea>
                                                                    <small class="form-text text-muted">This code will be added to the &lt;head&gt; section of all pages.</small>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Chat Widget Code</label>
                                                                    <textarea class="form-control" name="chat_code" rows="6" placeholder="Paste your chat widget code here (e.g., LiveChat, Tawk.to, etc.)"><?php echo getSetting($conn, 'code_chat_code'); ?></textarea>
                                                                    <small class="form-text text-muted">This code will be added to the &lt;head&gt; section of all pages.</small>
                                                                </div>
                                                                
                                                                <div class="form-group">
                                                                    <label>Custom Header Code</label>
                                                                    <textarea class="form-control" name="header_code" rows="6" placeholder="Paste any additional code you want to add to the &lt;head&gt; section"><?php echo getSetting($conn, 'code_header_code'); ?></textarea>
                                                                    <small class="form-text text-muted">This code will be added after the existing head tags on all pages.</small>
                                                                </div>
                                                                
                                                                <div class="text-right">
                                                                    <button type="submit" name="save_code" class="btn btn-primary">
                                                                        <i class="fa fa-save"></i> Save Code Settings
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Location Modal -->
    <div class="modal fade" id="addLocationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-plus"></i> Add New Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Location Name</label>
                            <input type="text" class="form-control" name="location_name" placeholder="e.g., Delhi Office" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone" placeholder="+91 98765 43210">
                        </div>
                        
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" rows="3" placeholder="Enter complete address"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" placeholder="delhi@company.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Location Image (Optional)</label>
                            <input type="file" class="form-control" name="location_image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="add_location" class="btn btn-primary">Add Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Edit Location Modal -->
    <div class="modal fade" id="editLocationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fa fa-edit"></i> Edit Location</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" name="location_id" id="edit_location_id">
                        
                        <div class="form-group">
                            <label>Location Name</label>
                            <input type="text" class="form-control" name="location_name" id="edit_location_name" required>
                        </div>
                        
                        <div class="form-group">
                            <label>Phone Number</label>
                            <input type="text" class="form-control" name="phone" id="edit_phone" placeholder="+91 98765 43210">
                        </div>
                        
                        <div class="form-group">
                            <label>Address</label>
                            <textarea class="form-control" name="address" id="edit_address" rows="3" placeholder="Enter complete address"></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" placeholder="delhi@company.com">
                        </div>
                        
                        <div class="form-group">
                            <label>Location Image (Optional)</label>
                            <input type="file" class="form-control" name="location_image" accept="image/*">
                            <small class="form-text text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="update_location" class="btn btn-primary">Update Location</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Scripts -->
    <script type="text/javascript" src="js/jquery-1.8.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="plugins/pnotify/js/jquery.pnotify.min.js"></script>
    
    <script>
        function editLocation(location) {
            document.getElementById('edit_location_id').value = location.id;
            document.getElementById('edit_location_name').value = location.location_name;
            document.getElementById('edit_phone').value = location.phone;
            document.getElementById('edit_address').value = location.address;
            document.getElementById('edit_email').value = location.email;
            
            $('#editLocationModal').modal('show');
        }
        
        $(document).ready(function() {
            // Initialize tooltips
            $('[data-toggle="tooltip"]').tooltip();
            
            // File upload preview
            $('input[type="file"]').change(function() {
                var file = this.files[0];
                var reader = new FileReader();
                var preview = $(this).siblings('.mt-2').find('img');
                
                if (file) {
                    reader.onload = function(e) {
                        if (preview.length > 0) {
                            preview.attr('src', e.target.result);
                        } else {
                            var img = $('<img class="upload-preview mt-2" alt="Preview">');
                            img.attr('src', e.target.result);
                            $(this).parent().append(img);
                        }
                    }.bind(this);
                    reader.readAsDataURL(file);
                }
            });
            
            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
