<?
ob_start();
include_once("includes/functions.php");
if(isset($_SESSION[$svra.'ag_id'])) header('location:agent-account.php');
$img_err_msg = $img_err = $error = $err = '';

if($_SERVER['REQUEST_METHOD']=="POST")
{
	$title=$_POST['title'];
	$fname=$_POST['fname'];
	$lname=$_POST['lname'];
	$uname=$_POST['uname'];
	$sex=$_POST['gender'];
	//$dob=date('Y-m-d H:i:s', strtotime($_POST['dob']));
	$email=$_POST['email'];
	$pwd=$_POST['password'];
	$authority=$_POST['authority'];
	$mobile=$_POST['mobile'];
	$phone=$_POST['landline'];
	$address=$_POST['address'];
	$pancard=$_POST['pancard'];
	$city=$_POST['city'];
	$state=$_POST['state'];
	$country=$_POST['country'];
	$pin=$_POST['pincode']; 
	$tnc=$_POST['tnc']; 
	
	$q = mysql_query("select ag_id from svr_agents where ag_email = '".$email."'");
	$count = mysql_num_rows($q);
	if($count > 0) { $error = "This email address is already registered with us."; }
	
	$unique = 'SAG'.rand(10000,99999);
	$path = "uploads/agents/".$unique."/";
	
	if($_FILES['image']["size"]>0)
	{
		  $imgExtension = array('jpg','jpe','jpeg','png');
		  $image_name = pathinfo($_FILES['image']['name']);
		  $extension = strtolower($image_name['extension']);
		  
		  if(in_array($extension,$imgExtension))
		  {
			  if($_FILES['image']["size"] > 1)
			  {
				  $b_image=substr($_FILES['image']['name'],0,strpos($_FILES['image']['name'],'.'));
				  $b_image.=time();
				  $b_image.=strstr($_FILES['image']['name'],'.');
				  //echo $path.$b_image;exit;
		  		  if(!file_exists($path.$b_image))	@mkdir($path, 0777, true);
				  
				  if(!move_uploaded_file($_FILES['image']['tmp_name'],$path.$b_image)) { $b_image=""; } else { 
				  	  resize_image($path.$b_image, 75); //width: 148; height: 159
				  }
				  $imagepath=$b_image;
			  }
		  }
		  else
		  {		
			  $img_err_msg = "You have to upload 'jpg , jpe , jpeg , png' images only";
		  }
	} else {
		$img_err = "Please upload logo.";
	}
	
	if(empty($email) || empty($pwd) || empty($fname) || empty($mobile) || empty($pancard) || empty($title) || empty($address))
	{
		$err = "Marked fields are mandatory.";
	}
	
	if(empty($error) && empty($img_err_msg) && empty($img_err) && empty($err))
	{
		mysql_query("insert into svr_agents(ag_id, ag_title, ag_fname, ag_lname, ag_unique_id, ag_uname, ag_password, ag_gender, ag_mobile, ag_landline, ag_email, ag_authority, ag_pancard, ag_address, ag_city, ag_country, ag_state, ag_pincode, ag_logo, ag_status, ag_added_date, ag_promotion) values ('','".$title."','".$fname."','".$lname."','".$unique."','".$uname."','".md5($pwd)."','".$sex."','".$mobile."','".$phone."','".$email."','".$authority."', '".$pancard."','".$address."','".$city."','".$country."','".$state."','".$pin."','".$b_image."',1,'".$now_time."','".$tnc."')");
		
		$_SESSION[$svra.'ag_id'] = mysql_insert_id();
		
		if(!empty($tnc)){
			$nl = getdata('svr_nl', 'count(nl_id)', "nl_email='".$email."'");
			if($nl == 0){
				mysql_query("insert into svr_nl ( nl_id, nl_email, nl_status, nl_dateadded) values( '', '".$email."', '1', '".$now_time."')");
			}
		}
		$content="<table width='100%' border='0' align='center' cellpadding='4' cellspacing='0'>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Name</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$titles[$title]." ".$fname." ".$lname."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Agent ID</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$unique."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Gender</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$gender[$sex]."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Authority Level</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$authority."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>E-Mail ID</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$email."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Mobile</td>
			  <td width='5%' align='center'><strong>:</strong></td>
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
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>PAN Card</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$pancard."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Address</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$address."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>City</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$city."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>City</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$states[$state]."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Country</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$country."</td>
			</tr>
			<tr>
			  <td width='40%' align='left' style='font-family:Verdana; font-size:13px; color:#131313; padding-left:20px;'>Pincode</td>
			  <td width='5%' align='center'><strong>:</strong></td>
			  <td align='left'>".$pin."</td>
			</tr>
		</table>";
		
		//echo $mail_body; exit;
		
		$data['subject'] = 'Agent Registration Details from SVR Travels India';
		$data['content'] = $content;
		$data['to_email'] = $email;
		send_email($data);
		
		$_SESSION[$svra.'ag_uname'] = $uname;
		$_SESSION[$svra.'ag_title'] = $title;
		$_SESSION[$svra.'ag_fname'] = $fname;
		$_SESSION[$svra.'ag_lname'] = $lname;
		$_SESSION[$svra.'ag_email'] = $email;
		$_SESSION[$svra.'ag_pan'] = $pancard;
		$_SESSION[$svra.'ag_addr'] = $address;
		$_SESSION[$svra.'ag_mobile'] = $mobile;
		$_SESSION[$svra.'ag_landline'] = $phone;
		$_SESSION[$svra.'ag_city'] = $city;
		$_SESSION[$svra.'ag_state'] = $state;
		$_SESSION[$svra.'ag_country'] = $country;
		$_SESSION[$svra.'ag_unique_id'] = $unique;
		$_SESSION[$sva.'ag_image'] = $path.$b_image;
		
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
			header("location:agent-account.php");
		} 
	}
}
$designFILE = "design/agent-registration.php";
include_once("includes/svrtravels-template.php");
?> 
