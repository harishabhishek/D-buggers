<?php
 session_start();
	$user = session_id();
	$gestureid=$_SESSION['GestureID'];
	$eventid=$_SESSION['EventID'];
    $link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$link)
    		echo "Error!";
    else
    {
	
    $descriptionTemp=mysqli_real_escape_string($link,$_POST['gestureName']);
    $detailsTemp=mysqli_real_escape_string($link,$_POST['gestureLink']);
    
           $description=preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $descriptionTemp);
           $details=preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $detailsTemp);
	
 
  	if (empty($description) && empty($details))
	{
			$_SESSION['EventID']=$eventid;
			
			header('Location: updateWishlistError.php?'.$eventid);
	
	}
	else
	{
	
	if (!empty($description))
	{
		$result= "UPDATE Gesture SET description='$description'
			WHERE GestureID='$gestureid'";
		mysqli_query($link,$result);
		$_SESSION['EventID']=$eventid;
		header('Location: updateWishlistSuccess.php?'.$eventid);

	}
	
	if (!empty($details))
	{
		$result2= "UPDATE Gesture SET details='$details'
			WHERE GestureID='$gestureid'";
		mysqli_query($link,$result2);
		$_SESSION['EventID']=$eventid;
		header('Location: updateWishlistSuccess.php?'.$eventid);

	}
  	
  	}
  	
  	}
  	
	
?>