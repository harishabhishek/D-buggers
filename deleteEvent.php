<?php
session_start();
$link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
$eventid=$_SESSION['EventID'];
$sql1 = "SELECT WishlistID FROM hasA WHERE EventID = $eventid";
$result1 = mysqli_query($link, $sql1);
while($row = mysqli_fetch_array($result1))
{
	$myvar1 = $row['WishlistID'];
	$sql2 = "SELECT ProductID FROM giftsA WHERE WishlistID = $myvar1";
	$sql3 = "SELECT GestureID FROM doesA WHERE WishlistID = $myvar1";
	$result2 = mysqli_query($link, $sql2);
	$result3 = mysqli_query($link, $sql3);
	while($row2 = mysqli_fetch_array($result2))
	{
		$myvar2 = $row2['ProductID'];
		$sql4 = "DELETE FROM Product WHERE ProductID = $myvar2";
		mysqli_query($link, $sql4);
	}
	while($row3 = mysqli_fetch_array($result3))
	{
		$myvar3 = $row3['GestureID'];
		$sql5 = "DELETE FROM Gesture WHERE GestureID = $myvar3";
		mysqli_query($link, $sql5);
	}
	$sql6 = "DELETE FROM giftsA WHERE WishlistID = $myvar1";
	$sql7 = "DELETE FROM doesA WHERE WishlistID = $myvar1";
	mysqli_query($link, $sql6);
	mysqli_query($link, $sql7);
}
$sql8 = "DELETE FROM hasA WHERE EventID = $eventid";
$sql9 = "DELETE FROM Event WHERE EventID = $eventid";
$sql10 = "DELETE FROM Celebrating WHERE EventID = $eventid";
mysqli_query($link, $sql8);
mysqli_query($link, $sql9);
mysqli_query($link, $sql10);
mysqli_close($link);
header('Location: userHome.php');
?>
