<?php
require_once('config.php');

function getConnection() 
{
	$conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $conn;
}

function getConnectionInit() 
{
	$conn = new PDO("mysql:host=".HOST, USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $conn;
}

const SQL_CREATE_DATABASE = "create database if not exists db_notes";


const SQL_LOGIN = "select * from users where email = :email and password = :pwd";
?>