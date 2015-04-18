<?php
// Fill up array with names
$a[]="";

// get the q parameter from URL
$q=$_REQUEST["q"]; $hint="";

    $con = mysqli_connect('engr-cpanel-mysql.engr.illinois.edu', 'uidebugg_root', 'root1','uidebugg_wishingwell');
    $query = "SELECT email FROM User where email LIKE '".$q."%' ";
    $result = mysqli_query($con, $query );

	if(!$result){
		echo "Error";
	}
	else{
	    while($row = mysqli_fetch_array($result)){
	        $a[]=$row['email'];
	    }
	}
// lookup all hints from array if $q is different from ""
if ($q !== "")
{ $q=strtolower($q); $len=strlen($q);
    foreach($a as $name)
    { if (stristr($q, substr($name,0,$len)))
    { if ($hint==="")
    { $hint=$name; }
    else
    { $hint .= ", $name"; }
    }
    }
}

// Output "no suggestion" if no hint were found
// or output the correct values
echo $hint==="" ? "no suggestion" : $hint;
?>