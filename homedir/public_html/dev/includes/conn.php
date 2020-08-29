<?php

session_start();

global $link_conn, $site_url, $admin_url, $svr, $frommail, $mastermail, $logalert_mail, $now, $now_time, $now_onlytime, $dmy, $ymd;

$timezone = "Asia/Kolkata";

if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

error_reporting(1);



global $conn;



//Live

$servername = "localhost";

$username = "svrtrave_user";

$password = "r]To,JD4_Q1I";

$dbname = "svrtrave_maindb";



$svr = 'svr';

$frommail = "info@svrtravelsindia.com";

$mastermail = "info@svrtravelsindia.com";

$logalert_mail = "info@svrtravelsindia.com";



$now = date("Y-m-d");

$now_time = date("Y-m-d H:i:s");

$now_onlytime = date("H:i");

$ymd = date("Ymd"); 

$dmy = date("d-m-Y");





$site_url="http://www.svrtravelsindia.com/";



// Create connection

$conn = new mysqli($servername, $username, $password, $dbname);



// Check connection

if($conn->connect_error){

	die("Connection failed: " . $conn->connect_error);

}



function query($str){

global $conn;

	return $conn->query($str);

}



function num_rows($str){

global $conn;

	return $str->num_rows;

}



function fetch_assoc($str){

global $conn;

	$data = $str->fetch_assoc();

	return $data;

}



function fetch_array($str){

global $conn;

	$data = $str->fetch_array();

	return $data;

}

function insert_id(){

	global $conn;

	$data = $conn->insert_id;

	return $data;

	}

?>