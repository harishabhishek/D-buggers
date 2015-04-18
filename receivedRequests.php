<?php

    $userId = $_POST['userId'];
    $friendId = $_POST['friendId'];
    if (empty($userId) || empty($friendId))
    {
        header('Location: error.html');
    }

    else
    {
    $con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    if(!$con)
        echo "Error!";
    else
    {
    $result = mysqli_query($con,"INSERT INTO friends VALUES ($userId, $friendId) ");
    $result = mysqli_query($con,"INSERT INTO friends VALUES ($friendId, $userId) ");
    $result = mysqli_query($con, "DELETE FROM requestReceived WHERE requestReceived.userId = $userId AND requestReceived.friendId = friendId");

    header('Location: addFriends.php');
    
    }
    }
?>
