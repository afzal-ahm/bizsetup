<?php
// Dynamic variables fallback
$display_title = isset($page_title) && !empty($page_title) ? $page_title : (isset($seo_title) && !empty(trim($seo_title)) ? $seo_title : 'BizSetup - Start & Grow Your Business in India');
$display_description = isset($page_description) && !empty($page_description) ? $page_description : (isset($seo_description) && !empty(trim($seo_description)) ? $seo_description : 'BizSetup provides hassle-free business registration, company incorporation, GST filing, trademark registration, and compliances in India.');
$display_keywords = isset($page_keywords) && !empty($page_keywords) ? $page_keywords : (isset($seo_keywords) && !empty(trim($seo_keywords)) ? $seo_keywords : 'company registration, pvt ltd incorporation, gst filing, trademark registration, ROC compliance, accounting');
?>
    <meta name="robots" content="index, follow">
    <title><?= htmlspecialchars($display_title) ?></title>
    <meta name="keywords" content="<?= htmlspecialchars($display_keywords) ?>">
    <meta name="description" content="<?= htmlspecialchars($display_description) ?>">