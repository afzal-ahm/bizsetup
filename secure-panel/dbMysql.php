<?php
define('DB_SERVER','localhost');
define('DB_USER','taxfunda_taxfunda');
define('DB_PASS','Computer@123#');
define('DB_NAME','taxfunda_taxfunda');

class DB_con {
	function __construct()
	{
		$conn = z(DB_SERVER,DB_USER,DB_PASS)or die('connection problem'.mysql_error());
		 mysql_select_db(DB_NAME);
	}
	public function checkUser($field_value,$table,$field){
		$data = array();
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' AND ".$field[1]." = '". $field_value[1]."' ") or die(mysql_error());
		if(mysql_num_rows($res) > 0){
			$data = mysql_fetch_assoc($res);
		}
		return $data ;
	}
   public function insert($field_value,$table,$field)
   {
	   $query_fields = '`' . implode('`,`', $field) . '`';
	   //print_r($query_fields);
	   //print_r($field[1]);
	   $query_fields_value = "'" . implode("','", $field_value) . "'";
	 // print_r($query_fields_value);
	   //print_r($field_value[1]);
	   $res = mysql_query("INSERT INTO ".$table." (".$query_fields.") VALUES (".$query_fields_value.") ") or die(mysql_error());
	   return $res;
	   }

public function selectcatprod($table,$field_value,$field)
     {
	   $categories = array();
	   $query_fields = '`' . implode('`,`', $field) . '`';
	   $query_fields_value = "" . implode("','", $field_value) . "";
	   $res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' ") or die(mysql_error());
	   if(mysql_num_rows($res) > 0){ 
	   while($row=mysql_fetch_assoc($res)){
			  $categories[] = $row;
			}
	   } else {
		      $var =array(0=>'',1=>'No Data Found');//echo'No Data Found';
		 //  $var ='No Data Found';
			  $categories []=$var;
		   }
		return $categories;
	   }
	   
	   
	   public function selectcatprodlimit($table,$field_value,$field)
     {
	   $categories = array();
	   $query_fields = '`' . implode('`,`', $field) . '`';
	   $query_fields_value = "" . implode("','", $field_value) . "";
	   $res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' order by id desc ") or die(mysql_error());
	   if(mysql_num_rows($res) > 0){ 
	   while($row=mysql_fetch_assoc($res)){
			  $categories[] = $row;
			}
	   } else {
		      $var =array(0=>'',1=>'No Data Found');//echo'No Data Found';
		 //  $var ='No Data Found';
			  $categories []=$var;
		   }
		return $categories;
	   }

