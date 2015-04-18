<?php

	session_start();
	$user = session_id();
	$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
	

		
	$result = mysqli_query($con, "Select EventID as id FROM Celebrating where UserID = $user");
	
	if (!$result)
		echo "We are unable to deactivate your account at this time.";
	
	else{
		while($row = mysqli_fetch_array($result)){
		
			$myVar = $row['id'];
			
			$newQuery = mysqli_query($con, "SELECT WishlistID as wish FROM hasA WHERE EventID = $myVar");
			if(!$newQuery){
				echo "There was some error while deactiving your account";
			}
			else{
				
				while($newRow = mysqli_fetch_array($newQuery)){
					
					$wish = $newRow['wish'];
					$que = mysqli_query($con, "DELETE FROM Wishlist WHERE WishlistID = $wish");
					$que = mysqli_query($con, "DELETE FROM doesA WHERE WishlistID = $wish");
					$que = mysqli_query($con, "DELETE FROM giftsA WHERE WishlistID = $wish");
					
				}
			
			}
			
			$que = mysqli_query($con, "DELETE FROM Event WHERE EventID = $myVar");
			$que = mysqli_query($con, "DELETE FROM hasA WHERE EventID = $myVar");
			
	
		}
		
		$result = mysqli_query($con, "DELETE FROM User WHERE User.userID = $user");
		$que = mysqli_query($con, "DELETE FROM Celebrating WHERE UserID = $user");
		
		$result = mysqli_query($con, "DELETE FROM friends WHERE userId = $user OR friendId = $user");
		$result = mysqli_query($con, "DELETE FROM requestReceived WHERE userId = $user OR friendId = $user");
		$result = mysqli_query($con, "DELETE FROM requestSent WHERE userId = $user OR friendId = $user");
		
		
		header('Location: afterDelete.html');
	}
	
	

?>
