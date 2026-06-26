<?php 
include "data.php";

$page_title = 'About Us - BizSetup | Reliable Business Registration & Tax Advisory';
$page_description = 'BizSetup is a trusted business compliance platform backed by VPRO & Co LLP, Chartered Accountants. We provide end-to-end services in company registration, GST, and audit.';
$page_keywords = 'about bizsetup, company registration india, tax compliance, charter accountants, VPRO & Co LLP, startup advisory, GST filing, corporate compliance';
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "include/title.php";?> 
    <?php include "include/css.php";?> 
    
    <!-- Custom Style Block for About Us Page -->
    <style>
        /* Custom Hero Banner */
        .custom-about-hero {
            background: linear-gradient(135deg, #0b2545 0%, #1c4c82 50%, #0b2545 100%);
            position: relative;
            padding: 90px 0;
            overflow: hidden;
            color: #ffffff;
        }
        
        .hero-glow-1 {
            position: absolute;
            top: -50%;
            left: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(241, 141, 45, 0.25) 0%, rgba(241, 141, 45, 0) 70%);
            filter: blur(50px);
            pointer-events: none;
            animation: floatGlow 10s ease-in-out infinite alternate;
        }
        
        .hero-glow-2 {
            position: absolute;
            bottom: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(28, 76, 130, 0.4) 0%, rgba(28, 76, 130, 0) 70%);
            filter: blur(60px);
            pointer-events: none;
            animation: floatGlow 12s ease-in-out infinite alternate-reverse;
        }
        
        @keyframes floatGlow {
            0% { transform: translate(0, 0) scale(1); }
            100% { transform: translate(20px, 20px) scale(1.1); }
        }
        
        .relative-content {
            position: relative;
            z-index: 2;
        }
        
        .hero-subtitle {
            display: inline-block;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #f18d2d;
            margin-bottom: 10px;
        }
        
        .breadcrumb-title {
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
        }
        
        .highlight-text {
            color: #f18d2d;
        }
        
        .custom-breadcrumb {
            background: transparent;
            padding: 0;
        }
        
        .custom-breadcrumb .breadcrumb-item {
            font-size: 14px;
            font-weight: 500;
        }
        
        .custom-breadcrumb .breadcrumb-item a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .custom-breadcrumb .breadcrumb-item a:hover {
            color: #f18d2d;
        }
        
        .custom-breadcrumb .breadcrumb-item.active {
            color: #ffffff;
        }
        
        .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255, 255, 255, 0.4);
        }

        /* Moving Line Support Section */
        .support-section {
            background-color: #0b2545 !important;
            padding: 15px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .horizontal-slide {
            overflow: hidden;
            white-space: nowrap;
            width: 100%;
        }
        
        .slide-list {
            display: inline-block;
            animation: marquee 25s linear infinite;
        }
        
        .support-item {
            display: inline-block;
            margin-right: 50px;
        }
        
        .support-item h5 {
            color: rgba(255, 255, 255, 0.9);
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @keyframes marquee {
            0% { transform: translate3d(0, 0, 0); }
            100% { transform: translate3d(-50%, 0, 0); }
        }

        /* Content Sections */
        .about-section {
            padding: 80px 0;
            background-color: #ffffff;
        }

        .section-header {
            margin-bottom: 50px;
            text-align: center;
        }

        .section-header .sub-title {
            color: #f18d2d;
            font-weight: 700;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            display: block;
            margin-bottom: 8px;
        }

        .section-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: #0b2545;
            position: relative;
            padding-bottom: 15px;
            display: inline-block;
        }

        .section-header h2::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #f18d2d 0%, #ffc107 100%);
            border-radius: 2px;
        }

        /* Two Column Intro */
        .intro-text-block h3 {
            color: #0b2545;
            font-weight: 700;
            font-size: 26px;
            margin-bottom: 20px;
        }

        .intro-text-block p {
            color: #555555;
            font-size: 16px;
            line-height: 1.7;
            margin-bottom: 20px;
        }

        .intro-card {
            background: linear-gradient(145deg, #0b2545 0%, #173d66 100%);
            color: #ffffff;
            border-radius: 16px;
            padding: 40px;
            height: 100%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(11, 37, 69, 0.15);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .intro-card::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle, rgba(241, 141, 45, 0.15) 0%, rgba(241, 141, 45, 0) 70%);
            pointer-events: none;
        }

        .intro-card h4 {
            font-weight: 800;
            font-size: 24px;
            color: #f18d2d;
            margin-bottom: 15px;
        }

        .intro-card p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 0;
        }

        /* Vision, Mission, Commitment Section */
        .values-section {
            padding: 80px 0;
            background-color: #f8fafc;
        }

        .value-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 35px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            position: relative;
        }

        .value-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(11, 37, 69, 0.08);
            border-color: #f18d2d;
        }

        .value-icon-box {
            width: 60px;
            height: 60px;
            background-color: rgba(241, 141, 45, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            transition: all 0.3s ease;
        }

        .value-card:hover .value-icon-box {
            background-color: #f18d2d;
        }

        .value-icon-box i {
            font-size: 24px;
            color: #f18d2d;
            transition: all 0.3s ease;
        }

        .value-card:hover .value-icon-box i {
            color: #ffffff;
        }

        .value-card h4 {
            color: #0b2545;
            font-weight: 700;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .value-card p {
            color: #64748b;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 0;
        }

        .commitment-list {
            list-style: none;
            padding-left: 0;
            margin-bottom: 0;
        }

        .commitment-list li {
            position: relative;
            padding-left: 28px;
            margin-bottom: 12px;
            color: #64748b;
            font-size: 14px;
            font-weight: 500;
        }

        .commitment-list li:last-child {
            margin-bottom: 0;
        }

        .commitment-list li::before {
            content: "\f00c";
            font-family: "Font Awesome 6 Free";
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 1px;
            color: #f18d2d;
            font-size: 14px;
        }

        /* Leadership Team Section */
        .leadership-section {
            padding: 80px 0;
            background-color: #ffffff;
        }

        .team-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 35px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .team-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(11, 37, 69, 0.1);
            border-color: #f18d2d;
        }

        .avatar-box {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #0b2545 0%, #1c4c82 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            box-shadow: 0 6px 15px rgba(11, 37, 69, 0.15);
            transition: all 0.3s ease;
            border: 4px solid #ffffff;
            outline: 2px solid #e2e8f0;
        }

        .team-card:hover .avatar-box {
            transform: scale(1.05);
            outline-color: #f18d2d;
        }

        .avatar-initials {
            color: #ffffff;
            font-size: 32px;
            font-weight: 800;
            letter-spacing: 1px;
        }

        .team-card h4 {
            color: #0b2545;
            font-weight: 800;
            font-size: 22px;
            margin-bottom: 5px;
        }

        .team-card .role {
            color: #f18d2d;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
        }

        .team-card .bio {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 20px;
            text-align: justify;
        }

        .divider {
            width: 100%;
            height: 1px;
            background-color: #e2e8f0;
            margin-bottom: 20px;
        }

        .spec-title {
            color: #0b2545;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 12px;
            align-self: flex-start;
        }

        .spec-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            justify-content: flex-start;
            width: 100%;
        }

        .spec-tag {
            background-color: #f1f5f9;
            color: #334155;
            font-size: 11px;
            font-weight: 600;
            padding: 5px 10px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
            transition: all 0.2s ease;
        }

        .team-card:hover .spec-tag {
            background-color: rgba(241, 141, 45, 0.05);
            border-color: rgba(241, 141, 45, 0.2);
            color: #0b2545;
        }

        .team-card:hover .spec-tag:hover {
            background-color: #f18d2d;
            color: #ffffff;
            border-color: #f18d2d;
            transform: translateY(-2px);
        }

        /* What We Do Section */
        .services-section {
            padding: 80px 0;
            background-color: #f8fafc;
        }

        .service-mini-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 20px;
            height: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.01);
        }

        .service-mini-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(11, 37, 69, 0.06);
            border-color: #f18d2d;
        }

        .service-icon-wrapper {
            width: 45px;
            height: 45px;
            background-color: rgba(28, 76, 130, 0.08);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .service-mini-card:hover .service-icon-wrapper {
            background-color: #0b2545;
        }

        .service-icon-wrapper i {
            font-size: 18px;
            color: #0b2545;
            transition: all 0.3s ease;
        }

        .service-mini-card:hover .service-icon-wrapper i {
            color: #ffffff;
        }

        .service-mini-card h5 {
            color: #0b2545;
            font-weight: 700;
            font-size: 15px;
            margin: 0;
            line-height: 1.4;
        }

        /* Why Choose Us Section */
        .choose-section {
            padding: 80px 0;
            background-color: #ffffff;
        }

        .choose-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 30px;
            height: 100%;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0,0,0,0.02);
            display: flex;
            flex-direction: column;
        }

        .choose-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(11, 37, 69, 0.08);
            border-color: #f18d2d;
        }

        .choose-header {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .choose-icon {
            width: 48px;
            height: 48px;
            background-color: rgba(241, 141, 45, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .choose-card:hover .choose-icon {
            background-color: #f18d2d;
        }

        .choose-icon i {
            font-size: 20px;
            color: #f18d2d;
            transition: all 0.3s ease;
        }

        .choose-card:hover .choose-icon i {
            color: #ffffff;
        }

        .choose-header h4 {
            color: #0b2545;
            font-weight: 700;
            font-size: 18px;
            margin: 0;
        }

        .choose-card p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
            margin: 0;
        }
    </style>
</head>

<body>

    <?php include "include/header.php";?> 
    
    <!-- Hero Section -->
    <div class="breadcrumb-bar text-center custom-about-hero">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>
        <div class="container relative-content">
            <div class="row">
                <div class="col-md-12 col-12">
                    <span class="hero-subtitle">Who We Are</span>
                    <h1 class="breadcrumb-title mb-3" style="color: #fff !important;">About <span class="highlight-text">BizSetup</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0 custom-breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $urlmain; ?>"><i class="isax isax-home5 me-1"></i>Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">About Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Hero Section -->

    <!-- Moving Line Support Section -->
    <section class="support-section">
        <div class="horizontal-slide d-flex">
            <div class="slide-list d-flex">
                <div class="support-item">
                    <h5>Simplify Compliance</h5>
                </div>
                <div class="support-item">
                    <h5>Chartered Accountant Led Advisory</h5>
                </div>
                <div class="support-item">
                    <h5>Pan-India Service Network</h5>
                </div>
                <div class="support-item">
                    <h5>Transparent Pricing</h5>
                </div>
                <div class="support-item">
                    <h5>End-to-End Business Solutions</h5>
                </div>
                <!-- Duplicate for seamless loop -->
                <div class="support-item">
                    <h5>Simplify Compliance</h5>
                </div>
                <div class="support-item">
                    <h5>Chartered Accountant Led Advisory</h5>
                </div>
                <div class="support-item">
                    <h5>Pan-India Service Network</h5>
                </div>
                <div class="support-item">
                    <h5>Transparent Pricing</h5>
                </div>
                <div class="support-item">
                    <h5>End-to-End Business Solutions</h5>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 1: Intro -->
    <section class="about-section">
        <div class="container">
            <div class="row align-items-stretch row-gap-4">
                <div class="col-lg-7">
                    <div class="intro-text-block">
                        <span class="text-primary fs-14 fw-bold text-uppercase letter-spacing-1 mb-2 d-block">Empowering Entrepreneurs</span>
                        <h3>Simplifying Business Compliance for Growing Businesses</h3>
                        <p>
                            BizSetup is a trusted business services platform dedicated to helping entrepreneurs, startups, professionals, and businesses establish, manage, and grow their ventures with confidence.
                        </p>
                        <p>
                            We understand that starting and running a business involves numerous legal, regulatory, and financial responsibilities. Our mission is to simplify these complexities by providing end-to-end support for business registration, taxation, compliance, accounting, and advisory services under one roof.
                        </p>
                        <p>
                            From company incorporation and LLP registration to GST, trademark registration, income tax compliance, accounting, and corporate advisory, we help businesses stay compliant while focusing on growth.
                        </p>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="intro-card">
                        <h4>Powered by VPRO & Co LLP</h4>
                        <span class="badge bg-warning text-dark align-self-start mb-3 px-3 py-2 fw-semibold">Chartered Accountants</span>
                        <p class="mb-3">
                            BizSetup is backed by VPRO & Co LLP, a professionally managed Chartered Accountant firm committed to delivering high-quality taxation, accounting, audit, and business advisory services.
                        </p>
                        <p>
                            By combining professional expertise with technology-enabled processes, we provide a seamless experience for businesses across India. Our clients benefit from practical guidance, timely compliance support, and personalized attention from qualified professionals.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Vision, Mission, Commitment -->
    <section class="values-section">
        <div class="container">
            <div class="section-header">
                <span class="sub-title">Our Pillars</span>
                <h2>Vision, Mission & Commitment</h2>
            </div>
            <div class="row row-gap-4">
                <!-- Vision -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-eye"></i>
                        </div>
                        <h4>Our Vision</h4>
                        <p>
                            To become one of India's most trusted business services platforms by delivering reliable, technology-enabled, and professionally managed solutions that support businesses throughout their lifecycle.
                        </p>
                    </div>
                </div>
                <!-- Mission -->
                <div class="col-lg-4 col-md-6">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-rocket"></i>
                        </div>
                        <h4>Our Mission</h4>
                        <p>
                            To simplify compliance, promote entrepreneurship, and help businesses succeed by providing accurate, timely, and value-driven professional services.
                        </p>
                    </div>
                </div>
                <!-- Commitment -->
                <div class="col-lg-4 col-md-12">
                    <div class="value-card">
                        <div class="value-icon-box">
                            <i class="fa-solid fa-handshake-angle"></i>
                        </div>
                        <h4>Our Commitment</h4>
                        <ul class="commitment-list">
                            <li>Professional Integrity</li>
                            <li>Timely Service Delivery</li>
                            <li>Client Confidentiality</li>
                            <li>Regulatory Compliance</li>
                            <li>Practical Business Solutions</li>
                            <li>Long-Term Client Success</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Leadership Team -->
    <section class="leadership-section">
        <div class="container">
            <div class="section-header">
                <span class="sub-title">Our Leadership</span>
                <h2>Meet Our Partners</h2>
            </div>
            <div class="row row-gap-4 justify-content-center">
                <!-- Vishal Gupta -->
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="avatar-box">
                            <span class="avatar-initials">VG</span>
                        </div>
                        <h4>CA Vishal Gupta</h4>
                        <span class="role">Founder & Partner</span>
                        <p class="bio">
                            CA Vishal Gupta is a practicing Chartered Accountant with extensive experience in taxation, GST, business registration, compliance management, and financial advisory. He has advised numerous startups, SMEs, and established businesses on regulatory compliance and growth strategies.
                        </p>
                        <div class="divider"></div>
                        <span class="spec-title">Specialization</span>
                        <div class="spec-tags">
                            <span class="spec-tag">Business Registration</span>
                            <span class="spec-tag">GST & Tax Advisory</span>
                            <span class="spec-tag">Corporate Compliance</span>
                            <span class="spec-tag">Financial Consulting</span>
                            <span class="spec-tag">Startup Advisory</span>
                        </div>
                    </div>
                </div>
                <!-- Om Prakash -->
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="avatar-box">
                            <span class="avatar-initials">OP</span>
                        </div>
                        <h4>CA Om Prakash</h4>
                        <span class="role">Partner</span>
                        <p class="bio">
                            CA Om Prakash specializes in accounting, audit, taxation, and financial reporting. His expertise helps businesses maintain strong financial systems and meet regulatory requirements efficiently.
                        </p>
                        <div class="divider"></div>
                        <span class="spec-title">Specialization</span>
                        <div class="spec-tags">
                            <span class="spec-tag">Audit & Assurance</span>
                            <span class="spec-tag">Accounting</span>
                            <span class="spec-tag">Direct Taxation</span>
                            <span class="spec-tag">Financial Reporting</span>
                            <span class="spec-tag">Compliance Management</span>
                        </div>
                    </div>
                </div>
                <!-- Ravi Pandey -->
                <div class="col-lg-4 col-md-6">
                    <div class="team-card">
                        <div class="avatar-box">
                            <span class="avatar-initials">RP</span>
                        </div>
                        <h4>CA Ravi Pandey</h4>
                        <span class="role">Partner</span>
                        <p class="bio">
                            CA Ravi Pandey focuses on corporate compliance, business advisory, and strategic consulting. He works closely with startups and growing enterprises to support their compliance and operational requirements.
                        </p>
                        <div class="divider"></div>
                        <span class="spec-title">Specialization</span>
                        <div class="spec-tags">
                            <span class="spec-tag">Corporate Advisory</span>
                            <span class="spec-tag">ROC Compliance</span>
                            <span class="spec-tag">Startup Consulting</span>
                            <span class="spec-tag">Business Strategy</span>
                            <span class="spec-tag">Risk Management</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: What We Do -->
    <section class="services-section">
        <div class="container">
            <div class="section-header">
                <span class="sub-title">Expert Solutions</span>
                <h2>What We Do</h2>
            </div>
            <div class="row row-gap-4">
                <!-- 1. Private Limited Company Registration -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-building"></i>
                        </div>
                        <h5>Private Limited Company Registration</h5>
                    </div>
                </div>
                <!-- 2. LLP Registration -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-briefcase"></i>
                        </div>
                        <h5>LLP Registration</h5>
                    </div>
                </div>
                <!-- 3. OPC Registration -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-user-gear"></i>
                        </div>
                        <h5>OPC Registration</h5>
                    </div>
                </div>
                <!-- 4. Partnership Firm Registration -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h5>Partnership Firm Registration</h5>
                    </div>
                </div>
                <!-- 5. GST Registration & Return Filing -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                        <h5>GST Registration & Return Filing</h5>
                    </div>
                </div>
                <!-- 6. Income Tax Return Filing -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-calculator"></i>
                        </div>
                        <h5>Income Tax Return Filing</h5>
                    </div>
                </div>
                <!-- 7. TDS Compliance -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-percent"></i>
                        </div>
                        <h5>TDS Compliance</h5>
                    </div>
                </div>
                <!-- 8. Trademark Registration -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-copyright"></i>
                        </div>
                        <h5>Trademark Registration</h5>
                    </div>
                </div>
                <!-- 9. ROC Annual Compliance -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h5>ROC Annual Compliance</h5>
                    </div>
                </div>
                <!-- 10. Accounting & Bookkeeping -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-book"></i>
                        </div>
                        <h5>Accounting & Bookkeeping</h5>
                    </div>
                </div>
                <!-- 11. Audit & Assurance Services -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-magnifying-glass-chart"></i>
                        </div>
                        <h5>Audit & Assurance Services</h5>
                    </div>
                </div>
                <!-- 12. Virtual CFO & Advisory -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                        <h5>Virtual CFO & Advisory Services</h5>
                    </div>
                </div>
                <!-- 13. Business Advisory & Consulting -->
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="service-mini-card">
                        <div class="service-icon-wrapper">
                            <i class="fa-solid fa-lightbulb"></i>
                        </div>
                        <h5>Business Advisory & Consulting</h5>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 5: Why Choose Us -->
    <section class="choose-section">
        <div class="container">
            <div class="section-header">
                <span class="sub-title">Our Value Proposition</span>
                <h2>Why Choose BizSetup?</h2>
            </div>
            <div class="row row-gap-4">
                <!-- 1. Professional Expertise -->
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <div class="choose-header">
                            <div class="choose-icon">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <h4>Professional Expertise</h4>
                        </div>
                        <p>Services delivered under the guidance of experienced Chartered Accountants and compliance professionals.</p>
                    </div>
                </div>
                <!-- 2. One-Stop Solution -->
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <div class="choose-header">
                            <div class="choose-icon">
                                <i class="fa-solid fa-cubes"></i>
                            </div>
                            <h4>One-Stop Solution</h4>
                        </div>
                        <p>Registration, taxation, accounting, compliance, and advisory services from a single platform.</p>
                    </div>
                </div>
                <!-- 3. Transparent Pricing -->
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <div class="choose-header">
                            <div class="choose-icon">
                                <i class="fa-solid fa-tags"></i>
                            </div>
                            <h4>Transparent Pricing</h4>
                        </div>
                        <p>Clear and competitive pricing with no hidden charges.</p>
                    </div>
                </div>
                <!-- 4. Technology-Driven Process -->
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <div class="choose-header">
                            <div class="choose-icon">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <h4>Technology-Driven Process</h4>
                        </div>
                        <p>Convenient online processes supported by dedicated professionals.</p>
                    </div>
                </div>
                <!-- 5. Long-Term Partnership -->
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <div class="choose-header">
                            <div class="choose-icon">
                                <i class="fa-solid fa-handshake"></i>
                            </div>
                            <h4>Long-Term Partnership</h4>
                        </div>
                        <p>We support businesses beyond registration by providing continuous compliance and advisory assistance.</p>
                    </div>
                </div>
                <!-- 6. Pan-India Service Network -->
                <div class="col-lg-4 col-md-6">
                    <div class="choose-card">
                        <div class="choose-header">
                            <div class="choose-icon">
                                <i class="fa-solid fa-map-marked-alt"></i>
                            </div>
                            <h4>Pan-India Network</h4>
                        </div>
                        <p>Serving clients across India with consistent quality and professional support.</p>
                    </div>
                </div>
            </div>
            
            <div class="text-center mt-5">
                <p class="lead text-secondary mb-4" style="font-size: 18px; font-weight: 500;">
                    Whether you are launching a startup, expanding your operations, or seeking ongoing compliance support, BizSetup is your trusted partner for business growth and compliance excellence.
                </p>
                <a href="<?php echo $urlmain;?>contact.php" class="btn btn-contact-custom px-4 py-3 btn-lg rounded-pill shadow-sm">
                    <i class="fa-solid fa-envelope me-2"></i>Get Started with BizSetup
                </a>
            </div>
        </div>
    </section>

    <?php include "include/footer.php";?> 
    <?php include "include/js.php";?> 

</body>

</html>
