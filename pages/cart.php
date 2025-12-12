<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

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

        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;
    } 
    else 
    {
        echo'<script>
                alert("Please log in to view your cart.");
                window.location.href = "../admin/login.php";
            </script>';
        exit();
    }

    foreach ($products as $item) 
    {
        $total += $item['product_price'] * $item['quantity'];
    }
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

                    header("Location: cart.php");
                    exit;
                } 
                catch (PDOException $e) 
                {
                    echo "Error: " . $e->getMessage();
                }
                break;

            default:
                header("Location: cart.php");
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

            header("Location: cart.php#shopping-cart-$cart_id");
            exit;
        } 
        catch (PDOException $e) 
        {
            echo "Error: " . $e->getMessage();
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

    <div class="page-banner">
        <div class="container">
            <h2>Cart</h2>
            
            <div class="banner-breadcrumb">
                <a href="home_page.php">Home</a>
                
                <i class="bi bi-chevron-right"></i>
        
                <a href="#">Cart</a>
                
            </div>
        </div>
    </div>

    <div class="container">
        <div class="shopping-cart">
            <div class="shopping-cart-product mt-4">
                <?php foreach ($products as $item): ?>
                    <div class="sc-product row align-items-center px-4 mx-5 mt-4" id="shopping-cart-<?= $item['cart_id']?>" >
                        <div class="sc-product-img col-lg-2 my-2">
                            <img src="<?= BASE_URL . $item['product_thumbnail'] ?>" alt="<?= $item['product_thumbnail'] ?>" />
                        </div>
                        <div class="sc-product-text col-lg-2 text-right">
                            <h5 class="fw-bold"><?= $item['product_title'] ?></h5>
                        </div>
                        <div class="sc-product-price col-lg-2 text-right">
                            <p class="">Price</p>
                            <span class="text-success fw-semibold">$<?= number_format($item['product_price'],2) ?></span>
                        </div>
                        <div class="sc-product-quantity col-lg-2 text-right">
                            <p class="">Quantity</p>
                            <form method="POST" class="cart-item-form">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <div class="sc-product-quantity-edit d-flex align-items-center gap-2">
                                    <button type="submit" class="btn btn-success btn-sm" <?= $item['quantity'] > 1 ? "" : "disabled"?> name="action" value="minus">−</button>
                                    <span class="text-success fw-semibold"> <?= $item['quantity'] ?></span>
                                    <button type="submit" class="btn btn-success btn-sm" <?= $item['quantity'] == $item['product_quantity'] ? "disabled" : ""?> name="action" value="plus">+</button>
                                </div>
                            </form>
                        </div>
                        <div class="sc-product-total col-lg-2 text-right">
                            <p class="">Total</p>
                            <span class="text-success fw-semibold">$<?= number_format($item['product_price'] * $item['quantity'],2) ?></span>
                        </div>
                        <div class="sc-product-total col-lg-1 text-right">
                            <p class="">In Stock</p>
                            <span class="text-success fw-semibold"><?= number_format($item['product_quantity']) ?></span>
                        </div>
                        <div class="sc-product-action col-lg-1 d-flex justify-content-start px-0">
                            <form method="POST">
                                <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                                <button type="submit" name="action" value="remove" class="btn btn-outline-dark">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>

            <div class="shopping-cart-total mx-5">

                 <div class="sc-total my-lg-5 d-flex align-items-center px-4">
                        <div class="sc-total-text col-lg-2 text-center">
                            <h3 class="fw-bold m-0">Total Amount:</h3>
                        </div>
                        <div class="sc-total-number col-lg-6 text-center">
                            <span class="text-success fw-bold" style="font-size:24px">$<?= number_format($total,2)?></span>
                        </div>
                        <div class="sc-total-action col-lg-4 d-flex justify-content-end gap-3">
                                <a href="./product.php"><button class="btn btn-outline-dark fw-bold p-3" style="border-radius: 20px;">Product</button></a>
                                <a href="./check_out.php"><button class="btn btn-outline-white bg-dark text-light me-2 fw-bold p-3 " style="border-radius: 20px;">Check out</button></a>
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