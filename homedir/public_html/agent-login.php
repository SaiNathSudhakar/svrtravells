<? 
ob_start();
//session_start();
include_once("includes/functions.php");
if(isset($_SESSION[$svra.'ag_id'])) header('location:agent-account.php');
$tablename = "svr_agents";

if($_SERVER['REQUEST_METHOD']=="POST")
{
	if(!empty($_POST['ag_login']) == "agent_login")
	{
		$query = query("select ag_id, ag_uname, ag_unique_id, ag_logo, ag_fname, ag_lname, ag_pancard, ag_email, ag_password, ag_address, ag_mobile, ag_deposit, ag_landline, ag_state, ag_country from ".$tablename." where ag_email = '".$_POST['email']."' and ag_password = '".md5($_POST['password'])."' and ag_status = 1");
		$row_login = fetch_array($query);
		$numrow_login = num_rows($query);
		
		if($numrow_login > 0)	
		{	
			$path = "uploads/agents/".$row_login['ag_unique_id']."/";
			
			$_SESSION[$svra.'ag_id'] = $row_login['ag_id'];
			$_SESSION[$svra.'ag_uname'] = $row_login['ag_uname'];
			$_SESSION[$svra.'ag_title'] = $row_login['ag_title'];
			$_SESSION[$svra.'ag_fname'] = $row_login['ag_fname'];
			$_SESSION[$svra.'ag_lname'] = $row_login['ag_lname'];
			$_SESSION[$svra.'ag_email'] = $row_login['ag_email'];
			$_SESSION[$svra.'ag_pan'] = $row_login['ag_pancard'];
			$_SESSION[$svra.'ag_addr'] = $row_login['ag_address'];
			$_SESSION[$svra.'ag_mobile'] = $row_login['ag_mobile'];
			$_SESSION[$svra.'ag_deposit'] = $row_login['ag_deposit'];
			$_SESSION[$svra.'ag_landline'] = $row_login['ag_landline'];
			$_SESSION[$svra.'ag_state'] = $row_login['ag_state'];
			$_SESSION[$svra.'ag_country'] = $row_login['ag_country'];
			$_SESSION[$svra.'ag_unique_id'] = $row_login['ag_unique_id'];
			$_SESSION[$svra.'ag_image'] = $path.$row_login['ag_logo'];
			
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
		} else{ 
			$msg = "Invalid User ID/Password";
		}
	}
}

$meta_title ="Agent Login | Bus Booking Online From Hyderabad";
$meta_keywords ="Tour and travel agency in Hyderabad, international tour operators, india tour packages with prices, online tour packages";
$meta_description ="Kerala Holiday Packages, holiday trips, chennai tour and travels, South india Tours, western india Holiday packages, Rajasthan holiday packages";

$designFILE = "design/agent-login.php";
include_once("includes/svrtravels-template.php");
?> 