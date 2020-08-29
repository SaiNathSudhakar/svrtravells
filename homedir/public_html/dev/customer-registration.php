<?
ob_start();
include_once("includes/functions.php");
if(isset($_SESSION[$svr.'cust_id'])) header('location:customer-account.php');
$fname=$lname=$dob=$email=$password=$mobile=$phone=$address1=$address2=$city=$state=$country=$pin=$tnc='';
if($_SERVER['REQUEST_METHOD']=="POST")
{
	$title=$_POST['title'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$dob=date('Y-m-d', strtotime($_POST['dob']));
	$email=$_POST['email'];
	$password=$_POST['password'];
	$mobile=$_POST['mobile'];
	$phone=$_POST['landline'];
	$address1=$_POST['address1'];
	$address2=$_POST['address2'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$country=$_POST['country'];
	$pin=$_POST['pincode']; 
	$tnc=$_POST['tnc'];
	
	$q = query("select cust_id from svr_customers where cust_email = '".$email."'");
	$count = num_rows($q);
	
	if($count == 0)
	{	
		query("insert into  svr_customers(cust_id,cust_title,cust_fname,cust_lname,cust_dob,cust_mobile,cust_landline,cust_email,cust_password,cust_address_1,cust_address_2,cust_city,cust_country,cust_state,cust_pincode,cust_status,cust_added_date,cust_promotion)values('','".$title."','".$fname."','".$lname."','".$dob."','".$mobile."','".$phone."','".$email."','".md5($password)."','".$address1."','".$address2."','".$city."','".$country."','".$state."','".$pin."',1,'".$now_time."','".$tnc."')");
		
		$_SESSION[$svr.'cust_id'] = insert_id();
		
		if(!empty($tnc)){
			$nl = getdata('svr_nl', 'count(nl_id)', "nl_email='".$email."'");
			if(empty($nl)){
				query("insert into svr_nl ( nl_id, nl_email, nl_status, nl_dateadded) values( '', '".$email."', '1', '".$now_time."')");
			}
		}
		$_SESSION[$svr.'cust_title'] = $title;
		$_SESSION[$svr.'cust_fname'] = $fname;
		$_SESSION[$svr.'cust_lname'] = $lname;
		$_SESSION[$svr.'cust_email'] = $email;
		$_SESSION[$svr.'cust_addr'] = $address1;
		$_SESSION[$svr.'cust_mobile'] = $mobile;
		$_SESSION[$svr.'cust_landline'] = $phone;
		$_SESSION[$svr.'cust_city'] = $city;
		$_SESSION[$svr.'cust_state'] = $state;
		$_SESSION[$svr.'cust_country'] = $country;
		
		$content="<table width='98%' border='0' align='center' cellpadding='0' cellspacing='1'>
		  <tr>
			<td><table width='100%' border='0' align='center' cellpadding='4' cellspacing='0'>
				<tr>
				  <td width='20%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Name</td>
				  <td width='3%' align='center'><strong>:</strong></td>
				  <td align='left'>".$titles[$title]." ".$fname." ".$lname."</td>
				</tr>
				<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>D.O.B</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".date('d/m/Y', strtotime($_POST['dob']))."</td>
				</tr>
				<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>E-Mail ID</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".$email."</td>
				</tr>
				<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Mobile</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".$mobile."</td>
				</tr>";
				if(!empty($phone)){
					$content.="<tr>
					  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Phone</td>
					  <td align='center'><strong>:</strong></td>
					  <td align='left'>".$phone."</td>
					</tr>";
				}
				$content.="<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Address</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".$address1."</td>
				</tr>
				<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>City</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".$city."</td>
				</tr>
				<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>State</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".$states[$state]."</td>
				</tr>
				<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Country</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".$country."</td>
				</tr>
				<tr>
				  <td align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Pincode</td>
				  <td align='center'><strong>:</strong></td>
				  <td align='left'>".$pin."</td>
				</tr>
			</table>";
	
		//echo $content; exit;
		
		$data['subject'] = 'Customer Registration Details from SVR Travels India';
		$data['content'] = $content;
		$data['to_email'] = $email;
		send_email($data);
		
		if(!empty($_SESSION['redir_after_auth']))
		{	
			$pg = $_SESSION['redir_after_auth'];
			$_SESSION['redir_after_auth'] = false;
			if($_SESSION['redir_args'])
			{
				$vars = $_SESSION['redir_args'];
				$_SESSION['redir_args'] = false;
				header('location: ' . $pg . '?' . http_build_query($vars));
			} else {
				header('location: ' . $pg);
			}
		}else {
			header("location:customer-account.php");
		} 
	} else {
		$error = "This Email address is already registered with us";
	}
}
$designFILE = "design/customer-registration.php";
include_once("includes/svrtravels-template.php");
?> 
