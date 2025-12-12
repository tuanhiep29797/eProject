<?php
    $order_details =
    [
        ["order_id" => 1, "product_id" => 1,  "quantity" => 1, "unit_price" => 5500.00],
        ["order_id" => 1, "product_id" => 5,  "quantity" => 1, "unit_price" => 195.00],

        ["order_id" => 2, "product_id" => 8,  "quantity" => 1, "unit_price" => 165.00],

        ["order_id" => 3, "product_id" => 2,  "quantity" => 2, "unit_price" => 85.00],
        ["order_id" => 3, "product_id" => 6,  "quantity" => 2, "unit_price" => 45.00],
        ["order_id" => 3, "product_id" => 19, "quantity" => 2, "unit_price" => 18.00],

        ["order_id" => 4, "product_id" => 10, "quantity" => 1, "unit_price" => 45.00],

        ["order_id" => 5, "product_id" => 4,  "quantity" => 1, "unit_price" => 480.00],
        ["order_id" => 5, "product_id" => 12, "quantity" => 2, "unit_price" => 75.00],
        ["order_id" => 5, "product_id" => 20, "quantity" => 2, "unit_price" => 25.00],

        ["order_id" => 6, "product_id" => 15, "quantity" => 1, "unit_price" => 550.00],
        ["order_id" => 6, "product_id" => 22, "quantity" => 4, "unit_price" => 20.00],

        ["order_id" => 7, "product_id" => 3,  "quantity" => 1, "unit_price" => 120.00],

        ["order_id" => 8, "product_id" => 6,  "quantity" => 4, "unit_price" => 45.00],
        ["order_id" => 8, "product_id" => 19, "quantity" => 5, "unit_price" => 18.00],

        ["order_id" => 9, "product_id" => 9,  "quantity" => 1, "unit_price" => 1250.00],
        ["order_id" => 9, "product_id" => 14, "quantity" => 1, "unit_price" => 150.00],
        ["order_id" => 9, "product_id" => 17, "quantity" => 1, "unit_price" => 120.00],

        ["order_id" => 10, "product_id" => 15, "quantity" => 1, "unit_price" => 550.00],

        ["order_id" => 11, "product_id" => 11, "quantity" => 2, "unit_price" => 95.00],
        ["order_id" => 11, "product_id" => 16, "quantity" => 1, "unit_price" => 220.00],

        ["order_id" => 12, "product_id" => 13, "quantity" => 2, "unit_price" => 68.00],
        ["order_id" => 12, "product_id" => 7,  "quantity" => 1, "unit_price" => 25.00],

        ["order_id" => 13, "product_id" => 20, "quantity" => 4, "unit_price" => 25.00],
        ["order_id" => 13, "product_id" => 21, "quantity" => 2, "unit_price" => 35.00],
        ["order_id" => 13, "product_id" => 19, "quantity" => 3, "unit_price" => 18.00],

        ["order_id" => 14, "product_id" => 22, "quantity" => 2, "unit_price" => 20.00],
        ["order_id" => 14, "product_id" => 17, "quantity" => 1, "unit_price" => 120.00],

        ["order_id" => 15, "product_id" => 18, "quantity" => 1, "unit_price" => 180.00],
        ["order_id" => 15, "product_id" => 23, "quantity" => 1, "unit_price" => 950.00]
    ];


    try
    {
        $conn = getConnection();
        foreach ($order_details as $detail) {
            $stmt = $conn->prepare(SQL_ADD_ORDER_DETAIL);
            $stmt->bindParam(":order_id", $detail["order_id"]);
            $stmt->bindParam(":product_id", $detail["product_id"]);
            $stmt->bindParam(":quantity", $detail["quantity"]);
            $stmt->bindParam(":unit_price", $detail["unit_price"]);
            $stmt->execute();
        }
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

    $conn = null;
?>

