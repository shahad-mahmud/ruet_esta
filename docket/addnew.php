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
			<label for="rcv_date">তারিখ</label>
			<input type="text" name="rcv_date" id="rcv_date" value="<?php echo date('m/d/Y'); ?>" disabled style= "background-color: inherit; border: none; outline: none;">
			<button type="button" name="change_date" id="change_date" onclick="getdate()">Change</button>
			<button type="button" name="cancel_update" id="cancel_update" onclick="cancel()" style="display: none">Cancel</button> <br>
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
			var date_given	= document.getElementById("rcv_date");		//get date_given section
			var change_btn	= document.getElementById("change_date");		//get change_btn button
			var cancel_btn	= document.getElementById("cancel_update");		//get date_given section
			var today = new Date();
			
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
			    dd = '0'+dd
			} 

			if(mm<10) {
			    mm = '0'+mm
			} 

			today = yyyy + '-' + mm + '-' + dd;

			change_btn.style.display = "none";						//don't display first section
			cancel_btn.style.display = "inline-block";						//display second section

			date_given.type = "date";
			date_given.value = today;
			date_given.disabled = false;
			date_given.style.border = "";
		}

		function cancel() {
			var date_given	= document.getElementById("rcv_date");		//get date_given section
			var change_btn	= document.getElementById("change_date");		//get change_btn button
			var cancel_btn	= document.getElementById("cancel_update");		//get date_given section
			var today = new Date();
			
			var dd = today.getDate();
			var mm = today.getMonth()+1; //January is 0!
			var yyyy = today.getFullYear();

			if(dd<10) {
			    dd = '0'+dd
			} 

			if(mm<10) {
			    mm = '0'+mm
			} 

			today = yyyy + '-' + mm + '-' + dd;

			change_btn.style.display = "inline-block";						//don't display first section
			cancel_btn.style.display = "none";						//display second section

			date_given.type = "date";
			date_given.value = today;
			date_given.disabled = true;
			date_given.style.border = "none";
		}
	</script>
</body>
</html>



<?php //php else ends here
	} 
?>
