<?php



/*session_start();
$link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}
$userid = session_id();
echo $userid;*/

/*if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST["Event"] == NULL || $_POST["Description"] == NULL || $_POST["Date1"] == NULL)
    {
        die('invalid entry' .mysqli_error($link));
        mysqli_close($link);

    }
    else
    {
        if($_POST["Date2"] == NULL)
            $date2 = test_input($_POST["Date1"]);
        else
            $date2 = test_input($_POST["Date2"]);


        $name = test_input($_POST["Event"]);
        $description = test_input($_POST["Description"]);
        $date1 = test_input($_POST["Date1"]);
        $sql1 = "SELECT MAX(EventID) as ID FROM Event";
        $result = mysqli_query($link,$sql1);
        $row = array();
        $row = mysqli_fetch_array($result);
        $eventid = $row['ID']+1;
        $sql3 = "INSERT INTO Event(EventID, Description, Name, StartDate, EndDate) VALUES('$eventid','$description','$name','$date1', '$date2')";
        $sql5 = "INSERT INTO Celebrating(UserID,EventID) VALUES('$userid','$eventid')";
        mysqli_query($link,$sql3);
        mysqli_query($link,$sql4);
        mysqli_query($link,$sql5);
        mysqli_close($link);
    }
}



function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
} */
?>