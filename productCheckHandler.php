<?php

	session_start();
	$user = session_id();
	if($user == -1){
	    exit();
	}
	session_id($user);

    $wishid = $_POST['wishlistID'];
    $productid = $_POST['productID'];
    $eventid=$_SESSION['EventID'];
    $_SESSION['EventID']=$eventid;
    
    if (empty($wishid) || empty($productid))
    {
    	echo "Here was I";
        header('Location: friendEventDetails.html');
    }

    else
    {
    
    		
	    $con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
	    if(!$con)
	        echo "Error!";
	    else
	    {
	    
	    	$query = "UPDATE giftsA SET Done=1, doneBy=$user WHERE ProductID=$productid AND WishlistID=$wishid ";
	
		    $result = mysqli_query($con, $query);
		
		    $str = "Location: friendEventDetails.php?".$eventid;
		    header($str);
	    }
    }
?>

