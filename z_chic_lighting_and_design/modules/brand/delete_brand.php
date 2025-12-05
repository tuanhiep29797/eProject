<?php
    require_once __DIR__."/../../database/dbhelper.php";
    if(empty($_GET))
    {
        header("Location: brand.php");
    }

    $id = $_GET['id'];

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_DELETE_BRAND);
        $stmt -> bindParam(':brand_id', $id);
        $stmt -> execute();

        header("Location: brand.php");
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>