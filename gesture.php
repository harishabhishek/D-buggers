<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}
session_id($user);
$eventid= $_SESSION['EventID'];
$description =preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $_POST['gestureDescription']);

$details =preg_replace('/[^A-Za-z0-9\-\(\) ]/', '',  $_POST['Details']);
if (empty($description) || $description==null  || $description==""  || $description==" ")
{
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
	{
	   $result1 = mysqli_query($con,"SELECT EventID FROM Event WHERE Event.Name='$event' AND Event.EventID IN
                                    (SELECT EventID as id FROM Celebrating WHERE userid = '$user')"); 
          $first=mysqli_fetch_array($result1);
          $eventid=$first['EventID'];  */     
	$result = mysqli_query($con,"SELECT WishlistID FROM hasA WHERE EventID='$eventid'");
    $row=mysqli_fetch_array($result);
    $wishid=$row['WishlistID'];
   // echo "Details: ".$details;

	$sql3 = "INSERT INTO Gesture(Description, Details) VALUES('$description','$details')";
	mysqli_query($con,$sql3);
	$getGest = mysqli_query($con,"SELECT GestureID FROM Gesture WHERE Description='$description' AND Details='$details'");
	$newRow=mysqli_fetch_array($getGest);
	$gestureid=$newRow['GestureID'];
	
	$sql4 = "INSERT INTO doesA(GestureID, WishlistID) VALUES('$gestureid','$wishid')";
	mysqli_query($con,$sql4);
	mysqli_close($con);
	header('Location: wishlistSuccess.html');
	//}
}


?>