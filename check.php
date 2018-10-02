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
		{
			if(isset($_GET['id']))
			{
				$id 	= $_GET['id'];
				$a_sql	= "SELECT destinations.destination_name FROM destinations, move_history WHERE destinations.destination_id = move_history.destination_id AND move_history.docket_id = '$id' ORDER BY move_history.date, move_history.time";

				$query		= $connection->query($a_sql);	
				if($query)
				{
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
						echo "আপনার ডকেটটি <b>".$row['destination_name']."</b> এর নিকট গিয়েছে এবং বর্তমানে <b>";
						$row = $query -> fetch_assoc();
						echo $row['destination_name']."</b> এর নিকট রয়েছে।";
					}
					else
					{
						echo "আপনার ডকেটটি <b>";
						for ($i=0; $i < $row_count-2; $i++) 
						{ 
							echo $row['destination_name']."</b>";
							if($i < $row_count-3)
								echo ", ";
							$row = $query -> fetch_assoc();
						}
						echo " ও <b>".$row['destination_name']."</b> এর নিকট গিয়েছে এবং বর্তমানে <b>";
						$row = $query -> fetch_assoc();
						echo $row['destination_name']."</b> এর নিকট রয়েছে।";
					}

					die();
				}
			}
			else
			{
				echo "Invalid request.";
			}
		}
	}
		//--------------handeling searching action-------------------

	//--------------handeling actions-------------------

	?>


	<!DOCTYPE html>
	<html>
	<head>
		<title>Docket check || ES, RUET</title>
	</head>
	<body>
		<input type="text" name="search" id="search" placeholder="Enter docket number...">
		<button id="btn" onclick="search()">Search</button>

		<script type="text/javascript">
			
			function search() {
				var value = document.getElementById("search").value;

				window.location.href = "check.php?action=search&id="+value;

				//console.log(value);
			}

		</script>
	</body>
	</html>

	