<?php
	require_once('dbhelper.php');

	//Create database
	try {
		$conn = getConnectionInit();
		$stmt = $conn->prepare(SQL_CREATE_DATABASE);
		$stmt->execute();
	} catch(PDOException $e) {
	  echo "Error: " . $e->getMessage();
	}
	$conn = null;

	//Create tables
	try {
		$conn = getConnection();

		$stmt = $conn->prepare();
		$stmt->execute();

	} catch(PDOException $e) {
	  echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>