<?php
require_once('dbhelper.php');

// Create Database
try {
	$conn = getConnectionInit();
	$stmt = $conn->prepare(SQL_CREATE_DATABASE);
	$stmt->execute();
} 
catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}
$conn = null;

// Create Tables
try {
	$conn = getConnection();

	$conn->prepare(SQL_CREATE_TABLE_USER)->execute();
	$conn->prepare(SQL_CREATE_TABLE_CATEGORY)->execute();
	$conn->prepare(SQL_CREATE_TABLE_BRAND)->execute();
	$conn->prepare(SQL_CREATE_TABLE_PRODUCT)->execute();
	$conn->prepare(SQL_CREATE_TABLE_PRODUCT_IMG)->execute();
	$conn->prepare(SQL_CREATE_TABLE_GALERRY)->execute();
	$conn->prepare(SQL_CREATE_TABLE_CART)->execute();
	$conn->prepare(SQL_CREATE_TABLE_ORDER)->execute();
	$conn->prepare(SQL_CREATE_TABLE_ORDER_DETAIL)->execute();
	$conn->prepare(SQL_CREATE_TABLE_REVIEW)->execute();
	$conn->prepare(SQL_CREATE_TABLE_FEEDBACK)->execute();

	echo "Database & tables created successfully!";
} 
catch(PDOException $e) {
	echo "Error: " . $e->getMessage();
}

$conn = null;
?>
