<?php
	require("db.php");

	//Handel login
	if (isset($_POST['login'])) {
		$name			= $_POST['uname'];
	 	$pass			= $_POST['psw'];
	 	$remember		= "off";
	 	if(isset($_POST['remember']))
	 	{	
	 		$remember	= $_POST['remember'];
	 	}
	 	//the selecting sql
	 	$sql			= "SELECT `user_name`,`user_password`,`emp_id` FROM `users` WHERE `user_name` = '$name'";
	 	
	 	$query		= $connection->query($sql);						//execute the query
	 	$row_count = mysqli_num_rows($query); 						//how many users having the user name

	 	if($row_count <= 0) 										//no users have the user name
	 		echo "The username is not correct. Try again!";
	 	else //users exit
	 	{
	 		$row = $query->fetch_assoc(); 							//data reading from database

	 		$DBusername = $row['user_name']; 						//username saved into database
			$DBpassword = $row['user_password']; 					//password saved into database
			$DBempId	= $row['emp_id'];							//employee id saved into database

			if(($name == $DBusername) and ($pass == $DBpassword)) 	//if username and password combination matches
			{
				echo "logged in!";

				session_start();									//session starts
				$_SESSION['logged'] = "TruE";						//session flag to make user logged in 
				$_SESSION['uname']  = $DBusername;					//save username into session global
				$_SESSION['empID']	= $DBempId;

				$sql = "SELECT esta_employees.emp_id, destinations.post_name FROM destinations, esta_employees WHERE esta_employees.emp_id = '$DBempId' and esta_employees.post_id = destinations.destination_id";

				$query		= $connection->query($sql);						//execute the query
	 			$row_count = mysqli_num_rows($query); 

	 			if($row_count > 0)
	 			{
	 				$row = $query->fetch_assoc();

 					header("Location: ".$row['post_name']."/index.php");
 					$_SESSION['post']	= $row['post_name'];	
	 			}
				// it is now set for developing pourpous
				// it means if I am loggged in
				// i'll be logged into docket entry
				// or related pourpous now
									//i have authonication for docket now.
				/*
				THE USER SHOULD BE REDIRECTED TO HIS/HER PAGE FROM HERE

				THIS OPERATIN WILL BE HANDELED HERE
				*/	
			}
			else
			{
				echo "Incorrect username and password combination. Please try again";
				session_start();
				$_SESSION['logged'] = "False";
			}
	 	}

	 	//echo $remember;
	 }
?>