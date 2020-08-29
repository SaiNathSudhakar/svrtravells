<? 
include("includes/functions.php");
cust_login_check();
$pageName="My Account";
$pageTitle="My Account";
$tablename="svr_customers";

if($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST['email']))
{	
	$msg = "";
	mysql_query("update ".$tablename." set cust_title='".$_POST['title']."', cust_fname='".$_POST['fname']."', cust_lname='".$_POST['lname']."', cust_mobile='".$_POST['mobile']."', cust_landline='".$_POST['landline']."', cust_email='".$_POST['email']."', cust_address_1='".$_POST['address1']."', cust_address_2='".$_POST['address2']."', cust_city='".$_POST['city']."', cust_country='".$_POST['country']."', cust_state='".$_POST['state']."', cust_pincode='".$_POST['pincode']."', cust_promotion = '".$_POST['promotion']."' where cust_id=".$_SESSION[$svr.'cust_id']);
	
	$count = getdata('svr_nl', 'count(nl_id)', "nl_email='".$_POST['email']."'");
	if(!empty($_POST['promotion'])){
		if($count == 0)
			mysql_query("insert into svr_nl (nl_id, nl_email, nl_status, nl_dateadded) values ('', '".$_POST['email']."', 1, '".$now_time."')");
	} else {
		if($count > 0)
			mysql_query("delete from svr_nl where nl_email = '".$_POST['email']."'");
	}
	
	$_SESSION[$svr.'cust_title'] = $_POST['title'];
	$_SESSION[$svr.'cust_fname'] = $_POST['fname'];
	$_SESSION[$svr.'cust_lname'] = $_POST['lname'];
	$_SESSION[$svr.'cust_email'] = $_POST['email'];
	$_SESSION[$svr.'cust_addr'] = $_POST['address1'];
	$_SESSION[$svr.'cust_mobile'] = $_POST['mobile'];
	$_SESSION[$svr.'cust_landline'] = $_POST['landline'];
	$_SESSION[$svr.'cust_city'] = $_POST['city'];
	$_SESSION[$svr.'cust_state'] = $_POST['state'];
	$_SESSION[$svr.'cust_country'] = $_POST['country'];
	
	$_SESSION["ATime"] = time();
	$_SESSION["CustomerAccount"] = "Your Profile Updated Successfully";
	header("location:customer-account.php");
	//$msg = "Your Profile Updated Successfully";
}	
	
	$sam = mysql_query("select cust_id, cust_title, cust_fname, cust_lname, cust_mobile, cust_landline, cust_email, cust_address_1, cust_address_2, cust_city, cust_country, cust_state, cust_pincode, cust_promotion, cnt_content from ".$tablename." 
		left join svr_content_pages on cnt_id = 2
			where cust_status=1 and cust_id='".$_SESSION[$svr.'cust_id']."'");
	$fetch_sam=mysql_fetch_array($sam);


$designFILE="design/customer-account.php";
include_once("includes/svrtravels-template.php");
?>