	public function selecttwocond($table,$field_value,$field)
	{
		$categories = array();
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' AND ".$field[1]." = '". $field_value[1]."' ") or die(mysql_error());
		if(mysql_num_rows($res) > 0){
			while($row=mysql_fetch_assoc($res)){
				$categories[] = $row;
			}
		} else {
			$var =array(0=>'',1=>'No Data Found');//echo'No Data Found';
			//  $var ='No Data Found';
			$categories []=$var;
		}
		return $categories;
	}
	public function select($table)
	{
	    $categories = array();
		$res = mysql_query("SELECT * FROM ".$table." ");
		while($row=mysql_fetch_assoc($res)){
			  $categories[] = $row;
			}
		return $categories;
		}
	public function selectcurrency($table)
	{
		$categories = array();
		$res = mysql_query("SELECT *
		FROM  ".$table." WHERE  `date` = (
	SELECT MAX(  `date` )
FROM currency )");


		while($row=mysql_fetch_assoc($res)){
			$categories[] = $row;
		}
		return $categories;
	}
	public function selectsub($table,$subcat)
	{
	    $categories = array();
		$res = mysql_query("SELECT * FROM ".$table." where category_id = ".$subcat." ");
		while($row=mysql_fetch_row($res)){
			  $categories[] = $row;
			}
		return $categories;
		} 
		public function selectsub_sub($table,$subcat)
	  {
	    $categories = array();
		$res = mysql_query("SELECT * FROM ".$table." where subcategory_id = ".$subcat." ");
		while($row=mysql_fetch_row($res)){
			  $categories[] = $row;
			}
		return $categories;
		} 
		
		
		public function selectproduct($table,$sku)
	{
	    $categories = array();
		$res = mysql_query("SELECT * FROM ".$table." where sku = '".$sku."' ")or die(mysql_error());
		//echo $res;
		while($row=mysql_fetch_assoc($res)){
			  $categories[] = $row;
			}
		return $categories;
	} 
		  
     public function search_sku($table,$field,$field_value)
   {
	   $search_sku = array();
	   $query_fields = '' . implode('`,`', $field) . '';
	   //print_r($query_fields);
	   $query_fields_value = "" . implode("','", $field_value) . "";
	   //print_r($query_fields_value);
	   $res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$query_fields."  like '%". $query_fields_value."%' LIMIT 10 ") or die(mysql_error());
	 //echo $res; 
	   while($row=mysql_fetch_row($res)){
			  $search_sku[] = $row;
			}
		
		return $search_sku;
	    
	   }
public function update_sku($table,$field,$field_value)
     {
	   $categories = array();
	   $query_fields = '`' . implode('`,`', $field) . '`';
	  // print_r($field);
	   //print_r($query_fields);
	   $query_fields_value = "" . implode("','", $field_value) . "";
	  // print_r($field_value);
	   $res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' ") or die(mysql_error());
	   //echo $res; 
	   while($row=mysql_fetch_row($res)){
			  $categories[] = $row;
			}
		return $categories;
	   }

     

   public function update($field_value,$table,$field)
     {
		if(count($field_value)==count($field))
		{
			for($a=0;$a<count($field_value);$a++)
			$res = mysql_query("UPDATE ".$table." SET ".$field[$a]." = '".$field_value[$a]."' where  ".$field[0]." = '". $field_value[0]."' ") or die(mysql_error());
	  //echo $res; 
			return $res;
			} 

	   }
public function select_deals($table)
	{
	    $categories = array();
		$res = mysql_query("SELECT * FROM ".$table."  ORDER BY id DESC limit 12");
		while($row=mysql_fetch_row($res)){
			  $categories[] = $row;
			}
		return $categories;
		} 
		
public function onsale($table,$orderby,$limit)
	{
	    $categories = array();
		$res = mysql_query("SELECT * FROM ".$table."  ORDER BY ".$orderby." DESC limit ".$limit."");
		while($row=mysql_fetch_assoc($res)){
			  $categories[] = $row;
			}
		return $categories;
		} 
		
		
public function select_hotdeals($table)
	{
	    $categories = array();
		$res = mysql_query("SELECT * FROM ".$table."  limit 6");
		while($row=mysql_fetch_row($res)){
			  $categories[] = $row;
			}
		return $categories;
		} 
     function runQuery($query) {
		$result = mysql_query($query);
		while($row=mysql_fetch_assoc($result)) {
			$resultset[] = $row;
		}		
		if(!empty($resultset))
			return $resultset;
	}
	function coupon_generator(){

		$num0 = (rand(10, 100));
		$num1 = date("dmY");
		$currentId = $num1 . $num0;
		$Orderid = 'BP' . $currentId;
		$res=mysql_query("select order_id from order_details where order_id ='".$Orderid."'");
		$numrows=mysql_num_rows($res);
		if($numrows > 0){
         $this->coupon_generator();
		}else{
			return	$Orderid;
		}

	}

