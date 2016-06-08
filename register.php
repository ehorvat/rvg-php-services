<?php

	require "config.inc.php";

		$json = file_get_contents('php://input');
		$obj = json_decode($json);

		$username = $obj->{'username'};

		$password = $obj->{'password'};


  		//First check that passwords match
  		if($pass == $confpass){

  			//Query to check if username already exists
  			$query = " SELECT * FROM `User` WHERE username = '" . $username . "';";
     
	    	try {
	        	$stmt   = $db->prepare($query);

	        	$result = $stmt->execute();
	    	}
	    	catch (PDOException $ex) {
	        	// For testing, you could use a die and message.
	        	//die("Failed to run query: " . $ex->getMessage());	         
	        	//or just use this use this one to product JSON data:
	        	$response["success"] = 0;
	        	$response["message"] = $ex->getMessage();
	        	die(json_encode($response));
	    	}

			$rows = $stmt->fetchAll();
	 
	 		//If returns a row, username already exists
			if ($rows) {
	    		$response["success"] = 0;
	    		$response["message"] = "Username already exists.";
	         
	    		echo json_encode($response);
	     
	     
			} else {
  				//Username doesn't exist, insert the new user
				$stmt = $conn->prepare("INSERT INTO User (username, pass) VALUES (?,?)");

    			$stmt->bind_param("ss",$username,$pass);

				$stmt->execute();

				$response["success"] = 1;
	    		$response["message"] = "User successfully added.";
	         
	    		echo json_encode($response);
			}

		}else{
			    $response["success"] = 0;
	    		$response["message"] = "Passwords don't match.";
	         
	    		echo json_encode($response);
		}



?>