<?php
    $link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$link)
    		echo "Error!";
    		
    	$result = mysqli_query($link, "SELECT Max(UserID) as id from User" );
    	if(!result){
    		echo "Server Error";
    	}
    	else{
    		
    		$row = mysqli_fetch_array($result);
    	}
    		
    		
    	$UserID = $row['id']+1;
    	
	//$UserID=mysqli_real_escape_string($link,$_POST['reguserid']);
    $name=mysqli_real_escape_string($link,$_POST['regname']);
    $password=mysqli_real_escape_string($link,$_POST['regpass1']);
	$password2=mysqli_real_escape_string($link,$_POST['regpass2']);
    $email=mysqli_real_escape_string($link,$_POST['regemail']);
    $DOB=mysqli_real_escape_string($link,$_POST['regDOB']);
    
    //echo "password2: ".$password2;

	if (empty($name) || empty($password) || empty($email) || empty($DOB) || empty($password2))
		header('Location: RegisterError.html'); 
	else if ($password!=$password2)
		header('Location: RegisterError.html');
	else if (!preg_match("/^[a-zA-Z ]*$/",$name))
		header('Location: RegisterError.html');
	else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
		header('Location: RegisterError.html');
	else if (strlen($password)<5)
		header('Location: RegisterError.html'); 
	
	
	else
	{
		$query = mysqli_query($link,"SELECT Count(*) as c from User WHERE User.email = '$email'");
		if (!$query){
		
			echo "Server Error!";
		
		}
		
		$row = mysqli_fetch_array($query);
		$count = $row['c'];
		
		
		if ($count >0)
		{
			
			header('Location: RegisterError2.html');
			
		}
		else
		{
			$password = md5($password);
			$result= "INSERT INTO User (`UserID`, `name`, `hashPswd`, `email`, `dob`) VALUES ('$UserID','$name','$password','$email','$DOB')";
			if (!mysqli_query($link,$result)) {
			die('Error: ' . mysqli_error($link));
			}
	
			session_id( $UserID );
           		session_start();
		   header('Location: userHome.php');
		}

      mysqli_close($link);
	 } 
?>