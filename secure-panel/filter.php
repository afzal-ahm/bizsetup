<?php
include "config.php";
if(isset($_GET['p2']))
{
	if($_GET['p2']=='color')
	{
		$type='color';
	}
	else
	{
		$type='size';
	}
	$select="SELECT * from attributemanager where attributes='".$type."'";
	$run=mysqli_query($conn,$select);
	
	echo '<div class="form-group" id="price1">
               
                        <label class="col-sm-2 control-label">'.$type.'</label>
                        <div class="col-sm-7 controls">
                         
                            <select   class="form-control "  name="description" >
		       <option  >Select</option>';
		       foreach($run as $key=> $data){
			   	 echo ' <option value="'.$data['description'].'">'.$data['description'].'</option>';
			   }
		              
		                
	        echo ' </select>
                        </div>
                      </div>';
}
 ?>