<?php
require 'connect.php';
if (isset($_GET['id']) && isset(($_GET['pic_source']))) {
		$id=$_GET['id'];
		$pic_source = $_GET['pic_source'];
		if($pic_source=="blog"){
		$sql="SELECT `image` FROM `blog_detail` WHERE `blog_id`='$id'";
		$res=mysqli_query($db,$sql);
		$row=mysqli_fetch_assoc($res);
		
		$image=$row['image'];
		echo "$image";
		}
		elseif($pic_source=="profile"){
			$sql="SELECT `profile_pic` FROM `userdetails` WHERE `Id`='$id'";
			$res=mysqli_query($db,$sql);
		$row=mysqli_fetch_assoc($res);
		
		$image=$row['profile_pic'];
		echo "$image";

		}	
	}
?>