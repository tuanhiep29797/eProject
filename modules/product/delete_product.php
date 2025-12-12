<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if(empty($_GET))
    {
        header("Location: product.php");
        exit();
    }
    else
    {
        $product_id = $_GET['id'];

        //connection to database and delete product
        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_DELETE_PRODUCT);
            $stmt -> bindParam(':product_id', $product_id);
            $stmt -> execute();

            header("Location: product.php");
            exit();
        }
        catch (PDOException $e)
        {
            echo $e -> getMessage();
        }
    }

    $conn = null;
?>