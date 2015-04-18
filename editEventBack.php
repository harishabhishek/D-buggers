<?php
 session_start();
	$user = session_id();
	$gestureid=$_SESSION['GestureID'];
	$ID=$_SESSION['EventID'];
    $link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    	if(!$link)
    		echo "Error!";
 else{
    $sql = "SELECT * FROM Event WHERE EventID = $ID ";
    $result = mysqli_query($link, $sql);
if(!$result){
echo "fail";
}
else{

    $row = mysqli_fetch_array($result);
}
    $name_old = $row["Event"];
    $description_old = $row["Description"];
    $date1_old = $row["StartDate"];
    $date2_old = $row["EndDate"];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {


        if ($_POST["Event"] == NULL && $_POST["Description"] == NULL && $_POST["Date1"] == NULL && $_POST["Date2"] == NULL)
        {
            echo "Nothing Changed: ";
        exit();

    }
        else 
        {
        if($_POST["Event"] != NULL) {
            if ($_POST["Event"] == $name_old)
            {
                nothing();

            }
            else {
                $name = test_input($_POST["Event"]);
                $sql1 = "UPDATE Event SET Name = '$name' WHERE EventID = '$ID'";
                mysqli_query($link, $sql1);
            }

        }
        if($_POST["Description"] != NULL) {
            if ($_POST["Description"] == $description_old)
            {
                echo "Nothing changed!";
                exit();
            }
            else {
                $description = test_input($_POST["Description"]);
                $sql2 = "UPDATE Event SET Description = '$description' WHERE EventID = '$ID'";
                mysqli_query($link, $sql2);
            }
        }
        if($_POST["Date1"] != NULL) {
            if ($_POST["Date1"] == $date1_old) {
                echo "Nothing changed!";
                exit();
            } 
            else if ($_POST["Date2"] ==NULL && $_POST["Date1"] > $date2_old) {
                echo "invalid Start Date";
                exit();

            } 
            else {
                $date1 = test_input($_POST["Date1"]);
                $sql3 = "UPDATE Event SET StartDate = '$date1' WHERE EventID = '$ID'";
                mysqli_query($link, $sql3);

            }
        }
       if($_POST["Date2"] != NULL) {
            if ($_POST["Date2"] == $date2_old) {
                echo "Nothing changed!";
                exit();
            } 
            else if ($_POST["Date1"] == NULL && $_POST["Date2"] < $date1_old) {
                echo "invalid End Date";
                exit();
            }
            else {
                $date2 = test_input($_POST["Date2"]);
                $sql4 = "UPDATE Event SET EndDate = '$date2' WHERE EventID = '$ID'";
                mysqli_query($link, $sql4);

            }
        }
        }
        mysqli_close($link);
        header('Location: userHome.php');
    }

}


function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
	
?>