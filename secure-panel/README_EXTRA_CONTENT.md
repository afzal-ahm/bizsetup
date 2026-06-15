# Extra Content Management System

## Overview
This system allows administrators to manage different types of content sections for their website through a user-friendly interface.

## Features

### Content Types Available
1. **Heading** - Simple heading sections
2. **3 Box Content** - Content displayed in 3 columns
3. **4 Box Content** - Content displayed in 4 columns
4. **About Us** - Company information sections
5. **Moving Line Long Content** - Scrolling or animated text content
6. **Banner** - Promotional banner sections
7. **Why Choose Us** - Feature highlight sections
8. **Counter** - Statistics and number displays
9. **4 Box Content 2** - Alternative 4-column layout
10. **Testimonial** - Customer review sections
11. **FAQ** - Frequently asked questions
12. **Call to Action** - Action-oriented content sections
13. **Social Link** - Social media and contact links

### Form Fields

#### Required Fields
- **Heading 1** - Main heading for the content section
- **Content Type** - Select from the predefined content types

#### Optional Fields
- **Heading 2** - Secondary heading
- **Position** - Display order (lower numbers appear first)
- **Status** - Active/Inactive toggle
- **Image** - Associated image file
- **Link** - URL for clickable content
- **Content** - Main content using CKEditor

## Database Structure

### Main Table: `extra_content`
```sql
CREATE TABLE `extra_content` (
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
);
```

### Page Mapping Table: `page_content_mapping`
```sql
CREATE TABLE `page_content_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(100) NOT NULL,
  `content_id` int(11) NOT NULL,
  `section_order` int(11) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
);
```

## Setup Instructions

### 1. Database Setup
Run the SQL script `create_extra_content_table.sql` in your MySQL database to create the required tables.

### 2. Directory Setup
Create the following directory for image uploads:
```bash
mkdir ../images/extra
chmod 755 ../images/extra
```

### 3. File Permissions
Ensure the upload directory has proper write permissions for the web server.

## Usage

### Adding New Content
1. Navigate to `new_extra.php`
2. Fill in the required fields (Heading 1 and Content Type)
3. Optionally add secondary heading, image, link, and content
4. Set position for display order
5. Choose active status
6. Click "Save Content"

### Content Management
- Content is automatically saved to the `extra_content` table
- Images are uploaded to `../images/extra/` directory
- Each content section gets a unique ID for reference

### Display Order
- Use the position field to control display order
- Lower position numbers appear first
- Default position is 0

## Integration

### Frontend Display
To display content on your website, query the database:
```php
$query = "SELECT * FROM extra_content WHERE is_active = 1 ORDER BY position ASC";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)) {
    // Display content based on type
    switch($row['type']) {
        case 'heading':
            echo "<h1>{$row['heading1']}</h1>";
            if($row['heading2']) echo "<h2>{$row['heading2']}</h2>";
            break;
        case '3_box_content':
            // Display 3-column layout
            break;
        // Add other cases for different content types
    }
}
```

### Page-Specific Content
Use the `page_content_mapping` table to assign specific content sections to different pages:
```php
$page = 'home';
$query = "SELECT ec.* FROM extra_content ec 
          JOIN page_content_mapping pcm ON ec.id = pcm.content_id 
          WHERE pcm.page_name = '$page' AND ec.is_active = 1 
          ORDER BY pcm.section_order ASC";
```

## Security Features

- Input validation and sanitization
- Secure file upload handling
- SQL injection prevention
- XSS protection through proper escaping

## File Structure
```
secure-panel/
├── new_extra.php              # Main content management form
├── create_extra_content_table.sql  # Database setup script
├── README_EXTRA_CONTENT.md    # This documentation
└── ../images/extra/           # Image upload directory
```

## Troubleshooting

### Common Issues
1. **Image upload fails** - Check directory permissions
2. **Database errors** - Verify table structure and connection
3. **Content not displaying** - Check is_active status and position values

### Support
For technical support, check:
- PHP error logs
- MySQL error logs
- File permissions
- Database connection settings

## Future Enhancements

- Content editing functionality
- Bulk content management
- Content templates
- Advanced content types
- Content versioning
- Multi-language support
