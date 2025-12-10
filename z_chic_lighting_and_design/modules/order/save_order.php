<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (empty($_POST["order_id"])) 
    {
        header("Location: order.php");
        exit;
    }

    // get new data
    $order_id = $_POST["order_id"] ?? [];
    $order_status = $_POST["order_status"] ?? [];

    //connection to database and update order
    try 
    {
        $conn = getConnection();
        for($i = 0; $i < count($order_id); $i++){
            $id = $order_id[$i];
            $status = $order_status[$i];
            $stmt = $conn->prepare("update `order` 
            set order_status = :order_status
            where order_id = :order_id
            ");
            $stmt->bindParam(":order_status", $status);
            $stmt->bindParam(":order_id", $id);
            $stmt->execute();
        }


        header("Location: order.php");
        exit;
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $conn = null;
    
?>
