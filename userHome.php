<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
    header('Location: index.html');
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
        
        <nav class="nav cf" id="nav">
            <ul>
              
                <li><a href="index.html">Home</a></li>
        <li><a href="subpage.html">About Us</a></li>
        <li><a href="contact.html">Contact</a></li>
        <li class="current"><a href="userHome.php">My Account</a></li>
        
            </ul>
        </nav>
    </div>
        <FORM Action="logout.php" Method="post">
        <input type="submit" value="Log Out" class="button33" style="margin-left: 30cm"></input>
    </FORM>
    <br>
    <a href="addFriends.php" class="button33" style="margin-left: 30cm">Manage Friends</a>
    <?php
    	
    	$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	
    	$query = "SELECT friendId from requestReceived where userId = $user";
    	$result = mysqli_query($con, $query);
    	
    	if($result){
    		
    		while(mysqli_fetch_array($result)){
    		
    		echo "<p style='margin-left: 30cm'>You have notifications</p>";
    		}
    	}
    
    ?>

</header>
<div class="introduction">
    <div class="wrapper cf">
        <hgroup>
          
            <h3> Hi
                <?php
                $con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
                //$user = 1;
                //echo $user;
                $result = mysqli_query($con,"SELECT name as name from User WHERE User.userID = $user");

                if(!$result){
                    echo "Error";
                }
                else{

                    while($row = mysqli_fetch_array($result)){
                        echo $row['name'];
                    }
                }

                ?>
            </h3>
            <h2>One place to organize all your events</h2>
            
        </hgroup>
        
         <?php
        $con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
        //$user = 1;
        $result = mysqli_query($con,"SELECT Description as des, Name FROM Event WHERE Event.EventID IN
                                    (SELECT EventID as id FROM Celebrating WHERE userid = '$user')");

        //echo "<p><u> Your Events are :</p> </u>";
         //$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
        //$user = 1;
        $result2 = mysqli_query($con,"SELECT Description, Name, StartDate, EndDate, EventID FROM Event WHERE Event.EventID IN
                                    (SELECT EventID as id FROM Celebrating WHERE userid = '$user')");
	
        echo "<table border='1'>
		<tr>
		<th><b>My Events</b></th>
		<th><b>Description</b></th>
		<th><b>Start Date</b></th>
		<th><b>End Date</b></th>
		</tr>";    
        while($row = mysqli_fetch_array($result2)){
            echo "<tr><td><a href='EventDetails.php?".$row['EventID']."'>".$row['Name']."</a></td><td>".$row['Description']."</td><td>".$row['StartDate']."</td><td>".$row['EndDate']."</td></tr>";
        }
        
        echo "</table>";

        /*while($row = mysqli_fetch_array($result)){
            echo "<p>".$row['Name'].": ".$row['des']."</p>";
        } */

        ?>


       
        
        <p><a href="Event.html" class="button">Add Event</a></p>
        <p><a href="updateInfo.html" class="button">Edit Info</a></p>
        <p><a href="Delete.php" class="button">Delete Account</a></p>



    </div>

</div>
<div class="features">
    <div class="wrapper cf">
        <h2>Key Features</h2>
        <article> </a>
            <p>Let your friends know about all the things that you would need</p>
        </article>
        <article> </a>
            <p>Invite your friends to different events that you are planning</p>
        </article>
        <article class="last"> </a>
            <p>Connect and share the wish lists that you created with your friends using social media</p>
        </article>
    </div>
</div>
<div class="testimonials">
    <div class="wrapper cf">
        <h2>What our customers say</h2>
        <article class="half cf">
            <div class="testimonials-image"> <img src="images/testimonial-01.png" alt=""></div>
            <div class="testimonials-text">
                <p>This website is awesome and it works <span>&ndash; Super Saiyyan</span></p>
            </div>
        </article>
        <article class="half f-right cf">
            <div class="testimonials-image"> <img src="images/testimonial-02.png" alt=""> </div>
            <div class="testimonials-text">
                <p>Yayyyy. Awesome service. I was able to get all the gifts I wanted <span>&ndash; Random User 9000</span></p>
            </div>
        </article>
    </div>
</div>
<footer class="footer">
    <div class="wrapper cf">
        <p class="f-right"> <a href="#"><img src="design/facebook.png" alt=""></a> <a href="#"><img src="design/twitter.png" alt=""></a> <a href="#"><img src="design/dribbble.png" alt=""></a> </p>
    </div>
</footer>
</body>
</html>