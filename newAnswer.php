<?php 
	require "config.inc.php";


	if(!empty($_GET)){

		date_default_timezone_set('America/Los_Angeles');


		$qid = $_GET["qid"];
		$answer = $_GET["answer"];
		$username = $_GET["username"];

		$currentdate2 = time();


		$stmt = $db->prepare("INSERT INTO `Answers` (answer, qid, username, unixtstamp) VALUES (?,?,?,?);");

		$stmt->execute(array($answer, $qid, $username, $currentdate2));

		$lastId = $db->lastInsertId();

		$query = "SELECT * FROM `Answers` where id=" . $lastId . ";";

		try {

	        $stmt   = $db->prepare($query);

	        $stmt->execute(array($lastId));

	        $result = $stmt->execute();

	        $rows = $stmt->fetchAll();

	   		foreach ($rows as $row) {
	        		$response["tstamp"] = date('M j, Y g:i A', $row["unixtstamp"]);
	        }
	        

	    } catch (PDOException $ex) {
	        $response["success"] = 0;
	        $response["message"] = $ex->getMessage();
	        die(json_encode($response));
	    }


		$response["success"] = 1;
	    $response["message"] = "Answer created.";

	    echo json_encode($response);
	}

?>