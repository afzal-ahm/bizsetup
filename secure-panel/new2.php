<?php
 session_start();
			include "secure-panel/config.php";
			
			
			 if($_SESSION['size']!="")
     {
	 	
?>
     <button onclick="showUserfiltercart1(this.value);" style="background: #222;
    color: #fff;
    padding: 7px 22px;
    border: 2px #222 solid;" class=" " title="Add to Cart" value="0" ><span>  Buy Now</span></button>
    
    <?php } else {
		?>
		 <button onclick="showUserfiltercartnew1(this.value);" style="background: #222;
    color: #fff;
    padding: 7px 22px;
    border: 2px #222 solid;" class=" " title="Add to Cart" value="0" ><span>  Buy Now</span></button>
		
		<br>
		
<?php  echo '<p style="color:red">Select Size *</p>';	} ?>