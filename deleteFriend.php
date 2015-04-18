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

    $result = mysqli_query($con, "DELETE FROM friends WHERE friends.userId = $userId AND friends.friendId = $friendId");
    $result = mysqli_query($con, "DELETE FROM friends WHERE friends.userId = $friendId AND friends.friendId = $userId");
    
    header('Location: addFriends.php');
    }
    }
?>
