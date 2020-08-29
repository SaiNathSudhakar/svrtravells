<?
ob_start();
include_once("includes/functions.php");

if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(!empty($_POST['txt_email']))
	{
		$name = $_POST['txt_name'];
		$phone = $_POST['txt_phone'];
		$email  = $_POST['txt_email'];
		$areaint = $_POST['txt_areaint'];
		$enquiry = (!empty($_POST['text_enquiry'])) ? $_POST['text_enquiry'] : '--';
		
		query("insert into svr_gen_enquiries(genq_name, genq_phone, genq_email, genq_area_interest, genq_enquiry, genq_added_date) values('".$name."', '".$phone."', '".$email."', '".$areaint."', '".$enquiry."', '".$now_time."')");
		
		$content = "<table width='100%'  border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
		  <tr>
			<td width='25%'><strong>Name</strong></td>
			<td width='3%' align='center'><strong>:</strong></td>
			<td align='left'>".$name."</td>
		  </tr>
		  <tr>
			<td ><strong>Phone</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left' >".$phone."</td>
		  </tr>
		  <tr >
			<td><strong> E-Mail</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$email."</td>
		  </tr>
		  <tr >
			<td nowrap='nowrap'><strong>Area of Interest</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$areaint."</td>
		  </tr>
		  <tr >
			<td><strong>Enquiry</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$enquiry."</td>
		  </tr>
		  </table>";
		//echo $mail_body; exit;
		
		$data['subject'] = 'Enquiry Details From SVR Travels India';
		$data['content'] = $content;
		$data['to_email'] = $email;
		send_email($data);
		$error = "Enquiry Mail Send Succesfully";
		
	} else {
		$error = "Please Fill the Form Completely";
	}
}
$designFILE = "design/enquiry.php";
include_once("includes/svrtravels-template.php");
?>