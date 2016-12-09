<?php 
require 'connect.php';
require 'session.php';

function getemail($id){
	$db = $GLOBALS['db'];
	$sql1 = "SELECT `email` FROM `userdetails` WHERE `Id` = '$id'";
	$result = mysqli_query($db,$sql1);
	$row = mysqli_fetch_row($result);
	return $row[0];
}

function insertdetails($email, $title, $detail){
	$db = $GLOBALS['db'];
	$sql = "INSERT INTO `contact`(`email`,`subject`,`message`) VALUES ('$email', '$title','$detail')";
	if(mysqli_query($db,$sql)){
		echo "<script>alert('Message sent to admin');</script>";
	}
	else {
		echo "<script>alert('There was a problem contacting admin');</script>";
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
				<li><a href="signout.php">Sign Out</a></li>
			</ul>
		</div>
	</nav>
	<title>Message</title>
</head>

<body class ="indigo darken-4">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<center>
		<div class="row" style= 'width:50%;margin:30px auto;'>
			<form class=" card-panel " style ="padding: 40px;background-color: #fdf8e4;" action = "message.php" method = "POST" enctype = "multipart/form-data"> 
				<div class="row">
					<div class="input-field col s12">
						<label for="Title">Title</label>
						<input  type = "text" name = "title" placeholder="Message Title" maxlength = 30 required>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<label for="Details">Message Details</label>

						<textarea style = "height:20%;width:100%" id="message-detail" name = "msgdetail" placeholder="Your Message Here" name="detail" maxlength="5000"> 
						</textarea>
					</div>
				</div>
				<div class="row">
					<div class="input-field col s12">
						<label for="signup-username"></label>

						<input type = <?php if (login()){echo "hidden";} else {echo "email";}?>
						name = "emailaddr" placeholder="Email Address" required> 
					</div>
				</div>
				<input class="btn waves-effect waves-light" Value = "submit" type="submit" name="submit">
			</form>
			
		</div>
	</center>
</body>
</html>

<?php
if (isset($_POST['submit'])){
		if(empty($_POST["title"]))
			echo "<script>alert('Please enter title');</script>";
		else if(empty($_POST["msgdetail"]))
			echo "<script>alert('Please enter details');</script>";
		else if(!login() && empty($_POST["emailaddr"])){
			echo "<script>alert('Please enter Email Address');</script>";

		}
		else{
			$title = $_POST['title'];
			$detail = $_POST['msgdetail'];

			if(login()){
				$email = getemail($_SESSION['id']);
			}
			else{
				$email = $_POST['emailaddr'];
			}
			insertdetails($email, $title, $detail);
		}
}
?>