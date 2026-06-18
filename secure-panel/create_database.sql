-- Create database if it doesn't exist
CREATE DATABASE IF NOT EXISTS `ca_website` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use the database
USE `ca_website`;

-- Create table for extra content sections
CREATE TABLE IF NOT EXISTS `extra_content` (
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
  PRIMARY KEY (`id`),
  KEY `type_index` (`type`),
  KEY `position_index` (`position`),
  KEY `is_active_index` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample data for different content types
INSERT INTO `extra_content` (`heading1`, `heading2`, `content`, `type`, `position`, `is_active`) VALUES
('Welcome to Our Company', 'Your Trusted Partner', '<p>We are committed to providing the best services to our customers.</p>', 'heading', 1, 1),
('Why Choose Us', 'Excellence in Every Detail', '<div class="row"><div class="col-md-4"><h4>Quality</h4><p>We maintain the highest standards</p></div><div class="col-md-4"><h4>Service</h4><p>24/7 customer support</p></div><div class="col-md-4"><h4>Experience</h4><p>Years of industry expertise</p></div></div>', '3_box_content', 2, 1),
('Our Services', 'Comprehensive Solutions', '<div class="row"><div class="col-md-3"><h4>Service 1</h4><p>Description of service 1</p></div><div class="col-md-3"><h4>Service 2</h4><p>Description of service 2</p></div><div class="col-md-3"><h4>Service 3</h4><p>Description of service 3</p></div><div class="col-md-3"><h4>Service 4</h4><p>Description of service 4</p></div></div>', '4_box_content', 3, 1),
('About Us', 'Our Story', '<p>Founded with a vision to revolutionize the industry, we have grown from a small startup to a leading company.</p>', 'about_us', 4, 1),
('Latest Updates', 'Stay Informed', '<p>Get the latest news and updates about our company and industry developments.</p>', 'moving_line', 5, 1),
('Special Offer', 'Limited Time Deal', '<p>Don\'t miss out on our special promotional offers!</p>', 'banner', 6, 1),
('Why Choose Us', 'The Best Choice', '<p>We offer unmatched quality and service that sets us apart from the competition.</p>', 'why_choose_us', 7, 1),
('Our Achievements', 'Numbers That Matter', '<div class="row"><div class="col-md-3"><h3>1000+</h3><p>Happy Clients</p></div><div class="col-md-3"><h3>500+</h3><p>Projects</p></div><div class="col-md-3"><h3>50+</h3><p>Team Members</p></div><div class="col-md-3"><h3>10+</h3><p>Years Experience</p></div></div>', 'counter', 8, 1),
('Featured Products', 'Top Picks', '<div class="row"><div class="col-md-6"><h4>Product 1</h4><p>Description of product 1</p></div><div class="col-md-6"><h4>Product 2</h4><p>Description of product 2</p></div></div>', '4_box_content_2', 9, 1),
('Client Testimonials', 'What They Say', '<div class="testimonial"><p>"Excellent service and quality products!"</p><h5>- John Doe, CEO</h5></div>', 'testimonial', 10, 1),
('Frequently Asked Questions', 'Common Queries', '<div class="faq-item"><h4>Question 1?</h4><p>Answer to question 1</p></div>', 'faq', 11, 1),
('Get Started Today', 'Ready to Begin?', '<p>Contact us now to get started with your project!</p><a href="#" class="btn btn-primary">Contact Us</a>', 'call_to_action', 12, 1),
('Follow Us', 'Stay Connected', '<div class="social-links"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-linkedin"></i></a></div>', 'social_link', 13, 1),
('Banner Heading', 'Main Banner', '<p>This is the main banner heading for your website.</p>', 'banner_heading', 14, 1),
('After Search Content', 'Search Results', '<p>Content that appears after search results.</p>', 'after_search_content', 15, 1);

-- Create table for managing content sections on different pages
CREATE TABLE IF NOT EXISTS `page_content_mapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_name` varchar(100) NOT NULL,
  `content_id` int(11) NOT NULL,
  `section_order` int(11) DEFAULT 0,
  `is_visible` tinyint(1) DEFAULT 1,
  `created_date` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `page_name_index` (`page_name`),
  KEY `content_id_index` (`content_id`),
  FOREIGN KEY (`content_id`) REFERENCES `extra_content`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert sample page mappings
INSERT INTO `page_content_mapping` (`page_name`, `content_id`, `section_order`) VALUES
('home', 1, 1),
('home', 2, 2),
('home', 3, 3),
('about', 4, 1),
('about', 5, 2),
('services', 6, 1),
('services', 7, 2),
('contact', 8, 1);

echo "Database and tables created successfully!";
?>
