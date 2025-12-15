<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

    $products = [];
    $total = 0;

    // get user infomation
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

        } 
        catch (PDOException $e) 
        {
            echo "<script>
                    console.error(" . json_encode($e->getMessage()) . ");
                </script>";
        }
        $conn = null;
    } 
    else 
    {
        echo"<script>
                alert('Please log in to view your cart.');
                window.location.href = '" . BASE_URL . "login';
            </script>";
        exit();
    }

    //calculate total
    foreach ($products as $item) 
    {
        $total += $item['product_price'] * $item['quantity'];
    }

    //plus minus and remove button
    if (!empty($_POST['action'])) 
    {
        $cart_id = $_POST["cart_id"];
        foreach ($products as $item) 
        {
            if ($item['cart_id'] == $cart_id) 
            {
                $quantity = $item['quantity'];
                break;
            }
        }
        $action = $_POST["action"];
        switch ($action) 
        {
            case "plus":
                    $quantity += 1;
                break;

            case "minus":
                if ($quantity > 1) 
                {
                    $quantity -= 1;
                }
                break;
            case "remove":
                try 
                {
                    $conn = getConnection();
                    $stmt = $conn->prepare(SQL_DELETE_CART);
                    $stmt->bindParam(":cart_id", $cart_id);
                    $stmt->execute();

                    header("Location:" . BASE_URL . "user/cart");
                    exit;
                } 
                catch (PDOException $e) 
                {
                    echo "<script>
                            console.error(" . json_encode($e->getMessage()) . ");
                        </script>";
                    exit();
                }
                break;

            default:
                header("Location:" . BASE_URL . "user/cart");
                exit;
                break;
        }

        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_UPDATE_CART);
            $stmt->bindParam(":quantity", $quantity);
            $stmt->bindParam(":user_id", $user_id);
            $stmt->bindParam(":cart_id", $cart_id);
            $stmt->execute();

            header("Location:" . BASE_URL . "user/cart#shopping-cart-$cart_id");
            exit;
        } 
        catch (PDOException $e) 
        {
            echo "<script>
                    console.error(" . json_encode($e->getMessage()) . ");
                </script>";
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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
            <h2>Cart</h2>
            
            <div class="banner-breadcrumb">
                <a href="<?= BASE_URL ?>home">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Cart</a>
                
            </div>
        </div>
    </div>

    <!-- body -->
    <div class="container px-3 px-md-4">
        <div class="shopping-cart">
            <div class="shopping-cart-product mt-3 mt-md-4">
                <?php foreach ($products as $item): ?>
                    <div class="sc-product row align-items-center px-2 px-md-4 mx-0 mx-md-3 mx-xl-5 mt-3 mt-md-4" id="shopping-cart-<?= $item['cart_id']?>" >
                        <div class="sc-product-img col-4 col-md-3 col-xl-2 my-2">
                            <img src="<?= BASE_URL . $item['product_thumbnail'] ?>" alt="<?= $item['product_thumbnail'] ?>" class="img-fluid" />
                        </div>
                        <div class="sc-product-text col-8 col-md-9 col-xl-2 text-right">
                            <h5 class="fw-bold fs-6"><?= $item['product_title'] ?></h5>
                        </div>
                        <div class="sc-product-price col-6 col-md-4 col-xl-2 text-right mt-2 mt-xl-0">
                            <p class="mb-1 small">Price</p>
                            <span class="text-success fw-semibold">$<?= number_format($item['product_price'],2) ?></span>
                        </div>
                        <div class="sc-product-quantity col-6 col-md-4 col-xl-2 text-right mt-2 mt-xl-0">
                            <p class="mb-1 small">Quantity</p>
                            <form method="POST" class="cart-item-form">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <div class="sc-product-quantity-edit d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-success btn-sm" <?= $item['quantity'] > 1 ? "" : "disabled"?> name="action" value="minus">−</button>
                                    <span class="text-success fw-semibold"> <?= $item['quantity'] ?></span>
                                    <button type="submit" class="btn btn-success btn-sm" <?= $item['quantity'] == $item['product_quantity'] ? "disabled" : ""?> name="action" value="plus">+</button>
                                </div>
                            </form>
                        </div>
                        <div class="sc-product-total col-6 col-md-4 col-xl-2 text-right mt-2 mt-xl-0">
                            <p class="mb-1 small">Total</p>
                            <span class="text-success fw-semibold">$<?= number_format($item['product_price'] * $item['quantity'],2) ?></span>
                        </div>
                        <div class="sc-product-total col-6 col-md-6 col-xl-1 text-right mt-2 mt-xl-0">
                            <p class="mb-1 small">In Stock</p>
                            <span class="text-success fw-semibold"><?= number_format($item['product_quantity']) ?></span>
                        </div>
                        <div class="sc-product-action col-12 col-md-6 col-xl-1 d-flex justify-content-end mt-3 mt-xl-0">
                            <form method="POST">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <button type="submit" name="action" value="remove" class="btn btn-outline-dark btn-sm px-3">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

            <div class="shopping-cart-total mx-0 mx-md-3 mx-xl-5">

                 <div class="sc-total my-4 my-md-5 px-2 px-md-4 py-3 rounded bg-light">
                        <div class="row align-items-center g-3">
                            <div class="col-12 col-md-4 col-xl-3 text-center text-md-start">
                                <h3 class="fw-bold m-0 fs-5">Total Amount:</h3>
                            </div>
                            <div class="col-12 col-md-4 col-xl-5 text-center">
                                <span class="text-success fw-bold fs-4">$<?= number_format($total,2)?></span>
                            </div>
                            <div class="col-12 col-md-4 col-xl-4">
                                <div class="d-flex flex-row justify-content-center justify-content-md-end gap-2">
                                    <a href="<?= BASE_URL ?>product" class="text-decoration-none" style="flex: 1; max-width: 130px;">
                                        <button class="btn btn-outline-dark fw-bold py-2 w-100" style="border-radius: 20px;">Product</button>
                                    </a>
                                    <a href="<?= BASE_URL ?>check-out" class="text-decoration-none" style="flex: 1; max-width: 130px;">
                                        <button class="btn bg-dark text-light fw-bold py-2 w-100" style="border-radius: 20px;">Check out</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                                    
                </div>

            </div>

        </div>
    </div>

    <!-- include footer -->
    <?php
        require_once (__DIR__."/../includes/home_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>