<? ob_start();
//include_once("includes/conn.php");
include_once("includes/functions.php");
$tablename="svr_customers";
$pageTitle="Forgot Password";
$pageName="Forgot Password";

if($_SERVER['REQUEST_METHOD']=="POST"){
	//if(!empty($_POST['forgot_password'])){
		//echo "asdasd";
		$yp=mysql_query("select * from ".$tablename." where cust_email='".$_POST['email']."' ");
		$yp_cnt=mysql_num_rows($yp);
		
		if($yp_cnt==0) {$invmsg="Invalid E-Mail ID"; }
		if($yp_cnt!=0) { 
			$yp_fetch=mysql_fetch_array($yp);
			$name=$yp_fetch['cust_fname'];
			$email=$yp_fetch['cust_email']; //print_r($_POST);
			$password=$yp_fetch['cust_password'];
			$random_text=genRandomString();
			
			$yp_fg_ins_rand_txt=mysql_query("update ".$tablename." set cust_fg_password='".$random_text."',cust_fg_date='".$now_time."' where cust_email='".$_POST['email']."' ");
			$mail_body="<style type='text/css'>
			body,td,th { font-family: Verdana; font-size:12px;}
			.borblue{ border: 2px solid #ff3300; }	
			.textfont{ font-family:Arial; font-size:13px; color:#000000}
			.givendata{ font-family:Verdana; font-size:13px; color:#ffffff; }
			.tdbg{background-color:#ff3300; color:#ffffff;}
			.td_color{background-color:#ff3300; color:#ffffff;}
			.td_reverse{background-color:#ffffff; color:#ff3300; font-weight:bold;}</style>
			<br/>
			<table width='55%' border='0' align='center' cellspacing='0' cellpadding='0' class='borblue'>
				 <tr>
					<td width='287' align='left' valign='top' style='border-bottom:2px solid #ff3300;'>
					<a href='".$site_url."' target='_blank'><img src='".$site_url."images/svr-travels.jpg' border='0'/></a></td>
				  </tr>
				<tr>
					<td>Customer Login Details are as follows. </td>
				</tr>
				  <tr>
				  	<td>&nbsp;</td>
				</tr>
				<tr>
					<td>
						<table width='100%' border='0' align='center' cellpadding='0' cellspacing='1' bgcolor='#ff3300'>
							<tr><td bgcolor='#FFFFFF'>
								<table width='100%' border='0' align='center' cellpadding='4' cellspacing='0'>
								
									<tr>
										<td colspan='6' align='left' valign='top' class='tdbg' style='border-bottom:1px solid #ff3300;'><span id='result_box'><strong>SVR Travels Forgot Password </strong></span></td>
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
						<td align='left' height='30' valign='top'class='textfont' colspan='3'>Please reset your password using this below link.</td>
					  </tr>
					  <tr>
						<td width='5' align='center' valign='top' colspan='3'>&nbsp;</td>
					  </tr>
					  <tr>
						<td align='left' height='30' valign='top'class='textfont' colspan='3'>
						<a href='".$site_url."reset-password.php?rid=".$random_text."'>".$site_url."reset-password.php?rid=".$random_text."</a></td>
					  </tr>
								</table>
							</td>
						</tr>
					</table>
					</td>
				</tr>
			</table>";
			
			echo $mail_body; exit;
			
			$from_email='info@svrtravels.com';
			
			$mailto =$email;
			$mailheader = 'MIME-Version: 1.0' . "\r\n";
			$mailheader.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$mailheader.="From: <".$from_email.">\r\n";
			$mailheader.="BCc: <sameera@bitragroup.com>\r\n";

			$mess='Forgot Password request from SVR Travels';
			@mail($mailto,$mess,$mail_body,$mailheader);
			header("location:forgot-password.php?fgmsg=sent");
		}
	//}
}
$designFILE = "design/forgot-password.php";
include_once("includes/svrtravels-template.php");
?>