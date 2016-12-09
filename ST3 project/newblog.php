<?php 
require 'connect.php';
require 'session.php';

function getTags($string){
	preg_match_all ("/(#(.*)\s)|(#(.*)$)/U", $string, $tagarray);
	if(!empty($tagarray)){
		$string = $tagarray[0][0];
		$i=1;
		while(!empty($tagarray[0][$i])){
			$string.=" ";
			$string.=$tagarray[0][$i];
			$i++;
		}
		return $string;
	}
	else
		return NULL;
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


if(isset($_GET['edit'])){
	$tmp = $_GET['edit'];
	if($tmp == "Y"){
		$bid = $_GET['blogid'];
		$sql = "SELECT `blog_id`,`title`,`detail`,`category` FROM `blogs` WHERE `blog_id`= '$bid'";
		$result1 = mysqli_query($db,$sql);

		$num_query = mysqli_num_rows($result1);
		$row=mysqli_fetch_array($result1);
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
				<li>Hi <?php echo $_SESSION['username'];?></li>
				<li><a href='home.php'>Home</a></li>
				<li><a class='modal-trigger' href="."#profile_modal".">My Profile</a></li>
				<li><a href='message.php'>Contact Us</a></li>
				<li><a href="signout.php">Sign Out</a></li>
			</ul>
		</div>
	</nav>
</head>

<body class ="indigo darken-4">
	<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<center>
		<div class="row" style= 'width:50%;margin:30px auto;'>
			<form action = 
			"<?php  
			if(isset($_GET['edit'])){
				$tmp = $_GET['edit'];
				if($tmp == "Y"){
					echo 'newblog.php?sender='.$_GET['sender'].'&edit=Y&blogid='.$_GET['blogid'];
				}
			}
			else echo "newblog.php";
			?>"

			method = "POST" enctype = "multipart/form-data" class=" card-panel" style ="padding: 40px;background-color: #fdf8e4;"> 
			<div class="fieldset">
				<label for="signup-username">Blog Title</label>

				<input type = "text" name = "blogtitle" value = "<?php if (isset($_GET['edit']))echo $row[1];?>" placeholder="Blog Title" maxlength = 30>
			</div>

			<div class="fieldset">
				<label for="signup-username">Details</label>
				<textarea style = "height:20%;width:100%" id="blog-detail" placeholder="Write your blog here. Max word limit is 5000" name="detail" maxlength="5000"><?php if (isset($_GET['edit']))echo $row[2];?> 
				</textarea>
			</div>

			<div class="row">
				<div class="input-field col s12">
					<label for="signup-username">Upload an image</label>
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input name="file" type="file" id="file"> 
				</div>
			</div>
			<div class="row">
				<div class="input-field col s12">
					<input class="btn waves-effect waves-light" Value = "submit" type="submit" name="action">
				</div></div>
			</div>
		</form>
	</center>

</body>

</html>


<?php

if (isset($_POST['action']) && $_FILES['file']['size']>0){
	if(empty($_POST['blogtitle'])){
		echo"<script>alert('Please give Title to the Blog')</script>";
	}
	elseif(empty($_POST['detail'])){
		echo"<script>alert('Blog cannot be empty')</script>";
	}
	elseif(!file_exists($_FILES['file']['tmp_name']) || !is_uploaded_file($_FILES['file']['tmp_name'])) 
	{
		echo "<script>alert('Please upload image.')</script>";}

	else{

			$file = checkforimage();
				$t=$_POST['blogtitle'];
				$c=$_POST['detail'];
				$id=$_SESSION['id'];


				if(isset($_GET['edit'])){
					$tmp = $_GET['edit'];
					$sender = $_GET['sender'];
					$bid = $_GET['blogid'];
				}
				if($tmp == "Y"){
					if($_SESSION["username"]=="admin"){

						$sql = "UPDATE `blogs` SET `title`='$t', `detail`='$c', `status`='A', `editedBy`='$sender' WHERE `blog_id` = '$bid'";
					}
					else
					{
						$sql = "UPDATE `blogs` SET `title`='$t', `detail`='$c', `status`='W', `editedBy`='$sender' WHERE `blog_id` = '$bid'";
					}
					$sql1 = "UPDATE `blog_detail` SET `image`='$file' WHERE `blog_id` = '$bid'";

					if(mysqli_query($db,$sql1) && mysqli_query($db,$sql)){
						echo"<script>alert('Blog Updated Successfully')</script>";
						header('Refresh: 1;location:home.php');			
					}
					else
					{
						echo"<script>alert('There was a problem in updating the blog')</script>";
					}
				}
				else{
					$sql = "INSERT INTO `blogs`(`blogger_id`, `title`, `detail`,	 `status`, `editedBy`) VALUES ('$id','$t','$c','W','U')";
					$sql1 = "SELECT `blog_id` from `blogs` ORDER BY `blog_id` DESC";
			
					mysqli_query($db,$sql);

					$r=mysqli_query($db,$sql1);
					$row=mysqli_fetch_array($r,MYSQLI_NUM);
					$last_id=$row[0];
					$sql2 = "INSERT INTO `blog_detail`(`blog_id`,`image`) VALUES('$last_id','$file')";
					if(mysqli_query($db,$sql2)){
						echo"<script>alert('Blog Added Successfully')</script>";
						header('Refresh: 1;location:home.php');			

					}
					else
					{
						echo"<script>alert('There was a problem in posting the blog')</script>";

					}
				}
		}
	}
	?>
