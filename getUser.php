<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}
session_id($user);
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
$q = intval($_GET['q']);
$result = mysqli_query($con,"SELECT name, Link FROM PRODUCT WHERE name='$q'");   //need to fix
                                   



echo "<table border='1'>
<tr>
<th>Product Name</th>
<th>Link</th>
</tr>";

while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['name'] . "</td>";
  echo "<td>" . $row['Link'] . "</td>";

  echo "</tr>";
}
echo "</table>";

mysqli_close($con);
								
    

?>

<p><a href="wishlist.html" class="button">Add Items to Wishlist</a></p>
<p><a href="editWishlist.html" class="button">Edit Wishlist</a></p>
<p><a href="editEvent.html" class="button">Edit Event</a></p>


</div>
</body>
</html>