<?php
require 'connect.php';
require 'session.php';
if(login()){
  if($_SESSION['username'] != "admin"){
    header('location:home.php');
  }
}
else {
      header('location:index.php');
}


if (isset($_GET['delete'])){
  $id = $_GET['delete'];
  $sql = "DELETE FROM `contact` WHERE `id` = '$id'";
  mysqli_query($db,$sql);
}
elseif(isset($_GET['mark'])){
  $id = $_GET['mark'];
  $sql = "UPDATE `contact` SET `status` = 'R' WHERE `id` = '$id'";
  mysqli_query($db,$sql);
}

$sql = "SELECT * FROM `contact` ORDER BY `status` DESC";
$result = mysqli_query($db,$sql);
$num_query= mysqli_num_rows($result);
?>

<html>
<head>
  <!--Import Google Icon Font-->
  <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
  <link type="text/css" rel="stylesheet" href="css/style.css">
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <nav>
    <div class="nav-wrapper"  style = "background-color: gray;">
      <a href="index.php" class="brand-logo" style="padding-left: 30px;">BlogViewer</a>
      <ul id="nav-mobile" class="right hide-on-med-and-down">
      	<li>Hi admin</li> <li><a class='modal-trigger' href=#profile_modal>My Profile</a></li>
        <li><a href='home.php'>Home</a></li>
        <li><a href= edituser.php >Edit User</a></li>
        <li><a href="signout.php">Sign Out</a></li>
      </ul>
    </div>
  </nav>
</head>
<body class ="indigo darken-4">
<div style="text-align: center;">
<h2 class ="indigo darken-4" style ="color:yellow;">Messages</h2>
</div>


<?php
for($i =0; $i<$num_query;$i++){
$row = mysqli_fetch_row($result);
?>

 <div class="row">
        <div class="col s12 m6" style="float: none;margin:  0 auto;">
          <div class="card " style="background-color: #1997ff;">
            <div class="card-content white-text">
              <span class="card-title" style="font-size: xx-large;font-weight: 700;"><?php echo $row[2]?></span>
              <p style="font-size: small;font-style: italic;">By <?php echo $row[1]?></p>
              <p style="font-size: x-large;"><?php echo $row[3]?></p>
            </div>
            <div class="card-action">
            <?php if ($row[4] == "U"){
              echo "<a href='?mark=".$row[0]."'>Mark as Read</a>";
              }?>
              <a href="?delete=<?php echo $row[0]?>">Delete</a>
            </div>
          </div>
        </div>
      </div>
<?php
}
?>

</body>
</html>