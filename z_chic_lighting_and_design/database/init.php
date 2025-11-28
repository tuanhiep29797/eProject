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

		$stmt = $conn->prepare(SQL_CREATE_TABLE_USER);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_CATEGORY);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_BRAND);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_PRODUCT);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_PRODUCT_IMG);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_GALLERY);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_CART);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_ORDER);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_ORDER_DETAIL);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_REVIEW);
		$stmt->execute();

		$stmt = $conn->prepare(SQL_CREATE_TABLE_FEEDBACK);
		$stmt->execute();

	} catch(PDOException $e) {
	  echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>