<?php
    $carts = [
        ["user_id" => 2, "product_id" => 1, "quantity" => 1],
        ["user_id" => 2, "product_id" => 5, "quantity" => 2],
        ["user_id" => 2, "product_id" => 8, "quantity" => 1],
        
        ["user_id" => 3, "product_id" => 2, "quantity" => 3],
        ["user_id" => 3, "product_id" => 10, "quantity" => 1],
        
        ["user_id" => 4, "product_id" => 3, "quantity" => 2],
        ["user_id" => 4, "product_id" => 7, "quantity" => 4],
        ["user_id" => 4, "product_id" => 15, "quantity" => 1],
        
        ["user_id" => 5, "product_id" => 4, "quantity" => 1],
        ["user_id" => 5, "product_id" => 12, "quantity" => 2],
        
        ["user_id" => 6, "product_id" => 6, "quantity" => 5],
        ["user_id" => 6, "product_id" => 19, "quantity" => 3],
        
        ["user_id" => 7, "product_id" => 9, "quantity" => 1],
        ["user_id" => 7, "product_id" => 14, "quantity" => 1],
        ["user_id" => 7, "product_id" => 21, "quantity" => 2],
        
        ["user_id" => 8, "product_id" => 11, "quantity" => 2],
        ["user_id" => 8, "product_id" => 16, "quantity" => 1],
        
        ["user_id" => 9, "product_id" => 13, "quantity" => 1],
        ["user_id" => 9, "product_id" => 20, "quantity" => 4],
        
        ["user_id" => 10, "product_id" => 17, "quantity" => 1],
        ["user_id" => 10, "product_id" => 22, "quantity" => 2],
        ["user_id" => 10, "product_id" => 24, "quantity" => 1],
        
        ["user_id" => 11, "product_id" => 18, "quantity" => 1],
        ["user_id" => 11, "product_id" => 23, "quantity" => 2]
    ];

    try
    {
        $conn = getConnection();
        foreach ($carts as $cart) {
            $stmt = $conn->prepare(SQL_ADD_CART);
            $stmt->bindParam(":user_id", $cart["user_id"]);
            $stmt->bindParam(":product_id", $cart["product_id"]);
            $stmt->bindParam(":quantity", $cart["quantity"]);
            $stmt->execute();
        }
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

    $conn = null;
?>

