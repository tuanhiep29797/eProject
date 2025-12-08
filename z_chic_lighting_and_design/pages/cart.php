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
if (!empty($_POST['action'])) {
    $cart_id = $_POST["cart_id"];
    foreach ($products as $item) {
        if ($item['cart_id'] == $cart_id) {
            $quantity = $item['quantity'];
            break;
        }
    }
    $action = $_POST["action"];
    switch ($action) {
        case "plus":
            $quantity += 1;
            break;

        case "minus":
            if ($quantity > 1) {
                $quantity -= 1;
            }
            break;
        case "remove":
            try {
                $conn = getConnection();
                $stmt = $conn->prepare("DELETE FROM cart WHERE cart_id = :cart_id");
                $stmt->bindParam(":cart_id", $cart_id);
                $stmt->execute();

                header("Location: cart.php");
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            break;
        case "remove-all":
            try {
                $conn = getConnection();
                $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = :user_id");
                $stmt->bindParam(":user_id", $user_id);
                $stmt->execute();

                header("Location: home_page.php");
                exit;
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            break;

        default:
            header("Location: cart.php");
            exit;
            break;
    }
    try {
        $conn = getConnection();
        $stmt = $conn->prepare("UPDATE cart SET quantity = :quantity WHERE cart_id = :cart_id");
        $stmt->bindParam(":quantity", $quantity);
        $stmt->bindParam(":cart_id", $cart_id);
        $stmt->execute();

        header("Location: cart.php#shopping-cart-$cart_id");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
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
    <div class="cart">
        <div class="cart-header">
            <?php
                require_once (__DIR__."/../includes/home_header.php");
            ?>
        </div>
        <div class="text-center text-white cart-header-text mt-5">
            <h1 style="font-size:48px">Cart</h1>
            <div class="d-flex justify-content-center align-items-center gap-3 text-center-bottom" style="cursor:pointer">
                <a href="home_page.php">
                    <h4 style="color:#26b66a">Home</h4>
                </a>
                <h4>></h4>
                <a href="#">
                    <h4>Cart</h4>
                </a>
            </div>
        </div>
    </div>
    </div class="container">
    <div class="shopping-cart">
        <div class="shopping-cart-header my-4 text-center">
            <h1>Shopping Cart</h1>
        </div>
        <div class="shopping-cart-search my-4 mb-5">
            <form action="GET">
                <div class="shopping-cart-search_input">
                    <label for="search_cart"><i class="bi bi-search"></i></label>
                    <input type="text" placeholder="Search on cart" name="search_cart" id="search_cart" />
                    <button type="submit">Search</button>
                </div>
            </form>
        </div>
        <div class="shopping-cart-product mt-4">
            <?php foreach ($products as $item): ?>
                <div class="sc-product row align-items-center px-4 mx-5 mt-4" id="shopping-cart-<?= $item['cart_id']?>" >
                    <div class="sc-product-img col-lg-2 my-2">
                        <img src="<?= $item['product_thumbnail'] ?>" alt="<?= $item['product_thumbnail'] ?>" />
                    </div>
                    <div class="sc-product-text col-lg-3 text-right">
                        <h5 class="fw-bold"><?= $item['product_title'] ?></h5>
                        <p class="m-0"><?= $item['product_description'] ?></p>
                    </div>
                    <div class="sc-product-price col-lg-2 text-right">
                        <p class="">Price</p>
                        <span class="text-success fw-semibold"> <?= number_format($item['product_price']) ?><sup>$</sup></span>
                    </div>
                    <div class="sc-product-quantity col-lg-2 text-right">
                        <p class="">Quantity</p>
                        <form method="POST" class="cart-item-form">
                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                            <div class="sc-product-quantity-edit d-flex align-items-center gap-2">
                                <button type="submit" class="btn btn-outline-dark btn-sm" name="action" value="minus">−</button>
                                <span class="text-success fw-semibold"> <?= $item['quantity'] ?></span>
                                <button type="submit" class="btn btn-outline-dark btn-sm" name="action" value="plus">+</button>
                            </div>
                        </form>
                    </div>
                    <div class="sc-product-total col-lg-2 text-right">
                        <p class="">Total</p>
                        <span class="text-success fw-semibold"><?= number_format($item['product_price'] * $item['quantity']) ?></span>
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
        </div>
        <div class="shopping-cart-total">
            <div class="row px-4 mx-5 my-5">
                <div class="sc-total ms-lg-5 ms-sm-0 d-flex align-items-center">
                    <div class="sc-total-text col-lg-2 text-center">
                        <h3 class="fw-bold m-0">Total Amount:</h3>
                    </div>
                    <div class="sc-total-number col-lg-6 text-center">
                        <span class="text-success fw-bold" style="font-size:24px"> <?= number_format($total) ?><sup>$</sup></span>
                    </div>
                    <div class="sc-total-action col-lg-4 d-flex justify-content-end gap-3">
                        <form method="POST">
                            <button class="btn btn-outline-dark fw-bold p-3" style="border-radius: 20px;" name="action" value="remove-all">Remove All</button>
                        </form>
                            <a href="./check-out.php"><button class="btn btn-outline-white bg-dark text-light me-2 fw-bold p-3 " style="border-radius: 20px;" name="action" value="check-out">Check out</button></a>
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
</body>

</html>