	public function delete($table, $sku)
	{
	$delete_product = mysql_query("DELETE FROM ".$table."
          WHERE sku = '".$sku."' ")or die(mysql_error());

		return $delete_product;
		}
		
		public function delete1($table, $sku)
	{
	$delete_product = mysql_query("DELETE FROM ".$table."
          WHERE id = '".$sku."' ")or die(mysql_error());

		return $delete_product;
		}
	public function delete_user($table,$field,$field_value)
	{
		$query_fields = '`' . implode('`,`', $field) . '`';
		//print_r($query_fields);
		//print_r($field[1]);
		$query_fields_value = "'" . implode("','", $field_value) . "'";
		// print_r($query_fields_value);
		//print_r($field_value[1]);
		$res = mysql_query("DELETE FROM ".$table." WHERE ".$field[0]." = ".$field_value[0]." ") or die(mysql_error());
		return $res;
	}


	public function searchingprod($table,$field,$field_value)
   {
	   $search_sku = array();
	   $query_fields = '' . implode('`,`', $field) . '';
	   //print_r($field[]);
	   $query_fields_value = "" . implode("','", $field_value) . "";
	   //print_r($query_fields_value);
	   $res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]."  like '%". $query_fields_value."%' LIMIT 10 ") or die(mysql_error());
	 //echo $res; 
	   while($row=mysql_fetch_row($res)){
			  $search_sku[] = $row;
			}
		
		return $search_sku;
	    
	   }
	   
