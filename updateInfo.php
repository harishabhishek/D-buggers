<?php
 session_start();
	$user = session_id();
    $link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$link)
    		echo "Error!";
	
    $name=mysqli_real_escape_string($link,$_POST['regname']);
    $password=mysqli_real_escape_string($link,$_POST['regpass1']);
	$password2=mysqli_real_escape_string($link,$_POST['regpass2']);
  
  	$bname = empty($name);
  	$bpw1 = empty($password);
  	$bpw2 = empty($password2);
  	
  	
  	
  	if(!$bname && !$bpw1 && !$bpw2){
  	
  		if ($password!=$password2)
  		 	header('Location: updateError.html');
else if (strlen($password)<5)
		header('Location: updateError.html');
else if (!preg_match("/^[a-zA-Z ]*$/",$name))
		header('Location: updateError.html');
  		else
  		{
  			$password = md5($password);
  			
  			$result= "UPDATE User SET name='$name', hashPswd='$password'
			WHERE UserID='$user'";
   			 if (!mysqli_query($link,$result)) {
 			 die('Error: ' . mysqli_error($link));
			}
	
           		session_start();
		  	 header('Location: userHome.php');
		  	 
		 }
  	
  	}	
  	else if(!$bname){
  		if ((!$bpw1 && $bpw2) || (!$bpw2 && $bpw1))
  			header('Location: updateError.html');
else if (!preg_match("/^[a-zA-Z ]*$/",$name))
		header('Location: updateError.html');
  		else
  		{
  			$result= "UPDATE User SET name='$name'
			WHERE UserID='$user'";
   			 if (!mysqli_query($link,$result)) {
 			 die('Error: ' . mysqli_error($link));
			}
	
           		session_start();
		  	 header('Location: userHome.php');
		}
  	}
  	else if(!$bpw1 && !$bpw2){
  	
  		if ($password!=$password2)
  		 	header('Location: updateError.html');
else if (strlen($password)<5)
		header('Location: updateError.html');
  		else
  		{
  			$password = md5($password);
  			
  			$result= "UPDATE User SET hashPswd='$password'
			WHERE UserID='$user'";
   			 if (!mysqli_query($link,$result)) {
 			 die('Error: ' . mysqli_error($link));
			}
	
           		session_start();
		  	 header('Location: userHome.php');
		  	 
		 }
  	}
  	else{
  		 header('Location: updateError.html');
  	}
  	
  	
	
?>