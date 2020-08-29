<? 
ob_start();
//session_start();
include_once("includes/functions.php");
if(isset($_SESSION[$svr.'cust_id'])) header('location:customer-account.php');
$tablename = "svr_customers";

if($_SERVER['REQUEST_METHOD']=="POST")
{
	if(!empty($_POST['login']) == "cust_login")
	{
		$query = mysql_query("select cust_id, cust_title, cust_fname, cust_lname, cust_email, cust_address_1, cust_mobile, cust_landline, cust_state, cust_country from ".$tablename." where cust_email = '".$_POST['email']."' and cust_password = '".md5($_POST['password'])."'");
		$row_login = mysql_fetch_array($query);
		$numrow_login = mysql_num_rows($query);
		
		if($numrow_login > 0)	
		{	
			$_SESSION[$svr.'cust_id'] = $row_login['cust_id'];
			$_SESSION[$svr.'cust_title'] = $row_login['cust_title'];
			$_SESSION[$svr.'cust_fname'] = $row_login['cust_fname'];
			$_SESSION[$svr.'cust_lname'] = $row_login['cust_lname'];
			$_SESSION[$svr.'cust_email'] = $row_login['cust_email'];
			$_SESSION[$svr.'cust_addr'] = $row_login['cust_address_1'];
			$_SESSION[$svr.'cust_mobile'] = $row_login['cust_mobile'];
			$_SESSION[$svr.'cust_landline'] = $row_login['cust_landline'];
			$_SESSION[$svr.'cust_state'] = $row_login['cust_state'];
			$_SESSION[$svr.'cust_country'] = $row_login['cust_country'];
			
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
				header("location:customer-account.php");
			} 
		} else{ 
			$msg = "Invalid User ID/Password";
		}
	}
}
$designFILE = "design/customer-login.php";
include_once("includes/svrtravels-template.php");
?> 