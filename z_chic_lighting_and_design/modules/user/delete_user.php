<?php
    require_once __DIR__."/../../database/dbhelper.php";
    if(empty($_GET))
    {
        header("Location: user.php");
    }

    $id = $_GET['id'];

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_DELETE_USER);
        $stmt -> bindParam(':user_id', $id);
        $stmt -> execute();

        header("Location: user.php");
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>