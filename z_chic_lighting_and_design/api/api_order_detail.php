<?php
    $order_details = [
        ["order_id" => 1, "product_id" => 1, "quantity" => 1, "unit_price" => 5500000.00],  // Philips Crystal Chandelier
        ["order_id" => 1, "product_id" => 5, "quantity" => 1, "unit_price" => 1950000.00],  // Nordic Floor Lamp
        
        ["order_id" => 2, "product_id" => 8, "quantity" => 1, "unit_price" => 1650000.00],  // Philips Hue Bulb
        
        ["order_id" => 3, "product_id" => 2, "quantity" => 2, "unit_price" => 850000.00],   // ArtDecor Wall Lamp x2
        ["order_id" => 3, "product_id" => 6, "quantity" => 2, "unit_price" => 450000.00],   // Panasonic Track Light x2
        ["order_id" => 3, "product_id" => 19, "quantity" => 2, "unit_price" => 180000.00],  // COB Downlight x2
        
        ["order_id" => 4, "product_id" => 10, "quantity" => 1, "unit_price" => 450000.00],  // Industrial Pendant
        
        ["order_id" => 5, "product_id" => 4, "quantity" => 1, "unit_price" => 4800000.00],  // Hunter Ceiling Fan
        ["order_id" => 5, "product_id" => 12, "quantity" => 2, "unit_price" => 750000.00],  // Reading Wall Lamp x2
        ["order_id" => 5, "product_id" => 20, "quantity" => 2, "unit_price" => 250000.00],  // Surface Tube Light x2
        
        ["order_id" => 6, "product_id" => 15, "quantity" => 1, "unit_price" => 5500000.00], // Wooden Blade Fan
        ["order_id" => 6, "product_id" => 22, "quantity" => 4, "unit_price" => 200000.00],  // Edison Bulb Set x4
        
        ["order_id" => 7, "product_id" => 3, "quantity" => 1, "unit_price" => 1200000.00],  // Panasonic Garden Light
        
        ["order_id" => 8, "product_id" => 6, "quantity" => 4, "unit_price" => 450000.00],   // Panasonic Track Light x4
        ["order_id" => 8, "product_id" => 19, "quantity" => 5, "unit_price" => 180000.00],  // COB Downlight x5
        
        ["order_id" => 9, "product_id" => 9, "quantity" => 1, "unit_price" => 1250000.00],  // Modern Ceiling LED
        ["order_id" => 9, "product_id" => 14, "quantity" => 1, "unit_price" => 1500000.00], // Floodlight 100W
        ["order_id" => 9, "product_id" => 17, "quantity" => 1, "unit_price" => 1200000.00], // Ceramic Table Lamp
        
        ["order_id" => 10, "product_id" => 15, "quantity" => 1, "unit_price" => 5500000.00], // Wooden Blade Fan
        
        ["order_id" => 11, "product_id" => 11, "quantity" => 2, "unit_price" => 950000.00],  // Outdoor Wall Sconce x2
        ["order_id" => 11, "product_id" => 16, "quantity" => 1, "unit_price" => 2200000.00], // Compact Bedroom Fan
        
        ["order_id" => 12, "product_id" => 13, "quantity" => 2, "unit_price" => 680000.00],  // Solar Pathway Set x2
        ["order_id" => 12, "product_id" => 7, "quantity" => 1, "unit_price" => 250000.00],   // LED Neon Flex
        
        ["order_id" => 13, "product_id" => 20, "quantity" => 4, "unit_price" => 250000.00],  // Surface Tube Light x4
        ["order_id" => 13, "product_id" => 21, "quantity" => 2, "unit_price" => 350000.00],  // RGB Smart Strip x2
        ["order_id" => 13, "product_id" => 19, "quantity" => 3, "unit_price" => 180000.00],  // COB Downlight x3
        
        ["order_id" => 14, "product_id" => 22, "quantity" => 2, "unit_price" => 200000.00],  // Edison Bulb Set x2
        ["order_id" => 14, "product_id" => 17, "quantity" => 1, "unit_price" => 1200000.00], // Ceramic Table Lamp
        
        ["order_id" => 15, "product_id" => 18, "quantity" => 1, "unit_price" => 1800000.00], // Bamboo Floor Lamp
        ["order_id" => 15, "product_id" => 23, "quantity" => 1, "unit_price" => 950000.00]   // Smart Wifi Ceiling
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

