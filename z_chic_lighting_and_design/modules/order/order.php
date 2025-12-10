<?php
    require_once (__DIR__."/../../database/dbhelper.php");
    
    // connect database and get order table
    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_GET_ORDER . " order by order_id desc");
        $stmt -> execute();

        $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $order_list = $stmt -> fetchAll();
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/modules.css">
</head>
<body>
    <!-- include header -->
    <?php
        require_once __DIR__."/../../admin/admin_header.php"; 
    ?>

    <!-- breadcrumb -->
    <?php
        $breadcrumb = 
        [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-people-fill", "label" => "Order Management"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php"; 
    ?>

    <!-- body order management page -->
    <div class="container table-container mt-4">
        <form method="post" action = 'save_order.php' >
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="page-title">
                <i class="bi bi-boxes me-2"></i>
                Order Management
            </h2>

            <button type='submit' class="btn btn-success">
                <i class="bi bi-patch-check-fill"></i>
                Save All
            </button>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Receiver</th>
                        <th scope="col">Phone Number</th>
                        <th scope="col">Address</th>
                        <th scope="col">Status</th>
                        <th scope="col">Order Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($order_list as $item): ?>
                        <?php
                            $selected = [];
                            $selected[$item["order_status"]] = "selected";
                        ?>
                        <input type="hidden" name="order_id[]" value="<?= $item["order_id"] ?>">
                        <tr>
                            <th><?= $item["order_id"] ?></th>
                            <td>$<?= number_format($item["total_amount"],2) ?></td>
                            <td><?= $item["receiver"] ?></td>
                            <td><?= $item["phone_number"] ?></td>
                            <td><?= $item["address"] ?></td>
                            <td>    
                                <select class="form-select" name="order_status[]"
                                    style="color:<?= isset($selected["pending"]) || isset($selected["cancelled"]) ? 
                                                "red" :
                                                (isset($selected["processing"]) ? "orange" :
                                                    (isset($selected["shipped"]) ? "brown" : "green"))?>;"
                                >

                                    <option style="color:red;" <?= $selected["pending"]  ?? "" ?> value="pending">⏰Pending</option>
                                    <option style="color:orange;" <?= $selected["processing"] ?? "" ?> value="processing">📦Processing</option>
                                    <option style="color:brown;" <?= $selected["shipped"]    ?? "" ?> value="shipped">🚕Shipped</option>
                                    <option style="color:green;" <?= $selected["delivered"]  ?? "" ?> value="delivered">✅Delivered</option>
                                    <option style="color:red;" <?= $selected["cancelled"]  ?? "" ?> value="cancelled">❌Cancelled</option>
                                </select>
                            </td>
                            <td><?= date("H:i d/m/Y", strtotime($item["order_date"])) ?></td>

                            <td>
                                <a href="edit_order.php?id=<?= $item["order_id"] ?>" 
                                   class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <a href="order_detail.php?id=<?= $item["order_id"] ?>" 
                                   class="btn btn-info btn-sm text-white">
                                    <i class='bi bi-eye-fill'></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>

            </table>
        </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>