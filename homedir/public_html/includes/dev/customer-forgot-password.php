<? ob_start();
include_once("includes/functions.php");
if(isset($_SESSION[$svr.'cust_id'])) header('location:customer-account.php');
$tablename="svr_customers";
$pageTitle="Forgot Password";
$pageName="Forgot Password";

if($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST['email']))
{	
	$yp = mysql_query("select cust_fname, cust_email, cust_password from ".$tablename." where cust_email='".$_POST['email']."'");
	$yp_cnt = mysql_num_rows($yp);
	
	if($yp_cnt==0) { $invmsg = "Invalid E-Mail ID"; }
	if($yp_cnt!=0) { 
		$yp_fetch=mysql_fetch_array($yp);
		$name=$yp_fetch['cust_fname'];
		$email=$yp_fetch['cust_email']; //print_r($_POST);
		$password=$yp_fetch['cust_password'];
		$random_text=genRandomString();
		
		mysql_query("update ".$tablename." set cust_fg_password='".$random_text."', cust_fg_date='".$now_time."' where cust_email='".$_POST['email']."'");
		
		$content = "<table width='100%' border='0' align='center' cellpadding='4' cellspacing='0'>			
			<tr>
				<td colspan='6' align='left' valign='top' class='tdbg' style='border-bottom:1px solid #ff3300;'>
				<span id='result_box'><strong>SVR Travels Forgot Password </strong></span></td>
			</tr>
			<tr>
				<td width='144' height='30' align='left' valign='top' class='textfont'>Name</td>
				<td width='5' align='center' valign='top'>:</td>
				<td width='418' valign='top'>".$name."</td>
			</tr>
			<tr>
				<td align='left' height='30' valign='top'class='textfont'>Email</td>
				<td width='5' align='center' valign='top'>:</td>
				<td valign='top'>".$email."</td>
			</tr>
			<tr>
				<td align='left' height='30' valign='top'class='textfont' colspan='3'>Please reset your password using the following link:</td>
			</tr>
			<tr>
				<td align='left' height='30' valign='top'class='textfont' colspan='3'>
				<a href='".$site_url."customer-reset-password.php?rid=".$random_text."'>".$site_url."customer-reset-password.php?rid=".$random_text."</a></td>
			</tr>
		</table>";
		
		$data['subject'] = 'Forgot Password Response - SVR Travels India';
		$data['content'] = $content;
		$data['to_email'] = $email;
		send_email($data);
	}
}
$designFILE = "design/customer-forgot-password.php";
include_once("includes/svrtravels-template.php");
?>