<?php
    require_once('db.php');
    if(empty($_GET))
    {
        header("Location: ../../admin.php");
    }

    $id = $_GET['id'];

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_DELETE_CATEGORY);
        $stmt -> bindParam(':id', $id);
        $stmt -> execute();

        header("Location: ../../admin.php");
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>