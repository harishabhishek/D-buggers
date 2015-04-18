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
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="reset.css" media="all">
<link rel="stylesheet" href="global.css" media="all">
<link rel="stylesheet" href="mobile.css" media="all and (max-width:767px)">
<link rel="stylesheet" href="desktop.css" media="all and (min-width:768px)">
<link rel="stylesheet" type="text/css" href="jquery.datetimepicker.css">
<!--[if (lt IE 9)&(!IEMobile)]><link rel="stylesheet" href="inc/desktop.css" media="all"><![endif]-->
<!--[if lt IE 9]><script src="inc/html5.js"></script><![endif]-->
<script src="inc/jquery.min.js"></script>
<script src="inc/init.js"></script>
<script src="jquery.js"></script>

    <script>
    function setSessionVariables(prod, event, wish){
    sessionStorage.setItem("ProductID",prod);
    sessionStorage.setItem("EventID",event;
    sessionStorage.setItem("WishlistID",wish);
    return;

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
$result = mysqli_query($con,"SELECT Description, Name, StartDate, EndDate, EventID FROM Event WHERE Event.EventID='$eventid'");

     
echo "<p><font size='3'>Failed to update</font></p>";   
echo "<p><font size='5'> Event Details: </font></p>";      

if (!mysqli_fetch_array($result))
{
	echo "No event named '" .$event."' found";

}
else
{
       $result = mysqli_query($con,"SELECT Description, Name, StartDate, EndDate, EventID FROM Event WHERE Event.EventID='$eventid'");
          $blank=" ";
          
             echo "<table border='1'>
		<tr>
		<th><b>Name</b></th>
		<th><b>Description</b></th>
		<th><b>Start Date</b></th>
		<th><b>End Date</b></th>
		<th><b>Edit/Delete</b></th>
		</tr>";                          	
                                                      
        
        while($row = mysqli_fetch_array($result)){
        $_SESSION['EventID'] = $row['EventID'];
            //echo "<p><b><u><font size='4'>".$row['Name']."</font></u></b></p>";
			//echo "<p><font size='2'>Description: ".$row['des']."</font></p>";
			//echo "<p><font size='2'>Start Date: ".$row['StartDate']."</font></p>";
			//echo "<p><font size='2'>End Date: ".$row['EndDate']."</font></p>";
			 echo "<tr><td>".$row['Name']."</td><td>".$row['Description']."</td><td>".$row['StartDate']."</td><td>".$row['EndDate']."</td><td><a href='editEvent.php'>Edit Event</a><br><a href='deleteEvent.php'>Delete Event</a></td></tr>";
			$eventid=$row['EventID'];
			$res = mysqli_query($con,"SELECT WishlistID FROM hasA WHERE EventID='$eventid'");
                        $row=mysqli_fetch_array($res);
                        $wishid=$row['WishlistID']; 
                        
                       echo"</table>";  
          echo "<p><b><font size='3'>Wishlist for this event: </font></b></p>"; 
         // echo "<p><u><font size='3'>Products: </font></u></p>"; 
           $productResult = mysqli_query($con,"SELECT Link, name FROM Product WHERE Product.ProductID IN
                                    (SELECT ProductID as id FROM giftsA WHERE WishlistID = '$wishid')"); 
            echo "<table border='1'>
		<tr>
		<th><b>Product</b></th>
		<th><b>Web Link</b></th>
		<th><b>Done</b></th>
		<th><b>Edit/Delete</b></th>
		
		
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
         
           if (!$doneRow['Done'])
           
           echo "<tr><td>".$productRow['name']."</td><td>".$productRow['Link']."</td><td>No</td><td><a href='editProduct.php?".$productid."'>Edit Item</a><br><a href='deleteProduct.php?".$productid."'>Delete Item</a></td></tr>";
           
           else
           {
           $doneByResult = mysqli_query($con,"SELECT User.name as name FROM giftsA, User WHERE giftsA.WishlistID = '$wishid' AND giftsA.ProductID='$productid' AND giftsA.doneBy=User.UserId"); 
           $doneTemp=mysqli_fetch_array($doneByResult);
           if (!$doneTemp)
           	  echo "<tr><td>".$productRow['name']."</td><td>".$productRow['Link']."</td><td>Done</td><td><a href='editProduct.php?".$productid."'>Edit Item</a><br><a href='deleteProduct.php?".$productid."'>Delete Item</a></td></tr>";
           $doneByResult = mysqli_query($con,"SELECT User.name as name FROM giftsA, User WHERE giftsA.WishlistID = '$wishid' AND giftsA.ProductID='$productid' AND giftsA.doneBy=User.UserId"); 
	    while($doneByRow=mysqli_fetch_array($doneByResult))
	    {
	    	
           	$str="By: ".$doneByRow['name']; 
           echo "<tr><td>".$productRow['name']."</td><td>".$productRow['Link']."</td><td>".$str."</td><td><a href='editProduct.php?".$productid."'>Edit Item</a><br><a href='deleteProduct.php?".$productid."'>Delete Item</a></td></tr>";
           
           }
           
           }
           // echo "<p><b><font size='2'>".$productRow['name']."</font></b></p>";
             //echo "<p><font size='2'>".$productRow['Link']."</font></p>";
           
           
           }  
           }
     		echo "</table>";	
       
        echo "<table border='1'>
		<tr>
		<th><b>Description</b></th>
		<th><b>Details</b></th>
		<th><b>Done</b></th>
		<th><b>Edit/Delete</b></th>
		
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
           
           if (!$doneRow2['Done'])
           echo "<tr><td>".$gestureRow['Description']."</td><td>".$gestureRow['Details']."</td><td>No</td><td><a href='editGesture.php?".$gestureid."'>Edit Item</a><br><a href='deleteGesture.php?".$gestureid."'>Delete Item</a></td></tr>";
           
           else
           {
           
            $doneByResult2 = mysqli_query($con,"SELECT User.name as name FROM doesA, User WHERE doesA.WishlistID = '$wishid' AND doesA.GestureID='$gestureid' AND doesA.doneBy=User.UserId"); 
             $doneTemp2=mysqli_fetch_array($doneByResult2);
             if (!$doneTemp2)
             	 echo "<tr><td>".$gestureRow['Description']."</td><td>".$gestureRow['Details']."</td><td>Done</td><td><a href='editGesture.php?".$gestureid."'>Edit Item</a><br><a href='deleteGesture.php?".$gestureid."'>Delete Item</a></td></tr>"; 
             $doneByResult2 = mysqli_query($con,"SELECT User.name as name FROM doesA, User WHERE doesA.WishlistID = '$wishid' AND doesA.GestureID='$gestureid' AND doesA.doneBy=User.UserId"); 
             while($doneByRow2=mysqli_fetch_array($doneByResult2))
	    {
           	$str="By: ".$doneByRow2['name'];
           	 echo "<tr><td>".$gestureRow['Description']."</td><td>".$gestureRow['Details']."</td><td>".$str."</td><td><a href='editGesture.php?".$gestureid."'>Edit Item</a><br><a href='deleteGesture.php?".$gestureid."'>Delete Item</a></td></tr>"; 
           	
           	
           }
          
           
           
            //echo "<p><font size='2'>Details: ".$gestureRow['Details']."</font></p>";
            
            }
          
           } 
           } 
           
           echo "</table>";
     			
        }
        
        }
       
        
    

?>

<p><a href="wishlist.html" class="button">Add Items to Wishlist</a></p>

</div>
</div>



</body>



</html>