<?php 
include "data.php";
 
?> 

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "include/title.php";?> 
   <?php include "include/css.php";?> 
   

</head>

<body>

     

   
   <?php include "include/header.php";?> 
   <div class="breadcrumb-bar text-center custom-contact-hero">
        <div class="hero-glow-1"></div>
        <div class="hero-glow-2"></div>
        <div class="container relative-content">
            <div class="row">
                <div class="col-md-12 col-12">
                    <span class="hero-subtitle">WE ARE HERE FOR YOU</span>
                    <h1 class="breadcrumb-title mb-3">Let's Start a <span class="highlight-text">Conversation</span></h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0 custom-breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo $urlmain; ?>"><i class="isax isax-home5 me-1"></i>Home</a></li>
                            
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
   
    <div class="content contact-page-container">
        <div class="container">
            <div class="row align-items-stretch row-gap-4">
                <div class="col-xl-7 col-lg-7 d-flex flex-column">
                    <div class="contact-heading-section">
                        <h2>Get in Touch With Us</h2>
                        <p>We’d love to hear from you! Whether you have a question about our services, need support, or want to explore new opportunities, our team is here to assist you.</p>
                    </div>
                    <div class="locations-wrapper flex-grow-1">
                        <?php
                        // Fetch company locations from the new locations table
                        $locations_query = "SELECT * FROM company_locations WHERE is_active = 1 ORDER BY sort_order ASC, location_name ASC";
                        $locations_result = mysqli_query($conn, $locations_query);

                        if ($locations_result && mysqli_num_rows($locations_result) > 0) {
                            while ($location = mysqli_fetch_assoc($locations_result)) {
                                echo '<div class="modern-contact-card">';
                                
                                // Location title with icon
                                echo '<h5 class="location-title mb-4">';
                                if (stripos($location['location_name'], 'head') !== false || stripos($location['location_name'], 'main') !== false) {
                                    echo '🏢 ';
                                } elseif (stripos($location['location_name'], 'branch') !== false || stripos($location['location_name'], 'office') !== false) {
                                    echo '🏢 ';
                                } elseif (stripos($location['location_name'], 'delhi') !== false || stripos($location['location_name'], 'mumbai') !== false || stripos($location['location_name'], 'bangalore') !== false) {
                                    echo '🇮🇳 ';
                                } elseif (stripos($location['location_name'], 'usa') !== false || stripos($location['location_name'], 'uk') !== false || stripos($location['location_name'], 'international') !== false) {
                                    echo '🌍 ';
                                } else {
                                    echo '📍 ';
                                }
                                echo htmlspecialchars($location['location_name']) . '</h5>';

                                // Phone
                                if (!empty($location['phone'])) {
                                    echo '<div class="contact-item-row">';
                                    echo '<span class="contact-icon-box"><i class="isax isax-call-calling5"></i></span>';
                                    echo '<div class="contact-details-text">';
                                    echo '<p>Phone Number</p>';
                                    echo '<h6><a href="tel:' . preg_replace('/[^0-9+\-\(\)\s]/', '', $location['phone']) . '">' . htmlspecialchars($location['phone']) . '</a></h6>';
                                    echo '</div>';
                                    echo '</div>';
                                }

                                // Email
                                if (!empty($location['email'])) {
                                    echo '<div class="contact-item-row">';
                                    echo '<span class="contact-icon-box"><i class="isax isax-sms5"></i></span>';
                                    echo '<div class="contact-details-text">';
                                    echo '<p>Email</p>';
                                    echo '<h6><a href="mailto:' . htmlspecialchars($location['email']) . '">' . htmlspecialchars($location['email']) . '</a></h6>';
                                    echo '</div>';
                                    echo '</div>';
                                }

                                // Address
                                if (!empty($location['address'])) {
                                    echo '<div class="contact-item-row">';
                                    echo '<span class="contact-icon-box"><i class="isax isax-location5"></i></span>';
                                    echo '<div class="contact-details-text">';
                                    echo '<p>Address</p>';
                                    echo '<h6>' . htmlspecialchars($location['address']) . '</h6>';
                                    echo '</div>';
                                    echo '</div>';
                                }

                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5 d-flex">
                    <div class="card modern-form-card shadow-none mb-0 w-100">
                        <div class="card-body p-0 d-flex flex-column justify-content-between">
                            <div>
                                <div class="mb-4">
                                    <h3>Get in Touch</h3>
                                    <p class="text-gray-6 mb-0">How we can help you? Please write down your query</p>
                                </div>
                                <form id="contactForm" action="<?php echo $urlmain;?>inquiry-handler.php" method="POST">
                                    <!-- Honeypot field for spam protection (hidden) -->
                                    <input type="text" name="honeypot" style="display:none;" tabindex="-1" autocomplete="off">
                                    <input type="hidden" name="source" value="contact_page">
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Last Name</label>
                                                <input type="text" name="last_name" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Phone</label>
                                                <input type="tel" name="phone" class="form-control" placeholder="+1234567890">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Message <span class="text-danger">*</span></label>
                                                <textarea name="message" class="form-control" rows="3" required minlength="5" placeholder="Please describe how we can help you..."></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div id="formMessage" class="mb-3" style="display:none;"></div>
                                    
                                    <button type="submit" id="submitBtn" class="btn btn-primary">
                                        <span class="btn-text">Send Message</span>
                                        <span class="spinner-border spinner-border-sm ms-2" style="display:none;" role="status" aria-hidden="true"></span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="map-grid">
            <iframe class="w-100" height="300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3501.6086372578316!2d77.33300457597163!3d28.64148939929478!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfbf419d29e67%3A0xca8a4301ef01b98e!2sVRG%20%26%20Associates%2C%20Chartered%20Accountants!5e0!3m2!1sen!2sin!4v1782123931265!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>    
            
            </div>
        </div>
    </div>
 
 

 <style>
    .ssa h2
    {
        font-size: 17px;
        margin-bottom: 12px;
    }
    .ssa h1
    {
        font-size: 17px;
        margin-bottom: 12px;
    }
    .ssa h3
    {
        font-size: 17px;
        margin-bottom: 12px;
    }
    
    /* Custom Contact Hero Styling */
    .custom-contact-hero {
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
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #f18d2d;
        margin-bottom: 12px;
        background: rgba(241, 141, 45, 0.15);
        padding: 6px 16px;
        border-radius: 20px;
        border: 1px solid rgba(241, 141, 45, 0.3);
    }
    
    .custom-contact-hero .breadcrumb-title {
        font-size: 42px;
        font-weight: 800;
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        line-height: 1.2;
    }
    
    .custom-contact-hero .highlight-text {
        background: linear-gradient(90deg, #f18d2d 0%, #ffc107 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        display: inline-block;
    }
    
    .custom-breadcrumb {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        display: inline-flex !important;
        padding: 8px 24px !important;
        border-radius: 30px;
        margin-top: 15px;
    }
    
    .custom-breadcrumb .breadcrumb-item, 
    .custom-breadcrumb .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.7) !important;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .custom-breadcrumb .breadcrumb-item a:hover {
        color: #f18d2d !important;
    }
    
    .custom-breadcrumb .breadcrumb-item.active {
        color: #ffffff !important;
    }
    
    .custom-breadcrumb .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255, 255, 255, 0.4) !important;
    }

    /* Main Content Styling */
    .contact-page-container {
        padding: 80px 0;
        background: #f8fafc;
    }
    
    .contact-heading-section {
        margin-bottom: 35px;
    }
    
    .contact-heading-section h2 {
        font-size: 32px;
        font-weight: 800;
        color: #0b2545;
        font-family: 'Poppins', sans-serif;
    }
    
    .contact-heading-section p {
        font-size: 15px;
        color: #64748b;
        line-height: 1.6;
        margin-top: 12px;
    }
    
    .modern-contact-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 28px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -1px rgba(0, 0, 0, 0.01);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        margin-bottom: 24px;
    }
    
    .modern-contact-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -5px rgba(0, 0, 0, 0.02);
        border-color: rgba(241, 141, 45, 0.3);
    }
    
    .modern-contact-card .location-title {
        color: #0b2545 !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f1f5f9;
        padding-bottom: 15px;
    }
    
    .contact-item-row {
        display: flex;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid #f1f5f9;
    }
    
    .contact-item-row:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    
    .contact-icon-box {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        background: rgba(241, 141, 45, 0.1);
        color: #f18d2d;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 16px;
        transition: all 0.3s ease;
    }
    
    .modern-contact-card:hover .contact-icon-box {
        background: #f18d2d;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(241, 141, 45, 0.2);
    }
    
    .contact-details-text p {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 3px;
        letter-spacing: 0.5px;
    }
    
    .contact-details-text h6 {
        font-size: 15px;
        font-weight: 600;
        color: #334155;
        margin: 0;
        line-height: 1.4;
    }
    
    .contact-details-text h6 a {
        color: #334155;
        text-decoration: none;
        transition: color 0.2s ease;
    }
    
    .contact-details-text h6 a:hover {
        color: #f18d2d;
    }
    
    /* Modern Form styling */
    .modern-form-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 20px;
        padding: 35px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        height: 100%;
    }
    
    .modern-form-card h3 {
        font-size: 26px;
        font-weight: 800;
        color: #0b2545;
        font-family: 'Poppins', sans-serif;
    }
    
    .modern-form-card .form-control {
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.3s ease;
        background-color: #f8fafc;
    }
    
    .modern-form-card .form-control:focus {
        border-color: #1c4c82;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(28, 76, 130, 0.1);
    }
    
    .modern-form-card .btn-primary {
        background-color: #f18d2d !important;
        border-color: #f18d2d !important;
        border-radius: 30px;
        padding: 12px 30px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.3s ease;
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .modern-form-card .btn-primary:hover {
        background-color: #d97706 !important;
        border-color: #d97706 !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(241, 141, 45, 0.3);
    }
 </style>
   <section class="support-section bg-primary">
        <div class="horizontal-slide d-flex" data-direction="left" data-speed="slow">
            <div class="slide-list d-flex">

            <?php
                                $ss="SELECT * from  extra_content where type='moving_line'";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){       ?> 
                <div class="support-item">
                    <h5><?php echo $socila['heading1'];?></h5>
                </div>
               <?php } ?>
               
                
            </div>
        </div>
    </section> 
   <?php include "include/footer.php";?> 

  



   <?php include "include/js.php";?> 
    <!-- Jquery JS -->
    
    <!-- Contact Form Handler Script -->
    <script>
    $(document).ready(function() {
        $('#contactForm').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $('#submitBtn');
            const $btnText = $submitBtn.find('.btn-text');
            const $spinner = $submitBtn.find('.spinner-border');
            const $message = $('#formMessage');
            
            // Basic client-side validation
            const firstName = $form.find('[name="first_name"]').val().trim();
            const email = $form.find('[name="email"]').val().trim();
            const message = $form.find('[name="message"]').val().trim();
            
            if (!firstName || !email || !message) {
                $message.removeClass('alert-success').addClass('alert alert-danger')
                       .html('<i class="fas fa-exclamation-triangle me-2"></i>Please fill in all required fields.')
                       .show();
                return;
            }
            
            if (message.length < 5) {
                $message.removeClass('alert-success').addClass('alert alert-danger')
                       .html('<i class="fas fa-exclamation-triangle me-2"></i>Message must be at least 5 characters long.')
                       .show();
                return;
            }
            
            // Show loading state
            $submitBtn.prop('disabled', true);
            $btnText.text('Sending...');
            $spinner.show();
            $message.hide();
            
            // Submit form via AJAX
            $.ajax({
                url: $form.attr('action'),
                method: 'POST',
                data: $form.serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $message.removeClass('alert-danger').addClass('alert alert-success')
                               .html('<i class="fas fa-check-circle me-2"></i>' + response.message)
                               .show();
                        $form[0].reset(); // Clear form
                    } else {
                        let errorMsg = response.message;
                        if (response.errors && response.errors.length > 0) {
                            errorMsg += '<ul class="mb-0 mt-2">';
                            response.errors.forEach(function(error) {
                                errorMsg += '<li>' + error + '</li>';
                            });
                            errorMsg += '</ul>';
                        }
                        $message.removeClass('alert-success').addClass('alert alert-danger')
                               .html('<i class="fas fa-exclamation-triangle me-2"></i>' + errorMsg)
                               .show();
                    }
                },
                error: function(xhr, status, error) {
                    $message.removeClass('alert-success').addClass('alert alert-danger')
                           .html('<i class="fas fa-exclamation-triangle me-2"></i>An error occurred while sending your message. Please try again.')
                           .show();
                },
                complete: function() {
                    // Reset button state
                    $submitBtn.prop('disabled', false);
                    $btnText.text('Send Message');
                    $spinner.hide();
                }
            });
        });
    });
    </script>

</body>

</html>