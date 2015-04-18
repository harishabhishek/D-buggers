<html>
<head>
</head>
<body>

<?php

	echo "This is a mySQL and PHP test on cPanel";
	$con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1');
	if(!$con)
		echo "Error!";
	$result = mysqli_query($con,"SELECT EventID as id FROM uidebugg_wishingwell.Celebrating");
	
	while($row = mysqli_fetch_array($result)){
	
		echo "<p>".$row['id']."</p>";
	}
	

?>
</body>
</html>

