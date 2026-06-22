 <footer class="footer-five">
        <div class="container">
            <div class="footer-top">
                <div class="row row-cols-lg-5 row-cols-md-3 row-cols-sm-2 row-cols-1">
                    <?php     $ss="SELECT * from  extra_content where type='heading' limit 1 OFFSET 6";
                    $re=mysqli_query($conn,$ss);
                    foreach($re as $key=> $socila){       ?>   
                    <div class="col-lg-5">
                        <div class="footer-about">
                            <span class="d-block mb-2 footer-logo-light"><img src="<?php echo $urlmain;?>images/<?php echo $company_logo;?>" style="    max-width: 150px;" alt="Img"></span>
                             
                            <p>At BizSetup, we specialize in making legal compliance and business incorporation simple, affordable, and seamless for startups, SMEs, and businesses of all sizes.</p>

                            
                           
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-2">
                        <div class="footer-widget">
                            <h5>Pages</h5>
                            <ul class="footer-menu">
                                <li>
                                    <a href="<?php echo $urlmain;?>">Home</a>
                                </li>
                            <li> <a href="<?php echo $urlmain;?>contact.php">Contact</a> </li>
                          
                            <?php $c='1';
                           $ss="SELECT * from category where is_active='0' and  show_in_footer='1' order by position asc";
                           $re=mysqli_query($conn,$ss);
                           foreach($re as $key=> $cate){
                            ?>
                                                            <li>
                                <a href="<?php echo $urlmain;?>pages/<?php echo $cate['url'];?>"><?php echo $cate['category_name'];?></a>
                            </li>
                                <?php } ?>
                           
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="footer-widget">
                            <h5>Company</h5>
                            <ul class="footer-menu">
                            <?php $c='1';
                           $ss="SELECT * from category where is_active='1' and  show_in_footer='1' order by position asc";
                           $re=mysqli_query($conn,$ss);
                           foreach($re as $key=> $cate){
                            ?>
                                                            <li>
                                <a href="<?php echo $urlmain;?>page/<?php echo $cate['url'];?>"><?php echo $cate['category_name'];?></a>
                            </li>
                                <?php } ?>
                                
                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="footer-widget">
                            <h5>Contact Info</h5>
                            <?php
                            // Fetch company locations from the new locations table
                            $locations_query = "SELECT * FROM company_locations WHERE is_active = 1 ORDER BY sort_order ASC, location_name ASC";
                            $locations_result = mysqli_query($conn, $locations_query);
                            
                            if ($locations_result && mysqli_num_rows($locations_result) > 0) {
                                while ($location = mysqli_fetch_assoc($locations_result)) {
                                    echo '<div class="contact-location mb-3">';
                                    echo '<h6 class="location-title">';
                                    
                                    // Add location icon based on location name or type
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
                                    
                                    // Display phone if available
                                    if (!empty($location['phone'])) {
                                        echo '<div class="customer-info">';
                                        echo '<div class="customer-info-icon">';
                                        echo '<span><i class="isax isax-call5"></i></span>';
                                        echo '</div>';
                                        echo '<div class="customer-info-content">';
                                        echo '<span>Phone</span>';
                                        echo '<h6><a href="tel:' . preg_replace('/[^0-9+\-\(\)\s]/', '', $location['phone']) . '">' . htmlspecialchars($location['phone']) . '</a></h6>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    
                                    // Display email if available
                                    if (!empty($location['email'])) {
                                        echo '<div class="customer-info">';
                                        echo '<div class="customer-info-icon">';
                                        echo '<span><i class="isax isax-sms5"></i></span>';
                                        echo '</div>';
                                        echo '<div class="customer-info-content">';
                                        echo '<span>Email</span>';
                                        echo '<h6><a href="mailto:' . htmlspecialchars($location['email']) . '">' . htmlspecialchars($location['email']) . '</a></h6>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                    
                                    // Display address if available
                                    if (!empty($location['address'])) {
                                        echo '<div class="customer-info">';
                                        echo '<div class="customer-info-icon">';
                                        echo '<span><i class="isax isax-location5"></i></span>';
                                        echo '</div>';
                                        echo '<div class="customer-info-content">';
                                        echo '<span>Address</span>';
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

                    <div class="col-lg-4"></div>

                    <div class="col-lg-4">
                    
                            </div>
                </div>
            </div>
        </div>
        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex align-items-center justify-content-between flex-wrap">
                            <p class="fs-14"><?= $company_copyright ?></p>
                            <div class="d-flex align-items-center">
                                <ul class="social-icon">
                                <?php
                              $ss="SELECT * from  extra_content where type='social_link'";
                              $re=mysqli_query($conn,$ss);
                              foreach($re as $key=> $socila){                              ?>
                                    <li>
                                        <a href="<?php echo $socila['link'];?>"><img src="<?php echo $urlmain;?>images/extra/<?php echo $socila['image'];?>"></a>
                                    </li>
                                    
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Footer Bottom -->

    </footer>
    
    <!-- Newsletter Subscription Styles and Scripts -->
    <style>
    /* Contact Info Styling */
    .contact-location {
        border-left: 3px solid #007bff;
        padding-left: 15px;
        margin-bottom: 20px;
    }
    
    .contact-location:last-child {
        margin-bottom: 0;
    }
    
    .location-title {
        color: #007bff;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 5px;
    }
    
    .customer-info {
        display: flex;
        align-items: flex-start;
        margin-bottom: 15px;
        transition: all 0.3s ease;
    }
    
    .customer-info:last-child {
        margin-bottom: 0;
    }
    
    .customer-info:hover {
        transform: translateX(5px);
    }
    
    .customer-info-icon {
        flex-shrink: 0;
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #007bff, #0056b3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }
    
    .customer-info-icon span {
        color: white;
        font-size: 18px;
    }
    
    .customer-info-content {
        flex: 1;
        min-width: 0;
    }
    
    .customer-info-content span {
        display: block;
        color: #6c757d;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 3px;
    }
    
    .customer-info-content h6 {
        color: #2c3e50;
        font-size: 13px;
        font-weight: 600;
        margin: 0;
        line-height: 1.4;
    }
    
    .customer-info-content h6 a {
        color: #2c3e50;
        text-decoration: none;
        transition: color 0.3s ease;
    }
    
    .customer-info-content h6 a:hover {
        color: #007bff;
    }
    
    .newsletter-form .input-group {
        position: relative;
    }
    
    .newsletter-form .form-control {
        border: 1px solid #e9ecef;
        border-radius: 0 8px 8px 0;
        padding: 12px 15px;
        font-size: 14px;
        transition: all 0.3s ease;
    }
    
    .newsletter-form .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .newsletter-form .btn {
        border-radius: 8px 0 0 8px;
        padding: 12px 20px;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .newsletter-form .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 123, 255, 0.3);
    }
    
    .newsletter-form .btn-loading {
        display: none;
    }
    
    .newsletter-form .btn.loading .btn-text {
        display: none;
    }
    
    .newsletter-form .btn.loading .btn-loading {
        display: inline-block;
    }
    
    .newsletter-form .btn.loading .btn-loading i {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    #newsletterMessage {
        font-size: 13px;
        font-weight: 500;
        text-align: center;
        min-height: 20px;
    }
    
    #newsletterMessage.success {
        color: #28a745;
    }
    
    #newsletterMessage.error {
        color: #dc3545;
    }
    
    #newsletterMessage.info {
        color: #17a2b8;
    }
    
    .newsletter-form .form-control.error {
        border-color: #dc3545;
        box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
    }
    
    .newsletter-form .form-control.success {
        border-color: #28a745;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }
    </style>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const newsletterForm = document.getElementById('newsletterForm');
        const newsletterEmail = document.getElementById('newsletterEmail');
        const newsletterBtn = document.getElementById('newsletterBtn');
        const newsletterMessage = document.getElementById('newsletterMessage');
        
        // Email validation function
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        // Show message function
        function showMessage(message, type) {
            newsletterMessage.textContent = message;
            newsletterMessage.className = `mt-2 ${type}`;
            newsletterMessage.style.display = 'block';
            
            // Auto-hide success messages after 5 seconds
            if (type === 'success') {
                setTimeout(() => {
                    newsletterMessage.style.display = 'none';
                }, 5000);
            }
        }
        
        // Reset form function
        function resetForm() {
            newsletterEmail.value = '';
            newsletterEmail.classList.remove('error', 'success');
            newsletterBtn.classList.remove('loading');
        }
        
        // Form submission handler
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = newsletterEmail.value.trim();
            
            // Validate email
            if (!email) {
                showMessage('Please enter your email address.', 'error');
                newsletterEmail.classList.add('error');
                return;
            }
            
            if (!isValidEmail(email)) {
                showMessage('Please enter a valid email address.', 'error');
                newsletterEmail.classList.add('error');
                return;
            }
            
            // Show loading state
            newsletterBtn.classList.add('loading');
            newsletterEmail.classList.remove('error', 'success');
            
            // AJAX request
            fetch('newsletter-subscribe.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'email=' + encodeURIComponent(email)
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.message, 'success');
                    newsletterEmail.classList.add('success');
                    resetForm();
                } else {
                    showMessage(data.message, 'error');
                    newsletterEmail.classList.add('error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showMessage('An error occurred. Please try again.', 'error');
                newsletterEmail.classList.add('error');
            })
            .finally(() => {
                newsletterBtn.classList.remove('loading');
            });
        });
        
        // Clear error on input
        newsletterEmail.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                this.classList.remove('error');
                newsletterMessage.style.display = 'none';
            }
        });
    });
    </script>