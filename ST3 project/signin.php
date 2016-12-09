<?php 
require 'connect.php';
require 'session.php';
if(login()){
	if($_SESSION['username']=="admin")
		header('location:admin.php');
	else
		header('location:home.php');
}
$id = 0;

function checkuser ($username,$password,$caller){
			$db = $GLOBALS['db'];
			if($caller == "login"){
			$sql = "SELECT `Id`,`userName`,`password` FROM `userdetails` WHERE `username`= '$username' and `password`= '$password'";}
			else
			{
				$sql = "SELECT `Id`,`userName`,`password` FROM `userdetails` WHERE `username`= '$username'";}
			$result = mysqli_query($db,$sql);
			$num=mysqli_num_rows($result);
			$row = mysqli_fetch_assoc($result);
			$GLOBALS['id']= $row['Id'];
			return $num;
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
				<li><a href="Signup.php">Signup</a></li>

				<li><a href="message.php">Contact Us</a></li>


			</ul>
		</div>
	</nav>

</head>


<body class =" card-panel indigo darken-4">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<div class="row" style= 'width:50%;margin:30px auto;'>
		<form class=" card-panel " style ="padding: 40px;background-color: #fdf8e4;" action = "signin.php" method = "POST" enctype = "utf-8"> 
			<div class="row">
				<div class="input-field col s12">

					<label for="signup-username">Username</label>

					<input class="validate" type = "text" name = "username" placeholder="User Name" maxlength = 30 required>
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<label for="signup-username">Password</label>

					<input class="validate" type = "password" name = "password" placeholder="Password" required> 
				</div>
			</div>
			<div class="row">

				<a href="forgot.php">Forgot your password?</a>
			</div>

			<input  type="submit" name="login" value="Login">
		</form>
	</div>

</body>

</html>


<?php

if (isset($_POST['login'])){
	$GLOBALS['checkstatus']=0;
	if(empty($_POST['username']))
		echo "<script>alert('Please enter username')</script>";

		elseif (empty($_POST['password']))
			{echo "<script>alert('Please enter password')</script>";}

		else{
			$u = $_POST['username'];
			$p = $_POST['password'];

			$num = checkuser($u,$p, "login");
			if($num>1){
				echo "<script>alert('The database is inconsistent Please Contact Administrator')</script>";
				header('location:contact_admin.php');	
			}
			else if($num==1){

				$_SESSION['username']= $u;
				$_SESSION['id'] = $GLOBALS['id'];
				$_SESSION['login-with-blog'] = 1;
				setcookie("username",$u,time()+60*60*24);
				
				if($_SESSION["username"]=="admin")
					header("location:admin.php");
				else {
					header("location:home.php");
				}
			}

			else{
				echo "<script>alert('Either username or password is Incorrect')</script>";
			}
		}
	}

	?>