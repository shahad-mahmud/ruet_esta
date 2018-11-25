<!DOCTYPE html>
<html>
<head>
	<title>Docket check || ES, RUET</title>
	<link rel="stylesheet" type="text/css" href="check.css">
	<link rel="stylesheet" type="text/css" href="header.css">
</head>
<body>
	<div class="header">
		<img onclick="window.location.href = 'index.php';" style="cursor: pointer;" src="logo.png" alt="logo">
		<h1> <b> Establishment Department </b> </h1>
		<h2 onclick="window.location.href = 'index.php';" style="cursor: pointer;"> Rajshahi University of Engineering and Technology </h2>
	</div>
<?php //check if logged into docket or not
	session_start();
	require("/opt/lampp/htdocs/ruet_esta/db.php");
	date_default_timezone_set("Asia/Dhaka");
	$date = date("Y/m/d");
	$time = date("H:i:sa"); 

	//--------------handeling actions-------------------
	if(isset($_GET['action']))
	{
		//--------------handeling searching action-------------------
		if($_GET['action'] == "search")
		{ ?>

		<div id="search_div">

			<?php if(isset($_GET['id']))
			{
				$id 	= $_GET['id'];
				$a_sql	= "SELECT destinations.destination_name FROM destinations, move_history WHERE destinations.destination_id = move_history.destination_id AND move_history.docket_id = '$id' ORDER BY move_history.date, move_history.time";

				$sql = "SELECT docket.reveiving_time, docket.reveiving_day, docket.receiving_date FROM `docket` WHERE docket.docket_id = '$id'";



				$query		= $connection->query($a_sql);	
				$query2		= $connection->query($sql);	
				if($query && $query2)
				{
					$row2 = $query2 -> fetch_assoc();
					echo "ডকেট নংঃ ".$id."<br>";
					echo "জমাদানের সময়ঃ ".$row2['reveiving_time']."<br>";
					echo "জমাদানের তারিখঃ ".$row2['receiving_date']."<br>";
					$row_count = mysqli_num_rows($query);
					$query -> data_seek(0);
					$row = $query -> fetch_assoc();

					if($row_count == 0)
					{
						echo "দুঃখিত! এই নম্বরের কোন ডকেট পাওয়া যায়নি। ";
					}
					else if($row_count == 1)
					{
						echo "আপনার ডকেটটি <b>".$row['destination_name']."</b> এর নিকট রয়েছে।";
					}
					else if($row_count == 2)
					{
						echo "আপনার ডকেটটি যথাক্রমে <b>".$row['destination_name']."</b> এর নিকট গিয়েছে এবং বর্তমানে <b>";
						$row = $query -> fetch_assoc();
						echo $row['destination_name']."</b> এর নিকট রয়েছে।";
					}
					else
					{
						echo "আপনার ডকেটটি যথাক্রমে <b>";
						for ($i=0; $i < $row_count-2; $i++) 
						{ 
							echo $row['destination_name']."</b>";
							if($i < $row_count-3)
								echo "</b>, <b>";
							$row = $query -> fetch_assoc();
						}
						echo " ও <b>".$row['destination_name']."</b> এর নিকট গিয়েছে এবং বর্তমানে <b>";
						$row = $query -> fetch_assoc();
						echo $row['destination_name']."</b> এর নিকট রয়েছে।";
					}
					?>
					<div style="">
						<button onclick="window.location.href = 'check.php';">Seach another</button>
					</div>
					<?php
					die();
				}
			}
			else
			{
				echo "Invalid request.";
			} ?>

		</div>

		<?php }
	}
		//--------------handeling searching action-------------------

	//--------------handeling actions-------------------

	?>




		<div id="main">
			<input type="text" name="search" id="search" placeholder="Enter docket number...">
			<button id="btn" onclick="search()">Search</button>
		</div>

		<script type="text/javascript">

			var input = document.getElementById("search");
			input.addEventListener("keyup", function(event) {
			    event.preventDefault();
			    if (event.keyCode === 13) {
			        document.getElementById("btn").click();
			    }
			});
			
			function search() {
				var value = document.getElementById("search").value;

				window.location.href = "check.php?action=search&id="+value;

				//console.log(value);
			}

		</script>
	</body>
	</html>

	