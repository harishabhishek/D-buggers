<?php
 session_start();
	$user = session_id();
	$productid=$_SESSION['ProductID'];
	$eventid=$_SESSION['EventID'];
    $link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$link)
    		echo "Error!";
    else
    {
	
	$result = mysqli_query($link, "DELETE FROM giftsA WHERE ProductID='$productid' AND WishlistID IN (Select WishlistID FROM hasA WHERE EventID='$eventid')");
	mysqli_query($link,$result);
	$_SESSION['EventID']=$eventid;
	header('Location: updateWishlistSuccess.php?'.$eventid);

	}
	
	

  	
	
?>