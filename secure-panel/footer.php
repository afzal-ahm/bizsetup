 <footer> 
    
    <!-- our clients Slider -->
    <div class="our-clients">
      <div class="container">
        <div class="col-md-12">
          <div class="slider-items-products">
            <div id="our-clients-slider" class="product-flexslider hidden-buttons">
              <div class="slider-items slider-width-col6"> 
                
              <?php
  $slider="SELECT * from logo   "; 
$slider1=mysqli_query($conn,$slider);
foreach($slider1 as $key=> $sliderimage)
{
 ?>
                <div class="item"> <a href="#"><img src="images/client/<?php echo $sliderimage['img'];?>" alt="Image"></a> </div>
                <!-- End Item --> 
               <?php } ?>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Information<a class="expander visible-xs" href="#TabBlock-1">+</a></h3>
    <?php echo substr($da12['about_us'],0,150);?>..
          </div>
        </div>
        <div class="col-sm-6 col-md-3 col-xs-12 col-lg-2 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Insider<a class="expander visible-xs" href="#TabBlock-3">+</a></h3>
            <div class="tabBlock" id="TabBlock-3">
              <ul class="list-links list-unstyled">
               
                <li> <a href="index.php">Home</a> </li>
               
                <li> <a href="about.php">About Us</a> </li>
                <li> <a href="blog.php">Blogs</a> </li>
                <li> <a href="contact.php">Contact Us</a> </li>
                <li> <a href="login.php">My Orders</a> </li>
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-2 col-xs-12 col-lg-2 collapsed-block">
          <div class="footer-links">
            <h3 class="links-title">Service<a class="expander visible-xs" href="#TabBlock-4">+</a></h3>
            <div class="tabBlock" id="TabBlock-4">
              <ul class="list-links list-unstyled">
               
                <li> <a href="wishlist.php">Wishlist</a> </li>
                <li> <a href="shipping-and-delivery.php">shipping & Delivery</a> </li>
                <li> <a href="privacy-policy.php">Privacy Policy</a> </li>
                <li> <a href="term-and-condition.php">Term & Condition</a> </li>
                <li> <a href="faq.php">FAQ</a> </li>
                 
              </ul>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 col-xs-12 col-lg-3">
          <h3 class="links-title">Contact us</h3>
         
          <div class="footer-content">
            <div class="email"> <i class="fa fa-envelope"></i>
              <p><?php echo $da12['email'];?></p>
            </div>
            <div class="phone"> <i class="fa fa-phone"></i>
              <p>(+91) <?php echo $da12['phone'];?>, <?php echo $da12['us'];?></p>
            </div>
            <div class="address"> <i class="fa fa-map-marker"></i>
              <p><?php echo $da12['address'];?></p>
            </div>
          </div>
        </div>
        <div class="col-sm-12 col-md-12 col-xs-12 col-lg-3">
          <div class="footer-links">
            <div class="footer-newsletter">
              <h3 class="links-title">Sign up for newsletter</h3>
               
                 <form class="form-inline" >


                            <input type="email" class="form-control input-block-level " id="SubscriptionEmail" value="Your E-mail..." onblur="if (this.value == '') {this.value = 'Your E-mail...';}" onfocus="if(this.value == 'Your E-mail...') {this.value = '';}">

<br>

                            <button style="    margin-top: 19px;" type="button" onClick="return SendSubscription()" class="btn btn-1 button subscribe"><span class="icon flaticon-new78"></span>subscribe</button>


                        <div class="_result" style="color: #000;">
                        <br>
                            <p style="color:#000;"> Don't worry, we hate spam! </p>
                        </div>

                </form>
            </div>
            <div class="social">
              <ul class="inline-mode">
                <li class="social-network fb"><a title="Connect us on Facebook" target="_blank" href="https://www.facebook.com/"><i class="fa fa-facebook"></i></a></li>
                <li class="social-network googleplus"><a title="Connect us on Google+" target="_blank" href="https://plus.google.com/"><i class="fa fa-google-plus"></i></a></li>
                <li class="social-network tw"><a title="Connect us on Twitter" target="_blank" href="https://twitter.com/"><i class="fa fa-twitter"></i></a></li>
                <li class="social-network linkedin"><a title="Connect us on Linkedin" target="_blank" href="https://www.pinterest.com/"><i class="fa fa-linkedin"></i></a></li>
                <li class="social-network rss"><a title="Connect us on Instagram" target="_blank" href="https://instagram.com/"><i class="fa fa-rss"></i></a></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="footer-coppyright">
      <div class="container">
        <div class="row">
          <div class="col-sm-6 col-xs-12 coppyright"> Copyright © 2018 <a href="#"> Rajan Admin </a>. All Rights Reserved. </div>
          <div class="col-sm-6 col-xs-12">
            <div class="payment">
              <ul>
                <?php
  $slider="SELECT * from footer   "; 
$slider1=mysqli_query($conn,$slider);
foreach($slider1 as $key=> $sliderimage)
{
 ?>
                <li><a href="#"><img title="Visa" alt="Visa" src="images/client/<?php echo $sliderimage['img'];?>"></a></li>
                <?php } ?>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>
  <script type="text/javascript">
    function SendSubscription(){
     //   var value = jQuery('#SubscriptionEmail').val();
        //alert(value);
        if(jQuery.trim(jQuery('#SubscriptionEmail').val()) != "Your E-mail..."){
            jQuery.ajax({
                type: "POST",
                url: "SubscriptionHandler.php",
                data: {'email':jQuery('#SubscriptionEmail').val()},
                cache: false,
                success: function(data)
                {
                   // alert(data);
                    jQuery('._result p').html(data);
                }
            });
        }
        else
        {
            jQuery('._result p').html('Email ID can not be blank!');
        }
        return false;
    }

    jQuery(document).ready(function(){

    })
</script> 