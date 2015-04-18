<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}
session_id($user);
$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');

$userId = $_POST['userId'];
$friendId = $_POST['friendId'];


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Wishing Well</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link rel="stylesheet" href="inc/reset.css" media="all">
    <link rel="stylesheet" href="inc/global.css" media="all">
    <link rel="stylesheet" href="inc/mobile.css" media="all and (max-width:767px)">
    <link rel="stylesheet" href="inc/desktop.css" media="all and (min-width:768px)">
    <!--[if (lt IE 9)&(!IEMobile)]><link rel="stylesheet" href="inc/desktop.css" media="all"><![endif]-->
    <!--[if lt IE 9]><script src="inc/html5.js"></script><![endif]-->
    <script src="inc/jquery.min.js"></script>
    <script src="inc/init.js"></script>

    <!--    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>-->
    <!--    <script>-->
    <!--        $(document).ready(function(){-->
    <!--            $(".receiveRequest").click(function(){-->
    <!--                $(this).hide();-->
    <!--            });-->
    <!--        });-->
    <!--    </script>-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script>

        function post(path, params, method) {
            method = method || "post"; // Set method to post by default if not specified.

            // The rest of this code assumes you are not using a library.
            // It can be made less wordy if you use one.
            var form = document.createElement("form");
            form.setAttribute("method", method);
            form.setAttribute("action", path);

            for(var key in params) {
                if(params.hasOwnProperty(key)) {
                    var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);

                    form.appendChild(hiddenField);
                }
            }

            document.body.appendChild(form);
            form.submit();
        }



    </script>

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
    <a href="addFriends.php" class="button33" style="margin-left: 30cm">Manage Friends</a>
   
</header>
                
      
<div class="mainAddPage">
    <div class="wrapper cf">
        <hgroup>

            <h3>The events your friend is having:</h3>
            <?php
            
	        $result2 = mysqli_query($con,"SELECT Description as des, Name, StartDate, EndDate, EventID FROM Event WHERE Event.EventID IN
	                                    (SELECT EventID as id FROM Celebrating WHERE userid = '$friendId')");
		
	        echo "<table border='1'>
	        <tr>
			<th><b>Events</b></th>
		<th><b>Description</b></th>
		<th><b>Start Date</b></th>
		<th><b>End Date</b></th>  
		</tr>";
	        while($row = mysqli_fetch_array($result2)){
	            echo "<tr><td><a href='friendEventDetails.php?".$row['EventID']."'>".$row['Name']."</a></td><td>".$row['des']."</td><td>".$row['StartDate']."</td><td>".$row['EndDate']."</td></tr>";
	         
	        }
	        
	        echo "</table>";

/*
                $resultNew  = mysqli_query($con, "SELECT EventID as id FROM Celebrating WHERE userid = $friendId)");

                if(!$resultNew){
                    echo "Error1";
                }
                else{
                    while($row = mysqli_fetch_array($resultNew)){

                        $eventId = $row['id'];
                        $result = mysqli_query($con,"SELECT Description as des, Name FROM Event WHERE Event.EventID = $eventId");

                        if(!$result){
                            echo "Error2";
                        }
                        else{
                            while($row2 = mysqli_fetch_array($result)){
                                echo "<p>".$row2['Name'].": ".$row2['des']."</p>";
                            }
                        }
                    }
                }
*/
            ?>
        </hgroup>

    </div>
</div>

<div class="features">
    <div class="wrapper cf">
        <h2>Key Features</h2>
        <article> 
            <p>Let your friends know about all the things that you would need</p>
        </article>
        <article>
            <p>Invite your friends to different events that you are planning</p>
        </article>
        <article class="last"> 
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