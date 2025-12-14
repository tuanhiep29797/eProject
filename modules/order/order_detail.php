<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    $order_id = $_GET["id"] ?? null;

    if (!$order_id) {
        die("Order ID not found.");
    }

    try {
        $conn = getConnection();

        $stmt = $conn->prepare(SQL_GET_ORDER_BY_ID);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $order = $stmt->fetch();

        $stmt = $conn->prepare(SQL_GET_ORDER_DETAIL);
        $stmt->bindParam(":order_id", $order_id);
        $stmt->execute();
        $order_detail = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Detail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modules.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>
    <!-- include header -->
    <?php 
        require_once __DIR__."/../../admin/admin_header.php"; 
    ?>

    <!-- breadcrumb -->
    <?php
        $breadcrumb = [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-bag-check-fill", "label" => "Order Management", "url" => "order.php"],
            ["icon" => "bi-eye-fill", "label" => "Order Detail"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php";
    ?>

    <!-- body -->
    <div class="container mt-4">

        <h2 class="page-title mb-4">
            <i class="bi bi-file-earmark-text-fill me-2"></i>
            Order Detail #<?= $order_id ?>
        </h2>

        <!-- Order Information -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <strong>Order Information</strong>
            </div>
            <div class="card-body">
                <p><strong>User ID:</strong> <?= $order["user_id"] ?></p>
                <p><strong>Status:</strong> <?= $order["order_status"] ?></p>
                <p><strong>Total Amount:</strong> $<?= number_format($order["total_amount"], 0, ',', '.') ?></p>
                <p><strong>Receiver:</strong> <?= $order["receiver"] ?></p>
                <p><strong>Phone:</strong> <?= $order["phone_number"] ?></p>
                <p><strong>Address:</strong> <?= $order["address"] ?></p>
                <p><strong>Order Date:</strong> <?= date("H:i:s d/m/Y", strtotime($order["order_date"])) ?></p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="card shadow-sm">
            <div class="card-header bg-secondary text-white">
                <strong>Order Items</strong>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th>Item ID</th>
                            <th>Product</th>
                            <th>Thumbnail</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($order_detail)): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted">No items found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($order_detail as $row): ?>
                                <tr>
                                    <td><?= $row["order_id"] ?></td>
                                    <td><?= $row["product_title"] ?></td>
                                    <td>
                                        <img src="<?= BASE_URL . $row["product_thumbnail"] ?>" 
                                             style="width:60px; height:60px; object-fit:cover"
                                             class="rounded border">
                                    </td>
                                    <td><?= $row["quantity"] ?></td>
                                    <td>$<?= number_format($row["product_price"]) ?></td>
                                    <td>$<?= number_format($row["product_price"] * $row["quantity"]) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>

                </table>
            </div>
        </div>

        <a href="order.php" class="btn btn-secondary mb-4 mt-3 py-3 px-4">
            <i class="bi bi-arrow-left"></i> Back
        </a>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
