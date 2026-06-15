<?php 

include "secure-panel/config.php";
session_start();
 
 $urlmain='https://bizsetup.in/';
 
  $ss = "SELECT * FROM settings 
       WHERE setting_key IN (
           'company_logo',
           'company_favicon',
           'company_website_name',
           'seo_title',
           'seo_keywords',
            'company_whatsapp_no',
             'company_enquiry_email',
              'company_copyright',
               'code_google_analytics',
                'code_chat_code',
                 'code_header_code', 
           'seo_description'
       )";

$re = mysqli_query($conn, $ss);

$settings = [];
while($row = mysqli_fetch_assoc($re)){
    $settings[$row['setting_key']] = $row['value'];
}

// Example usage:
  $company_logo        = isset($settings['company_logo']) ? $settings['company_logo'] : '';
  $company_favicon     = isset($settings['company_favicon']) ? $settings['company_favicon'] : '';
$company_website_name= isset($settings['company_website_name']) ? $settings['company_website_name'] : '';
$seo_title           = isset($settings['seo_title']) ? $settings['seo_title'] : '';
$seo_keywords        = isset($settings['seo_keywords']) ? $settings['seo_keywords'] : '';
$seo_description     = isset($settings['seo_description']) ? $settings['seo_description'] : '';
$company_whatsapp_no    = isset($settings['company_whatsapp_no']) ? $settings['company_whatsapp_no'] : '';
$company_enquiry_email     = isset($settings['company_enquiry_email']) ? $settings['company_enquiry_email'] : '';
$company_copyright    = isset($settings['company_copyright']) ? $settings['company_copyright'] : '';
$code_google_analytics     = isset($settings['code_google_analytics']) ? $settings['code_google_analytics'] : '';
$code_chat_code    = isset($settings['code_chat_code']) ? $settings['code_chat_code'] : '';
$code_header_code   = isset($settings['code_header_code']) ? $settings['code_header_code'] : '';

				
	 
	
	 				
	
                                     				
										?>