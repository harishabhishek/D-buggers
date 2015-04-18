<?php


$a="";
$his;

$q=$_REQUEST["q"];
$mine = $_REQUEST["v"];

$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
$query = "SELECT email, userID FROM User where email LIKE '".$q."' ";
$result = mysqli_query($con, $query );

if(!$result){

}
else{
	while($row = mysqli_fetch_array($result)){
	    $a=$row['email'];
	    $his=$row['userID'];
	}
}

if($a === "")
    echo "Invalid Email Address. Make sure that the Email is correct";
else{


    $query = "Insert Into requestReceived VALUES ($his, $mine)";

    $result = mysqli_query($con, $query);
    echo "The Friend Request was successfully sent :)";
}

?>