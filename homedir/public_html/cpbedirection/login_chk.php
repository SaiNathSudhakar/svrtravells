<?
//@session_start();
if(!isset($_SESSION['tm_id']) || !isset($_SESSION['tm_dispname']) || !isset($_SESSION['tm_type']))
{
	header('location:index.php'); 
}
?>