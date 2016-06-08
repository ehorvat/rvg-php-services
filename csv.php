<?php


if (isset($_POST['exp'])) {
	header('Content-Disposition: attachment; filename="data.csv";');
	require "config.inc.php";




	$query = "SELECT * FROM `masterinv2` LIMIT 1000;";

	$fp = fopen('php://output', 'w');

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
	         
	        fputcsv($fp, $post);
	    }
	}

	fclose($fp);
}
?>

<div>
  <form action="#" method="post">
    <input type="submit" value="Export" name="exp" />
  </form>
</div>