<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

    $products = [];
    $count = 1;

    //get order data
    if (isset($_SESSION["user_id"])) 
    {
        $user_id = $_SESSION["user_id"];

        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_GET_ORDER_BY_USER_ID);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $order_history = $stmt->fetchAll();
        } 
        catch (PDOException $e) 
        {
            echo "<script>
                    console.error(" . json_encode($e->getMessage()) . ");
                </script>";
            exit();
        }

        $order_history = array_reverse($order_history);

        $order_id_list = [];
        foreach ($order_history as $item) 
        {
            $order_id_list[$item['order_id']]['order_id'] = $item['receiver'];
            $order_id_list[$item['order_id']]['receiver'] = $item['receiver'];
            $order_id_list[$item['order_id']]['phone_number'] = $item['phone_number'];
            $order_id_list[$item['order_id']]['address'] = $item['address'];
            $order_id_list[$item['order_id']]['order_status'] = $item['order_status'];
            $order_id_list[$item['order_id']]['order_date'] = $item['order_date'];
        }

        $conn = null;
    } 
    else 
    {
        echo '<script>
            alert("Please log in");
            window.location.href = "' . BASE_URL . 'login";
        </script>';
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/style.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

    <!-- include header -->
    <?php
    require_once(__DIR__ . "/../includes/home_header.php");
    ?>

    <!-- banner -->
    <div class="page-banner">
        <div class="container">
            <h2>Order History</h2>

            <div class="banner-breadcrumb">
                <a href="<?= BASE_URL ?>home">Home</a>

                <i class="bi bi-chevron-right"></i>

                <a href="<?= BASE_URL ?>user/infomation">Account</a>

                <i class="bi bi-chevron-right"></i>

                <a href="#">Order History</a>

            </div>
        </div>
    </div>

    <!-- body -->
    <div class="container px-3 px-md-4">
    <div class="shopping-cart">
        <div class="shopping-cart-header my-3 my-md-4 text-center">
            <h1>Order History</h1>
        </div>
        <div class="shopping-cart-product m-0 m-md-3 m-xl-5 px-0 px-md-3 px-xl-5 row g-4" style="border: 1px;">
            <div class="col-12 col-md-4 col-xl-4 mb-4 mb-xl-0">
                <div class="account-card p-3 p-md-4">
                    <h5 class="fw-bold mb-3 mb-md-4">Account</h5>

                    <a href="<?= BASE_URL ?>user/infomation" class="account-item">
                        <i class="bi bi-person"></i>
                        <div>
                            <p class="title">My Profile</p>
                            <span class="desc d-none d-md-block">Change your profile details & password</span>
                        </div>
                    </a>

                    <a href="#" class="account-item">
                        <i class="bi bi-bag-check"></i>
                        <div>
                            <p class="title">My Orders</p>
                            <span class="desc d-none d-md-block">View & Manage orders</span>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-12 col-md-8 col-xl-8">
            <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="d-none d-md-table-cell">STT</th>
                        <th>Receiver</th>
                        <th class="d-none d-xl-table-cell">Phone</th>
                        <th class="d-none d-xl-table-cell">Address</th>
                        <th>Status</th>
                        <th class="d-none d-md-table-cell">Date</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($order_id_list as $order_id => $info): ?>
                        
                        <!-- row order -->
                        <tr>
                            <td class="d-none d-md-table-cell"><?= $count++ ?></td>
                            <td><?= $info['receiver'] ?></td>
                            <td class="d-none d-xl-table-cell"><?= $info['phone_number'] ?></td>
                            <td class="d-none d-xl-table-cell"><?= $info['address'] ?></td>

                            <td>
                                <?php if ($info['order_status'] === 'pending'): ?>
                                    <span class="badge bg-danger-subtle text-danger"><i class="bi bi-clock-history"></i> Pending</span>

                                <?php elseif ($info['order_status'] === 'processing'): ?>
                                    <span class="badge bg-warning-subtle text-warning">📦 Processing</span>

                                <?php elseif ($info['order_status'] === 'shipped'): ?>
                                    <span class="badge bg-secondary-subtle text-secondary">🚚 Shipped</span>

                                <?php elseif ($info['order_status'] === 'delivered'): ?>
                                    <span class="badge bg-success-subtle text-success">✅ Delivered</span>

                                <?php elseif ($info['order_status'] === 'cancelled'): ?>
                                    <span class="badge bg-danger text-light">❌ Cancelled</span>

                                <?php endif; ?>
                            </td>

                            <td class="d-none d-md-table-cell"><?= $info['order_date'] ?></td>

                            <td>
                                <button class="btn btn-outline-success btn-sm"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#order<?= $order_id ?>">
                                    <span class="d-none d-md-inline">View Items</span>
                                    <i class="bi bi-eye d-md-none"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- row item collapse -->
                        <tr class="collapse" id="order<?= $order_id ?>">
                            <td colspan="7" class="bg-light">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr class="table-secondary">
                                            <th></th>
                                            <th>Thumbnail</th>
                                            <th>Product</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($order_history as $item): ?>
                                            <?php if ($order_id == $item['order_id']): ?>
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <img src="<?= BASE_URL . $item['product_thumbnail'] ?>"
                                                            class="rounded"
                                                            style="width:60px; height:60px; object-fit:cover;">
                                                    </td>
                                                    <td><?= $item['product_title'] ?></td>
                                                    <td class="fw-bold"><?= $item['quantity'] ?></td>
                                                    <td class="text-success">$<?= number_format($item['unit_price'], 2) ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </tbody>

                                </table>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
            </div>
        </div>
    </div>
    </div>

    <!-- include footer -->
    <?php
        require_once(__DIR__ . "/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>