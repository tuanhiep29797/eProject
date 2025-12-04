<?php
    $users = [
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
            $admin["password"] = password_hash($admin["password"], PASSWORD_DEFAULT);
            $stmt = $conn -> prepare(SQL_ADD_USER);
            $stmt -> bindParam(":fullname", $admin["fullname"]);
            $stmt -> bindParam(":username", $admin["username"]);
            $stmt -> bindParam(":email", $admin["email"]);
            $stmt -> bindParam(":phone_number", $admin["phone_number"]);
            $stmt -> bindParam(":password", $admin["password"]);
            $stmt -> bindParam(":role", $admin["role"]);
            $stmt -> execute();
        }
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    };

    $conn = null;
?>