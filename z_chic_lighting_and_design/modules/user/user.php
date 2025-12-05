<?php
    require_once __DIR__."/../../database/dbhelper.php";
    
    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_GET_USER);
        $stmt -> execute();

        $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt -> fetchAll();
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
</head>
</head>
<body>
    <?php require_once __DIR__."/../../admin/header.php";?>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>User Management</h1>
            </div>
        </div>
    </div>

    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Fullname</th>
                <th scope="col">Username</th>
                <th scope="col">Email</th>
                <th scope="col">Phone Number</th>
                <th scope="col">Role</th>
                <th scope="col">Created At</th>
                <th scope="col">Updated At</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_list as $item):?>
                <tr>
                    <th scope="row"><?= $item['user_id'] ?></td>
                    <td><?= $item['fullname'] ?></td>
                    <td><?= $item['username'] ?></td>
                    <td><?= $item['email'] ?></td>
                    <td><?= $item['phone_number'] ?></td>
                    <td><?= $item['role'] ?></td>
                    <td><?= $item['created_at'] ?></td>
                    <td><?= $item['updated_at'] ?></td>
                    <td>                       
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>