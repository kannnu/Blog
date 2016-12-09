<?php 
require 'connect.php';
require 'session.php';
if(login()){
	if($_SESSION['username']=="admin")
		header('location:admin.php');
	else
		header('location:home.php');
}

function checkuser($u,$e,$c){
	$db = $GLOBALS['db'];
	$sql = "SELECT * FROM `userdetails` WHERE `userName` = '$u' AND `email`= '$e' AND `contact` = '$c'";
	$result = mysqli_query($db, $sql);
	$num_query = mysqli_num_rows($result);
	if($num_query == 1){
		$row = mysqli_fetch_row($result);
		return $row[2];
	}
	else 
		return 0;
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
	<title>Forgot Passeord</title>
</head>

<body class ="indigo darken-4">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<center>
	<h1>Give your Details</h1>
	<div class="row" style= 'width:50%;margin:30px auto;'>
		<form class=" card-panel" style ="padding: 40px;background-color: #fdf8e4;" action = "forgot.php" method = "POST" enctype = "multipart/form-data"> 
				<div class="row">
					<div class="input-field col s12">

						<label for="signup-username">Username</label>

						<input  type = "text" name = "username" placeholder="User Name" maxlength = 30 required>
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
						<label for="signup-username">Contact</label>

						<input type = "number" name = "contact" placeholder="Contact Number"> 
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<input class="btn waves-effect waves-light" Value = "submit" type="submit" name="forgot">
					</div>
				</div>
			</form>
			
		</div>
		</center>
	</body>

	</html>	

	<?php

	if(isset($_POST["forgot"])){
		if(empty($_POST["username"]))
			echo "<script>alert('Please enter username');</script>";
		else if(empty($_POST["emailaddr"]))
			echo "<script>alert('Please enter E-mail ID');</script>";
		else{
			$u = $_POST['username'];
			$e = $_POST["emailaddr"];
			$c = $_POST['contact'];

			$checkuser = checkuser($u,$e,$c);
			if ($checkuser == 0){
				echo "<script>alert('Details incorrect please enter correct information');</script>";

			}
			else {
				echo "<script>alert('The Password for entered user is ".$checkuser."');</script>";

			}

				}

			}
		?>