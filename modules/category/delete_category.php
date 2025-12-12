<?php
    require_once (__DIR__."/../../database/dbhelper.php");
    if(empty($_GET))
    {
        header("Location: category.php");
    }

    $category_id = $_GET["id"];

    //connection to database and delete category
    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_DELETE_CATEGORY);
        $stmt -> bindParam(":category_id", $category_id);
        $stmt -> execute();

        header("Location: category.php");
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>