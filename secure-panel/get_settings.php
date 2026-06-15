<?php
// Helper file to get website settings
// Include this file in any page where you need to access settings

function getWebsiteSetting($conn, $key) {
    $query = "SELECT value FROM settings WHERE setting_key = '$key'";
    $result = mysqli_query($conn, $query);
    if($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return '';
}

// Function to get all settings at once
function getAllSettings($conn) {
    $settings = [];
    $query = "SELECT setting_key, value FROM settings";
    $result = mysqli_query($conn, $query);
    
    if($result) {
        while($row = mysqli_fetch_assoc($result)) {
            $settings[$row['setting_key']] = $row['value'];
        }
    }
    
    return $settings;
}

// Function to get company settings
function getCompanySettings($conn) {
    $company_settings = [];
    $keys = ['company_logo', 'company_favicon', 'company_website_name', 'company_whatsapp_no', 'company_enquiry_email', 'company_copyright'];
    
    foreach($keys as $key) {
        $company_settings[$key] = getWebsiteSetting($conn, $key);
    }
    
    return $company_settings;
}

// Function to get contact settings
function getContactSettings($conn) {
    $contact_settings = [];
    $keys = ['contact_heading', 'contact_phone', 'contact_address', 'contact_email', 'contact_location', 'contact_image'];
    
    foreach($keys as $key) {
        $contact_settings[$key] = getWebsiteSetting($conn, $key);
    }
    
    return $contact_settings;
}

// Function to get SEO settings
function getSEOSettings($conn) {
    $seo_settings = [];
    $keys = ['seo_title', 'seo_keywords', 'seo_description'];
    
    foreach($keys as $key) {
        $seo_settings[$key] = getWebsiteSetting($conn, $key);
    }
    
    return $seo_settings;
}

// Function to get code injection settings
function getCodeSettings($conn) {
    $code_settings = [];
    $keys = ['code_google_analytics', 'code_chat_code', 'code_header_code'];
    
    foreach($keys as $key) {
        $code_settings[$key] = getWebsiteSetting($conn, $key);
    }
    
    return $code_settings;
}

// Function to output Google Analytics code
function outputGoogleAnalytics($conn) {
    $code = getWebsiteSetting($conn, 'code_google_analytics');
    if(!empty($code)) {
        echo $code;
    }
}

// Function to output chat widget code
function outputChatCode($conn) {
    $code = getWebsiteSetting($conn, 'code_chat_code');
    if(!empty($code)) {
        echo $code;
    }
}

// Function to output custom header code
function outputHeaderCode($conn) {
    $code = getWebsiteSetting($conn, 'code_header_code');
    if(!empty($code)) {
        echo $code;
    }
}

// Function to output favicon
function outputFavicon($conn) {
    $favicon = getWebsiteSetting($conn, 'company_favicon');
    if(!empty($favicon)) {
        echo '<link rel="icon" type="image/x-icon" href="images/' . $favicon . '">';
    }
}

// Function to output website title
function outputWebsiteTitle($conn, $page_title = '') {
    $website_name = getWebsiteSetting($conn, 'company_website_name');
    $seo_title = getWebsiteSetting($conn, 'seo_title');
    
    if(!empty($page_title)) {
        echo $page_title . ' - ' . $website_name;
    } elseif(!empty($seo_title)) {
        echo $seo_title;
    } else {
        echo $website_name;
    }
}

// Function to output SEO meta tags
function outputSEOMeta($conn) {
    $seo_keywords = getWebsiteSetting($conn, 'seo_keywords');
    $seo_description = getWebsiteSetting($conn, 'seo_description');
    
    if(!empty($seo_keywords)) {
        echo '<meta name="keywords" content="' . htmlspecialchars($seo_keywords) . '">' . "\n";
    }
    
    if(!empty($seo_description)) {
        echo '<meta name="description" content="' . htmlspecialchars($seo_description) . '">' . "\n";
    }
}
?>
