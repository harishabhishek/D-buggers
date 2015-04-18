<?php
session_start();
$user = session_id();
if($user == -1){
    exit();
}
session_id($user);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$productid = substr($actual_link, strrpos($actual_link, '?') + 1);
$ID= $_SESSION['EventID'];

?>
<html lang="en">
<head>
<title>Event and Wishlist</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<link rel="stylesheet" href="inc/reset.css" media="all">
<link rel="stylesheet" href="inc/global.css" media="all">
<link rel="stylesheet" href="inc/mobile.css" media="all and (max-width:767px)">
<link rel="stylesheet" href="inc/desktop.css" media="all and (min-width:768px)">
<link rel="stylesheet" type="text/css" href="./jquery.datetimepicker.css">
<!--[if (lt IE 9)&(!IEMobile)]><link rel="stylesheet" href="inc/desktop.css" media="all"><![endif]-->
<!--[if lt IE 9]><script src="inc/html5.js"></script><![endif]-->
<script src="inc/jquery.min.js"></script>
<script src="inc/init.js"></script>
<script src="jquery.js"></script>
<script src="jquery.datetimepicker.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css">
    <script>
        $(function() {
            var availableTags = [
                "Birthday party",
                "Game night",
                "Wedding"
            ];
            $( "#event" ).autocomplete({
                source: availableTags
            });
        });
    </script>
</head>
<body>
<header class="header">
    <div class="wrapper cf">
        <p class="logo"><a href="index.html" title="[Go to homepage]"><img src="design/logo.png" alt=""></a></p>
        <nav class="nav cf" id="nav">
            <ul>
                <li><a href="index.html">Homepage</a></li>
                <li><a href="UserHome.html">My account</a></li>
            </ul>
        </nav>
    </div>
</header>
<div class="main-subpage">
    <div class="wrapper">
        <h1>Event and Wishlist</h1>
    </div>
</div>

<div class="content">
    <div class="wrapper cf">
        <p class="nomt cf"> <img src="images/image-01.png" alt="" class="f-left">  </p>
        <h2>Edit Event</h2>
        <!--suppress HtmlUnknownTarget -->
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <ul>
                <li>
                    <div class="ui-widget">
                        <label for="event">Event:</label>
                        <label><input id="event" name="Event" type="text" size="35" class="input-text">
                        </label>
                    </div>

                </li>
                <li>
                    <label>Start Date:</label>
                    <label>
                        <input name="Date1" id="datetimepicker1" type="text" size="35" class="input-text" >
                    </label>
                </li>
                <li>
                    <label>End Date:</label>
                    <label>
                        <input name="Date2" id="datetimepicker2" type="text" size="35" class="input-text" >
                    </label>
                </li>
                <li>
                    <label>Description:</label>
                    <label><textarea name="Description" cols="85" rows="7" class="input-textarea"></textarea></label>
                </li>
                <li>
                    <input type="submit" value="Submit" class="input-submit">
                </li>

            </ul>
        </form>
    </div>
</div>

</body>
</html>
<?php
$link = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
if (mysqli_connect_errno()) {
    echo "Database connection failed: " . mysqli_connect_error();
}
else{
$sql = "SELECT Event, Description, StartDate, EndDate FROM Event WHERE EventID = '$ID' ";
$result = mysqli_query($link,$sql);
$row = mysqli_fetch_array($result);
$name_old = $row[0];
$description_old = $row[1];
$date1_old = $row[2];
$date2_old = $row[3];
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    if ($_POST["Event"] == NULL && $_POST["Description"] == NULL && $_POST["Date1"] == NULL && $_POST["Date2"] == NULL)
    {
        echo "Nothing Changed: ";
        exit();

    }
    else if($_POST["Event"] != NULL) {
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
    else if($_POST["Description"] != NULL) {
        if ($_POST["Description"] == $description_old)
        {
            echo "Nothing changed!";

            exit();
        }
        else {
            $description = test_input($_POST["Description"]);
            $sql2 = "UPDATE Event SET Description = '$description' WHERE EventID = '$ID'";
            mysql_query($link, $sql2);
        }
    }
    else if($_POST["Date1"] != NULL) {
        if ($_POST["Date1"] == $date1_old) {
            echo "Nothing changed!";

            exit();
        } else if ($_POST["Date1"] > $date2_old) {
            echo "invalid Start Date";

            exit();

        } else {
            $date1 = test_input($_POST["Date1"]);
            $sql3 = "UPDATE Event SET StartDate = '$date1' WHERE EventID = '$ID'";
            mysql_query($link, $sql3);

        }
    }
    else if($_POST["Date2"] != NULL) {
        if ($_POST["Date2"] == $date2_old) {
            echo "Nothing changed!";
            mysqli_close($link);
            exit();
        } else if ($_POST['Date2'] < $date1_old) {
            echo "invalid End Date";
            mysqli_close($link);
            exit();
        } else {
            $date2 = test_input($_POST["Date2"]);
            $sql4 = "UPDATE Event SET EndDate = '$date2' WHERE EventID = '$ID'";
            mysql_query($link, $sql4);

        }
    }

    mysqli_close($link);
    header('Location: EventDetails.php');
}

}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>