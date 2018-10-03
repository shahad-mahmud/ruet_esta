<?php //check if logged into docket or not
	session_start();

if( !(isset($_SESSION['uname']) && $_SESSION['logged'] == "TruE" && $_SESSION['post'] == "docket" )) //logged in for docket??
{
	echo "Please login first";
}
else{ 

	require("/opt/lampp/htdocs/ruet_esta/db.php");

	$sql		= "SELECT `docket_id`, `file_holder_no`, `on_move`, `sent_from` FROM `docket`"; //sql for the table
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
		//--------------handeling send action-------------------
		if($_GET['action'] == "send")
		{
			if(isset($_GET['desination']))
			{
				if(isset($_GET['id']))
				{
					$desination = $_GET['desination'];
					$id = $_GET['id'];

					//echo $id;

					date_default_timezone_set("Asia/Dhaka");
					$date = date("Y/m/d");
					$time = date("H:i:sa");

					$sql1		= "UPDATE `docket` SET `on_move`=11, `sent_from` = '10_11' WHERE `docket_id` = '$id'";
					$sql2		= "INSERT INTO `move_history`(`docket_id`, `sent_from`, `destination_id`, `if_received`, `date`, `time`) VALUES ('$id', 10,11, 0, '$date','$time' )";
					if($connection->query($sql1) && $connection->query($sql2))
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

		//--------------handeling 'add to file' action-------------------
		if($_GET['action'] == "AddToFile")
		{
			if(isset($_GET['ref']))
			{
				$ref = $_GET['ref'];
				if(isset($_GET['id']))
				{
					$id = $_GET['id'];

					$sql		= "UPDATE `docket` SET `file_holder_no`='$ref' WHERE `docket_id` = '$id'";
					if($connection->query($sql))
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
		//--------------handeling 'add to file' action-------------------
	}
	else
	{
		
	}
	//--------------handeling actions-------------------
?>


<!DOCTYPE html>
<html>
<head>
	<title>Docket || ES RUET</title>

	<link rel="stylesheet" href="index.css">
</head>
<body>
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
      <li> <a href="addnew.php">Add new</a> </li>
    </ul>
  </div>



	<table>
		<thead>
			<tr>
				<th>Docket No.</th>
				<th>File Name</th>		        	
				<th>Action</th>
			</tr>
		</thead>

		<tbody>

			<?php
				while($row=$data->fetch_assoc())
				{ ?>
					
					<tr> 
						<td> <?php echo $row['docket_id']; ?> </td>
						<td> 
							<?php if($row['file_holder_no'] == 0){ ?> 
								<select name="file_selection" id="file_selection<?php echo $row['docket_id']; ?>" onchange="set_file('<?php echo $row['docket_id']; ?>')" >
									<option disabled selected>Select File</option>
									<?php 
									while ($file_row = $files->fetch_assoc()) 
									{ ?>
										
										<option value="<?php echo($file_row['file_holder_no']); ?>"><?php echo($file_row['file_holder_name']); ?></option>
										

									<?php }
									$files->data_seek(0);
									?>
								</select>
							<?php } else{

								$file_no = $row['file_holder_no'];
								$file_data = $connection->query("SELECT `file_holder_name` FROM `file_holder` WHERE `file_holder_no` = '$file_no'");
								$file_row=$file_data->fetch_assoc();

								echo $file_row['file_holder_name'];

							} ?> 
						</td>
						<td> 
							<?php 
								$info 	= $row['sent_from']; 
								$ln 	= strlen($info);
								$flag	= false;

								for($i = 0; $i < $ln; $i = $i+5)
								{
									$sub  = substr($info, $i, 5);
									$sub1 = substr($info, $i, 3);

									if($sub1 == "10_")
									{
										$des_sub = substr($sub, 3, 2);
										echo $des[$des_sub]." এর কাছে প্রেরিত";
										$flag = true;
										break;
									}
								}

								if($flag == false)
								{ ?>
									<a href="index.php?action=send&desination=section&id=<?php echo $row['docket_id']; ?>" title="send to section">send to section officer</a> 
								<?php }

							?>
							

						</td> 
					</tr>

				<?php }
			?>
		</tbody>
	</table>

	<script type="text/javascript" charset="utf-8">
		function set_file(id)
		{
			id = decodeURI(id);
			var elementID = "file_selection"+id;
			id = encodeURI(id);


			var select = document.getElementById(elementID);
			var value = select.value;

			console.log(elementID);
			console.log(value);
			window.location.href = "index.php?action=AddToFile&ref="+value+"&id="+id;
		}
	</script>
</body>
</html>



<?php //php else ends here
	} 
?>