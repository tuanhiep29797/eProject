<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!isset($_GET["id"])) 
    {
        header("Location:" . BASE_URL . "admin/order");
        exit;
    }

    $order_id = $_GET["id"];

    //connection to database and get order by id
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_ORDER_BY_ID);
        $stmt -> bindParam(":order_id", $order_id);
        $stmt -> execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $order_list = $stmt->fetch();

        if ($order_list == null || count($order_list) == 0) {
            header("Location:" . BASE_URL . "admin/order");
            exit;
        }
        else
        {
            $selected[$order_list["order_status"]] = "selected";

            //update order when submit form
            if (!empty($_POST)) 
            {
                //get new data
                $order_status = $_POST["order_status"];
                $receiver     = $_POST["receiver"];
                $phone_number = $_POST["phone_number"];
                $address      = $_POST["address"];

                //connection to database and update order
                try 
                {
                    $conn = getConnection();
                    $stmt = $conn->prepare(SQL_UPDATE_ORDER);

                    $stmt->bindParam(":order_status", $order_status);
                    $stmt->bindParam(":receiver", $receiver);
                    $stmt->bindParam(":phone_number", $phone_number);
                    $stmt->bindParam(":address", $address);
                    $stmt->bindParam(":order_id", $order_id);

                    $stmt->execute();

                    header("Location:" . BASE_URL . "admin/order");
                    exit;
                }
                catch (PDOException $e) 
                {
                    echo $e->getMessage();
                }
            }
        }   
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $conn = null;
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modules.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

    <!-- include header -->
    <?php 
        require_once (__DIR__."/../../admin/admin_header.php"); 
    ?>

    <!-- breadcrumb -->
    <?php
        $breadcrumb = [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => BASE_URL . "admin/dashboard"],
            ["icon" => "bi-receipt",    "label" => "Order Management", "url" => BASE_URL . "admin/order"],
            ["icon" => "bi-pencil-square", "label" => "Edit Order"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php");
    ?>

    <!-- body -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-8">

                <h2 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Order
                </h2>

                <!-- edit form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">User ID</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order_list["user_id"]) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select class="form-select" name="order_status">
                            <option <?= $selected["pending"]    ?? "" ?> value="pending">Pending</option>
                            <option <?= $selected["processing"] ?? "" ?> value="processing">Processing</option>
                            <option <?= $selected["shipped"]    ?? "" ?> value="shipped">Shipped</option>
                            <option <?= $selected["delivered"]  ?? "" ?> value="delivered">Delivered</option>
                            <option <?= $selected["cancelled"]  ?? "" ?> value="cancelled">Cancelled</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Receiver</label>
                        <input type="text" class="form-control" name="receiver"
                               value="<?= htmlspecialchars($order_list["receiver"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" name="phone_number"
                               value="<?= htmlspecialchars($order_list["phone_number"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <input type="text" class="form-control" name="address"
                               value="<?= htmlspecialchars($order_list["address"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Total Amount</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order_list["total_amount"]) ?>" disabled>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Order Date</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($order_list["order_date"]) ?>" disabled>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Order</button>
                    <a href="<?= BASE_URL ?>admin/order" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
