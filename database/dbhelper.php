<?php
	require_once __DIR__ ."/../config.php";

	//function get connection to server and create database
	function getConnectionInit() 
	{
		$conn = new PDO("mysql:host=".HOST, USERNAME, PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $conn;
	}

	//function get connection to database
	function getConnection() 
	{
		$conn = new PDO("mysql:host=".HOST.";dbname=".DBNAME, USERNAME, PASSWORD);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		return $conn;
	}


	//SQL create database
	const SQL_CREATE_DATABASE = "create database if not exists db_cl_and_d";

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
		product_title VARCHAR(255) UNIQUE NOT NULL,
		product_description TEXT,
		product_price DECIMAL(10, 2) NOT NULL,
		product_content TEXT,
		product_quantity INT NOT NULL DEFAULT 0,
		product_thumbnail VARCHAR(255),
		product_slug VARCHAR(255),

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
		url VARCHAR(255) UNIQUE NOT NULL,

		FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE 
	)";

	const SQL_CREATE_TABLE_GALLERY = 
	"create table if not exists gallery 
	(
		img_id INT AUTO_INCREMENT PRIMARY KEY,
    	url VARCHAR(255) UNIQUE NOT NULL
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
		total_amount DECIMAL(15, 2) NOT NULL,
		receiver VARCHAR(255) NOT NULL,
		phone_number VARCHAR(20) NOT NULL,
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
		status ENUM('new', 'readed') NOT NULL DEFAULT 'new',
		created_at DATETIME DEFAULT CURRENT_TIMESTAMP
	)";

	//SQL GET TABLE

	const SQL_GET_USER = "select * from user";
	const SQL_GET_COUNT_USER = "select count(*) from user";

	const SQL_SEARCH_USER = SQL_GET_USER . " where email = :account or username = :account";
	const SQL_SEARCH_USER_BY_EMAIL = SQL_GET_USER . " where email = :email";
	const SQL_SEARCH_USER_BY_USERNAME = SQL_GET_USER . " where username = :username";
	const SQL_GET_USER_BY_ID = SQL_GET_USER . " where user_id = :user_id";

	const SQL_GET_CATEGORY = "select * from category";
	const SQL_GET_CATEGORY_BY_ID = SQL_GET_CATEGORY . " where category_id = :category_id";

	const SQL_GET_BRAND = "select * from `brand`";
	const SQL_GET_BRAND_BY_ID = "select * from `brand` where brand_id = :brand_id";

	const SQL_GET_PRODUCT = "select * from product";
	const SQL_GET_PRODUCT_BY_ID = SQL_GET_PRODUCT . " where product_id = :product_id";
	const SQL_SEARCH_PRODUCT = SQL_GET_PRODUCT . " where product_title like :search";

	const SQL_GET_PRODUCT_AS_CAT_AND_BRAND = 
	"select p.*, c.category_name, b.brand_name
	from product p 
	inner join category c on p.category_id = c.category_id
	inner join brand b on p.brand_id = b.brand_id
	";

	const SQL_GET_PRODUCT_AS_C_AND_B_BY_ID = SQL_GET_PRODUCT_AS_CAT_AND_BRAND . " where p.product_id = :product_id";
	const SQL_GET_PRODUCT_AS_C_AND_B_BY_SLUG = SQL_GET_PRODUCT_AS_CAT_AND_BRAND . " where p.product_slug = :product_slug";

	const SQL_COUNT_PRODUCT = "select count(*) from product";

	const SQL_COUNT_PRODUCT_FILTER_CAT_BRAND = 
	"select count(*) from product p
	inner join category c on p.category_id = c.category_id
	inner join brand b on p.brand_id = b.brand_id
	";

	const SQL_COUNT_PRODUCT_SEARCH = "select count(*) from product where product_title like :search";

	const SQL_COUNT_PRODUCT_FILTER_BRAND = 
	"select count(*) from product p
	inner join brand b on p.brand_id = b.brand_id
	";

	const SQL_GET_PRODUCT_AS_BRAND = 
	"select p.*, b.brand_name
	from product p
	inner join brand b on p.brand_id = b.brand_id
	";

	const SQL_COUNT_PRODUCT_FILTER_CATEGORY = 
	"select count(*) from product p
	inner join category c on p.category_id = c.category_id
	";

	const SQL_GET_PRODUCT_AS_CATEGORY = 
	"select p.*, c.category_name
	from product p
	inner join category c on p.category_id = c.category_id
	";

	const SQL_GET_CATEGORY_AS_PRODUCT = 
	"select c.category_id, c.category_name, p.product_id, p.product_title, p.product_slug
	from category c join product p 
	on c.category_id = p.category_id
	order by c.category_name, p.product_title
	";
	
	const SQL_GET_CART = "select * from cart";
	const SQL_GET_CART_BY_USER_AND_PRODUCT = SQL_GET_CART . " where user_id = :user_id and product_id = :product_id";

	const SQL_GET_CART_BY_USER_ID = 
	"select p.*, c.quantity, c.cart_id, c.user_id
	from product p
	inner join cart c on c.product_id = p.product_id
	inner join user u on  u.user_id = c.user_id
	where u.user_id = :user_id
	";

	const SQL_GET_ORDER = "select * from `order`";
	const SQL_COUNT_ORDER = "select count(*) from `order`";
	const SQL_GET_ORDER_BY_ID = SQL_GET_ORDER . " where order_id = :order_id";
	const SQL_GET_ORDER_BY_USER = SQL_GET_ORDER . " where user_id = :user_id";

	const SQL_GET_ORDER_BY_USER_ID =
	"select o.*, od.* , p.product_title, p.product_thumbnail
    from `order` o
    inner join order_detail od on od.order_id = o.order_id
    inner join product p on p.product_id = od.product_id
    where o.user_id = :user_id
    ";

	const SQL_GET_ORDER_DETAIL = 
	"select od.*, p.product_title, p.product_thumbnail, p.product_price
    from order_detail od
    join product p on od.product_id = p.product_id
    where od.order_id = :order_id
	";

	const SQL_GET_SUM_QUANTITY_IN_CART =
	"select sum(c.quantity) as total_quantity
	from cart c
	where c.user_id = :user_id
	";

	const SQL_GET_FEEDBACK = "select * from feedback";
	

	const SQL_GET_GALLERY = "select * from gallery";

	const SQL_GET_PRODUCT_IMG = "select * from product_img";
	const SQL_GET_PRODUCT_IMG_BY_PRODUCT = SQL_GET_PRODUCT_IMG . " where product_id = :product_id";

	//SQL ADD TABLE

	const SQL_ADD_USER = 
	"insert into user(fullname, username, email, phone_number, password, role)
	values
	(:fullname, :username, :email, :phone_number, :password, :role)
	";

	const SQL_ADD_USER_REGISTER = 
	"insert into user(fullname, username, email, phone_number, password)
	values
	(:fullname, :username, :email, :phone_number, :password)
	";

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
	"insert into product(product_title, product_description, product_price, product_content, product_quantity, product_thumbnail, category_id, brand_id, product_slug) 
	values
	(:product_title, :product_description, :product_price, :product_content, :product_quantity, :product_thumbnail, :category_id, :brand_id, :product_slug)
	";

	const SQL_ADD_FEEDBACK = 
	"insert into feedback(username, email, phone_number, content)
	values
	(:username, :email, :phone_number, :content)
	";

	const SQL_ADD_CART = 
	"insert into cart(user_id, product_id, quantity)
	values
	(:user_id, :product_id, :quantity)
	";

	const SQL_ADD_ORDER = 
    "insert into `order` (user_id, order_status, total_amount, receiver, phone_number, address) 
    values 
	(:user_id, :order_status, :total_amount, :receiver, :phone_number, :address)
	";

	const SQL_ADD_NEW_ORDER = 
	"insert into `order` (user_id, total_amount, receiver, phone_number, address) 
    values 
	(:user_id, :total_amount, :receiver, :phone_number, :address)
	";

	const SQL_ADD_ORDER_DETAIL = 
    "insert into order_detail (order_id, product_id, quantity, unit_price) 
    values
	(:order_id, :product_id, :quantity, :unit_price)
	";

	const SQL_ADD_REVIEW = 
    "insert into review (order_id, user_id, product_id, review_content, rating, is_public) 
    values 
	(:order_id, :user_id, :product_id, :review_content, :rating, :is_public)
	";

	const SQL_ADD_GALLERY = 
	"insert into gallery (url)
	values
	(:url)
	";

	const SQL_ADD_PRODUCT_IMG = 
	"insert into product_img (product_id, url)
	values
	(:product_id, :url)
	";



	//SQL UPDATE TABLE

	const SQL_UPDATE_USER = 
	"update user
	set fullname = :fullname,
		username = :username,
		email = :email,
		phone_number = :phone_number,
		role = :role
	where user_id = :user_id
	";

	const SQL_UPDATE_CATEGORY = 
	"update category 
	set category_name = :category_name, 
		category_thumbnail = :category_thumbnail
	where category_id = :category_id
	";

	const SQL_UPDATE_BRAND = 
	"update brand 
	set brand_name = :brand_name, 
		brand_thumbnail = :brand_thumbnail
	where brand_id = :brand_id
	";

	const SQL_UPDATE_PRODUCT = 
	"update product
	set product_title = :product_title,
		product_description = :product_description,
		product_price = :product_price,
		product_content = :product_content,
		product_quantity = :product_quantity,
		product_thumbnail = :product_thumbnail,
		category_id = :category_id,
		brand_id = :brand_id
	where product_id = :product_id
	";

	const SQL_UPDATE_PRODUCT_QUANTITY =
	"update product
	set product_quantity = :product_quantity
	where product_id = :product_id
	";

	const SQL_UPDATE_ORDER_STATUS = 
	"update `order`
	set order_status = :order_status
	where order_id = :order_id
	";

	const SQL_UPDATE_ORDER = 
	"update `order` 
	set order_status = :order_status,
		receiver = :receiver,
		phone_number = :phone_number,
		address = :address
	where order_id = :order_id	
	";

	const SQL_UPDATE_FEEDBACK_STATUS =
	"update feedback
	set status = :status
	where feedback_id = :feedback_id
	";

	const SQL_UPDATE_CART = 
	"update cart 
	set quantity = :quantity
	where user_id = :user_id and cart_id = :cart_id
	";

	//SQL DELETE TABLE

	const SQL_DELETE_USER = "delete from user where user_id = :user_id";

	const SQL_DELETE_CATEGORY = "delete from category where category_id = :category_id";

	const SQL_DELETE_BRAND = "delete from brand where brand_id = :brand_id";
	
	const SQL_DELETE_PRODUCT = "delete from product where product_id = :product_id";

	const SQL_DELETE_CART = "delete from cart where cart_id = :cart_id";

	const SQL_DELETE_CART_BY_USER_ID = "delete from cart where user_id = :user_id";
?>