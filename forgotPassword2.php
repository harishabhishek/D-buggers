<?php
$email = $_POST['email'];
	$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$con)
    	{
    		echo "Error!";
    	}
    	
    	else {

    $result = mysqli_query($con,"SELECT UserID FROM uidebugg_wishingwell.User WHERE email='$email'");
	if (!$result)
	{
		header('Location: forgotPasswordError.html');
	}
	else
	{
		$row = mysqli_fetch_array($result);

		if (!$row || $row==" " || $row=="")
		{
			header('Location: forgotPasswordError.html');
		}
		else
		{
			$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
			$randPwd = substr( str_shuffle( $chars ), 0, 8 );
			$origPwd=$randPwd;
			$randPwd=md5($randPwd);
			$result2= "UPDATE User SET hashPswd='$randPwd'
			WHERE email='$email'";
   			 if (!mysqli_query($con,$result2)) {
 			 die('Error: ' . mysqli_error($con));
			}
	
	$to = $email;
	$subject = "Password Reset";
	$txt = "Here is your new password: $origPwd";
	$headers = "From: uidebuggers@gmail.com";

mail($to,$subject,$txt,$headers);
	mysqli_close($con);
 	header('Location: indexNew.html');
	
	 }
	 
	 }
	 
	 }
?>