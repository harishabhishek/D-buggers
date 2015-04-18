<?php
// Fill up array with names
$a[]="";

// get the q parameter from URL
$q=$_REQUEST["q"]; $hint="";

    $con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    $query = "SELECT Distinct name, Link FROM Product where name LIKE '".$q."%' Limit 10 ";
    $result = mysqli_query($con, $query );

	if($result){
	    while($row = mysqli_fetch_array($result)){
	        $a[]= $row['name']."<br>"."<a href='".$row['Link']."' target='_blank'>".$row['Link']."</a>";
	        
	    }
	}
// lookup all hints from array if $q is different from ""
if ($q !== "")
{ $q=strtolower($q); $len=strlen($q);
    foreach($a as $name)
    { if (stristr($q, substr($name,0,$len)))
	    { 
	    	if ($hint==="")
		    { 
		    	$hint=$name; 
		    }
	    	else
	    	{
	    		$hint .= "<br><br>$name"; 
	    	}
	    }	
    }
}

// Output "no suggestion" if no hint were found
// or output the correct values

echo $hint==="" ? "No Suggestion" : $hint;
?>

