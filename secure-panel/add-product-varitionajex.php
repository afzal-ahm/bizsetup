<?php 
include"config.php";

$variation_type=$_GET['variation_type'];
$variation_name=$_GET['variation_name'];
$sku=$_GET['sku'];
$color_code=$_GET['color_code'];
 
 $in="INSERT INTO `attributemanager_2`(  `sku`, `type`, `attribute_name`, `code`) VALUES ('$sku','$variation_type','$variation_name','$color_code')";
 $run=mysqli_query($conn,$in);
 if($in)
 { ?>
 	 <div class="alert alert-success"> <span class="vd_alert-icon"><i class="fa fa-check-circle vd_green"></i></span><strong>Well done!</strong><br>Variation <?php echo $variation_type;?> - <?php echo $variation_name;?>   added successfully   </div>
 <?php }      
?>


       <div class="plan">
                    <div class="plan-header vd_bg-blue vd_white text-center vd_info-parent">
                      <h3 class=" mgbt-xs-0">Variation</h3>
                       
                       </div>
                    <div class="features vd_bg-white font-sm content-list">
                      <ul class="list-wrapper">
                      <?php 
                        $select="SELECT * from   attributemanager_2 where sku='".$sku."'";
                      $ff=mysqli_query($conn,$select);
                      foreach ($ff as $key=> $data) 
                      {
					  	
					
                      ?>
                        <li><i class="fa fa-check-circle vd_green"></i> <b><?php echo $data['type'];?></b> ->  <?php echo $data['attribute_name'];?></li>
                       <?php } ?>
                      </ul>
                      
                    </div>
                 
                </div>
