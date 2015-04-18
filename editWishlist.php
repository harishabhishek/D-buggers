<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}
session_id($user);
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
	<script>
function showUser(str) {
  if (str=="") {
    document.getElementById("txtHint").innerHTML="";
    return;
  } 
  if (window.XMLHttpRequest) {
    // code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  } else { // code for IE6, IE5
    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
    if (xmlhttp.readyState==4 && xmlhttp.status==200) {
      document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
  xmlhttp.open("GET","getuser.php?q="+str,true);
  xmlhttp.send();
}
</script>
</head>
<body>
<header class="header">
    <div class="wrapper cf">
        <p class="logo"><a href="userHome.php" title="[Go to homepage]"><img src="design/logo.png" alt=""></a></p>
        <nav class="nav cf" id="nav">
            <ul>
                <li style="font-size:xx-large">WishingWell</li>
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
<?php

$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
$result = mysqli_query($con,"SELECT Name FROM Event WHERE EventID=$eventid"); 
									
					

        
        while($row = mysqli_fetch_array($result)){
            echo "<p><b><u><font size='4'>".$row['Name']."</font></u></b></p>";
     			
        }
 echo "<table><tr><td>";       
        echo"<form><select name='users' onchange='showUser(this.value)'><option value=''>Select an Item</option>";
        $count=1;
        $wish=mysqli_query($con,"Select WishlistID From hasA WHERE EventID='$eventid'");
        $wish_id_array=mysqli_fetch_array($wish);
        $wishid=$wish_id_array['WishlistID'];
        $prodResult=mysqli_query($con,"SELECT name FROM Product WHERE ProductID IN (Select ProductID FROM giftsA WHERE WishlistID='$wishid')"); 
         while($row = mysqli_fetch_array($prodResult)){
         
        
           echo "<option value='".$count."'>".$row['name']."</option>";
     			
        }

echo "</select></form></td><td>"; 

echo"<form><select name='users' onchange='showUser(this.value)'><option value=''>Select a Gesture</option>";
        $count=1;
        $wish=mysqli_query($con,"Select WishlistID From hasA WHERE EventID='$eventid'");
        $wish_id_array=mysqli_fetch_array($wish);
        $wishid=$wish_id_array['WishlistID'];
        $gestResult=mysqli_query($con,"SELECT Description FROM Gesture WHERE GestureID IN (Select GestureID FROM doessA WHERE WishlistID='$wishid')"); 
         while($gestRow = mysqli_fetch_array($gestResult)){
         
        
           echo "<option value='".$count."'>".$gestRow['Description']."</option>";
     			
        }

echo "</select></form></td></tr></table>"; 



  
  
      $_SESSION['EventID']=$eventid;
     
 ?>    
     
<p><a href="wishlist.html" class="button">Add Items to Wishlist</a></p>
<p><a href="editWishlist.html" class="button">Edit Wishlist</a></p>
<p><a href="editEvent.html" class="button">Edit Event</a></p>


</div>
</body>
</html>