# Contact Inquiry System

## Overview
This system replaces email-based contact forms with a database-driven inquiry management system that prevents spam and provides better tracking and management capabilities.

## Features

### 🚫 **Spam Protection**
- **Honeypot Fields**: Hidden fields that trap bots
- **Rate Limiting**: Maximum 3 submissions per IP per 5 minutes
- **Keyword Filtering**: Blocks common spam keywords
- **Input Sanitization**: All inputs are cleaned and validated

### 📊 **Database Storage**
- All inquiries stored in `contact_inquiries` table
- Tracks source (Contact Page vs Service Detail Page)
- Automatic priority assignment based on keywords
- Client information (IP, User Agent) for analysis

### 🎯 **Smart Features**
- **Auto-Priority Detection**: Urgent/High/Medium/Low based on message content
- **Service Context**: Service detail inquiries include service name and category
- **Status Tracking**: New → Read → Responded → Closed workflow
- **Response Time Tracking**: Timestamps for all status changes

### 📱 **User Experience**
- **AJAX Form Submission**: No page reloads
- **Real-time Validation**: Client-side and server-side validation
- **Loading States**: Visual feedback during submission
- **Success/Error Messages**: Clear feedback to users

## Database Structure

### Main Table: `contact_inquiries`
```sql
CREATE TABLE `contact_inquiries` (
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
  PRIMARY KEY (`id`)
);
```

## File Structure

```
/
├── inquiry-handler.php           # Form processing backend
├── create_inquiries_table.sql    # Database setup script
├── contact.php                   # Updated contact page with new form
├── service_detail.php            # Updated service page with new form
└── secure-panel/
    └── view-inquiries.php        # Admin panel for managing inquiries
```

## Installation

1. **Create Database Table**:
   ```bash
   mysql -u your_username -p your_database < create_inquiries_table.sql
   ```

2. **Update File Permissions**:
   ```bash
   chmod 644 inquiry-handler.php
   chmod 644 secure-panel/view-inquiries.php
   ```

3. **Test Forms**:
   - Visit your contact page and submit a test inquiry
   - Visit a service detail page and submit a test inquiry
   - Check the admin panel at `/secure-panel/view-inquiries.php`

## Usage

### For Users
1. **Contact Page**: Standard contact form with name, email, phone, and message
2. **Service Pages**: Context-aware forms that include service information
3. **Validation**: Real-time validation with helpful error messages
4. **Confirmation**: Success messages confirm submission

### For Administrators
1. **View Inquiries**: Access `/secure-panel/view-inquiries.php`
2. **Filter & Search**: Filter by status, source, or search content
3. **Manage Status**: Update inquiry status and add notes
4. **Statistics**: Dashboard shows inquiry counts and trends

## Status Workflow

```
NEW → READ → RESPONDED → CLOSED
```

- **NEW**: Just submitted, needs attention
- **READ**: Viewed by admin, under review
- **RESPONDED**: Reply sent to customer
- **CLOSED**: Issue resolved, no further action needed

## Priority System

**Auto-Detection Keywords**:
- **URGENT**: urgent, asap, immediately, emergency
- **HIGH**: important, deadline, tomorrow
- **MEDIUM**: Default priority
- **LOW**: Manual assignment only

## Spam Protection Details

### Honeypot Field
```html
<input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
```

### Rate Limiting
- Max 3 submissions per IP per 5 minutes
- Configurable in `inquiry-handler.php`

### Keyword Filtering
- Blocks: viagra, casino, lottery, winner, congratulations, click here, buy now
- Easily customizable in the spam detection function

## Security Features

- ✅ SQL Injection Protection (Prepared Statements)
- ✅ XSS Prevention (Input Sanitization)
- ✅ CSRF Protection (Can be enhanced with tokens)
- ✅ Rate Limiting
- ✅ Input Validation
- ✅ Spam Detection

## Customization

### Add New Spam Keywords
Edit `inquiry-handler.php`:
```php
$spamKeywords = ['viagra', 'casino', 'your-keyword-here'];
```

### Change Rate Limiting
Edit `inquiry-handler.php`:
```php
if ($row['count'] > 5) { // Change from 3 to 5
    return true;
}
```

### Add New Status Options
Update database enum and admin panel:
```sql
ALTER TABLE contact_inquiries MODIFY status ENUM('new','read','responded','closed','your-new-status');
```

## Benefits Over Email Forms

| Feature | Email Forms | Database System |
|---------|-------------|-----------------|
| Spam Protection | ❌ Limited | ✅ Advanced |
| Tracking | ❌ None | ✅ Complete |
| Search/Filter | ❌ None | ✅ Advanced |
| Response Time | ❌ Unknown | ✅ Tracked |
| Backup | ❌ Email dependent | ✅ Database backup |
| Analytics | ❌ None | ✅ Built-in stats |
| Workflow | ❌ Manual | ✅ Automated |

## Maintenance

### Regular Tasks
1. **Review New Inquiries**: Check daily for new submissions
2. **Update Status**: Keep inquiry status current
3. **Database Cleanup**: Archive old closed inquiries (optional)
4. **Spam Review**: Monitor and update spam filters

### Backup
```bash
mysqldump -u username -p database_name contact_inquiries > inquiries_backup.sql
```

## Troubleshooting

### Common Issues

**Forms not submitting**:
- Check JavaScript console for errors
- Verify `inquiry-handler.php` permissions
- Check database connection

**Admin panel not loading**:
- Verify database table exists
- Check file permissions
- Review error logs

**Too many spam submissions**:
- Reduce rate limit threshold
- Add more spam keywords
- Implement CAPTCHA (future enhancement)

## Future Enhancements

- 📧 Email notifications for new inquiries
- 🔐 CAPTCHA integration
- 📊 Advanced analytics and reporting
- 🏷️ Tagging and categorization system
- 📱 Mobile app for inquiry management
- 🤖 Auto-response system
- 📈 Performance metrics and SLA tracking

## Support

For technical support or questions about this inquiry system, please contact your development team or refer to the code comments in each file.
