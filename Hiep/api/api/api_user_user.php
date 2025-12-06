<?php
    $users = [
        [
            "fullname" => "Nguyen Tuan Hiep",
            "username" => "nguyentuanhiep",
            "email" => "nguyentuanhiep@gmail.com",
            "phone_number" => "0901234567",
            "password" => "nguyentuanhiep",
            "role" => "user"
        ],
        [
            "fullname" => "Ngo Vi Dong",
            "username" => "ngovidong",
            "email" => "ngovidong@gmail.com",
            "phone_number" => "0912345678",
            "password" => "ngovidong",
            "role" => "user"
        ],
        [
            "fullname" => "Nguyen Kieu Van Nhi",
            "username" => "nguyenkieuvannhi",
            "email" => "nguyenkieuvannhi@gmail.com",
            "phone_number" => "0923456789",
            "password" => "nguyenkieuvannhi",
            "role" => "user"
        ],
        [
            "fullname" => "Bui Doan Manh",
            "username" => "buidoanmanh",
            "email" => "buidoanmanh@gmail.com",
            "phone_number" => "0934567890",
            "password" => "buidoanmanh",
            "role" => "user"
        ],
        [
            "fullname" => "Pham Thanh Phat",
            "username" => "phamthanhphat",
            "email" => "phamthanhphat@gmail.com",
            "phone_number" => "0945678901",
            "password" => "phamthanhphat",
            "role" => "user"
        ],
        [
            "fullname" => "Tran Minh Quan",
            "username" => "tranminhquan",
            "email" => "tranminhquan@gmail.com",
            "phone_number" => "0956789012",
            "password" => "tranminhquan",
            "role" => "user"
        ],
        [
            "fullname" => "Le Hoang Nam",
            "username" => "lehoangnam",
            "email" => "lehoangnam@gmail.com",
            "phone_number" => "0967890123",
            "password" => "lehoangnam",
            "role" => "user"
        ],
        [
            "fullname" => "Vo Thi Mai",
            "username" => "vothimai",
            "email" => "vothimai@gmail.com",
            "phone_number" => "0978901234",
            "password" => "vothimai",
            "role" => "user"
        ],
        [
            "fullname" => "Hoang Van Duc",
            "username" => "hoangvanduc",
            "email" => "hoangvanduc@gmail.com",
            "phone_number" => "0989012345",
            "password" => "hoangvanduc",
            "role" => "user"
        ],
        [
            "fullname" => "Phan Thi Lan",
            "username" => "phanthilan",
            "email" => "phanthilan@gmail.com",
            "phone_number" => "0990123456",
            "password" => "phanthilan",
            "role" => "user"
        ]
    ];
    
    try
    {
        $conn = getConnection();
        foreach ($users as $user) {
            $hashedPassword = password_hash($user["password"], PASSWORD_DEFAULT);
            $stmt = $conn -> prepare(SQL_ADD_USER);
            $stmt -> bindParam(":fullname", $user["fullname"]);
            $stmt -> bindParam(":username", $user["username"]);
            $stmt -> bindParam(":email", $user["email"]);
            $stmt -> bindParam(":phone_number", $user["phone_number"]);
            $stmt -> bindParam(":password", $hashedPassword);
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