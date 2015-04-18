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
	
    $productTemp=mysqli_real_escape_string($link,$_POST['productName']);
    $lin=mysqli_real_escape_string($link,$_POST['productLink']);
	
        $product=preg_replace('/[^A-Za-z0-9\-\(\) ]/', '', $productTemp);
  	if (empty($product) && empty($lin))
	{
			$_SESSION['EventID']=$eventid;
			
			header('Location: updateWishlistError.php?'.$eventid);
	
	}
	else
	{
	
	if (!empty($product))
	{
		$result= "UPDATE Product SET name='$product'
			WHERE ProductID='$productid'";
		mysqli_query($link,$result);
		$_SESSION['EventID']=$eventid;
		header('Location: updateWishlistSuccess.php?'.$eventid);

	}
	
	if (!empty($lin))
	{
		$result2= "UPDATE Product SET Link='$lin'
			WHERE ProductID='$productid'";
		mysqli_query($link,$result2);
		$_SESSION['EventID']=$eventid;
		header('Location: updateWishlistSuccess.php?'.$eventid);

	}
  	
  	}
  	
  	}
  	
	
?>