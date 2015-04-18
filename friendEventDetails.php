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
            
            function productDone(wishlistID, productID){
            	post('productCheckHandler.php', {wishlistID: wishlistID, productID: productID});
            }
           
             function gestureDone(wishlistID, productID){
            	post('gestureCheckHandler.php', {wishlistID: wishlistID, productID: productID});
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
<div class="introduction">
    <div class="wrapper cf">
        <div class="half introduction-text">
        </div>
<?php
$event = $_POST['event'];
$eventid=$_SESSION['EventID'];
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$id = substr($actual_link, strrpos($actual_link, '?') + 1);
if (!empty($id) && $id!=" " && $id!="")
	$eventid=$id;

$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
$result = mysqli_query($con,"SELECT Description as des, Name, StartDate, EndDate, EventID FROM Event WHERE Event.EventID='$eventid'");


echo "<p><font size='5'> Event Details: </font></p>";      

if (!mysqli_fetch_array($result))
{
	echo "No event named '" .$event."' found";

}
else
{
       $result = mysqli_query($con,"SELECT Description as des, Name, StartDate, EndDate, EventID FROM Event WHERE Event.EventID='$eventid'");
          $blank=" ";
          
             echo "<table border='1'>
		<tr>
		<th><b>Name</b></th>
		<th><b>Description</b></th>
		<th><b>Start Date</b></th>
		<th><b>End Date</b></th>
		</tr>";                          	
                                                      
        
        while($row = mysqli_fetch_array($result)){
        $_SESSION['EventID'] = $row['EventID'];


	echo "<tr><td>".$row['Name']."</td><td>".$row['des']."</td><td>".$row['StartDate']."</td><td>".$row['EndDate']."</td></tr>";
			$eventid=$row['EventID'];
			$res = mysqli_query($con,"SELECT WishlistID FROM hasA WHERE EventID='$eventid'");
                        $row=mysqli_fetch_array($res);
                        $wishid=$row['WishlistID']; 
                        
                       echo"</table>";  
          echo "<p><b><font size='3'>Wishlist for this event: </font></b></p>"; 

           $productResult = mysqli_query($con,"SELECT Link, name FROM Product WHERE Product.ProductID IN
                                    (SELECT ProductID as id FROM giftsA WHERE WishlistID = '$wishid')"); 
            echo "<table border='1'>
		<tr>
		<th><b>Product</b></th>
		<th><b>Web Link</b></th>
		<th><b>Done</b></th>
		
		
		</tr>";  
	if (!$productRow=mysqli_fetch_array($productResult))  
		 echo "<tr><td>".$blank."</td><td>".$blank."</td></tr>"; 
	 $productResult = mysqli_query($con,"SELECT Link, name, ProductID FROM Product WHERE Product.ProductID IN
                                    (SELECT ProductID as id FROM giftsA WHERE WishlistID = '$wishid')");                   
           while ($productRow=mysqli_fetch_array($productResult)){
           
           $productid=$productRow['ProductID'];
           $doneResult = mysqli_query($con,"SELECT Done FROM giftsA WHERE WishlistID = '$wishid' AND ProductID='$productid'"); 
	    while($doneRow=mysqli_fetch_array($doneResult))
	    {
           
           if (!$doneRow['Done']){
           
           $str = "<input type='checkbox' onclick='productDone(".$wishid.", ".$productid.");' >";
           
           
           echo "<tr><td>".$productRow['name']."</td><td>".$productRow['Link']."</td><td>".$str."</td></tr>";
           }
           else{
           
           echo "<tr><td>".$productRow['name']."</td><td>".$productRow['Link']."</td><td>Done</td></tr>";
           }
           
           }


           }  
     		echo "</table>";	
       
        echo "<table border='1'>
		<tr>
		<th><b>Description</b></th>
		<th><b>Details</b></th>
		<th><b>Done</b></th>

		
		</tr>";                        
          
         $gestureResult = mysqli_query($con,"SELECT Description, Details FROM Gesture WHERE Gesture.GestureID IN
                                    (SELECT GestureID as id FROM doesA WHERE WishlistID = '$wishid')"); 
           if(!$gestureRow=mysqli_fetch_array($gestureResult))
           	 echo "<tr><td>".$blank."</td><td>".$blank."</td></tr>";
           $gestureResult = mysqli_query($con,"SELECT Description, Details, GestureID FROM Gesture WHERE Gesture.GestureID IN
                                    (SELECT GestureID as id FROM doesA WHERE WishlistID = '$wishid')"); 
            //echo "<p><u><font size='3'>Gestures: </font></u></p>"; 
           while ($gestureRow=mysqli_fetch_array($gestureResult)){
            $_SESSION['EventID']=$eventid;
           $_SESSION['GestureID']=$gestureRow['GestureID'];
            $gestureid=$gestureRow['GestureID'];
           $_SESSION['WishlistID']=$wishid;
           $doneResult2 = mysqli_query($con,"SELECT Done FROM doesA WHERE WishlistID = '$wishid' AND GestureID='$gestureid'"); 
           
            while($doneRow2=mysqli_fetch_array($doneResult2))
	    {
           
           if (!$doneRow2['Done']) {
           
           $str = "<input type='checkbox' onclick='gestureDone(".$wishid.", ".$gestureid.");' >";
           
           echo "<tr><td>".$gestureRow['Description']."</td><td>".$gestureRow['Details']."</td><td>".$str."</td></tr>";
           }
           
           else{
           echo "<tr><td>".$gestureRow['Description']."</td><td>".$gestureRow['Details']."</td><td>Done</td></tr>";
           
           }
	
          
           } 
           } 
           
           echo "</table>";
     			
        }
        
        }
        
    

?>


</div>
</div>



</body>



</html>