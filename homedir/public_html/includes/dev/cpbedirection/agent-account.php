<? 
include("includes/functions.php");
//agent_login_check();
$pageName="My Account";
$pageTitle="My Account";
$tablename="svr_agents";
//, ag_pancard = '".$_POST['pancard']."'
if($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST['email']))
{	
	$msg = "";
	mysql_query("update ".$tablename." set ag_gender='".$_POST['gender']."', ag_fname='".$_POST['fname']."', ag_lname='".$_POST['lname']."', ag_mobile='".$_POST['mobile']."', ag_landline='".$_POST['landline']."', ag_email='".$_POST['email']."', ag_address='".$_POST['address']."', ag_authority='".$_POST['authority']."', ag_city='".$_POST['city']."', ag_country='".$_POST['country']."', ag_state='".$_POST['state']."', ag_pincode='".$_POST['pincode']."', ag_promotion = '".$_POST['promotion']."' where ag_id=".$_SESSION[$svra.'ag_id']);
	
	$count = getdata('svr_nl', 'count(nl_id)', "nl_email='".$_POST['email']."'");
	if(!empty($_POST['promotion'])){
		if($count == 0)
			mysql_query("insert into svr_nl (nl_id, nl_email, nl_status, nl_dateadded) values ('', '".$_POST['email']."', 1, '".$now_time."')");
	} else {
		if($count > 0)
			mysql_query("delete from svr_nl where nl_email = '".$_POST['email']."'");
	}
	
	$msg = "Your Profile Updated Successfully";
}	
	
	$sam = mysql_query("select ag_id, ag_gender, ag_uname, ag_fname, ag_lname, ag_mobile, ag_landline, ag_email, ag_address, ag_authority, ag_city, ag_country, ag_state, ag_pincode, ag_promotion, cnt_content from ".$tablename." 
		left join svr_content_pages on cnt_id = 2
			where ag_status=1 and ag_id='".$_SESSION[$svra.'ag_id']."'");
	$fetch_sam=mysql_fetch_array($sam);


$designFILE="design/agent-account.php";
include_once("includes/svrtravels-template.php");
?>