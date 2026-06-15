# Website Settings System

This document explains how to use the comprehensive website settings system that has been created for your admin panel.

## Overview

The settings system provides a centralized way to manage all website configurations including company information, contact details, SEO settings, and code injection. It's designed to be user-friendly and follows the existing admin panel theme.

## Files Created

1. **`settings.php`** - Basic settings page with company, contact, SEO, and code injection tabs
2. **`settings_advanced.php`** - Advanced settings page with multiple location support
3. **`get_settings.php`** - Helper functions to retrieve settings in other parts of the website
4. **`SETTINGS_README.md`** - This documentation file

## Features

### 1. Company Tab
- **Website Name**: Set your company's website name
- **WhatsApp Number**: Add your business WhatsApp contact
- **Enquiry Email**: Set the main enquiry email address
- **Copyright Text**: Customize copyright information
- **Company Logo**: Upload and manage company logo
- **Favicon**: Upload and manage website favicon

### 2. Contact Tab
- **Contact Heading**: Set the main contact section title
- **Multiple Locations**: Add, edit, and delete multiple branch locations
- **Location Details**: Each location can have:
  - Location name (e.g., "Delhi Office", "Mumbai Branch")
  - Phone number
  - Address
  - Email
  - Location image

### 3. SEO Tab
- **Default SEO Title**: Set default page titles
- **Meta Keywords**: Add default keywords for search engines
- **Meta Description**: Set default page descriptions

### 4. Code Injection Tab
- **Google Analytics**: Paste Google Analytics tracking code
- **Chat Widget**: Add live chat widget code
- **Custom Header Code**: Inject any additional code into the `<head>` section

## How to Use

### Accessing Settings
1. Log into your admin panel
2. Navigate to **Settings** in the left menu
3. Choose between:
   - **Basic Settings**: Simple settings management
   - **Advanced Settings**: Full settings with multiple location support

### Adding Multiple Locations
1. Go to the **Contact & Locations** tab
2. Click **"Add New Location"**
3. Fill in the location details:
   - Location name (e.g., "Delhi Office")
   - Phone number
   - Address
   - Email
   - Optional location image
4. Click **"Add Location"**

### Editing Locations
1. Find the location you want to edit
2. Click the **"Edit"** button
3. Modify the details as needed
4. Click **"Update Location"**

### Deleting Locations
1. Find the location you want to delete
2. Click the **"Delete"** button
3. Confirm the deletion

## Using Settings in Your Website

### Include the Helper File
```php
<?php
include_once 'secure-panel/get_settings.php';
?>
```

### Get Company Settings
```php
<?php
$company = getCompanySettings($conn);
echo $company['company_website_name'];
echo $company['company_logo'];
?>
```

### Get Contact Settings
```php
<?php
$contact = getContactSettings($conn);
echo $contact['contact_heading'];
?>
```

### Get All Locations
```php
<?php
$locations = getLocations($conn);
foreach($locations as $location) {
    echo $location['location_name'];
    echo $location['phone'];
    echo $location['address'];
}
?>
```

### Output SEO Meta Tags
```php
<?php
outputSEOMeta($conn);
?>
```

### Output Website Title
```php
<title><?php outputWebsiteTitle($conn, 'Page Name'); ?></title>
```

### Output Code Injection
```php
<?php
// In your <head> section
outputGoogleAnalytics($conn);
outputChatCode($conn);
outputHeaderCode($conn);
?>
```

## Database Structure

### Settings Table
```sql
CREATE TABLE settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    value TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### Company Locations Table
```sql
CREATE TABLE company_locations (
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
);
```

## Security Features

- **Session Validation**: Only logged-in admin users can access settings
- **SQL Injection Protection**: All inputs are properly escaped
- **File Upload Security**: Only image files are allowed
- **Access Control**: Settings are only accessible through the admin panel

## File Uploads

- **Logo**: Uploaded to `../images/` directory
- **Favicon**: Uploaded to `../images/` directory
- **Location Images**: Uploaded to `../images/` directory
- **Supported Formats**: All common image formats (JPG, PNG, GIF, etc.)

## Customization

### Adding New Settings
1. Add the setting key to the `$default_settings` array
2. Create the form field in the appropriate tab
3. Handle the form submission
4. Use `getSetting()` function to retrieve the value

### Styling
The settings pages use the existing admin panel theme with:
- Poppins Google Font
- Consistent color scheme (#008e93)
- Responsive design
- Modern card-based layout

## Troubleshooting

### Common Issues

1. **Settings not saving**: Check database connection and permissions
2. **Images not uploading**: Verify directory permissions for `../images/`
3. **Page not loading**: Ensure all required files are included
4. **Menu not showing**: Check if the admin menu has been updated

### Error Messages
- **"Company settings updated successfully!"**: Settings saved successfully
- **"Error adding location"**: Database error occurred
- **"Location deleted successfully!"**: Location removed successfully

## Support

If you encounter any issues:
1. Check the error logs
2. Verify database connectivity
3. Ensure all files are properly uploaded
4. Check file permissions

## Future Enhancements

Potential improvements for future versions:
- Bulk location import/export
- Setting categories and groups
- User permission levels for different settings
- Setting change history and audit logs
- API endpoints for external access
- Setting validation rules
- Backup and restore functionality

---

**Note**: This settings system is designed to be extensible. You can easily add new settings by following the existing pattern and updating the database structure as needed.
