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
	<title>Add New | Docket || ES RUET</title>
</head>
<body>
	<form action="" method="post">
		<div id="first" style="display: block;">
			<input type="text" name="test">
			<br>
			<button type="reset">Reset</button>
			<button type="button" onclick="secondsection()">Next</button>
		
		</div>

		<div id="second" style="display: none;">
			<button type="button" onclick="firstsection()">Previous</button>
		</div>
	</form>

	<script type="text/javascript">
		function secondsection() {
			var first	= document.getElementById("first");		//get first section
			var second 	= document.getElementById("second");	//get second section

			first.style.display = "none";						//don't display first section
			second.style.display = "block";						//display second section
		}

		function firstsection() {
			var first	= document.getElementById("first");		//get first section
			var second 	= document.getElementById("second");	//get second section

			first.style.display = "block";						//don't display first section
			second.style.display = "none";						//display second section
		}

	</script>
</body>
</html>



<?php //php else ends here
	} 
?>