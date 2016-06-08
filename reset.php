<?php

	require "config.inc.php";

	$stmt = $db->prepare("DELETE FROM `Answers` where id > 0");

	$stmt->execute();

	$stmt = $db->prepare("DELETE FROM `Questions` where id > 0");

	$stmt->execute();

?>