	   public function searching($field_value,$table,$field)
   {
	   $search_sku = array();
	   $query_fields = '' . implode('`,`', $field) . '';
	  // print_r($query_fields);
	   $query_fields_value = "" . implode("','", $field_value) . "";
	  // print_r($query_fields_value);
	   $res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$query_fields."  like '%". $query_fields_value."%' ") or die(mysql_error());
	 //echo $res; 
	   while($row=mysql_fetch_row($res)){
			  $search_sku[] = $row;
			}
		return $search_sku;
	   }
	   
	   
	   public function already_exist($table,$field,$field_value){
		    $query_fields = '`' . implode('`,`', $field) . '`';
			 $query_fields_value = "" . implode("','", $field_value) . "";
		 // print_r($query_fields);
		   //print_r($query_fields_value);die;
		   //print_r($field[1]);
		    //print_r($field_value[1]);
		   $check = mysql_query("SELECT ".$query_fields." FROM ".$table." WHERE ".$field[1]." = '".$field_value[1]."' AND ".$field[0]." = '".$field_value[0]." ' ") or die(mysql_error());
          
	//print_r($check); 

		    if(mysql_num_rows($check)> 0) {
           echo "This IS Already  Exists Please try another<br/>";
              }

          else
       {
    $res = mysql_query("INSERT INTO ".$table." (".$query_fields.") VALUES ('".$query_fields_value."') ") or die(mysql_error());
	   return $res;
       }
		   
		   
		   }
	public function already_existnewsletter($table,$field,$field_value){
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		// print_r($query_fields);
		//print_r($query_fields_value);die;
		//print_r($field[1]);
		//print_r($field_value[1]);
		$check = mysql_query("SELECT ".$query_fields." FROM ".$table." WHERE ".$field[0]." = '".$field_value[0]."'  ") or die(mysql_error());

		//print_r($check);

		if(mysql_num_rows($check)> 0) {
			//echo "This IS Already  Exists Please try another<br/>";
		}

		else
		{
			$res = mysql_query("INSERT INTO ".$table." (".$query_fields.") VALUES ('".$query_fields_value."') ") or die(mysql_error());
			return $res;
		}


	}

	public function already_exist_sizechart($table,$field,$field_value){
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		// print_r($query_fields);
		//print_r($query_fields_value);die;
		//print_r($field[1]);
		//print_r($field_value[1]);
		$check = mysql_query("SELECT ".$query_fields." FROM ".$table." WHERE ".$field[1]." = '".$field_value[1]."' AND ".$field[0]." = '".$field_value[0]." ' AND ".$field[2]." = '".$field_value[2]."'") or die(mysql_error());

		//print_r($check);

		if(mysql_num_rows($check)> 0) {
			echo "This IS Already  Exists Please try another<br/>";
		}

		else
		{
			$res = mysql_query("INSERT INTO ".$table." (".$query_fields.") VALUES ('".$query_fields_value."') ") or die(mysql_error());
			return $res;
		}


	}

	public function selectsearchingnow()
	{
		// $con = new DB_con();
		$res= mysql_query( "SELECT DISTINCT (
p.product_category
), c.category_name, sbb.sub_subcategory_name, sbb.sub_subcategory_id, p.product_name, p.description, p.quantity, p.unit_price, p.mrp, p.image, p.discount, p.sku, p.product_subcategory
FROM product AS p
LEFT JOIN sub_subcategory AS sbb ON sbb.category_id = p.product_category
AND sbb.subcategory_id = p.product_subcategory
AND sbb.sub_subcategory_id = p.sub_subcategory_id
LEFT JOIN subcategory AS sb ON sbb.category_id = sb.category_id
LEFT JOIN category AS c ON c.category_id = sb.category_id
where p.product_category in (select category_id from category)
ORDER BY c.category_name");
		while($row=mysql_fetch_row($res)){
			$search_sku[] = $row;
		}
		return $search_sku;
	}



	public function selectsearchingnow12()
	{
		// $con = new DB_con();
		$res= mysql_query( "select subcategory_id,subcategory_name from subcategory where category_id=".$_GET['catid']." ");
		while($row=mysql_fetch_row($res)){
			$search_sku[] = $row;
		}
		return $search_sku;
	}

	public function selectsearchingnow123($a,$b)
	{
		// $con = new DB_con();

		$res5= mysql_query( "select * from sub_subcategory where category_id=".$b." and subcategory_id=".$a." ");
		if($res5)
		{
			$search_sku5=array();
			// if($res5->num_rows>0)
			{
				while($row5=mysql_fetch_row($res5))
				{
					$search_sku5[] = $row5;
					//  print_r($row5);
				}
				return $search_sku5;
			}
		}
	}

    public function Guest_Register($table,$field_value,$field){
		$categories = array();
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' ") or die(mysql_error());
		if(mysql_num_rows($res) > 0){
			$this->update($field_value,$table,$field);
		} else {
			$this->insert($field_value,$table,$field);
		}
		return $categories;

	}
	public function create_account($table,$field,$field_value){
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$check = mysql_query("SELECT * FROM ".$table." WHERE ".$field[0]." = '".$field_value[0]."' ") or die(mysql_error());
		if(mysql_num_rows($check)> 0) {
			$rows = mysql_fetch_assoc($check);

			if($rows['role']=='Guest'){
				//echo'<script>alert("You are already register with us as guest ,do you want to register an account with us")</script>';
				 $message = 'Guest';
				return $message;
			}
		}

		else
		{
			$res = mysql_query("INSERT INTO ".$table." (".$query_fields.") VALUES ('".$query_fields_value."') ") or die(mysql_error());
			//return $res;
		}


	}
	public function selectpromo($table,$field_value,$field)
	{
		$categories = array();
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$res = mysql_query("SELECT ".$query_fields." FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' ") or die(mysql_error());
		if(mysql_num_rows($res) > 0){
			$row=mysql_fetch_assoc($res);
				$categories = $row;
			}
		return $categories;
	}
	public function selectinvoicedetails($orderid){
		$data=array();
		  $res = mysql_query("SELECT (
			p.order_id
		), c.total_amount,c.order_id ,c.subtotal,c.coupondiscount,c.invoice_status,c.invoiceno, sbb.customer_user_id,sbb.fname,sbb.mname,sbb.lname,sbb.country,sbb.state,sbb.pincode,sbb.address,sbb.email,sbb.company,sbb.city,sbb.mobile_no, p.customer_user_id, p.product_name,p.sku,
		p.unit_cost,p.quantity,p.amount,(SELECT a.name FROM states a
  WHERE sbb.state = a.id
		AND sbb.country = a.country_id) as states
FROM order_details AS p
LEFT JOIN customer_detail AS sbb ON sbb.customer_user_id = p.customer_user_id
LEFT JOIN order_summary AS c ON c.order_id = p.order_id
where p.order_id = '$orderid' ");
		if(mysql_num_rows($res) > 0){
			while($details = mysql_fetch_assoc($res)){
				$data[] = $details;
			}

		}
		return $data;
	}
	public function invoiceNo(){
		$resp=mysql_query("select MAX(invoiceno) from order_summary");
		$data1=mysql_fetch_assoc($resp);
		//$bill_no=$data1['invoiceno'];
		return $data1;
	}
	public function searchresult($str)
	{
		$data = array();

		$stringarray = explode(" ", $str);
		$sqlstring = "SELECT * FROM product WHERE 1 = 1 ";


		$loopCount = 0;
		foreach ($stringarray as $keyarray => $valuearray) {

			if ($loopCount > 0)
				$sqlstring = $sqlstring . " or (CONCAT(sku , ' ',product_name, ' ' ,description, ' ' ,brand_name) Like '%" . $valuearray . "%') ";
			else
				$sqlstring = $sqlstring . " and (CONCAT(sku , ' ',product_name, ' ' ,description, ' ' ,brand_name) Like '%" . $valuearray . "%') ";
			$loopCount++;
		}

		// echo $sqlstring;

		$Querysearch = mysql_query($sqlstring) or die(mysql_error());;
		if (mysql_num_rows($Querysearch) > 0) {
			while ($details = mysql_fetch_assoc($Querysearch)) {
				$data[] = $details;
			}
			return $data;
			// $res = mysql_fetch_assoc($Querysearch);

		}
	}
	public function customerOrderDetails($OrderIDForDetail){
		$data =array();
		$Query = mysql_query("SELECT (
			p.customer_user_id
		), c.total_amount,c.order_id ,c.subtotal,c.coupondiscount,sbb.fname,sbb.mname,sbb.lname,sbb.address,sbb.email,sbb.mobile_no,a.image,a.description, p.product_name,p.sku,
		p.unit_cost,p.quantity,p.amount,p.order_date
FROM order_details AS p
LEFT JOIN customer_detail AS sbb ON sbb.customer_user_id = p.customer_user_id
LEFT JOIN product AS a ON a.sku= p.sku
LEFT JOIN order_summary AS c ON c.order_id = p.order_id
where p.order_id ='".$OrderIDForDetail."' ");
		if(mysql_num_rows($Query) > 0){
			while($details = mysql_fetch_assoc($Query)){
				$data[] = $details;
			}

		}
		return $data;
	}
	function send_mail_Registration($name,$email,$password)
	{
		$to = 'manishanglia2gmail.com';
		$subject = 'Welcome!';
		$from = $email;

// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$to."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
		$headers .= "Date: " . date('r', time()) . "\n";
// Compose a simple HTML email message
		$message = '<html><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;}

	#customers th {
    font-size: 1.4em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #fff;
	    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}
