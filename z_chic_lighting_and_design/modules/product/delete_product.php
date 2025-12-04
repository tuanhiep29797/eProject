<?php
    require_once('../database/dbhelper.php');
    if(empty($_GET))
    {
        header("Location: ../home_admin.php");
    }

    $id = $_GET['id'];

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_DELETE_PRODUCT);
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