<?php
require_once('../config.php');

//function get connection to database
function getConnection() 
{
	$conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $conn;
}

//function get connection to server and create database
function getConnectionInit() 
{
	$conn = new PDO("mysql:host=".HOST, USERNAME, PASSWORD);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	return $conn;
}

//SQL create database
const SQL_CREATE_DATABASE = "create database if not exists db_cl_and_d";

const SQL_LOGIN = "select * from user where email = :email and password = :password";


//SQL create table
const SQL_CREATE_TABLE_USER = 
	"create table if not exists user 
	(
		user_id INT AUTO_INCREMENT PRIMARY KEY,
		fullname VARCHAR(255) NOT NULL,
		username VARCHAR(100) UNIQUE NOT NULL,
		email VARCHAR(255) UNIQUE NOT NULL,
		phone_number VARCHAR(20),
		password VARCHAR(255) NOT NULL,
		role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
		created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
		updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
	)";

const SQL_CREATE_TABLE_CATEGORY = 
	"create table if not exists category 
	(
		category_id INT AUTO_INCREMENT PRIMARY KEY,
		category_name VARCHAR(255) UNIQUE NOT NULL,
		category_thumbnail VARCHAR(255)
	)";

const SQL_CREATE_TABLE_BRAND = 
	"create table if not exists brand 
	(
		brand_id INT AUTO_INCREMENT PRIMARY KEY,
		brand_name VARCHAR(255) UNIQUE NOT NULL,
		brand_thumbnail VARCHAR(255)
	)";

const SQL_CREATE_TABLE_PRODUCT = 
	"create table if not exists product 
	(
		product_id INT AUTO_INCREMENT PRIMARY KEY,
		product_title VARCHAR(255) NOT NULL,
		product_description TEXT,
		product_price DECIMAL(10, 2) NOT NULL,
		product_content TEXT,
		product_quantity INT NOT NULL DEFAULT 0,
		product_thumbnail VARCHAR(255),

		category_id INT,
		brand_id INT,

		created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
		updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

		FOREIGN KEY (category_id) REFERENCES category(category_id) ON DELETE CASCADE,
		FOREIGN KEY (brand_id) REFERENCES brand(brand_id) ON DELETE CASCADE
	)";

const SQL_CREATE_TABLE_PRODUCT_IMG = 
	"create table if not exists product_img 
	(
		product_img_id INT AUTO_INCREMENT PRIMARY KEY,
		product_id INT NOT NULL,
		url VARCHAR(255) NOT NULL,

		FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE 
	)";

const SQL_CREATE_TABLE_GALLERY = 
	"create table if not exists gallery 
	(
		img_id INT AUTO_INCREMENT PRIMARY KEY,
    	url VARCHAR(255) NOT NULL
	)";

const SQL_CREATE_TABLE_CART = 
	"create table if not exists cart 
	(
		cart_id INT AUTO_INCREMENT PRIMARY KEY,
		user_id INT NOT NULL,
		product_id INT NOT NULL,
		quantity INT NOT NULL,
		created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
		
		FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE ,
		FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE 
	)";

const SQL_CREATE_TABLE_ORDER = 
	"create table if not exists `order`
	(
		order_id INT AUTO_INCREMENT PRIMARY KEY,
		user_id INT NOT NULL,
		order_status ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending',
		total_amount DECIMAL(10, 2) NOT NULL,
		receiver VARCHAR(255) NOT NULL,
		address VARCHAR(255) NOT NULL,
		order_date DATETIME DEFAULT CURRENT_TIMESTAMP,

		FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE 
	)";

const SQL_CREATE_TABLE_ORDER_DETAIL = 
	"create table if not exists order_detail 
	(
		order_id INT NOT NULL,
		product_id INT NOT NULL,
		quantity INT NOT NULL,
		unit_price DECIMAL(10, 2) NOT NULL,

		PRIMARY KEY (order_id, product_id),
		FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE,
		FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE 
	)";

const SQL_CREATE_TABLE_REVIEW = 
	"create table if not exists review 
	(
		review_id INT AUTO_INCREMENT PRIMARY KEY,
		order_id INT,
		user_id INT NOT NULL,
		product_id INT NOT NULL,
		review_content TEXT,
		rating INT CHECK (rating >= 1 AND rating <= 5),
		is_public BOOLEAN DEFAULT TRUE,
		created_at DATETIME DEFAULT CURRENT_TIMESTAMP,

		FOREIGN KEY (order_id) REFERENCES `order`(order_id) ON DELETE CASCADE,
		FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
		FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
	)";

const SQL_CREATE_TABLE_FEEDBACK = 
	"create table if not exists feedback 
	(
		feedback_id INT AUTO_INCREMENT PRIMARY KEY,
		username VARCHAR(255),
		email VARCHAR(255),
		phone_number VARCHAR(20),
		content TEXT NOT NULL,
		created_at DATETIME DEFAULT CURRENT_TIMESTAMP
	)";
	

	//SQL GET TABLE

	const SQL_GET_CATEGORY = "select * from category where id = :id";

	//SQL ADD TABLE

	const SQL_ADD_CATEGORY = 
	"insert into category(category_name, category_thumbnail) 
	values
	(:category_name, :category_thumbnail)
	";

	const SQL_ADD_BRAND = 
	"insert into brand(brand_name, brand_thumbnail) 
	values
	(:brand_name, :brand_thumbnail)
	";

	const SQL_ADD_PRODUCT = 
	"insert into product(product_title, product_description, product_price, product_content, product_quantity, product_thumbnail, category_id, brand_id) 
	values
	(:product_title, :product_description, :product_price, :product_content, :product_quantity, :product_thumbnail, :category_id, :brand_id)
	";

	//SQL UPDATE TABLE

	const SQL_UPDATE_CATEGORY = 
	"update from category 
	set category_name = :category_name, 
		category_thumbnail = :category_thumbnail
	where id = :id";

	//SQL DELETE TABLE

	const SQL_DELETE_CATEGORY = "delete from category where id = :id";

?>