<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}
session_id($user);
//$event = $_POST['event'];
$eventid=$_SESSION['EventID'];

$product =preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $_POST['product1']);
$link = $_POST['link1'];
if ( empty($product)  || $product==null  || $product=="" || $product==" ")
{
	$_SESSION['EventID']=$eventid;
    header('Location: wishlisterror.html');
}
else
{

	$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$con)
    		echo "Error!";
    		
    		 /*$result1 = mysqli_query($con,"SELECT EventID FROM Event WHERE Event.Name='$event' AND Event.EventID IN
                                    (SELECT EventID as id FROM Celebrating WHERE userid = '$user')");                                 
	if (!mysqli_fetch_array($result1))
	{
		header('Location: wishlisterror.html');
	}
	else
	{ */
	  /* $result1 = mysqli_query($con,"SELECT EventID FROM Event WHERE Event.Name='$event' AND Event.EventID IN
                                    (SELECT EventID as id FROM Celebrating WHERE userid = '$user')"); 
          $first=mysqli_fetch_array($result1);
          $eventid=$first['EventID'];  */ 
    	else
    	{
        
	$result = mysqli_query($con,"SELECT WishlistID FROM hasA WHERE EventID='$eventid'");
    $row=mysqli_fetch_array($result);
    $wishid=$row['WishlistID'];
   
	$sql3 = "INSERT INTO Product(Link, name) VALUES('$link','$product')";
	mysqli_query($con,$sql3);
	//echo $product;
	$getProd = mysqli_query($con,"SELECT ProductID FROM Product WHERE Link='$link' AND name='$product'");
	$newRow=mysqli_fetch_array($getProd);
	$productid=$newRow['ProductID'];
	$sql4 = "INSERT INTO giftsA(WishlistID, ProductID) VALUES('$wishid','$productid')";
	mysqli_query($con,$sql4);
	mysqli_close($con);
	$_SESSION['EventID']=$eventid;
	header('Location: wishlistSuccess.html'); 
	
	}
	//}
}


?>