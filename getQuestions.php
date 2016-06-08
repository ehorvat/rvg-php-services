<?php

	require "config.inc.php";

		$query = " SELECT * FROM `Questions`;";
		date_default_timezone_set('America/Los_Angeles');


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
	        				$post["qid"] = $row["id"];
	        				$post["title"] = $row["title"];
	        				$post["body"]    = $row["question"];
	        				$post["platform"]  = $row["platform"];
	        				$post["username"] = $row["username"];
	        				$post["tstamp"] = date('M j, Y g:i A', $row["unixtstamp"]);
	        				$post["answers"] = array();


							$query = " SELECT * FROM `Answers` where qid=" . $row["id"] . ";";

							$stmt = $db->prepare($query);
							$result = $stmt->execute();
							$r = $stmt->fetchAll();

							foreach($r as $record){

									$answers = array();
									$answers["aid"] = $record["id"];
									$answers["answer"] = $record["answer"];
									$answers["qid"] = $record["qid"];
									$answers["username"] = $record["username"];
									$answers["tstamp"] = date('M j, Y g:i A', $record["unixtstamp"]);

									array_push($post["answers"], $answers);

							}
							
 
	        				array_push($response["posts"], $post);

	        			}

	        		$response["success"] = 1;
	    			$response["message"] = "Questions Found!";
	         
	    			echo json_encode($response);

	        		}else{
	        			echo "failed";
	        			$response["success"] = 0;
	        			$response["messages"] = "No Questions!";
	        		}
	        	
	 ?>
