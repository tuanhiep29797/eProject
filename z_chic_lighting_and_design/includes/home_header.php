<?php
require_once (__DIR__."/../database/dbhelper.php");

// get category + products
try 
{
    $conn = getConnection();
    $stmt = $conn->prepare(SQL_GET_CATEGORY_AS_PRODUCT);
    $stmt->execute();

    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $data_list = $stmt->fetchAll();

    $category_list = [];
    foreach ($data_list as $item)
    {
        $category_list[$item["category_name"]][] = $item["product_title"];
    } 
}
catch (PDOException $e) {
    echo $e->getMessage();
}
$conn = null;

// user login (avoid undefined variable)
$user = $_SESSION["user"] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/style.css">
    <title>Home Header</title>
</head>

<body>

<header class="header shadow-sm">
    <div class="container">
        <div class="row align-items-center py-3">

            <!-- LEFT LOGO -->
            <div class="col-lg-2 col-6">
                <a href="../pages/home.php">
                    <img src="<?= BASE_URL ?>/../assets/img/home/img_logo.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
                </a>
            </div>

            <!-- MENU CENTER -->
            <div class="col-lg-8 d-none d-lg-block">
                <nav class="navbar navbar-expand-lg p-0">
                    <ul class="navbar-nav gap-3 mx-auto">

                        <li class="nav-item">
                            <a class="nav-link text-success fw-bold" href="<?BASE_URL?>/../pages/home.php">Home</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?BASE_URL?>/../pages/about.php">About Us</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?BASE_URL?>/../pages/gallery.php">Gallery</a>
                        </li>

                        <!-- PRODUCT DROPDOWN -->
                        <li class="nav-item dropdown position-static">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                Product
                            </a>

                            <div class="dropdown-menu w-100 p-3">
                                <div class="row">
                                    <?php foreach ($category_list as $category => $items): ?>
                                        <div class="col-4">
                                            <h6 class="fw-bold text-success"><?= $category ?></h6>
                                            <ul class="list-unstyled">
                                                <?php foreach ($items as $item): ?>
                                                    <li>
                                                        <a class="dropdown-item"
                                                           href="/product.php/product=<?= strtolower(str_replace(' ', '-', $item)) ?>">
                                                            <?= $item ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </li>

                        <!-- category -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                Category
                            </a>
                            <div class="dropdown-menu p-2">
                                <?php foreach ($category_list as $category => $items): ?>
                                    <a class="dropdown-item"
                                       href="<?BASE_URL?>/pages/product.php/product=<?= strtolower(str_replace(' ', '-', $category)) ?>">
                                        <?= $category ?>
                                    </a>
                                <?php endforeach ?>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?BASE_URL?>/../pages/contact.php">Contact Us</a>
                        </li>

                    </ul>
                </nav>
            </div>

            <div class="col-lg-2 col-6 text-end">

                <a href="../pages/cart.php" class="me-3 fs-4 text-dark">
                    <i class="bi bi-cart"></i>
                </a>

                <!-- account  -->
                <div class="dropdown d-inline-block">
                    <a class="dropdown-toggle text-dark text-decoration-none fs-5"
                       href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-person"></i>
                        <?= htmlspecialchars($user["username"] ?? "Login/Register") ?>
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow">

                        <?php if(empty($_SESSION["username"])): ?>

                            <li><a class="dropdown-item" href="<?BASE_URL?>/../admin/login.php">Login</a></li>
                            <li><a class="dropdown-item" href="<?BASE_URL?>/../admin/register.php">Register</a></li>

                        <?php else: ?>

                            <li><a class="dropdown-item" href="<?BASE_URL?>/../pages/account.php">Account</a></li>
                            <li><a class="dropdown-item" href="<?BASE_URL?>/../pages/order_history.php">Order History</a></li>
                            <li><a class="dropdown-item text-danger" href="<?BASE_URL?>/../admin/logout.php">Log Out</a></li>

                        <?php endif; ?>

                    </ul>
                </div>

            </div>

        </div>
    </div>
</header>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
