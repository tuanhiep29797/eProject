<?php
require_once(__DIR__ . "/../config.php");

require_once(__DIR__ . "/../database/dbhelper.php");

try {
    $conn = getConnection();
    $stmt = $conn->prepare(SQL_GET_ORDER . " order by order_id desc limit 5");
    $stmt->execute();

    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $order_list = $stmt->fetchAll();

    $stmt = $conn->prepare(SQL_GET_FEEDBACK . " where status = 'new' order by created_at desc limit 6");
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $feedback_list = $stmt->fetchAll();

    $stmt = $conn->prepare(SQL_GET_USER);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $userList = $stmt->fetchAll();
    $count_user = count($userList);

    $stmt = $conn->prepare(SQL_GET_PRODUCT);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $productList = $stmt->fetchAll();
    $count_product = count($productList);

    $stmt = $conn->prepare(SQL_GET_ORDER);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $orderList = $stmt->fetchAll();
    $count_order = count($orderList);
    
    $total_amount = 0;
    foreach($orderList as $item){
        $total_amount +=$item['total_amount'];
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}

$conn = null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

    <?php require_once("admin_header.php"); ?>
    <div class="container-fluid">
        <div class="d-flex">
            <?php require_once("admin_side_bar.php"); ?>

            <div class="py-4 m-auto">

                <!-- TITLE -->
                <h2 class="text-center fw-bold mb-4">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Admin Dashboard
                </h2>

                <main class="px-3">

                    <!-- TOP BAR -->
                    <div class="d-flex justify-content-between align-items-center mb-4 ">
                        <!-- TODO: thay bằng tên admin từ PHP -->
                        <h3 class="fw-bold">Hello, Admin 👋</h3>
                    </div>

                    <!-- TOP FOUR CARDS -->
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-4">

                        <!-- TODO: gắn total customers từ PHP -->
                        <div class="col">
                            <div class="card dashboard-card p-3">
                                <a href='<?= BASE_URL ?>admin/user' class='text-decoration-none text-dark'>
                                    <div class="icon-box purple"><i class="bi bi-people"></i></div>
                                    <h6 class="mt-2">Total Customers</h6>
                                    <p class="value"><?= $count_user ?>+</p>
                                </a>
                            </div>
                        </div>

                        <!-- TODO: gắn số sản phẩm từ PHP -->
                        <div class="col">
                            <div class="card dashboard-card p-3">
                                <a href='<?= BASE_URL ?>admin/product' class='text-decoration-none text-dark'>
                                    <div class="icon-box yellow"><i class="bi bi-box"></i></div>
                                    <h6 class="mt-2">Total Products</h6>
                                    <p class="value"><?= $count_product ?>+</p>
                                </a>
                            </div>
                        </div>

                        <!-- TODO: gắn đơn hàng từ PHP -->
                        <div class="col">
                            <div class="card dashboard-card p-3">
                                <a href='<?= BASE_URL ?>admin/order' class='text-decoration-none text-dark'>
                                    <div class="icon-box red"><i class="bi bi-cart4"></i></div>
                                    <h6 class="mt-2">Total Orders</h6>
                                    <p class="value"><?= $count_order ?>+</p>
                                </a>
                            </div>
                        </div>

                        <!-- TODO: gắn doanh thu từ PHP -->
                        <div class="col">
                            <a href='<?= BASE_URL ?>admin/order' class='text-decoration-none text-dark'>
                            <div class="card dashboard-card p-3">
                                <div class="icon-box green"><i class="bi bi-cash-stack"></i></div>
                                <h6 class="mt-2">Total Amount</h6>
                                <p class="value">$<?= number_format($total_amount,2) ?></p>
                            </div>
                            </a>
                        </div>

                    </div>

                    <div class="row mt-4 g-4">
                        <div class="col-xl-8"> 
                            <div class="card p-3 text-left" style="height: auto;">
                                <a href='<?= BASE_URL ?>admin/order' class='text-decoration-none text-dark'>
                                    <h5 class="fw-bold mb-4">All Orders</h5>
                                </a>
                                <table class="table table-bordered table-hover table-striped align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th scope="col">Order ID</th>
                                            <th scope="col">Total Amount</th>
                                            <th scope="col">Receiver</th>
                                            <th scope="col">Phone Number</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Order Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($order_list as $item): ?>
                                            <?php
                                            $selected = [];
                                            $selected[$item["order_status"]] = "selected";
                                            ?>
                                            <input type="hidden" name="order_id[]" value="<?= $item["order_id"] ?>">
                                            <tr>
                                                <th><?= $item["order_id"] ?></th>
                                                <td>$<?= number_format($item["total_amount"], 2) ?></td>
                                                <td><?= $item["receiver"] ?></td>
                                                <td><?= $item["phone_number"] ?></td>
                                                <td>
                                                    <?php switch ($item["order_status"]) {
                                                        case "pending":
                                                            echo '<p style="color:red;">⏰ Pending</p>';
                                                            break;
                                                        case "processing":
                                                            echo '<p style="color:orange;">📦 Processing</p>';
                                                            break;

                                                        case "shipped":
                                                            echo '<p style="color:brown;">🚕 Shipped</p>';
                                                            break;
                                                        case "delivered":
                                                            echo '<p style="color:green;">✅ Delivered</p>';
                                                            break;
                                                        case "cancelled":
                                                            echo '<p style="color:red;">❌ Cancelled</p>';
                                                            break;
                                                    }
                                                    ?>

                                                    </select>
                                                </td>
                                                <td><?= date("H:i d/m/Y", strtotime($item["order_date"])) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                        <!-- Chart area 2 -->
                        <div class="col-xl-4">
                            <div class="card text-left p-3" style="height: auto;">
                                <a href='<?= BASE_URL ?>admin/feedback' class='text-decoration-none text-dark'>
                                    <h5 class="fw-bold mb-4">New Feedback</h5>
                                </a>
                                <table class="table table-bordered table-hover table-striped align-middle">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Content</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($feedback_list as $index => $item): ?>

                                            <?php
                                            $status = ($item["status"] === "new")
                                                ? "<span class='badge bg-danger'>New</span>"
                                                : "<span class='badge bg-success'>Read</span>";
                                            ?>

                                            <tr class="<?= $item["status"] === "new" ? 'table-warning' : '' ?>">
                                                <th><?= $index + 1 ?></th>
                                                <td><?= $item["username"] ?></td>
                                                <td><?= $item["content"] ?></td>
                                            </tr>

                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>