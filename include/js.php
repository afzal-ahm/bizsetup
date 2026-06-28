<script src="<?php echo $urlmain;?>assets/js/jquery-3.7.1.min.js"></script>

<!-- Bootstrap JS -->
<script src="<?php echo $urlmain;?>assets/js/bootstrap.bundle.min.js"></script>

<!-- Wow JS -->
<script src="<?php echo $urlmain;?>assets/js/wow.min.js"></script>

<!-- MeanMenu Js -->
<script src="<?php echo $urlmain;?>assets/js/jquery.meanmenu.min.js"></script>

<!-- Swiper Js -->
<script src="<?php echo $urlmain;?>assets/plugins/owlcarousel/owl.carousel.min.js"></script>

<!-- Fancybox JS -->
<script src="<?php echo $urlmain;?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>

<!-- Counter JS -->
<script src="<?php echo $urlmain;?>assets/js/jquery.counterup.min.js"></script>
<script src="<?php echo $urlmain;?>assets/js/jquery.waypoints.min.js"></script>

<!-- Datepicker Core JS -->
<script src="<?php echo $urlmain;?>assets/plugins/moment/moment.js"></script>
<script src="<?php echo $urlmain;?>assets/js/bootstrap-datetimepicker.min.js"></script>

<!-- cursor JS -->
<script src="<?php echo $urlmain;?>assets/js/cursor.js"></script>

<!-- Script JS -->
<script src="<?php echo $urlmain;?>assets/js/script.js"></script>

  <!-- Cursor -->
    <div class="xb-cursor tx-js-cursor">
        <div class="xb-cursor-wrapper">
            <div class="xb-cursor--follower xb-js-follower"></div>
        </div>
    </div>
    <!-- /Cursor -->

    <div class="back-to-top">
		<a class="back-to-top-icon align-items-center justify-content-center d-flex"  href="#top"><i class="fa-solid fa-arrow-up"></i></a>
	</div>


  <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
        <script>
          <?php 
          $wa_phone = preg_replace('/[^0-9]/', '', $company_whatsapp_no);
          if (strlen($wa_phone) == 10) {
              $wa_phone = '91' . $wa_phone;
          }
          ?>
          var wa_btnSetting = {"btnColor":"#16BE45","ctaText":"WhatsApp Us","cornerRadius":40,"marginBottom":20,"marginLeft":20,"marginRight":20,"btnPosition":"left","whatsAppNumber":"<?php echo $wa_phone; ?>","welcomeMessage":"Hello","zIndex":999999,"btnColorScheme":"light"};
          window.onload = () => {
            _waEmbed(wa_btnSetting);
          };
        </script>
      
      
