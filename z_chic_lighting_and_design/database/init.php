<?php
	//Create database
	try 
	{
		$conn = getConnectionInit();
		$stmt = $conn->prepare(SQL_CREATE_DATABASE);
		$stmt -> execute();
	} 
	catch(PDOException $e) 
	{
	  echo "Error: " . $e->getMessage();
	}

	$conn = null;

	//Create tables

	$sql_create = [
		SQL_CREATE_TABLE_USER,
		SQL_CREATE_TABLE_CATEGORY,
		SQL_CREATE_TABLE_BRAND,
		SQL_CREATE_TABLE_PRODUCT,
		SQL_CREATE_TABLE_PRODUCT_IMG,
		SQL_CREATE_TABLE_GALLERY,
		SQL_CREATE_TABLE_CART,
		SQL_CREATE_TABLE_ORDER,
		SQL_CREATE_TABLE_ORDER_DETAIL,
		SQL_CREATE_TABLE_REVIEW,
		SQL_CREATE_TABLE_FEEDBACK
	];

	try {
		$conn = getConnection();

		foreach ($sql_create as $item)
		{
			$stmt = $conn->prepare($item);
			$stmt->execute();
		}

	} catch(PDOException $e) {
	  echo "Error: " . $e->getMessage();
	}
	$conn = null;
?>