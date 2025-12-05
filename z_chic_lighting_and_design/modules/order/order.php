<?php
    require_once __DIR__."/../../database/dbhelper.php";
    
    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_GET_ORDER);
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
    <title>Order Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
</head>
<body>
    <?php require_once __DIR__."/../../admin/header.php";?>
    <h1 class="text-center my-4">ORDER MANAGER</h1>

    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">USER ID</th>
                <th scope="col">STATUS</th>
                <th scope="col">Total Amount</th>
                <th scope="col">Receiver</th>
                <th scope="col">Address</th>
                <th scope="col">Order Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($data_list as $item):?>
                <tr>
                    <th scope="row"><?= $item['order_id'] ?></td>
                    <td><?= $item['user_id'] ?>?></td>
                    <td><?= $item['order_status'] ?>?></td>
                    <td><?= $item['total_amount'] ?>?></td>
                    <td><?= $item['receiver'] ?>?></td>
                    <td><?= $item['address'] ?>?></td>
                    <td><?= $item['order_date'] ?>?></td>
                    <td>
                        <a href="edit_order.php?id=<?= $item['order_id'] ?>" class="btn btn-primary">
                            <i class="bi bi-pencil-square"></i>
                        </a>                     
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>