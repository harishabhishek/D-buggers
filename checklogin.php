<?php
$email = $_POST['email'];
$password = $_POST['password'];
if (empty($email) || empty($password))
{
    header('Location: error.html');
}


	$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$con)
    		echo "Error!";
    		
    		$password = md5($password);
    $result = mysqli_query($con,"SELECT UserID FROM uidebugg_wishingwell.User WHERE email='$email' AND hashPswd='$password'");
	if (!$result)
	{
		header('Location: error.html');
	}
	else
	{
		$row = mysqli_fetch_array($result);

		if (!$row || $row==" " || $row=="")
		{
			header('Location: error.html');
		}
		else
		{
           $sVar=$row['UserID'];
           session_id( $sVar );
           session_start();
		   header('Location: userHome.php');

		}
	}


?>