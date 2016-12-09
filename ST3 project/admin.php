<?php 
require 'session.php';
if(!isset($_SESSION['username'])){
	header('location:index.php');
}

if(login()){
	if($_SESSION['username']!="admin")
		header('location:home.php');
}

$priviledge = "admin";

require 'display.php';

display_blogs($priviledge);

?>