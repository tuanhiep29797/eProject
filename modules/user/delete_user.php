<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if(empty($_GET))
    {
        header("Location:" . BASE_URL . "admin/user");
    }

    $user_id = $_GET['id'];

    //connection to database and delete user
    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_DELETE_USER);
        $stmt -> bindParam(':user_id', $user_id);
        $stmt -> execute();

        header("Location:" . BASE_URL . "admin/user");
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>