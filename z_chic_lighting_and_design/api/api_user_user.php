<?php
    $users = [
        [
            "fullname" => "User",
            "username" => "user",
            "email" => "user@gmail.com",
            "phone_number" => "0123456789",
            "password" => "user",
            "role" => "user"
        ],
        [
            "fullname" => "Nguyen Tuan Hiep",
            "username" => "nguyentuanhiep",
            "email" => "nguyentuanhiep@gmail.com",
            "phone_number" => "029071997",
            "password" => "nguyentuanhiep",
            "role" => "user"
        ],
        [
            "fullname" => "Ngo Vi Dong",
            "username" => "ngovidong",
            "email" => "ngovidong@gmail.com",
            "phone_number" => "029071997",
            "password" => "ngovidong",
            "role" => "user"
        ],
        [
            "fullname" => "Nguyen Kieu Van Nhi",
            "username" => "nguyenkieuvannhi",
            "email" => "nguyenkieuvannhi@gmail.com",
            "phone_number" => "029071997",
            "password" => "nguyenkieuvannhi",
            "role" => "user"
        ],
        [
            "fullname" => "Bui Doan Manh",
            "username" => "buidoanmanh",
            "email" => "buidoanmanh@gmail.com",
            "phone_number" => "029071997",
            "password" => "buidoanmanh",
            "role" => "user"
        ],
        [
            "fullname" => "Pham Thanh Phat",
            "username" => "phamthanhphat",
            "email" => "phamthanhphat@gmail.com",
            "phone_number" => "029071997",
            "password" => "phamthanhphat",
            "role" => "user"
        ]
    ];
    
 

    try
    {
        $conn = getConnection();
        foreach ($users as $user) {
            $user["password"] = password_hash($user["password"], PASSWORD_DEFAULT);
            $stmt = $conn -> prepare(SQL_ADD_USER);
            $stmt -> bindParam(":fullname", $user["fullname"]);
            $stmt -> bindParam(":username", $user["username"]);
            $stmt -> bindParam(":email", $user["email"]);
            $stmt -> bindParam(":phone_number", $user["phone_number"]);
            $stmt -> bindParam(":password", $user["password"]);
            $stmt -> bindParam(":role", $user["role"]);
            $stmt -> execute();
        }
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    };

    $conn = null;
?>

