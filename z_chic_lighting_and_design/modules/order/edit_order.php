<?php
    require_once __DIR__."/../../database/dbhelper.php";
    if(empty($_GET))
    {
        header("Location: ../home_admin.php");
    }

    $id = $_GET['id'];

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_GET_ORDER_BY_ID);
        $stmt -> bindParam(':id', $id);
        $stmt -> execute();

        $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt -> fetchAll();

        $item = $data_list[0];
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $selected[$item['order_status']] = "selected";

    $conn = null;

    if (!empty($_POST))
    {
        $order_status = $_POST['order_status'];
        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_UPDATE_ORDER);      
            $stmt -> bindParam(':order_status', $order_status);        
            $stmt -> bindParam(':id', $id);
            $stmt -> execute();

            header("Location: ../home_admin.php");
        }
        catch (PDOException $e)
        {
            echo $e -> getMessage();
        }

        $conn = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once __DIR__."/../../admin/header.php";?>
    <h1>EDIT ORDER</h1>
    <a href="../home_admin.php"><button class="btn btn-primary">ADMIN PAGE</button></a>

    <form method="post">
         <div class="mb-3">
            <label for="disabledTextInput" class="form-label">User ID</label>
            <input type="text" id="disabledTextInput" class="form-control" value="<?= $item['user_id'] ?>?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select class="form-select" aria-label="Default select example">
                <option <?= $selected['pending'] ?? "" ?> value="pending">Pending</option>
                <option <?= $selected['processing'] ?? "" ?> value="processing">Processing</option>
                <option <?= $selected['shipped'] ?? "" ?> value="shipped">Shipped</option>
                <option <?= $selected['delivered'] ?? "" ?> value="delivered">Delivered</option>
                <option <?= $selected['cancelled'] ?? "" ?> value="cancelled">Cancelled</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="disabledTextInput" class="form-label">Total Amount</label>
            <input type="text" id="disabledTextInput" class="form-control" value="<?= $item['total_amount'] ?>?>">
        </div>

        <div class="mb-3">
            <label for="disabledTextInput" class="form-label">Receiver</label>
            <input type="text" id="disabledTextInput" class="form-control" value="<?= $item['receiver'] ?>?>">
        </div>

        <div class="mb-3">
            <label for="disabledTextInput" class="form-label">Address</label>
            <input type="text" id="disabledTextInput" class="form-control" value="<?= $item['address'] ?>?>">
        </div>

        <div class="mb-3">
            <label for="disabledTextInput" class="form-label">Order Date</label>
            <input type="text" id="disabledTextInput" class="form-control" value="<?= $item['order_date'] ?>?>">
        </div>
        
        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>