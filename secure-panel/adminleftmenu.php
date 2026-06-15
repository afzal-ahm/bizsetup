<?php 
session_start();
error_reporting(0);
include_once 'config.php';  

if(isset($_SESSION['email'])){
  $query = "select * from admin_account where admin_account_email='".$_SESSION['email']."'";
					$run = mysqli_query($conn, "$query");
					
					foreach($run as $key=> $admindata1)
					
					 
				 	$typeadmin= $admindata1['type'];
				
				 
				 if($_SESSION['email']!='')
					 { 
				
					  ?>
					 	<div class="vd_navbar vd_nav-width vd_navbar-tabs-menu vd_navbar-left  " style="background-color: #008e93;">
	
	<div class="navbar-menu clearfix">
        <div class="vd_panel-menu hidden-xs">
            <span data-original-title="Expand All" data-toggle="tooltip" data-placement="bottom" data-action="expand-all" class="menu" data-intro="<strong>Expand Button</strong><br/>To expand all menu on left navigation menu." data-step=4 >
                <i class="fa fa-sort-amount-asc"></i>
            </span>                   
        </div>
    	<h3 class="menu-title hide-nav-medium hide-nav-small">UI Features</h3>
        <div class="vd_menu">
        	 <ul>
    <li>
    	<a href="javascript:void(0);" data-action="click-trigger">
        	<span class="menu-icon"><i class="fa fa-dashboard"></i></span> 
            <span class="menu-text">Home</span>  
            <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
       	</a>
     	<div class="child-menu"  data-action="click-target">
            <ul>
                <li>
                    <a href="index.php?view=<?php echo $_SESSION['email'];?>">
                        <span class="menu-text"> Dashboard</span>  
                    </a>
                </li>              
                                                                                                
            </ul>   
      	</div>
    </li>  
 	       
    <li>
    	<a href="javascript:void(0);" data-action="click-trigger">
        	<span class="menu-icon"><i class="fa fa-dashboard"></i></span> 
            <span class="menu-text"> Page manager</span>  
            <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
       	</a>
     	<div class="child-menu"  data-action="click-target">
            <ul>
                <li>
                    <a href="addcategory.php">
                        <span class="menu-text">ADD Category</span>  
                    </a>
                </li> 
                
                 <li>
                    <a href="addsubcategories.php">
                        <span class="menu-text">ADD Sub category</span>  
                    </a>
                </li>              
                <li>
                    <a href="addsub_subcategories.php">
                        <span class="menu-text">ADD Service</span>  
                    </a>
                </li> 
                 <li>
                    <a href="addproduct.php">
                        <span class="menu-text">ADD Service Details</span>  
                    </a>
                </li> 
              
				
            </ul>   
      	</div>
    </li>
	   <li>
    	<a href="javascript:void(0);" data-action="click-trigger">
        	<span class="menu-icon"><i class="fa fa-dashboard"></i></span> 
            <span class="menu-text">View Page manager</span>  
            <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
       	</a>
     	<div class="child-menu"  data-action="click-target">
            <ul>
                <li>
                    <a href="viewcategories.php">
                        <span class="menu-text">View Category</span>
                    </a>
                </li>
				
				<li>
                    <a href="viewsubcategory.php">
                        <span class="menu-text">View Sub category</span>
                    </a>
                </li>
				<li>
                    <a href="viewsub-subcat.php">
                        <span class="menu-text">View  Service</span>
                    </a>
                </li>
				<li>
                    <a href="inventory.php">
                        <span class="menu-text">View  Service Details</span>
                    </a>
                </li>
				
            </ul>   
      	</div>
    </li>
	
 
	
	 	<li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Testimonial</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="testimonial.php">
                                     <span class="menu-text">Add Testimonail</span>
                                 </a>


                             </li>
                             <li>
                                 <a href="showtestimonial.php">
                                     <span class="menu-text">View Testimonail </span>
                                 </a>


                             </li>
                             
                            
                         </ul>
                     </div>
                 </li>
                 
                 <li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Extra Home page</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="new_extra.php">
                                     <span class="menu-text">Add Extra Home</span>
                                 </a>


                             </li>
                             <li>
                                 <a href="new_extra_content_view.php">
                                     <span class="menu-text">View Extra Home </span>
                                 </a>


                             </li>
                             
                            
                         </ul>
                     </div>
                 </li>
             		 	 	 
	<li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Home page Slider</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="addmain_slider.php">
                                     <span class="menu-text">Add Slider</span>
                                 </a>


                             </li>
                             <li>
                                 <a href="viewmain_slider.php">
                                     <span class="menu-text">View Slider </span>
                                 </a>


                             </li>
                             
                            
                         </ul>
                     </div>
                 </li>           		 	 	 
	<li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Blog </span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="blog.php">
                                     <span class="menu-text">Add blog</span>
                                 </a>


                             </li>
                             <li>
                                 <a href="view_blog.php">
                                     <span class="menu-text">View blog </span>
                                 </a>


                             </li>
                             
                            
                         </ul>
                     </div>
                 </li>	
                  <li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Newsletter </span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="view-newsletter.php">
                                     <span class="menu-text">View Newsletter</span>
                                 </a>


                             </li>
                                
                            
                         </ul>
                     </div>
                 </li>	 
 
 <!--	<li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Registration</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="vendor_registration.php">
                                     <span class="menu-text">View Registration</span>
                                 </a>


                             </li>
                              
                             
                            
                         </ul>
                     </div>
                 </li>
                 
                
	<li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Payment History</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="paid-record.php">
                                     <span class="menu-text">View Paid Record</span>
                                 </a>
                             </li>
                              
                                                          <li>
                                 <a href="unpaid-record.php">
                                     <span class="menu-text">View UnPaid Record</span>
                                 </a>
                             </li>
                              

                            
                         </ul>
                     </div>
                 </li>	 
      
   
     	<li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">States</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>


                             <li>
                                 <a href="addclient.php">
                                     <span class="menu-text">Add state</span>
                                 </a>


                             </li>
                             <li>
                                 <a href="viewclient.php">
                                     <span class="menu-text">View state </span>
                                 </a>


                             </li>
                             
                            
                         </ul>
                     </div>
                 </li>	 
 
            -->
     
             
                 
               
                
                  
  
      
   <li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Add Logo/Moving content</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>
                             <li>
                                 <a href="add_gallery.php">
                                     <span class="menu-text">Add LOGO/Moving content </span>
                                 </a>
                             </li>
                             <li>
                                 <a href="gallery.php">
                                     <span class="menu-text">Show LOGO/Moving content </span>
                                 </a>
                             </li>


                         </ul>
                     </div>
                 </li>
                    
 
    

                       <li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Change Password </span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>
                             <li>
                                 <a href="change-password.php">
                                     <span class="menu-text">Change Password </span>
                                 </a>
                             </li>
                             

                         </ul>
                     </div>
                 </li>
                 
                 <li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-cogs"></i></span>
                         <span class="menu-text">Settings</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>
                             <li>
                                 <a href="settings.php">
                                     <span class="menu-text">Basic Settings</span>
                                 </a>
                             </li>
                            
                         </ul>
                     </div>
                 </li>  
    


     <li>
                     <a href="javascript:void(0);" data-action="click-trigger">
                         <span class="menu-icon"><i class="fa fa-dashboard"></i></span>
                         <span class="menu-text">Logout</span>
                         <span class="menu-badge"><span class="badge vd_bg-black-30"><i class="fa fa-angle-down"></i></span></span>
                     </a>
                     <div class="child-menu"  data-action="click-target">
                         <ul>
                             <li>
                                 <a href="logout.php">
                                     <span class="menu-text">Logout </span>
                                 </a>
                             </li>
                            


                         </ul>
                     </div>
                 </li>
   


   

           

             </ul>
<!-- Head menu search form ends -->         </div>             
    </div>
    <div class="navbar-spacing clearfix">
    </div>
    <div class="vd_menu vd_navbar-bottom-widget">
        <ul>
            <li>
                <a href="logout.php">
                    <span class="menu-icon"><i class="fa fa-sign-out"></i></span>          
                    <span class="menu-text">Logout</span>             
                </a>
                
            </li>
        </ul>
    </div>     
</div> 
					<?php  }    else
 {
   echo'<script>location.assign("logout.php")</script>';
 }
}
else
 {
   echo'<script>location.assign("logout.php")</script>';
 }
 ?>