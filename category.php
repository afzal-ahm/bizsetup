<?php 
include "data.php";

$page_title = 'Service Categories - BizSetup Business Registration & Compliances';
$page_description = 'Browse business registration and tax compliance services offered by BizSetup, including Company setup, LLP, GST, Accounting, and Trademark.';
$page_keywords = 'business services, business setup categories, legal compliance categories';
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
   <div class="breadcrumb-bar breadcrumb-bg-01 text-center" style="    padding: 39px 0 40px;">
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
                
                
            </div>
             
        </div>
    </div>
 
 
 
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
    
 

</body>

</html>