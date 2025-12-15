<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

    //check login
    if(!is_login())
    {
        header("Location:" . BASE_URL . "home");
    }
    
    //get cart data
    $products = [];
    $total = 0;
    if (isset($_SESSION["user_id"])) 
    {
        $user_id = $_SESSION["user_id"];

        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_GET_CART_BY_USER_ID);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $products = $stmt->fetchAll();

            if ($products == null || count($products) == 0) 
            {
                echo '<script>
                        alert("Please add product to cart.");
                        window.location.href = "' . BASE_URL .'product";
                    </script>';
                exit();
            }
        } catch (PDOException $e) 
        {
            echo "<script>
                    console.error(" . json_encode($e->getMessage()) . ");
                </script>";
            exit();
        }
        $conn = null;
    } 
    else 
    {
        echo   '<script>
                    alert("Please log in to view your cart.");
                    window.location.href = "' . BASE_URL .'login";
                </script>';
        exit();
    }

    //calculator total
    foreach ($products as $item) 
    {
        $total += $item['product_price'] * $item['quantity'];
    }

    // create order
    if (!empty($_POST)) {
        $fullname = $_POST['fullname'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];

        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_ADD_NEW_ORDER);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":total_amount", $total);
            $stmt->bindParam(":receiver", $fullname);
            $stmt->bindParam(":phone_number", $phone_number);
            $stmt->bindParam(":address", $address);
            $stmt->execute();

            $stmt = $conn->prepare(SQL_GET_ORDER_BY_USER . 
            " order by order_id desc
            limit 1
            ");

            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();
            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $order = $stmt->fetch();

            $orderID = $order['order_id'];

            foreach ($products as $item) 
            {
                $stmt = $conn->prepare(SQL_ADD_ORDER_DETAIL);
                $stmt->bindParam(":order_id", $orderID);
                $stmt->bindParam(":product_id", $item['product_id']);
                $stmt->bindParam(":quantity", $item['quantity']);
                $stmt->bindParam(":unit_price", $item['product_price']);
                $stmt->execute();

                $new_product_quantity = $item["product_quantity"] - $item["quantity"];
                $stmt = $conn->prepare(SQL_UPDATE_PRODUCT_QUANTITY);
                $stmt->bindParam(":product_id", $item['product_id']);
                $stmt->bindParam(":product_quantity", $new_product_quantity);
                $stmt->execute();
            }

            //delete cart
            $stmt = $conn->prepare(SQL_DELETE_CART_BY_USER_ID);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->execute();

            header("Location: " . BASE_URL . "user/order-history");
            exit();
        } 
        catch (PDOException $e) 
        {
           echo "<script>
                    console.error(" . json_encode($e->getMessage()) . ");
                </script>";
            exit();
        }
        $conn = null;
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Check Out</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/style.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>
    
    <!-- include header -->
    <?php
        require_once (__DIR__."/../includes/home_header.php");
    ?>

    <!-- banner -->
    <div class="page-banner">
        <div class="container">
            <h2>Check Out</h2>
            
            <div class="banner-breadcrumb">
                <a href="<?= BASE_URL ?>home">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="<?= BASE_URL ?>user/cart">Cart</a>

                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Check Out</a>
                
            </div>
        </div>
    </div>

    <!-- body -->
    <div class="container px-3 px-md-4">
    <div class="shopping-cart">
        <div class="shopping-cart-header my-3 my-md-4 text-center">
            <h1>Check Out</h1>
        </div>
        <form method="POST">
            <div class="check-out row g-4">
                <div class="check-out-left col-12 col-md-12 col-xl-4">
                    <h2 class="text-center fw-bold fs-5">PAYMENT INFORMATION</h2>
                    <div class="ms-0 ms-md-3 ms-xl-5">
                        <div class="form-group fw-bold">
                            <label class="my-2 form-label" for="fullname">Fullname</label>
                            <input type="text" placeholder="Fullname" name="fullname" id="fullname" required class="form-control py-2 py-md-3 mb-3 mb-md-4">
                            <label class="my-2 form-label" for="phone_number">Phone Number</label>
                            <input type="number" placeholder="Phone number" name="phone_number" required class="form-control py-2 py-md-3 mb-3 mb-md-4">
                            <label class="my-2 form-label" for="address">Address</label>
                            <input type="text" placeholder="Address" name="address" required class="form-control py-2 py-md-3 mb-3 mb-md-4">
                        </div>
                    </div>
                </div>
                <div class="shopping-cart-product mt-0 mt-xl-4 col-12 col-md-12 col-xl-8 px-0 px-md-3 px-xl-5">
                    <?php foreach ($products as $item): ?>
                        <div class="sc-product row align-items-center mx-0 mx-md-3 mx-xl-5 mt-3 mt-md-4 p-2 p-md-3" id="shopping-cart-<?= $item['cart_id'] ?>">
                            <div class="sc-product-img col-4 col-md-3 col-xl-2 my-2">
                                <img src="<?= BASE_URL . $item['product_thumbnail'] ?>" alt="<?= $item['product_thumbnail'] ?>" class="img-fluid rounded" style="max-width:70px; height:70px; object-fit:cover;" />
                            </div>
                            <div class="sc-product-text col-8 col-md-9 col-xl-6 text-right">
                                <h5 class='fw-bold fs-6'><?= $item['product_title'] ?></h5>
                                <p class="mb-0 small">Price <span class="text-success fw-semibold">$<?= number_format($item['product_price'], 2) ?></span></p>
                            </div>
                            <div class="sc-product-quantity col-6 col-md-6 col-xl-2 text-right mt-2 mt-xl-0">
                                <p class="mb-1 small">Quantity</p>
                                <span class="text-success fw-semibold"> <?= $item['quantity'] ?></span>
                            </div>
                            <div class="sc-product-total col-6 col-md-6 col-xl-2 text-right mt-2 mt-xl-0">
                                <p class="mb-1 small">Total</p>
                                <span class="text-success fw-semibold">$<?= number_format($item['product_price'] * $item['quantity'], 2) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="shopping-cart-total">
                        <div class="row my-4 my-md-5 me-0 me-md-3 me-xl-5">
                            <div class="sc-total ms-0 ms-xl-5 d-flex flex-column flex-md-row align-items-center">
                                <div class="sc-total-text col-12 col-md-4 col-xl-3 text-center mb-2 mb-md-0">
                                    <h3 class="fw-bold m-0 fs-5">Total Amount:</h3>
                                </div>
                                <div class="sc-total-number col-12 col-md-4 col-xl-5 text-center mb-3 mb-md-0">
                                    <span class="text-success fw-bold" style="font-size:24px">$<?= number_format($total, 2) ?></span>
                                </div>
                                <div class="sc-total-action col-12 col-md-4 col-xl-4 d-flex justify-content-center justify-content-md-end gap-3">
                                    <button type="submit" class="btn btn-outline-white bg-dark text-light fw-bold p-2 p-md-3 px-3 px-md-4 w-100 w-md-auto" style="border-radius: 20px;">Payment</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    </div>
    
    <!-- include footer -->
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>