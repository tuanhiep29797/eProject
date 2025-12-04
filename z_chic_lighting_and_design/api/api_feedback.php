<?php
    $feedbacks = [
        [
            "username" => "tuanhiep",
            "email" => "th@gmail.com",
            "phone_number" => "0987787888",
            "content" => "Good shop!"
        ],
        [
            "username" => "vidong",
            "email" => "vd@gmail.com",
            "phone_number" => "0987787888",
            "content" => "MU champion of C4!"
        ],
        [
            "username" => "doanmanh",
            "email" => "dm@gmail.com",
            "phone_number" => "0987787888",
            "content" => "Gooddddddđ shop!"
        ],
        [
            "username" => "thanhphat",
            "email" => "tp@gmail.com",
            "phone_number" => "0987787888",
            "content" => "Gooooooooooooooooood shop!"
        ],
        [
            "username" => "vannhi",
            "email" => "vn@gmail.com",
            "phone_number" => "0987787888",
            "content" => "Good shoppppppppppp!"
        ],
    ];
    
    try
    {
        $conn = getConnection();
        foreach ($feedbacks as $item)
        {
            $stmt = $conn -> prepare(SQL_ADD_FEEDBACK);
            $stmt -> bindParam(":username", $item["username"]);
            $stmt -> bindParam(":email", $item["email"]);
            $stmt -> bindParam(":phone_number", $item["phone_number"]);
            $stmt -> bindParam(":content", $item["content"]);
            $stmt -> execute();
        }
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    };

    $conn = null;
?>