#customers td, #customers th {
    font-size: 1.2em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;}
</style><body>';
		$message .= '<p></p><br>
    Hi '.$name.'<br>
   Thank you for registering.<br><br>
   Login using your email id : '.$email.' and,<br>
   your password : '.$password.'<br><br>';
		$message .= '<img src="http://bonitopanos.com/images/logo.png" title="">';
		$message .= '</body></html>';
		//For admin
		$message1 = '<html><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;}

	#customers th {
    font-size: 1.4em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #fff;
	    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}
#customers td, #customers th {
    font-size: 1.2em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;}
</style><body>';
		$message1 .= '<p></p><br>
   Hi Admin<br>
   You have found a new registration,<br><br>
   in your website,<br>
   Details of registration :
		Name : '.$name.'<br><br>	Email Id : '.$email.'<br><br>';

		$message1 .= '<img src="http://bonitopanos.com/images/logo.png" title="">';
		$message1 .= '</body></html>';
// Sending email
		if(mail($to, $subject, $message1, $headers)){

			mail($email , $subject, $message, $headers);
			$data = 'Your mail has been sent successfully.';
		} else{
			$data = 'Unable to send email. Please try again.';
		}
return $data;
	}

	function guestregistrationcomfirm($email)
	{
		$to = 'aditya@starcom-india.com';
		$subject = 'Welcome!';
		$from = $email;

// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$to."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
		$headers .= "Date: " . date('r', time()) . "\n";
// Compose a simple HTML email message
		$message = '<html><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;}

	#customers th {
    font-size: 1.4em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #fff;
	    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}
