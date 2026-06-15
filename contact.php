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
   <div class="breadcrumb-bar  text-center" style="      background-color: #fc9d0b78; padding: 39px 0 40px;">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title mb-2">Contact Us</h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb justify-content-center mb-0">
                            <li class="breadcrumb-item"><a href="#"><i class="isax isax-home5"></i></a></li>
                            <li class="breadcrumb-item">Pages</li>
                            <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
   
    <div class="content">
        <div class="container">
            <div class="row align-items-center row-gap-4">
                <div class="col-xl-7 col-lg-7">
                    <div class="mb-4 mb-lg-0">
                        <div class="row">
                            <div class="col-md-8">
                                <h2 class="mb-3">Get in Touch With Us</h2>
                            </div>
                        </div>
                        <div class="mb-4">
                            <h6 class="mb-2">Get in Touch With Us</h6>
                            <p>We’d love to hear from you! Whether you have a question about our services, need support, or want to explore new opportunities, our team is here to assist you.</p>
                        </div>
                        <div class="border-bottom mb-4">
                        <?php
// Fetch company locations from the new locations table
$locations_query = "SELECT * FROM company_locations WHERE is_active = 1 ORDER BY sort_order ASC, location_name ASC";
$locations_result = mysqli_query($conn, $locations_query);

if ($locations_result && mysqli_num_rows($locations_result) > 0) {
    while ($location = mysqli_fetch_assoc($locations_result)) {
        echo '<div class="contact-location mb-4">';
        
        // Location title with icon
        echo '<h6 class="location-title mb-3">';
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
        echo htmlspecialchars($location['location_name']) . '</h6>';

        // Phone
        if (!empty($location['phone'])) {
            echo '<div class="border-bottom mb-4">';
            echo '<div class="d-flex align-items-center mb-3">';
            echo '<span class="avatar avatar-lg rounded-circle bg-light text-gray-6 me-2"><i class="isax isax-call-calling5 fs-24"></i></span>';
            echo '<div>';
            echo '<p class="fs-14 mb-0">Phone Number</p>';
            echo '<h6 class="text-gray-6"><a href="tel:' . preg_replace('/[^0-9+\-\(\)\s]/', '', $location['phone']) . '">' . htmlspecialchars($location['phone']) . '</a></h6>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        // Email
        if (!empty($location['email'])) {
            echo '<div class="border-bottom mb-4">';
            echo '<div class="d-flex align-items-center mb-3">';
            echo '<span class="avatar avatar-lg rounded-circle bg-light text-gray-6 me-2"><i class="isax isax-sms5 fs-24"></i></span>';
            echo '<div>';
            echo '<p class="fs-14 mb-0">Email</p>';
            echo '<h6 class="text-gray-6"><a href="mailto:' . htmlspecialchars($location['email']) . '">' . htmlspecialchars($location['email']) . '</a></h6>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        // Address
        if (!empty($location['address'])) {
            echo '<div class="border-bottom mb-4">';
            echo '<div class="d-flex align-items-center mb-3">';
            echo '<span class="avatar avatar-lg rounded-circle bg-light text-gray-6 me-2"><i class="isax isax-location5 fs-24"></i></span>';
            echo '<div>';
            echo '<p class="fs-14 mb-0">Address</p>';
            echo '<h6 class="text-gray-6">' . htmlspecialchars($location['address']) . '</h6>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }

        echo '</div>';
    }
}
?>

                       
                        </div>
                       
                    </div>
                </div>
                <div class="col-xl-5 col-lg-5">
                    <div class="card bg-light-200 shadow-none mb-0">
                        <div class="card-body">
                            <div class="mb-3">
                                <h2 class="mb-1">Get in Touch</h2>
                                <p class="text-gray-6 mb-1">How we can help you? Please write down your query</p>
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
            <div class="map-grid">
                <iframe class="w-100" height="300" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6509170.989457427!2d-123.80081967108484!3d37.192957227641294!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x808fb9fe5f285e3d%3A0x8b5109a227086f55!2sCalifornia%2C%20USA!5e0!3m2!1sen!2sin!4v1669181581381!5m2!1sen!2sin" allowfullscreen="" loading="lazy"></iframe>
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