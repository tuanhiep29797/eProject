<?php
    require_once (__DIR__."/../../database/dbhelper.php");
    if(empty($_GET))
    {
        header("Location: ../home_admin.php");
    }

    $id = $_GET['id'];

    //connection to database and delete category
    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_DELETE_CATEGORY);
        $stmt -> bindParam(':id', $id);
        $stmt -> execute();

        header("Location: ../home_admin.php");
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>