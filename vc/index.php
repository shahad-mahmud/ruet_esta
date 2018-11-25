<?php //check if logged into docket or not
	session_start();

if( !(isset($_SESSION['uname']) && $_SESSION['logged'] == "TruE" && $_SESSION['post'] == "vc" )) //logged in for docket??
{
	echo "Please login first";
}
else{ 

	require("/opt/lampp/htdocs/ruet_esta/db.php");
	date_default_timezone_set("Asia/Dhaka");
	$date = date("Y/m/d");
	$time = date("H:i:sa");

	$sql		= 	"
					SELECT
						move_history.history_id,
					    move_history.docket_id,
					    file_holder.file_holder_name,
					    destinations.destination_name,
					    move_history.date,
					    move_history.time,
					    move_history.if_received,
					    docket.sent_from
					FROM
					    move_history,
					    file_holder,
					    destinations,
					    docket
					WHERE
					    move_history.docket_id = docket.docket_id AND docket.file_holder_no = file_holder.file_holder_no AND move_history.sent_from = destinations.destination_id AND move_history.destination_id = 16
					ORDER BY
					    move_history.date
					DESC
					    ,
					    move_history.time
					DESC
				"; //sql for the table
	$sql_file	= "SELECT `file_holder_no`, `file_holder_name` FROM `file_holder`";
	$sql3 		= "SELECT * FROM `destinations` WHERE 1"; //sql for destinations.

	 	
	$data		= $connection->query($sql);						//execute the sql query
	$files 		= $connection->query($sql_file);				//execute the sql_file query
	$destinations = $connection->query($sql3);						//execute the sql3 
	$des 		= array();

	while ($row = $destinations -> fetch_assoc())  //get all destinations in a array
	{	
		$des[$row['destination_id']] = $row['destination_name'];
	}

	//--------------handeling actions-------------------
	if(isset($_GET['action']))
	{
		//--------------handeling conferming receive action-------------------
		if($_GET['action'] == "cr")
		{
			if(isset($_GET['ref']))
			{
				$id 	= $_GET['ref'];
				$a_sql	= "UPDATE `move_history` SET `if_received`=1 WHERE `history_id` = '$id'";

				if($connection->query($a_sql))
				{
					echo "success";
					header("Location: index.php");
					die();
				}
			}
			else
			{
				echo "Invalid request.";
			}
		}
		//--------------handeling conferming receive action-------------------

		//--------------handeling send action-------------------
		if($_GET['action'] == "send")
		{
			if(isset($_GET['ref']))
			{
				$ref = $_GET['ref'];
				if(isset($_GET['id']))
				{
					$id = $_GET['id'];
					$cs = $_GET['cs'];

					echo $cs;

					$sql		= "UPDATE `move_history` SET `if_received`='$ref' WHERE `history_id` = '$cs'";
					$sql2		= "INSERT INTO `move_history`(`docket_id`, `sent_from`, `destination_id`, `if_received`, `date`, `time`) VALUES ('$id', 16, '$ref', 0, '$date','$time' )";
					if($connection->query($sql) && $connection->query($sql2))
					{
						echo "success";
						header("Location: index.php");
						die();
					}
				}
				else
				{
					echo "Invalid request.";
				}
			}
			else
			{
				echo "Invalid request.";
			}
		}
		//--------------handeling send action-------------------
	}
	else
	{
		
	}
	//--------------handeling actions-------------------
?>


<!DOCTYPE html>
<html>
<head>
	<title>Assistant Register || ES RUET</title>

	<link rel="stylesheet" href="index.css">
</head>
<body>

 <div class="header">
  <img src="logo.png" alt="logo">
  <h1> <b> Establishment Department </b> </h1>
    <h2> Rajshahi University of Engineering and Technology </h2>
  </div>

  <div class="nav">
    <ul>
      <li> <a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/ruet_esta/logout.php">log out </a> </li>
    </ul>
  </div>

  
	<table>
		<thead>
			<tr>
				<th>Docket No.</th>
				<th>File Name</th>
				<th>Received from</th>
				<th>date</th>
				<th>time</th>		        	
				<th>Action</th>
			</tr>
		</thead>

		<tbody>

			<?php
				while($row=$data->fetch_assoc())
				{ ?>
					
					<tr> 
						<td> <?php echo $row['docket_id']; ?> </td>
						<td> <?php echo $row['file_holder_name']; ?> </td>
						<td> <?php echo $row['destination_name']; ?> </td>
						<td> <?php echo $row['date']; ?> </td>
						<td> <?php echo $row['time']; ?> </td>
						<td> 
							<?php 
								
								if($row['if_received'] == 0)
								{ ?>
									<button type="button" onclick="rcv('<?php echo $row['history_id']; ?>')">Confirm receive</button>
								<? }
								else if($row['if_received'] == 1)
								{ 

								// 	$info 	= $row['sent_from']; 
								// 	$ln 	= strlen($info);
								// 	$flag	= false;

								// 	for($i = 0; $i < $ln; $i = $i+5)
								// 	{
								// 		$sub  = substr($info, $i, 5);
								// 		$sub1 = substr($info, $i, 3);

								// 		if($sub1 == "12_")
								// 		{
								// 			$des_sub = substr($sub, 3, 2);
								// 			echo $des[$des_sub]." এর কাছে প্রেরিত";
								// 			$flag = true;
								// 			break;
								// 		}
								// 	}

									//if($flag == false ){
									?>
									
									<select name="send" id="send<?php echo $row['docket_id']; ?>" onchange="sendFunc('<?php echo $row['docket_id']; ?>', '<?php echo $row['history_id']; ?>')">
										
										<option disabled selected="true">Send to</option>
										<option value="10">ডকেট এন্ট্রি</option>
										<option value="11">সেকশন অফিসার</option>
										<option value="12">অ্যাসিস্ট্যান্ট রেজিস্টার</option>
										<option value="13">অ্যাডিশনাল রেজিস্টার</option>
										<option value="14">ডেপুটি রেজিস্টার</option>
										<option value="15">রেজিস্টার</option>

									</select>

								<?php // } 
							}
								else if($row['if_received'] > 1)
								{
									echo $des[$row['if_received']]." এর কাছে প্রেরিত";
								}

							?>
							

						</td> 
					</tr>

				<?php }
			?>
		</tbody>
	</table>

	<script type="text/javascript" charset="utf-8">
		function rcv(id)
		{
			id = decodeURI(id);
			id = encodeURI(id);

			window.location.href = "index.php?action=cr&ref="+id;
		}

		function sendFunc(id, h_id)
		{
			id = decodeURI(id);
			var elementID = "send"+id;
			id = encodeURI(id);


			var select = document.getElementById(elementID);
			var value = select.value;

			//console.log(elementID);
			//console.log(h_id);
			window.location.href = "index.php?action=send&ref="+value+"&id="+id+"&cs="+h_id; //cs = current status
		}
	</script>
</body>
</html>



<?php //php else ends here
	} 
?>