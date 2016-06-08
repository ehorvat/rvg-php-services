<?php

	require "config.inc.php";

if(!empty($_GET)){

		$store = $_GET["store"];
		$platform = $_GET["platform"];

		if(empty($_GET['store']) || empty($_GET['platform'])){

			$response["success"] = 0;
			$response["error"] = "Store or platform is null"; 

			die(json_encode($response));
		}

	$query = " SELECT * FROM `masterinv2` WHERE `" . $store . "` >= 1 AND `platform` = '" . $platform . "' ORDER BY `title` ASC;";
		//
	     

	    //Now let's make run the query:
	    try {
	        // These two statements run the query against your database table.
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
	 
	 
	if ($rows) {
	    $response["success"] = 1;
	    $response["message"] = "Inventory Found!";
	    $response["posts"]   = array();
	     
	    foreach ($rows as $row) {
	        $post             = array();
	        $post["title"] = $row["title"];
	        $post["platform"]    = $row["platform"];
	        $post["price"]  = $row["price"];
	        $post["trade"] = $row["trade"];
	        $post["nbqty"] = $row["nb_qty"];
	        $post["npqty"] = $row["np_qty"];
	        $post["bkqty"] = $row["bk_qty"];
	        $post["tmqty"] = $row["tm_qty"];


			$post["skuid"] = $row["skuid"];
			$post["picture"] = $row["picture"];

			if($post["picture"] == 'Y'){

    			$thumbimagepath = "http://www.rvgnet.net/prodimages/thumb/" . $post["skuid"] . ".jpg"; 
    			$webimagepath = "http://www.rvgnet.net/prodimages/web/" . $post["skuid"] . ".jpg"; 

			}elseif($post["picture"] == 'N'){

   				$thumbimagepath = '';
   				$webimagepath = '';

			}

	         
	         	        //update our repsonse JSON data
	        array_push($response["posts"], $post);
	    }

	    // echoing JSON response
	    echo json_encode($response);
	     
	     
	} else {
	    $response["success"] = 0;
	    $response["message"] = "No Post Available!";
	    die(json_encode($response));
	}
	     
	     


	}else{
		echo "get is empty";
	}

?>

