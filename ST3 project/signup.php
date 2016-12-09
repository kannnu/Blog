<?php 
require 'connect.php';
require 'session.php';
if(login()){
	if($_SESSION['username']=="admin")
		header('location:admin.php');
	else
		header('location:home.php');
}

function checkforimage(){
	$allowed = array('gif','png' ,'jpg');
	$filename = $_FILES['file']['name'];
	$ext = pathinfo($filename, PATHINFO_EXTENSION);
	if(!in_array($ext,$allowed)) 
		echo "<script>alert('".$ext." file format is not allowed. Upload jpg, png or gif format only.')</script>";
	else{
		$file=addslashes(file_get_contents($_FILES["file"]["tmp_name"]));
		return $file;
	}

}

function checkduplicate($u,$e){
		$db=mysqli_connect("localhost","root","","datablog") or die("Can not connect right now!");

		$sql1="SELECT `userName` FROM `userdetails` WHERE `username` = '$u'";
		$sql2 = "SELECT `email` FROM `userdetails` WHERE `email` = '$e'";

		$result1 = mysqli_query($db,$sql2);
		$num1=mysqli_num_rows($result1);
		$result = mysqli_query($db,$sql1);
		$num = mysqli_num_rows($result);
		if($num>0){
			echo "<script>alert('Username already taken please select other username');</script>";
			return "FALSE";
		}

		elseif($num1>0){
			echo "<script>alert('Email is already in use');</script>";
			return "FALSE";
		}

		else{
			return "TRUE";
		}
	}

?>


<html>
<head>
	<!--Import Google Icon Font-->
	<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<!--Import materialize.css-->
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>

	<!--Let browser know website is optimized for mobile-->
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<nav>
		<div class="nav-wrapper" style = "background-color: gray;">
			<a href="index.php" class="brand-logo" style="padding-left: 30px;">BlogViewer</a>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><a href="index.php">Home</a></li>
				<li><a href="message.php">Contact Us</a></li>

			</ul>
		</div>
	</nav>
	<title>Sign Up User</title>
</head>

<body class ="indigo darken-4">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<center>
		<div class="row" style= 'width:50%;margin:30px auto;'>
			<form class=" card-panel" style ="padding: 40px;background-color: #fdf8e4;" action = "signup.php" method = "POST" enctype = "multipart/form-data"> 
				<div class="row">
					<div class="input-field col s12">
						<input  type = "text" name = "fname" placeholder="First Name" maxlength = 30 required>
						<label for="First">First name</label>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<label for="Last-Name">Last name</label>

						<input  type = "text" name = "lname" placeholder="Last Name" maxlength = 30 required>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<label for="signup-username">Email Address </label>

						<input  type = "email" name = "emailaddr" placeholder="Email Address" required> 
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">

						<label for="signup-username">Username</label>

						<input  type = "text" name = "username" placeholder="User Name" maxlength = 30 required>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<label for="signup-username">Password</label>

						<input type = "password" name = "password" placeholder="Password" required> 
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">

						<label for="signup-username">About Me</label>

						<input  type = "text" name = "abtme" placeholder="About Me" maxlength = 30 required>
					</div>
				</div>

				<div class="row">
					<div class="input-field col s12">
						<label for="signup-username">Contact</label>

						<input type = "number" name = "contact" placeholder="Contact Number"> 
					</div>
				</div>
				<div class="row">
				
						<label for="signup-username">Upload a Profile Picture</label>
						<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
						<input name="file" type="file" id="file"> 
				
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input class="btn waves-effect waves-light" Value = "submit" type="submit" name="cre">
					</div>
				</div>
			</form>
			
		</div>
		</center>
	</body>

	</html>	

	<?php

	if(isset($_POST["cre"]) &&  $_FILES['file']['size']>0){
		if(empty($_POST["username"]))
			echo "<script>alert('Please enter username');</script>";
		else if(empty($_POST["fname"]))
			echo "<script>alert('Please enter firstname');</script>";
		else if(empty($_POST["lname"]))
			echo "<script>alert('Please enter lastname');</script>";
		else if(empty($_POST["emailaddr"]))
			echo "<script>alert('Please enter E-mail ID');</script>";
		else if(empty($_POST["password"]) || strlen($_POST["password"]) < 8)
			echo "<script>alert('Please enter Password atleast 8 character long');</script>";
		elseif(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) 
		{
			echo "<script>alert('Please upload image.')</script>";}

			else{
				$u = $_POST['username'];
				$f = $_POST["fname"];
				$l = $_POST["lname"];
				$e = $_POST["emailaddr"];
				$p = $_POST["password"];
				$abtme = $_POST["abtme"];

				$file = checkforimage();

				if(empty($_POST["contact"]))
					$c=NULL;
				else
					$c = $_POST["contact"];

				if(checkduplicate($u,$e)=="TRUE"){

					$sql = "INSERT INTO `userdetails`(`userName`,`fname`,`lname`,`password`,`email`,`aboutme`,`contact`,`profile_pic`) VALUES ('$u','$f','$l','$p','$e','$abtme','$c','$file')";
					$db = $GLOBALS['db'];
					if(mysqli_query($db,$sql)){
						echo "<script>alert('Account created Successfully');</script>";

						header('Refresh: 2;URL= signin.php');
					}
					else
					{
						echo "<script>alert('Something went wrong.Please try again');</script>";

					}

				}

			}
		}

		?>