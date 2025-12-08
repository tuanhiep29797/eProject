<?php
require_once(__DIR__ . "/../database/dbhelper.php");

$products = [];
$total = 0;
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
        select p.*, c.quantity, c.cart_id, c.user_id
        from product p
        inner join cart c on c.product_id = p.product_id
        inner join user u on  u.user_id = c.user_id
        where u.user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $products = $stmt->fetchAll();

        if ($products == null || count($products) == 0) {
        echo '<script>
                alert("Please add product to cart.");
                window.location.href = "product.php";
            </script>';
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
} else {
    echo '<script>
        alert("Please log in to view your cart.");
        window.location.href = "../admin/login.php";
    </script>';
    exit();
}

foreach ($products as $item) {
    $total += $item['product_price'] * $item['quantity'];
}

if (!empty($_POST)) {
    $fullname = $_POST['fullname'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    try {
        $conn = getConnection();
        $stmt = $conn->prepare("
            INSERT INTO `order` (user_id, total_amount, receiver,phone_number, address)
            VALUES (:user_id, :total_amount, :receiver,:phone_number, :address)
        ");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":total_amount", $total);
        $stmt->bindParam(":receiver", $fullname);
        $stmt->bindParam(":phone_number", $phone);
        $stmt->bindParam(":address", $address);
        $stmt->execute();

        $stmt = $conn->prepare("
            SELECT *
            FROM `order`
            WHERE user_id = :user_id
            ORDER BY order_id DESC
            LIMIT 1
        ");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        $orderID = $order['order_id'];

        foreach ($products as $item) {
        $stmt = $conn->prepare("INSERT INTO order_detail (order_id, product_id, quantity, unit_price)
                VALUES (:order_id, :product_id, :quantity, :unit_price)");
        $stmt->bindParam(":order_id", $orderID);
        $stmt->bindParam(":product_id", $item['product_id']);
        $stmt->bindParam(":quantity", $item['quantity']);
        $stmt->bindParam(":unit_price", $item['product_price']);

        $stmt->execute();
        }

        $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        echo '<script>
        alert("Thanks you for your payment 😘😘😘");
        window.location.href = "home_page.php";
        </script>';
        exit();


    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
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
    <title>Cart</title>
</head>

<body>
    
    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <div class="page-banner">
        <div class="container">
            <h2>Check Out</h2>
            
            <div class="banner-breadcrumb">
                <a href="home_page.php">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="cart.php">Cart</a>

                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Check Out</a>
                
            </div>
        </div>
    </div>

    </div class="container">
    <div class="shopping-cart">
        <div class="shopping-cart-header my-4 text-center">
            <h1>Check Out</h1>
        </div>
        <form method="POST">
            <div class="check-out row">
                <div class="check-out-left col-4">
                    <h2 class="text-center fw-bold">PAYMENT INFORMATION</h2>
                    <div class="ms-5">
                        <div class="form-group fw-bold ">
                            <label class="my-2 form-label " for="fullname">Fullname</label>
                            <input type="text" placeholder="Fullname" name="fullname" id="fullname" required class="form-control py-3 mb-4">
                            <label class="my-2 form-label " for="fullname">Phone Number</label>
                            <input type="number" placeholder="Phone number" name="phone" required class="form-control py-3 mb-4">
                            <label class="my-2 form-label " for="fullname">Address</label>
                            <input type="text" placeholder="Address" name="address" required class="form-control py-3 mb-4">
                        </div>
                    </div>
                </div>
                <div class="shopping-cart-product mt-4 col-8 px-5">
                    <?php foreach ($products as $item): ?>
                        <div class="sc-product row align-items-center mx-5 mt-4" id="shopping-cart-<?= $item['cart_id'] ?>">
                            <div class="sc-product-img col-lg-2 my-2">
                                <img src="<?= $item['product_thumbnail'] ?>" alt="<?= $item['product_thumbnail'] ?>" style="width:70px; height:70px; object-fit:cover; margin:10px;" />
                            </div>
                            <div class="sc-product-text col-lg-6 text-right">
                                <h5 class='fw-bold'><?= $item['product_title'] ?></h5>
                                <p class="">Price <span class="text-success fw-semibold"> <?= number_format($item['product_price']) ?><sup>$</sup></span></p>
                            </div>
                            <div class="sc-product-quantity col-lg-2 text-right">
                                <p class="">Quantity</p>
                                <span class="text-success fw-semibold"> <?= $item['quantity'] ?></span>
                            </div>
                            <div class="sc-product-total col-lg-2 text-right">
                                <p class="">Total</p>
                                <span class="text-success fw-semibold"><?= number_format($item['product_price'] * $item['quantity']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="shopping-cart-total">
                        <div class="row my-5 me-5">
                            <div class="sc-total ms-lg-5 ms-sm-0 d-flex align-items-center">
                                <div class="sc-total-text col-lg-3 text-center">
                                    <h3 class="fw-bold m-0">Total Amount:</h3>
                                </div>
                                <div class="sc-total-number col-lg-5 text-center">
                                    <span class="text-success fw-bold" style="font-size:24px"> <?= number_format($total) ?><sup>$</sup></span>
                                </div>
                                <div class="sc-total-action col-lg-4 d-flex justify-content-end gap-3">
                                    <button type="submit" class="btn btn-outline-white bg-dark text-light me-3 fw-bold p-3 px-4" style="border-radius: 20px;">Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>
</body>

</html>