#customers td, #customers th {
    font-size: 1.2em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;}
</style><body>';
		$message .= '<p></p><br>
    Thank you for confirmation with bonitopanos.com. Click the link  below to activate your account.  <br>
     <br>
     <a href="http://infotrench.in/demo/bonitopanos/confirmGuest.php?email='.$email.'">Confirmation Link </a>
     <br>';
		$message .= '<img src="http://bonitopanos.com/images/logo.png" title="">';
		$message .= '</body></html>';
// Sending email
		if(mail($email , $subject, $message, $headers)){

			//mail($email , $subject, $message, $headers);
			$data = 'Your mail has been sent successfully.';
		} else{
			$data = 'Unable to send email. Please try again.';
		}
		return $data;
	}

	function mailforcancelorder($email,$OrderIds,$remarks)
	{
		$to = 'aditya@starcom-india.com';
		$subject = 'Welcome!';
		$from = $email;

// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$to."\r\n" .
			'X-Mailer: PHP/' . phpversion();
		$headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
		$headers .= "Date: " . date('r', time()) . "\n";
// Compose a simple HTML email message
		$message = '<html><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;}

	#customers th {
    font-size: 1.4em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #fff;
	    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}
#customers td, #customers th {
    font-size: 1.2em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;}
</style><body>';
		$message .= '<p></p><br>
    Hi '.$email.'<br>
   Your Order Id : '.$OrderIds.' has been cancelled successfully.<br><br>
   Thankyou for using ..<br><br>';
		$message .= '<img src="http://bonitopanos.com/images/logo.png" title="">';
		$message .= '</body></html>';
		//For admin
		$message1 = '<html><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;}

	#customers th {
    font-size: 1.4em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #fff;
	    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}
#customers td, #customers th {
    font-size: 1.2em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;}
</style><body>';
		$message1 .= '<p></p><br>
   Hi Admin<br>
   Order Id : '.$OrderIds.' has been cancelled ,<br><br>
   Reason for cancel order : '.$remarks.',<br>';

		$message1 .= '<img src="http://bonitopanos.com/images/logo.png" title="">';
		$message1 .= '</body></html>';
// Sending email
		if(mail($to, $subject, $message1, $headers)){

			mail($email , $subject, $message, $headers);
			$data = 'Your mail has been sent successfully.';
		} else{
			$data = 'Unable to send email. Please try again.';
		}
		return $data;
	}

	function orderconfirmationmail($OrderIds)
	{
		$table = "order_summary";
		$field_value=array($OrderIds);
		$field=array('order_id','email_id','mobile_no','order_date','total_amount');
		$res = $this->selectcatprod($table,$field_value,$field);
		foreach($res as $key=>$Ordersummary)
			$emailId = $Ordersummary['email_id'];
		    $mobile_no = $Ordersummary['mobile_no'];
		    $total_amount = $Ordersummary['total_amount'];
		    $orderDate = $Ordersummary['order_date'];
		$table = "order_details";
		$field_value=array($OrderIds);
		$field=array('order_id','customer_user_id','product_name','unit_cost', 'quantity', 'amount', 'shipping_method','order_date');
		$Orderdetails = $this->selectcatprod($table,$field_value,$field);

		$table = "customer_detail";
		$field_value=array($emailId);
		$field=array('email', 'fname', 'mname', 'lname', 'mobile_no', 'telephone', 'pincode', 'company', 'address', 'city');
		$customerInfo = $this->selectcatprod($table,$field_value,$field);
		foreach($customerInfo as $keyinfo =>$Customerinfo)
			$to = 'rakeshmethi@gmail.com';
		$subject = 'Your order  is confirmed';
		$from = $emailId;

// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$to."\r\n" .
			'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message
		$message = '<html><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;}

	#customers th {
    font-size: 1.4em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #fff;
	    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}
#customers td, #customers th {
    font-size: 1.2em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;}
