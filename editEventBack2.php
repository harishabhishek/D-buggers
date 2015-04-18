<?php
 session_start();
	$user = session_id();
	$eventid=$_SESSION['EventID'];
    $link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$link)
    		echo "Error!";
    else
    {
	
    $tempName=mysqli_real_escape_string($link,$_POST['Event']);
    $descriptionTemp=mysqli_real_escape_string($link,$_POST['Description']);
	$date1=mysqli_real_escape_string($link,$_POST['Date1']);
	$date2=mysqli_real_escape_string($link,$_POST['Date2']);
	
	       $name=preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $tempName);
	       $description=preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $descriptionTemp);
 
  	if (empty($name) && empty($description) && empty($date1) && empty($date2))
	{
			$_SESSION['EventID']=$eventid;
			
			//echo "Here";
			header('Location: updateWishlistError.php?'.$eventid);
	
	}
	else
	{
	
	if (!empty($name))
	{
		$result= "UPDATE Event SET Name='$name'
			WHERE EventID='$eventid'";
		mysqli_query($link,$result);
		$_SESSION['EventID']=$eventid;
		header('Location: updateWishlistSuccess.php?'.$eventid);

	}
	
	if (!empty($description))
	{
		$result2= "UPDATE Event SET Description='$description'
			WHERE EventID='$eventid'";
		mysqli_query($link,$result2);
		$_SESSION['EventID']=$eventid;
		header('Location: updateWishlistSuccess.php?'.$eventid);

	}
	if (!empty($date1) && !empty($date2))
	{
		if (strtotime($date1) > strtotime($date2))
		{
			
			header('Location: updateWishlistError.php?'.$eventid);
		}
		
		else
		{
		
		$result2= "UPDATE Event SET StartDate='$date1'
			WHERE EventID='$eventid'";
		mysqli_query($link,$result2);
		$result3= "UPDATE Event SET EndDate='$date2'
			WHERE EventID='$eventid'";
		mysqli_query($link,$result3);
		$_SESSION['EventID']=$eventid;
		header('Location: updateWishlistSuccess.php?'.$eventid);
		
		}

	}
	
	if (!empty($date1))
	{
		$oneResult = mysqli_query($link,"SELECT EndDate FROM Event WHERE EventID='$eventid'");
		$flag=0;
		
		while ($row=mysqli_fetch_array($oneResult)){
			$currentdate2=$row['EndDate'];
			
			if (strtotime($date1) > strtotime($currentdate2))
			{
				$flag=1;
				
				header('Location: updateWishlistError.php?'.$eventid);
			}
			
		
		}
		
		if (!$flag)
		{
			$result2= "UPDATE Event SET StartDate='$date1'
			WHERE EventID='$eventid'";
			mysqli_query($link,$result2);
			header('Location: updateWishlistSuccess.php?'.$eventid);
		
		}
	
	
	}
	
	if (!empty($date2))
	{
		$twoResult = mysqli_query($link,"SELECT StartDate FROM Event WHERE EventID='$eventid'");
		$flag=0;
		
		while ($row=mysqli_fetch_array($twoResult)){
			$currentdate1=$row['StartDate'];
			if (strtotime($date2) < strtotime($currentdate1))
			{
				$flag=1;
				header('Location: updateWishlistError.php?'.$eventid);
			}
			
		
		}
		
		if (!$flag)
		{
			$result2= "UPDATE Event SET EndDate='$date2'
			WHERE EventID='$eventid'";
			mysqli_query($link,$result2);
			header('Location: updateWishlistSuccess.php?'.$eventid);
		
		
		}
	
	
	}
  	
  	}
  	
  	}
  	
	
?>