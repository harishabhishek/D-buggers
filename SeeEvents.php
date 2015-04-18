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
    <a href="addFriends.php" class="button33" style="margin-left: 30cm">Manage Friends</a>
    <FORM Action="logout.php" Method="post">
        <input type="submit" value="Log Out" class="button33" style="margin-left: 30cm"></input>
    </FORM>
</header>
<div class="main">
   
<div class="introduction">
    <div class="wrapper cf">
        <div class="half introduction-text">
        </div>
	
        <?php
        $con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
        //$user = 1;
        $result = mysqli_query($con,"SELECT Description as des, Name, StartDate, EndDate, EventID FROM Event WHERE Event.EventID IN
                                    (SELECT EventID as id FROM Celebrating WHERE userid = '$user')");
	echo "<b><font size='3'>My Events</font></b>";
        echo "<table border='1'>
		<tr>
		<th><b>Events</b></th>
		</tr>";    
        while($row = mysqli_fetch_array($result)){
            echo "<tr><td><a href='EventDetails.php?".$row['EventID']."'>".$row['Name']."</a></tr>";
        }
        
        echo "</table>";

        ?>
        
     
        
        <p><a href="Event.html" class="button">Add Event</a></p>
    


    </div>

</div>

</body>
</html>