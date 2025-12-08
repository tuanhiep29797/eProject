<?php
require_once(__DIR__ . "/../database/dbhelper.php");

$products = [];
$count=1;
if (isset($_SESSION["id"])) {
    $user_id = $_SESSION["id"];

    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            SELECT o.*, od.* , p.product_title, p.product_thumbnail
            FROM `order` o
            INNER JOIN order_detail od ON od.order_id = o.order_id
            INNER JOIN product p ON p.product_id = od.product_id
            WHERE o.user_id = :user_id
        ");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $order_history = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo '<script>
        alert("Please log in");
        window.location.href = "../admin/login.php";
    </script>';
    exit();
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/style.css?v=<?= time() ?>">
    <title>Order History</title>
</head>

<body>
    <div class="cart">
        <div class="cart-header">
        <?php
                require_once (__DIR__."/../includes/home_header.php");
        ?>
        </div>
        <div class="text-center text-white cart-header-text mt-5">
            <h1 style="font-size:48px">Order History</h1>
            <div class="d-flex justify-content-center align-items-center gap-3 text-center-bottom" style="cursor:pointer">
                <a href="home_page.php">
                    <h4 style="color:#26b66a">Home</h4>
                </a>
                <h4>></h4>
                <a href="#">
                    <h4>Order History</h4>
                </a>
            </div>
        </div>
    </div>
    </div class="container">
    <div class="shopping-cart">
        <div class="shopping-cart-header my-4 text-center">
            <h1>Order History</h1>
        </div>
        <div class="shopping-cart-product m-5 px-5 row" style="border: 1px;">
            <div class="col-lg-4">
            <div class="account-card p-4">
                <h5 class="fw-bold mb-4">Account</h5>

                <a href="account.php" class="account-item">
                    <i class="bi bi-person"></i>
                    <div>
                        <p class="title">My Profile</p>
                        <span class="desc">Change your profile details & password</span>
                    </div>
                </a>

                <a href="#" class="account-item">
                    <i class="bi bi-bag-check"></i>
                    <div>
                        <p class="title">My Orders</p>
                        <span class="desc">View & Manage orders</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-8">

            <table class="table ">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Picture</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($order_history as $item): ?>
                    <tr class="align-middle">
                        <td><?= $count++ ?></td>
                        <td><img src="<?= $item['product_thumbnail'] ?>" alt="<?= $item['product_thumbnail'] ?>" style="width:70px; height:70px; object-fit:cover; margin:10px;" /></td>
                        <td><?= $item['product_title'] ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td><?= number_format($item['unit_price']) ?></td>
                        <?php if( $item['order_status'] === 'pending'):?>
                            <td style="color:red;"><i class="bi bi-circle-fill"></i> Pending</td>
                        <?php elseif( $item['order_status'] === 'processing'):?>
                            <td style="color:orange;">📦 Processing</td>
                        <?php elseif( $item['order_status'] === 'shipped'):?>
                            <td style="color:brown;">🚕 Shipped</td>
                        <?php elseif( $item['order_status'] === 'delivered'):?>
                            <td style="color:green;">✅ Delivered</td>
                        <?php elseif( $item['order_status'] === 'cancelled'):?>
                            <td style="color:red;">❌ Cancelled</td>
                        <?php endif; ?>

                        <td><?= $item['order_date'] ?></td>
                    </tr>
                        <?php endforeach; ?>
                </tbody>
            </table>   
                    </div>

        </div>
    </div>
    </div>
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>
</body>

</html>