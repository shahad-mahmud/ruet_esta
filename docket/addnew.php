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

			ডকেট সংক্রান্ত তথ্য
			<hr>
			<label for="file_id">ডকেট নং</label>
			<input type="text" name="file_id" id="file_id" placeholder="যেমনঃ ১২৩৪"><br>
			<div id="date_given" style="display: block;">
				<label for="rcv_date">তারিখ</label>
				<input type="text" name="rcv_date" id="rcv_date" value="<?php echo date("F j, Y"); ?>" disabled style= "background-color: inherit; border: none; outline: none;">
				<button type="button" name="change_date" onclick="getdate()">Change</button><br>
			</div>
			<div id="get_date" style="display: none;">
				<label for="rcv_date">তারিখ</label>
				<input type="date" name="rcv_date" id="rcv_date">
				<button type="button" name="show_date" onclick="showdate()">Cancel</button><br>
			</div>
			<hr>
			জমাদানকারীর তথ্য
			<hr>
			<label for="depo_name">নাম</label>
			<input type="text" name="depo_name" id="depo_name" placeholder="যেমনঃ সাব্বির আহমেদ"><br>

			<label for="depo_address">ঠিকানা</label>
			<input type="text" name="depo_address" id="depo_address" placeholder="যেমনঃ তালাইমাড়ি, রাজশাহী"><br>

			<label for="depo_no">ফোন নম্বর</label>
			<input type="text" name="depo_no" id="depo_no" placeholder="যেমনঃ ০১XXXXXXXX"><br>

			<label for="depo_email">ইমেইল</label>
			<input type="text" name="depo_email" id="depo_email" placeholder="যেমনঃ abc@xyz.com"><br>

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

		function getdate() {
			var date_given	= document.getElementById("date_given");		//get date_given section
			var get_date 	= document.getElementById("get_date");	//get get_date section

			date_given.style.display = "none";						//don't display first section
			get_date.style.display = "block";						//display second section
		}

		function showdate() {
			var date_given	= document.getElementById("date_given");		//get date_given section
			var get_date 	= document.getElementById("get_date");	//get get_date section

			date_given.style.display = "block";						//don't display first section
			get_date.style.display = "none";						//display second section

			get_date.value 	=	date_given.value;
		}

	</script>
</body>
</html>



<?php //php else ends here
	} 
?>
