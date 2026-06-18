-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `ca_website` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `ca_website`;

-- Drop existing blog table if exists
DROP TABLE IF EXISTS `blog`;

-- Create comprehensive blog table
CREATE TABLE `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `content` longtext NOT NULL,
  `excerpt` text DEFAULT NULL,
  `author` varchar(100) NOT NULL,
  `author_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `featured_image` varchar(255) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `status` enum('draft','published','archived') DEFAULT 'draft',
  `is_featured` tinyint(1) DEFAULT 0,
  `allow_comments` tinyint(1) DEFAULT 1,
  `view_count` int(11) DEFAULT 0,
  `reading_time` int(11) DEFAULT 0,
  `published_date` datetime DEFAULT NULL,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_unique` (`slug`),
  KEY `status_index` (`status`),
  KEY `author_index` (`author`),
  KEY `category_index` (`category_id`),
  KEY `published_date_index` (`published_date`),
  KEY `is_featured_index` (`is_featured`),
  KEY `view_count_index` (`view_count`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create blog categories table
CREATE TABLE IF NOT EXISTS `blog_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `sort_order` int(11) DEFAULT 0,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_date` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_unique` (`slug`),
  KEY `parent_index` (`parent_id`),
  KEY `is_active_index` (`is_active`),
  KEY `sort_order_index` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create blog tags table
CREATE TABLE IF NOT EXISTS `blog_tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug_unique` (`slug`),
  KEY `is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Create blog tag relationships table
CREATE TABLE IF NOT EXISTS `blog_tag_relationships` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blog_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_tag_unique` (`blog_id`, `tag_id`),
  KEY `blog_index` (`blog_id`),
  KEY `tag_index` (`tag_id`),
  FOREIGN KEY (`blog_id`) REFERENCES `blog`(`id`) ON DELETE CASCADE,
  FOREIGN KEY (`tag_id`) REFERENCES `blog_tags`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample blog categories
INSERT INTO `blog_categories` (`name`, `slug`, `description`, `sort_order`) VALUES
('Technology', 'technology', 'Technology related articles and news', 1),
('Business', 'business', 'Business insights and strategies', 2),
('Lifestyle', 'lifestyle', 'Lifestyle and personal development', 3),
('Travel', 'travel', 'Travel guides and experiences', 4),
('Health', 'health', 'Health and wellness articles', 5),
('Education', 'education', 'Educational content and tutorials', 6);

-- Insert sample blog tags
INSERT INTO `blog_tags` (`name`, `slug`, `description`) VALUES
('Web Development', 'web-development', 'Web development related content'),
('Digital Marketing', 'digital-marketing', 'Digital marketing strategies'),
('Startup', 'startup', 'Startup and entrepreneurship'),
('Productivity', 'productivity', 'Productivity tips and tricks'),
('Innovation', 'innovation', 'Innovation and creativity'),
('Leadership', 'leadership', 'Leadership and management');

-- Insert sample blog posts
INSERT INTO `blog` (`title`, `slug`, `content`, `excerpt`, `author`, `image`, `category_id`, `status`, `is_featured`, `published_date`, `reading_time`) VALUES
('Getting Started with Modern Web Development', 'getting-started-with-modern-web-development', '<h2>Introduction</h2><p>Web development has evolved significantly over the years. Modern web development involves using cutting-edge technologies and best practices to create fast, responsive, and user-friendly websites.</p><h2>Key Technologies</h2><ul><li>HTML5</li><li>CSS3</li><li>JavaScript ES6+</li><li>React/Vue.js</li><li>Node.js</li></ul><h2>Conclusion</h2><p>Modern web development is all about creating exceptional user experiences while maintaining code quality and performance.</p>', 'Learn the fundamentals of modern web development and the technologies that power today\'s websites.', 'Admin User', 'sample-blog-1.jpg', 1, 'published', 1, NOW(), 5),
('Digital Marketing Strategies for 2024', 'digital-marketing-strategies-2024', '<h2>Overview</h2><p>Digital marketing continues to evolve with new technologies and changing consumer behaviors. Here are the key strategies that will dominate 2024.</p><h2>Key Strategies</h2><ul><li>AI-Powered Marketing</li><li>Video Content Marketing</li><li>Voice Search Optimization</li><li>Personalization at Scale</li><li>Social Commerce</li></ul><h2>Implementation Tips</h2><p>Focus on creating authentic, valuable content that resonates with your target audience.</p>', 'Discover the top digital marketing strategies that will help your business grow in 2024.', 'Marketing Expert', 'sample-blog-2.jpg', 2, 'published', 1, NOW(), 8),
('Building a Successful Startup: Lessons Learned', 'building-successful-startup-lessons-learned', '<h2>The Journey</h2><p>Starting a business is challenging, but with the right approach, you can increase your chances of success. Here are the key lessons learned from building successful startups.</p><h2>Essential Elements</h2><ul><li>Clear Vision and Mission</li><li>Strong Team Building</li><li>Customer-Centric Approach</li><li>Agile Development</li><li>Financial Planning</li></ul><h2>Success Factors</h2><p>Focus on solving real problems and building genuine relationships with your customers.</p>', 'Learn from real experiences and discover what it takes to build a successful startup from the ground up.', 'Startup Founder', 'sample-blog-3.jpg', 2, 'published', 0, NOW(), 6);

-- Insert sample tag relationships
INSERT INTO `blog_tag_relationships` (`blog_id`, `tag_id`) VALUES
(1, 1), -- Web Development tag for first blog
(2, 2), -- Digital Marketing tag for second blog
(3, 3); -- Startup tag for third blog

echo "Blog system tables created successfully with sample data!";
?>
