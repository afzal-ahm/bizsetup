 <?php include "config.php";
   session_start();
 error_reporting(0); 
 
       $msg=$_GET['msg'];
       $code=$_GET['code'];
       $admin=$_GET['admin'];
       $bymessage=$_GET['bymessage'];
      
      
 if(function_exists('date_default_timezone_set')) {
    date_default_timezone_set("Asia/Kolkata");
}
 
 
 $date = date("d M Y");
 $date1 =  date("H:i a");
 $datex=' ';
 $posting_date=$date.$datex.$date1;
 
  $sqls="select Count(*) AS total from   saller_sopport where  saller_id='".$code."'";
									$results=mysqli_query($conn,$sqls);
									 $mls=mysqli_fetch_array($results); 
									  $cous= $mls[0];
									  
									  if($cous>'0')
									  {
									   	$ss="SELECT * from saller_sopport where  saller_id='".$code."' order by id DESC LIMIT 1";
									  	$run=mysqli_query($conn,$ss);
									  	foreach($run as $key=> $co)
									   	$chat_code=$co['unique_id'];
									  }
									  else{
									  	  $random_digit=rand(000000,999999);
									  	  $datexx='-';
									   	$chat_code=$code.$datexx.$random_digit;
									  }
									  
									   $in="INSERT INTO `saller_sopport`(  `message`, `date`, `saller_id`, `admin_id`, `unique_id`, `bymessage`) VALUES ('$msg','$posting_date','$code','$admin','$chat_code','admin' )";
									 $run=mysqli_query($conn,$in);
									 if($run)
									 { ?>
									 	
									 	
									 	<li>
                            
                            <div class="menu-text"> <strong><?php echo $msg;?></strong> Admin
                              <div class="menu-info"> <span class="menu-date"><?php echo $posting_date;?></span>  </div>
                            </div>
                          </li>
									 
									 	
									 	
									   
									 <?php }
 
 
 
 ?>