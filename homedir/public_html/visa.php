<?
ob_start();
include_once("includes/functions.php");

$name="";
$phone="";
$email="";
$date1="";
$address="";
$city="";
$state="";
$country="";
$people="";

if($_SERVER['REQUEST_METHOD']=='POST')
{
	if(!empty($_POST['email']))
	{ 
	//var_dump($_POST);exit;
	
		$name = $_POST['name'];
		$phone = $_POST['phone'];
		$email  = $_POST['email'];
		$date1 = date('Y-m-d',strtotime($_POST['travel_date']));
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		$country = $_POST['country'];
		$people = $_POST['people'];
			
		$content = "<table width='100%' border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
		 <tr>
			<td width='25%'><strong>Travel Date</strong></td>
			<td width='3%' align='center'><strong>:</strong></td>
			<td align='left'>".$date1."</td>
		  </tr>
		  <tr>
			<td width='25%'><strong>Name</strong></td>
			<td width='3%' align='center'><strong>:</strong></td>
			<td align='left'>".$name."</td>
		  </tr>
		  <tr>
			<td width='25%'><strong>No. of People</strong></td>
			<td width='3%' align='center'><strong>:</strong></td>
			<td align='left'>".$people."</td>
		  </tr>
		  <tr>
			<td ><strong>Phone</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$phone."</td>
		  </tr>
		  <tr>
			<td><strong>E-Mail</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$email."</td>
		  </tr>
		  <tr>
			<td nowrap='nowrap'><strong>Address</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$address."</td>
		  </tr>
		  <tr>
			<td><strong>City</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$city."</td>
		  </tr>
		  <tr >
			<td nowrap='nowrap'><strong>State</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$states[$state]."</td>
		  </tr>
		  <tr>
			<td nowrap='nowrap'><strong>Country</strong></td>
			<td align='center'><strong>:</strong></td>
			<td align='left'>".$country."</td>
		  </tr>
		  </table>";
		//echo $content; exit;
		
		$data['subject'] = 'Visa Enquiry Details From SVR Travels India';
		$data['content'] = $content;
		$data['to_email'] = $email;
		send_email($data);
		$error = "Visa Enquiry Form Sent Successfully";
		
	} else {
		$error = "Please Fill the Form Completely";
	}
}
$designFILE = "design/visa.php";
include_once("includes/svrtravels-template.php");
?>