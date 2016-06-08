<?php 
	require "config.inc.php";
		/*************************************************************
		get a current unix timestamp and insert with the insert query
		Date format examples can be found at: http://php.net/manual/en/function.date.php
		**************************************************************/
		$currentdate = time();
		//here's a couple examples of use of a unix timestamp
			//echo "CURRENT UNIX TIME STAMP: " . $currentdate . "<br />";
				$currentdate2 = date('m/d/Y H:i:s', $currentdate);
					//echo "CONVERTED UNIX TIME: " . $currentdate2 . "<br />";
						$currentdate3 = date('F j, Y H:i:s', $currentdate);
							//echo "CONVERTED UNIX TIME 2: " . $currentdate3 . "<br /><br />";	
			
		/*************************************************************
		end demos
		*************************************************************/
			date_default_timezone_set('America/Los_Angeles');
			
			
	if(!empty($_GET)){

		$platform = $_GET["platform"];
		$title = $_GET["title"];
		$body = $_GET["body"];
		$username = $_GET["username"];
		
		$stmt = $db->prepare("INSERT INTO `Questions` (title, question, platform, username, tstamp) VALUES (?,?,?,?,?)");

		$stmt->execute(array($title, $body, $platform, $username, $currentdate2));
	}else{
		$query = " SELECT * FROM `Questions`;";

	    try{

	        $stmt   = $db->prepare($query);

	        $result = $stmt->execute();

	        $rows = $stmt->fetchAll();

	    }catch (PDOException $ex) {
	        $response["success"] = 0;
	        $response["message"] = $ex->getMessage();
	        die(json_encode($response));
	    }

	        $response["posts"]   = array();
			
			
	        		if($rows){

	   					foreach ($rows as $row) {
	        				$post = array();
	        				$post["tstamp"] = date('Y-m-d H:i:s', $row["unixtstamp"]);
	        				$post["answers"] = array();
							$datecreated = date('m/d/Y', $row["tstamp"]);
				
							echo "<br /><strong>TITLE:</strong> " . $row["title"] . "<br />";
							echo "<strong>QUESTION:</strong> " . $row["question"] . "<br />";
							echo "<strong>PLATFORM:</strong> " . $row["platform"] . "<br />";
							echo "<strong>USER:</strong> " . $row["username"] . "<br />";
	        				echo "<strong>TSTAMP:</strong> " . $row["tstamp"] . "<br />";
							echo "<strong>UNIX TSTAMP:</strong> " . $row["unixtstamp"] . "<br />";
							
							$exmpleformattedtime = date('Y-m-d H:i:s', $row["unixtstamp"]);
								echo "<strong>UNIX TSTAMP FORMATTED TIME 1:</strong> " . $exmpleformattedtime . "<br />";
							
							$exmpleformattedtime = date('m/d/Y H:i:s', $row["unixtstamp"]);
								echo "<strong>UNIX TSTAMP FORMATTED TIME 2:</strong> " . $exmpleformattedtime . "<br />";
							
							$exmpleformattedtime = date('F j, Y H:i:s', $row["unixtstamp"]);
								echo "<strong>UNIX TSTAMP FORMATTED TIME 3:</strong> " . $exmpleformattedtime . "<br />";
							
							$exmpleformattedtime = date('M j, Y H:i:s A', $row["unixtstamp"]);
								echo "<strong>UNIX TSTAMP FORMATTED TIME 4:</strong> " . $exmpleformattedtime . "<br />";
							
							$exmpleformattedtime = date('M j, Y g:i A', $row["unixtstamp"]);
 
							//$dt = new DateTime($exmpleformattedtime, new DateTimeZone('America/Los_Angeles'));
							//$result = $dt->format('M j, Y g:i A');

							print_r($exmpleformattedtime);


								echo "<strong>UNIX TSTAMP FORMATTED TIME 5:</strong> " . $exmpleformattedtime . "<br />";
							
							$exmpleformattedtime = date('l F jS, Y H:i:s', $row["unixtstamp"]);
								echo "<strong>UNIX TSTAMP FORMATTED TIME 6:</strong> " . $exmpleformattedtime . "<br />";
							
							$exmpleformattedtime = date('g:ia T \o\n l F jS, Y', $row["unixtstamp"]);
								echo "<strong>UNIX TSTAMP FORMATTED TIME 7:</strong> " . $exmpleformattedtime . "<br /><br />";
							
	        			}
	        		
					}

		$response["success"] = 1;
	    $response["message"] = "Question created.";
	    $response["qid"] = $db->lastInsertId(); 

	    echo json_encode($response);
	}

?>