<?php //check if logged into docket or not
	session_start();

if( !(isset($_SESSION['uname']) && $_SESSION['logged'] == "TruE" && $_SESSION['post'] == "docket" )) //logged in for docket??
{
	echo "Please login first";
}
else{
	require("/opt/lampp/htdocs/ruet_esta/db.php");

	$empID		= $_SESSION['empID'];

	$sql		= "SELECT `emp_name` FROM `esta_employees` WHERE `emp_id` = '$empID'";
	$query		= $connection->query($sql);						//execute the query
	$row 		= $query->fetch_assoc(); 						//data reading from database
	$empName 	= $row['emp_name'];

	date_default_timezone_set("Asia/Dhaka");					//set time zone to dhaka


	//**********Form handeling******************
	$docket_id			=	"";
	$depositor_name		=	"";
	$depositor_address	=	"";
	$depositor_phone	=	"";
	$depositor_email	=	"";
	$rev_date			=	"";

	if(isset($_POST['submit']))
	{
		$docket_id			=	$_POST['docket_id'];
		$depositor_name		=	$_POST['depositor_name'];
		$depositor_address	=	$_POST['depositor_address'];
		$depositor_phone	=	$_POST['depositor_phone'];
		$depositor_email	=	$_POST['depositor_email'];
		$rcv_date			=	$_POST['rcv_date'];
		$timestamp 			= 	strtotime($rcv_date);
		$day 				= 	date('l', $timestamp);
		$time 				= 	date("h:i:sa");

		//insert into the receiver table
		$sql	= "INSERT INTO `received_form` (`name`, `address`, `phone_no`, `email_address`) VALUES ('$depositor_name','$depositor_address','$depositor_phone','$depositor_email')"; //query to insert into the receiver table
		$query	= $connection->query($sql);					//execute the query

		if($query)
		{
			$sql	= "SELECT `rcv_id` FROM `received_form` ORDER BY `rcv_id` DESC"; //query to select last id from the receiver table
			$query	= $connection->query($sql);						//execute the query
			$row = $query->fetch_assoc(); 							//set the pointer to the top
			$rcv_id = $row['rcv_id'];								//the id
			//echo $rcv_id;

			$sql	= "INSERT INTO `docket`(`docket_id`, `receiving_date`, `reveiving_day`, `reveiving_time`, `rcv_id`, `emp_id`,`on_move`) VALUES ('$docket_id','$rcv_date','$day','$time','$rcv_id','$empID',0)"; //query to insert into the receiver table
			$query	= $connection->query($sql);						//execute the query

			if($query)
			{
				$date = date("Y/m/d");
				$sql	= "INSERT INTO `move_history`(`docket_id`, `date`, `time`, `destination_id`) VALUES ('$docket_id','$date','$time',10)"; //query to insert into the move history table
				$query	= $connection->query($sql);						//execute the query

				if($query)
				{
					//echo "sfdsdfsdfsdfsdf".mysqli_error($connection)."\n";
				}
				else
				{
					//echo "neeee\n";
				}

				header("Location: index.php");
				
				//echo "Dhukche!! baccha hobe".mysqli_error($connection)."\n";
			}
			else
			{
				//echo "dhuke nai! baccha hobe na.".mysqli_error($connection)."\n";

			}
		}
		else
		{
			//echo "dhuke nai! baccha hobe na.";
			$sql	= "DELETE FROM `received_form` WHERE `rcv_id` = '$rcv_id'"; //query to delet record from the receiver table
			$query	= $connection->query($sql);						//execute the query
		}
	}
	//**********Form handeling******************
?>


<!DOCTYPE html>
<html>
<head>
	<title>Add New | Docket || ES RUET</title>

	<link rel="stylesheet" href="addnew.css">
</head>
<body>

<div class="header">
  <img src="logo.png" alt="logo">
  <h1> <b> Establishment Department </b> </h1>
    <h2> Rajshahi University of Engineering and Technology </h2>
  </div>

  <div class="nav">
    <ul>
      <li> <a href="#">log out </a> </li>
    </ul>
  </div>

  <div class="container">
	<form action="" method="post" enctype="multipart/form-data">
		<div id="first" style="display: block;">

			<b> ডকেট সংক্রান্ত তথ্য </b>
			<hr>
			<label for="docket_id">ডকেট নং</label>
			<input type="text" name="docket_id" id="docket_id" placeholder="যেমনঃ ১২৩৪" required><br>
			
			জমাদানকারীর তথ্য
			<hr>
			<label for="depositor_name">নাম</label>
			<input type="text" name="depositor_name" id="depositor_name" placeholder="যেমনঃ সাব্বির আহমেদ"><br>

			<label for="depositor_address">ঠিকানা</label>
			<input type="text" name="depositor_address" id="depositor_address" placeholder="যেমনঃ তালাইমাড়ি, রাজশাহী"><br>

			<label for="depositor_phone">ফোন নম্বর</label>
			<input type="text" name="depositor_phone" id="depositor_phone" placeholder="যেমনঃ ০১XXXXXXXX"><br>

			<label for="depositor_email">ইমেইল</label>
			<input type="text" name="depositor_email" id="depositor_email" placeholder="যেমনঃ abc@xyz.com"><br>

			<b> joma grohon </b>
			<hr>
			<label for="emp_name">নাম</label>	
			<input type="text" name="emp_name" id="emp_name" value="<?php echo $empName; ?>" disabled><br>
			<label for="rcv_date">তারিখ</label>
			<input type="date" name="rcv_date" id="rcv_date" value="<?php echo date('Y-m-d'); ?>" style= "background-color: inherit; border: none; outline: none;">
			<!-- <button type="button" name="change_date" id="change_date" onclick="getdate()">Change</button>
			<button type="button" name="cancel_update" id="cancel_update" onclick="cancel()" style="display: none">Cancel</button> <br> -->
			

			<br>
			<button type="reset" style=" background-color: #f44336;">Reset</button>
			<!-- <button type="button" onclick="secondsection()">Next</button> -->
			<button type="submit" name="submit">Submit</button>
		</div>

		<!-- <div id="second" style="display: none;">
			<button type="button" onclick="firstsection()">Previous</button>
		</div> -->
	</form>
	</div>

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

		// function getdate() {
		// 	var date_given	= document.getElementById("rcv_date");		//get date_given section
		// 	var change_btn	= document.getElementById("change_date");		//get change_btn button
		// 	var cancel_btn	= document.getElementById("cancel_update");		//get date_given section
		// 	var today = new Date();
			
		// 	var dd = today.getDate();
		// 	var mm = today.getMonth()+1; //January is 0!
		// 	var yyyy = today.getFullYear();

		// 	if(dd<10) {
		// 	    dd = '0'+dd
		// 	} 

		// 	if(mm<10) {
		// 	    mm = '0'+mm
		// 	} 

		// 	today = yyyy + '-' + mm + '-' + dd;

		// 	change_btn.style.display = "none";						//don't display first section
		// 	cancel_btn.style.display = "inline-block";						//display second section

		// 	date_given.type = "date";
		// 	date_given.value = today;
		// 	date_given.disabled = false;
		// 	date_given.style.border = "";
		// }

		// //cancel date changing option
		// function cancel() {
		// 	var date_given	= document.getElementById("rcv_date");		//get date_given section
		// 	var change_btn	= document.getElementById("change_date");		//get change_btn button
		// 	var cancel_btn	= document.getElementById("cancel_update");		//get date_given section
		// 	var today = new Date();
			
		// 	var dd = today.getDate();
		// 	var mm = today.getMonth()+1; //January is 0!
		// 	var yyyy = today.getFullYear();

		// 	if(dd<10) {
		// 	    dd = '0'+dd
		// 	} 

		// 	if(mm<10) {
		// 	    mm = '0'+mm
		// 	} 

		// 	today = yyyy + '-' + mm + '-' + dd;

		// 	change_btn.style.display = "inline-block";						//don't display first section
		// 	cancel_btn.style.display = "none";						//display second section

		// 	date_given.type = "date";
		// 	date_given.value = today;
		// 	date_given.disabled = true;
		// 	date_given.style.border = "none";
		// }
	</script>
</body>
</html>



<?php //php else ends here
	} 
?>
