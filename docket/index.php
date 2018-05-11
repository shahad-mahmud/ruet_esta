<?php //check if logged into docket or not
	session_start();

if( !(isset($_SESSION['uname']) && $_SESSION['logged'] == "TruE" && $_SESSION['post'] == "docket" )) //logged in for docket??
{
	echo "Please login first";
}
else{ 
?>


<!DOCTYPE html>
<html>
<head>
	<title>Docket || ES RUET</title>
</head>
<body>
<a href="addnew.php">Add new</a>
</body>
</html>



<?php //php else ends here
	} 
?>