<?
ob_start();
include_once("includes/functions.php");
$error = '';
$cond = (!empty($_GET['ssid'])) ? ' and subsubcat_id='.$_GET['ssid'] : '';

if(!empty($_GET['sid']))
{	
 	$nqur = mysql_query("select cat_name, subcat_name, subsubcat_name, subcat_ref_no, subcat_banner_image from svr_categories as cat
		left join svr_subcategories as subcat on subcat.cat_id_fk = cat.cat_id
			left join svr_subsubcategories as subsubcat on subsubcat.subcat_id_fk = subcat.subcat_id
				where subcat_id = ".$_GET['sid']." $cond ");
	$nav_count = mysql_num_rows($nqur);
	$nav = mysql_fetch_array($nqur);
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
  if(!empty($_POST['email']))
  {
	$arrival_date = date('Y-m-d H:i:s', strtotime($_POST['arrival_date']));
	$departure_date = date('Y-m-d H:i:s', strtotime($_POST['departure_date']));
	
	mysql_query("insert into svr_enquiries(enq_id, enq_type, enq_arrival_date, enq_departure_date, enq_interests, enq_description, enq_name, enq_adults, enq_children, enq_email, enq_mobile, enq_fax, enq_address, enq_city, enq_state, enq_country, enq_status, enq_added_date) values ('', '".$_POST['form_type']."', '".$arrival_date."', '".$departure_date."', '".implode(',', $_POST['interests'])."', '".$_POST['enquiry']."', '".$_POST['name']."', '".$_POST['adults']."', '".$_POST['children']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['fax']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['country']."', 1, '".$now_time."')");
	
	$arrival_date = date('d-m-Y', strtotime($_POST['arrival_date']));
	$departure_date = date('d-m-Y', strtotime($_POST['departure_date']));
	
	$content = "<table width='100%'  border='0' align='center' cellpadding='6' cellspacing='2' style='margin:10px;'>
	  <tr>
		<td width='120'><strong>Type</strong></td>
		<td width='5' align='center'><strong>:</strong></td>
		<td align='left'>".$enquiry_forms[$_POST['form_type']]."</td>
	  </tr>
	  <tr>
		<td><strong>Arrival Date</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".$arrival_date."</td>
	  </tr>
	  <tr>
		<td><strong>Departure Date</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".$departure_date."</td>
	  </tr>
	  <tr>
		<td><strong>Name</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".$_POST['name']."</td>
	  </tr>
	  <tr>
		<td ><strong>Phone</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left' >".$_POST['phone']."</td>
	  </tr>
	  <tr>
		<td><strong>E-Mail</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".$_POST['email']."</td>
	  </tr>
	  <tr>
		<td><strong>Enquiry</strong></td>
		<td align='center'><strong>:</strong></td>
		<td align='left'>".$_POST['enquiry']."</td>
	  </tr>
	</table>";
	
	$data['subject'] = 'Enquiry Details From SVR Travels India';
	$data['content'] = $content;
	$data['to_email'] = 'janardhan@svrtravelsindia.com';
	send_email($data);
	
  } else {
  	$error = "Please Fill the Form Completely";
  }
}

$designFILE = "design/destination.php";
include_once("includes/svrtravels-template.php");
?>                  