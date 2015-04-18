<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}
session_id($user);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$gestureid = substr($actual_link, strrpos($actual_link, '?') + 1);
$eventid= $_SESSION['EventID'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wishing Well</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="reset.css" media="all">
    <link rel="stylesheet" href="global.css" media="all">
    <link rel="stylesheet" href="mobile.css" media="all and (max-width:767px)">
    <link rel="stylesheet" href="desktop.css" media="all and (min-width:768px)">
    <!--[if (lt IE 9)&(!IEMobile)]><link rel="stylesheet" href="desktop.css" media="all"><![endif]-->
    <!--[if lt IE 9]><script src="html5.js"></script><![endif]-->
    <script src="jquery.min.js"></script>
    <script src="init.js"></script>
    
</head>
<body>
  <header class="header">
    <div class="wrapper cf">
       
    <nav class="nav cf" id="nav">
      <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="subpage.html">About Us</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li><a href="userHome.php">My Account</a></li>
      </ul>
    </nav>
  </div>
        

    <FORM Action="logout.php" Method="post">
        <input type="submit" value="Log Out" class="button33" style="margin-left: 30cm"></input>
        
    </FORM>
    

</header>
<div class="introduction">
    <div class="wrapper cf">
        <div class="half introduction-text">
        
        </div>
        <h3>Delete Item</h3>
<?php

$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
$productResult = mysqli_query($con,"SELECT Description, Details, GestureID FROM Gesture WHERE GestureID='$gestureid'");
 echo "<table border='1'>
		<tr>
		<th><b>Description</b></th>
		<th><b>Details</b></th>
		</tr>";      		

 while ($productRow=mysqli_fetch_array($productResult)){
           
           echo "<tr><td>".$productRow['Description']."</td><td>".$productRow['Details']."</td></tr>";	
   
          // $_SESSION['GestureID']=$productRow['GesturetID'];	
			
     			
        }
  
  $_SESSION['GestureID']=$gestureid;
 echo "</table>" 
    

?>
<FORM ACTION="deleteGestureBack.php" METHOD="post">
    
   
    <input type="submit" class="button" value="Delete"></input>
</FORM>




</div>
</body>
</html>