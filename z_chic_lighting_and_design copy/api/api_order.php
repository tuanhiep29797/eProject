<?php
    $orders = 
    [
        [
            "user_id" => 2,
            "order_status" => "delivered",
            "total_amount" => 7450000.00,
            "receiver" => "Nguyen Tuan Hiep",
            "phone_number" => "0901234567",
            "address" => "123 Le Loi, Quan 1, TP.HCM"
        ],
        [
            "user_id" => 2,
            "order_status" => "shipped",
            "total_amount" => 1650000.00,
            "receiver" => "Nguyen Tuan Hiep",
            "phone_number" => "0901234567",
            "address" => "123 Le Loi, Quan 1, TP.HCM"
        ],
        [
            "user_id" => 3,
            "order_status" => "delivered",
            "total_amount" => 3000000.00,
            "receiver" => "Ngo Vi Dong",
            "phone_number" => "0912345678",
            "address" => "456 Nguyen Hue, Quan 1, TP.HCM"
        ],
        [
            "user_id" => 3,
            "order_status" => "processing",
            "total_amount" => 450000.00,
            "receiver" => "Ngo Vi Dong",
            "phone_number" => "0912345678",
            "address" => "456 Nguyen Hue, Quan 1, TP.HCM"
        ],
        [
            "user_id" => 4,
            "order_status" => "delivered",
            "total_amount" => 6700000.00,
            "receiver" => "Nguyen Kieu Van Nhi",
            "phone_number" => "0923456789",
            "address" => "789 Tran Hung Dao, Quan 5, TP.HCM"
        ],
        [
            "user_id" => 5,
            "order_status" => "shipped",
            "total_amount" => 6300000.00,
            "receiver" => "Bui Doan Manh",
            "phone_number" => "0934567890",
            "address" => "321 Hai Ba Trung, Quan 3, TP.HCM"
        ],
        [
            "user_id" => 5,
            "order_status" => "pending",
            "total_amount" => 1200000.00,
            "receiver" => "Bui Doan Manh",
            "phone_number" => "0934567890",
            "address" => "321 Hai Ba Trung, Quan 3, TP.HCM"
        ],
        [
            "user_id" => 6,
            "order_status" => "delivered",
            "total_amount" => 2790000.00,
            "receiver" => "Pham Thanh Phat",
            "phone_number" => "0945678901",
            "address" => "654 Vo Van Tan, Quan 3, TP.HCM"
        ],
        [
            "user_id" => 7,
            "order_status" => "delivered",
            "total_amount" => 3950000.00,
            "receiver" => "Tran Minh Quan",
            "phone_number" => "0956789012",
            "address" => "987 Pasteur, Quan 1, TP.HCM"
        ],
        [
            "user_id" => 7,
            "order_status" => "cancelled",
            "total_amount" => 5500000.00,
            "receiver" => "Tran Minh Quan",
            "phone_number" => "0956789012",
            "address" => "987 Pasteur, Quan 1, TP.HCM"
        ],
        [
            "user_id" => 8,
            "order_status" => "processing",
            "total_amount" => 4100000.00,
            "receiver" => "Le Hoang Nam",
            "phone_number" => "0967890123",
            "address" => "159 Ly Tu Trong, Quan 1, TP.HCM"
        ],
        [
            "user_id" => 9,
            "order_status" => "delivered",
            "total_amount" => 1680000.00,
            "receiver" => "Vo Thi Mai",
            "phone_number" => "0978901234",
            "address" => "753 Dien Bien Phu, Quan Binh Thanh, TP.HCM"
        ],
        [
            "user_id" => 9,
            "order_status" => "shipped",
            "total_amount" => 2500000.00,
            "receiver" => "Vo Thi Mai",
            "phone_number" => "0978901234",
            "address" => "753 Dien Bien Phu, Quan Binh Thanh, TP.HCM"
        ],
        [
            "user_id" => 10,
            "order_status" => "delivered",
            "total_amount" => 1600000.00,
            "receiver" => "Hoang Van Duc",
            "phone_number" => "0989012345",
            "address" => "246 Cach Mang Thang 8, Quan 10, TP.HCM"
        ],
        [
            "user_id" => 11,
            "order_status" => "pending",
            "total_amount" => 2750000.00,
            "receiver" => "Phan Thi Lan",
            "phone_number" => "0990123456",
            "address" => "135 Ba Thang Hai, Quan 10, TP.HCM"
        ]
    ];

    try
    {
        $conn = getConnection();
        foreach ($orders as $order) {
            $stmt = $conn->prepare(SQL_ADD_ORDER);
            $stmt->bindParam(":user_id", $order["user_id"]);
            $stmt->bindParam(":order_status", $order["order_status"]);
            $stmt->bindParam(":total_amount", $order["total_amount"]);
            $stmt->bindParam(":receiver", $order["receiver"]);
            $stmt->bindParam(":phone_number", $order["phone_number"]);
            $stmt->bindParam(":address", $order["address"]);
            $stmt->execute();
        }
    }
    catch (PDOException $e)
    {
        echo $e->getMessage();
    }

    $conn = null;
?>