</style><body>';
		$message .= '<h1>MR/MRS : '.$Customerinfo['fname'].'&nbsp;'.$Customerinfo['mname'].'&nbsp;'.$Customerinfo['lname'].'</h1><br/>Thank you for your order!';
		$message .= '<p style="color:#080;font-size:14px;">Here is a summary of your purchase. When we ship an item, we will send an update with tracking details.';

		$message .= '<h2 style="color:#f40;">Customer Mob No : '.$Customerinfo['mobile_no'].'</h2>';
		$message .= '<h5>Address: '.$Customerinfo['address'].'&nbsp;'.$Customerinfo['city'].'</h5>';
		$message .= '<p style="color:#080;font-size:14px;">Order ID  : '.$OrderIds.'</p><p style="color:black;font-size:12px;">Placed On  : '.$orderDate.' ';
		$message .= '<p style="color:#080;font-size:14px;">';
		$message .= '<table width="1011"  align="center" style="border-collapse:collapse;font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;">
  <tr>

    <th width="201" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Product Name</th>
    <th width="176" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Quantity</th>
    <th width="131" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Unit Price</th>
    <th width="199" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Amount</th>

  </tr>';
		foreach($Orderdetails as $keyorderdetails=>$Orderdetailsval){
			$message .= '<tr>

    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['product_name'].'</div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['quantity'].'</div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['unit_cost'].'</div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['amount'].'</div></td>

  </tr>';}
		$message .= '<tr>

    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center"></div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"> <div align="center"></div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center"></div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center"></div></td>

  </tr>
</table>
<table width="1010" border="0" align="center" >
  <tr>
    <th width="278" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">Total</div></th>
    <th width="716" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"> <div align="center">'.$total_amount.'</div></th>
  </tr>
</table>

';
		$message .= '<img src="http://yaduvanshipackers.com/Admin2/images/pet-logo.png"" title="">';
		$message .= '</body></html>';

// Sending email
		if(mail($to , $subject, $message, $headers)){

			mail($emailId , $subject, $message, $headers);
			//echo 'Your mail has been sent successfully.';
		} else{
			echo 'Unable to send email. Please try again.';
		}
	}

	function oncompletionmail($OrderIds)
	{
		$table = "order_summary";
		$field_value=array($OrderIds);
		$field=array('order_id','email_id','mobile_no','order_date','total_amount');
		$res = $this->selectcatprod($table,$field_value,$field);
		foreach($res as $key=>$Ordersummary)
			$emailId = $Ordersummary['email_id'];
		$mobile_no = $Ordersummary['mobile_no'];
		$total_amount = $Ordersummary['total_amount'];
		$orderDate = $Ordersummary['order_date'];
		$table = "order_details";
		$field_value=array($OrderIds);
		$field=array('order_id','customer_user_id','product_name','unit_cost', 'quantity', 'amount', 'shipping_method','order_date');
		$Orderdetails = $this->selectcatprod($table,$field_value,$field);

		$table = "customer_detail";
		$field_value=array($emailId);
		$field=array('email', 'fname', 'mname', 'lname', 'mobile_no', 'telephone', 'pincode', 'company', 'address', 'city');
		$customerInfo = $this->selectcatprod($table,$field_value,$field);
		foreach($customerInfo as $keyinfo =>$Customerinfo)
			$to = 'rakeshmethi@gmail.com';
		$subject = 'Your Product has been delivered';
		$from = $emailId;

// To send HTML mail, the Content-type header must be set
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
		$headers .= 'From: '.$from."\r\n".
			'Reply-To: '.$to."\r\n" .
			'X-Mailer: PHP/' . phpversion();

// Compose a simple HTML email message
		$message = '<html><style>
#customers {
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
    width: 100%;
    border-collapse: collapse;}

	#customers th {
    font-size: 1.4em;
    text-align: left;
    padding-top: 5px;
    padding-bottom: 4px;
    background-color: #A7C942;
    color: #fff;
	    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;
}
#customers td, #customers th {
    font-size: 1.2em;
    border: 1px solid #98bf21;
    padding: 3px 7px 2px 7px;}
