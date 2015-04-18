<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}

session_id($user);
$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
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


        function viewProfile(userId, friendId){
                post('viewProfile.php', {userId: userId, friendId: friendId});
            }
            
            function receiveRequest(userId, friendId){

                post('receivedRequests.php', {userId: userId, friendId: friendId});

            }

            function deleteRequest(userId, friendId){

                post('deleteRequests.php', {userId: userId, friendId: friendId});
            }
            function deleteFriend(userId, friendId){

                post('deleteFriend.php', {userId: userId, friendId: friendId});
            }

            function messageFriend(userId, friendId, divId){

                  //alert(divId);
//                post('deleteFriend.php', {userId: userId, friendId: friendId});
                var changeIt = document.getElementById(divId);
                changeIt.style.visibility = 'visible';
                changeIt.style.height = '100px';
            }


            function showHint(str)
            {
                var xmlhttp;
                if (str.length==0)
                {
                    document.getElementById("txtHint").innerHTML="";
                    return;
                }
                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
                    }
                }
                xmlhttp.open("GET","suggestion.php?q="+str,true);
                xmlhttp.send();
            }

            function sendRequestValidator(){

                str = document.getElementById("txt1").value;

                var xmlhttp;

                if (window.XMLHttpRequest)
                {// code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp=new XMLHttpRequest();
                }
                else
                {// code for IE6, IE5
                    xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange=function()
                {
                    if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    {
                        //document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
                        alert(xmlhttp.responseText);
                    }
                }
                var get = "addHandler.php?q="+str+"&v=<?php echo session_id() ?>";
                xmlhttp.open("GET",get,true);
                xmlhttp.send();


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
        

    <FORM Action="logout.php" Method="post">
        <input type="submit" value="Log Out" class="button33" style="margin-left: 30cm"></input>
        
    </FORM>
    

</header>
<div class="mainAddPage">
    <div class="wrapper cf">
        <hgroup>


            <h3> <u> Enter email address of the friend to add </u></h3> <br>

            Email: <input type="text" id="txt1" onkeyup="showHint(this.value)" />
            <input id="sendRequest" type="button" value="Send Request" class="button33" onclick="sendRequestValidator()" />

            <p>Suggestions: <span id="txtHint"></span></p>


            <h3><u> Your Pending requests are: </u></h3>

            <?php
                $result = mysqli_query($con, "SELECT friendId from requestReceived WHERE userId = $user");
                if(!$result)
                	echo "Error";
                else{
                
	                if(mysqli_num_rows($result) == 0)
	                    echo "You have no Pending Friend Requests";
	
	                else{
	                    $itr= 0;
	                    while($row = mysqli_fetch_array($result)){
	
	                        $friend = $row['friendId'];
	                        $temp = mysqli_query($con, "SELECT name from User WHERE  User.userID= $friend ");
	
	                        while($tempRow = mysqli_fetch_array($temp)){
	                       		echo "<br>";
	                            echo $tempRow['name']."<br>";
	                        }
	                        $str = "<input id='clickMe".$itr."' type='button' value='Add Friend' class='button22' onclick='receiveRequest( ".$user.", ". $row['friendId']." );' />";
	                        echo $str;
	                        $str = "<input id='deleteRequest".$itr."' type='button' value='Delete Friend' class='button22' onclick='deleteRequest( ".$user.", ". $row['friendId']." );' />";
	                        echo $str;
	                        $itr++;
	                    }
	                }
	           }

            ?>
            <br>
            <br>
            <h3><u> You Friends are:</u></h3>
            <?php
                $result = mysqli_query($con, "SELECT friendId from friends WHERE userId = $user");
                
                if(!$result)
                	echo "Error";
                else{

	            	if(mysqli_num_rows($result) == 0)
	                    echo "You have no Friends. It's so sad :(";
	
	                else{
	                    $itr =0;
	                    while($row = mysqli_fetch_array($result)){
	
	                        $friend = $row['friendId'];
	                        $temp = mysqli_query($con, "SELECT name from User WHERE  User.userID= $friend ");
	
	                        while($tempRow = mysqli_fetch_array($temp)){
	                        	echo "<br>";
	                            $strNew = "<div onclick='viewProfile(".$user.", ".$friend.")'> <u>".$tempRow['name']."</u> </div>";
	                            echo $strNew;
	                        }
	

	                        $str = "<input id='deleteFriend".$itr."' type='button' value='Delete Friend' class='button22' onclick='deleteFriend( ".$user.", ". $row['friendId']." );' />";
	                        echo $str;
				echo "<br>";
	                        $itr++;
	                        echo "<br>";
	                    }
	                }
		}
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