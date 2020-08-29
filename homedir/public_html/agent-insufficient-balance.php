<?
ob_start();
include_once("includes/functions.php");
agent_login_check();

$designFILE = "design/agent-insufficient-balance.php";
include_once("includes/svrtravels-template.php");
?> 
