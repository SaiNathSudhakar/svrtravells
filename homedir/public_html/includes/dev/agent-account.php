<? 
include("includes/functions.php");
agent_login_check();

$pageName="My Account";
$pageTitle="My Account";
$tablename="svr_agents";

if($_SERVER['REQUEST_METHOD']=="POST" && !empty($_POST['email']))
{	
	$msg = "";
	
	//$unique = 'SAG'.rand(10000,99999);
	$path = "uploads/agents/".$_POST['unique']."/";
	//var_dump($_FILES);exit;
	if($_FILES['image']["size"] > 0)
	{
		  $imgExtension = array('jpg','jpe','jpeg','gif');
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
		  		  if(!file_exists($path.$b_image)) @mkdir($path, 0777, true);
				  
				  if(!move_uploaded_file($_FILES['image']['tmp_name'],$path.$b_image)) { $b_image=""; } else { 
				  	  resize_image($path.$b_image, 75); //width: 148; height: 159
					  if(!empty($_POST['old_img'])) @unlink($path.$_POST['old_img']);
				  }
				  $imagepath=$b_image;
			  }
		  }else{		
			  $img_err_msg = "You have to upload 'jpg , jpe , jpeg , gif' images only";
		  }
	}elseif(!empty($_POST['old_img']))
	{
	  $b_image=$_POST['old_img'];
	}
	//if(!empty($_GET['id'])){
	
	mysql_query("update ".$tablename." set ag_title='".$_POST['title']."', ag_fname='".$_POST['fname']."', ag_lname='".$_POST['lname']."', ag_gender='".$_POST['gender']."', ag_mobile='".$_POST['mobile']."', ag_landline='".$_POST['landline']."', ag_email='".$_POST['email']."', ag_pancard='".$_POST['pancard']."', ag_address='".$_POST['address']."', ag_authority='".$_POST['authority']."', ag_city='".$_POST['city']."', ag_country='".$_POST['country']."', ag_state='".$_POST['state']."', ag_pincode='".$_POST['pincode']."', ag_logo='".$b_image."', ag_promotion = '".$_POST['promotion']."' where ag_id=".$_SESSION[$svra.'ag_id']);
	
	$_SESSION[$svra.'ag_image'] = $path.$b_image;
	$_SESSION[$svra.'ag_fname'] = $_POST['fname'];
	$_SESSION[$svra.'ag_lname'] = $_POST['lname'];
	$_SESSION[$svra.'ag_email'] = $_POST['email'];
	$_SESSION[$svra.'ag_pan'] = $_POST['pancard'];
	$_SESSION[$svra.'ag_addr'] = $_POST['address'];
	$_SESSION[$svra.'ag_mobile'] = $_POST['mobile'];
	$_SESSION[$svra.'ag_landline'] = $_POST['landline'];
	$_SESSION[$svra.'ag_state'] = $_POST['state'];
	$_SESSION[$svra.'ag_country'] = $_POST['country'];
	$_SESSION[$svra.'ag_image'] = $path.$b_image;
	//}
	$count = getdata('svr_nl', 'count(nl_id)', "nl_email='".$_POST['email']."'");
	if(!empty($_POST['promotion'])){
		if($count == 0)
			mysql_query("insert into svr_nl (nl_id, nl_email, nl_status, nl_dateadded) values ('', '".$_POST['email']."', 1, '".$now_time."')");
	} else {
		if($count > 0)
			mysql_query("delete from svr_nl where nl_email = '".$_POST['email']."'");
	}
	$_SESSION["ATime"] = time();
	$_SESSION["AgentAccount"] = "Your Profile Updated Successfully";
	header("location:agent-account.php");
	//$msg = "Your Profile Updated Successfully";
}	
	
	$sam = mysql_query("select ag_id, ag_unique_id, ag_gender, ag_uname, ag_title, ag_fname, ag_lname, ag_mobile, ag_landline, ag_email, ag_logo, ag_pancard, ag_address, ag_authority, ag_city, ag_country, ag_state, ag_pincode, ag_promotion, cnt_content from ".$tablename." 
	left join svr_content_pages on cnt_id = 2
		where ag_status=1 and ag_id='".$_SESSION[$svra.'ag_id']."'");
	$fetch_sam=mysql_fetch_array($sam);

$designFILE="design/agent-account.php";
include_once("includes/svrtravels-template.php");
?>