</style><body>';
		$message .= '<h1>MR/MRS : '.$Customerinfo['fname'].'&nbsp;'.$Customerinfo['mname'].'&nbsp;'.$Customerinfo['lname'].'</h1><br/>We hope you are happy with your purchase!';
		$message .= '<p style="color:#080;font-size:14px;">Here is a summary of the item(s) delivered. ';

		$message .= '<h2 style="color:#f40;">Customer Mob No : '.$Customerinfo['mobile_no'].'</h2>';
		$message .= '<h5>Address: '.$Customerinfo['address'].'&nbsp;'.$Customerinfo['company'].'</h5>';
		$message .= '<h2 style="color:#f40;">Item(s) Delivered</h2>';
		$message .= '<p style="color:#080;font-size:14px;">Order ID  : '.$OrderIds.'</p><p style="color:black;font-size:12px;">Placed On  : '.$orderDate.' ';
		$message .= '<table width="1011"  align="center" style="border-collapse:collapse;font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;">
  <tr>

    <th width="201" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Product Name</th>
    <th width="176" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Quantity</th>
    <th width="131" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Unit Price</th>
    <th width="199" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;">Amount</th>
  </tr>';
		foreach($Orderdetails as $keyorderdetails=>$Orderdetailsval){
			$message .= '<tr>

    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['product_name'].'</div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['quantity'].'</div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['unit_cost'].'</div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">'.$Orderdetailsval['amount'].'</div></td>

  </tr>';}
		$message .= '<tr>

    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center"></div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"> <div align="center"></div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center"></div></td>
    <td style="font-size: 1.2em;border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center"></div></td>

  </tr>
</table>
<table width="1010" border="0" align="center" >
  <tr>
    <th width="278" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"><div align="center">Total</div></th>
    <th width="716" scope="col" style="font-size: 1.4em;text-align: left;padding-top: 5px; padding-bottom: 4px;background-color: #A7C942;color: #fff;
    border: 1px solid #98bf21;padding: 3px 7px 2px 7px;"> <div align="center">'.$total_amount.'</div></th>
  </tr>
</table>

';
		$message .= '<img src="http://yaduvanshipackers.com/Admin2/images/pet-logo.png" title="">';
		$message .= '</body></html>';

// Sending email
		if(mail($to , $subject, $message, $headers)){

			mail($emailId , $subject, $message, $headers);
			//echo 'Your mail has been sent successfully.';
		} else{
			echo 'Unable to send email. Please try again.';
		}
	}


	public function notification ($table,$field_value,$field){

		$categories = array();
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$res = mysql_query("SELECT COUNT(".$field[0].") FROM ".$table."  where  ".$field[0]." = '". $field_value[0]."' ") or die(mysql_error());
		if(mysql_num_rows($res) > 0){
			$row=mysql_fetch_assoc($res);
			$categories = $row;
		}
		return $categories;

	}

	public function already_exist_attributes($table, $field, $field_value){
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$check = mysql_query("SELECT ".$query_fields." FROM ".$table." WHERE ".$field[1]." = '".$field_value[1]."' AND ".$field[0]." = '".$field_value[0]." ' AND ".$field[2]." = '".$field_value[2]."'") or die(mysql_error());

		if(mysql_num_rows($check)> 0) {

			$this->update($field_value,$table,$field);
		}

		else
		{
			$this->insert($field_value,$table,$field);
		}


	}
    public function Fetchattributes ($table, $field, $field_value){
		$data = array();
		$query_fields = '`' . implode('`,`', $field) . '`';
		$query_fields_value = "" . implode("','", $field_value) . "";
		$Query = mysql_query("SELECT * FROM ".$table." WHERE ".$field[0]." = '".$field_value[0]."' AND ".$field[1]." = '".$field_value[1]."' AND ".$field[2]." = '".$field_value[2]."' AND ".$field[3]." = '".$field_value[3]."' ");
		if(mysql_num_rows($Query)> 0) {
			$data = mysql_fetch_assoc($Query);
		}
		return $data ;

	}
	public function redirect($url)
	{
		header("Location: $url");
	}

}