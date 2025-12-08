<?php
    $admin = [
        "fullname" => "ADMIN",
        "username" => "admin",
        "email" => "admin@gmail.com",
        "phone_number" => "0123456789",
        "password" => "admin",
        "role" => "admin"
    ];
    
    $admin["password"] = password_hash($admin["password"], PASSWORD_DEFAULT);

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_ADD_USER);
        $stmt -> bindParam(":fullname", $admin["fullname"]);
        $stmt -> bindParam(":username", $admin["username"]);
        $stmt -> bindParam(":email", $admin["email"]);
        $stmt -> bindParam(":phone_number", $admin["phone_number"]);
        $stmt -> bindParam(":password", $admin["password"]);
        $stmt -> bindParam(":role", $admin["role"]);
        $stmt -> execute();
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    };

    $conn = null;
?>