<?php
    require_once (__DIR__."/../database/dbhelper.php");

    // get category + products
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_CATEGORY_AS_PRODUCT);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $header_list = $stmt->fetchAll();

        $category_list = [];
        foreach ($header_list as $item)
        {   $category_list[$item["category_id"]]["category_name"] = $item["category_name"];
            $category_list[$item["category_id"]]["product"][$item["product_id"]] = $item["product_title"];
        } 
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $conn = null;

    // get brand
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_BRAND);
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $brand_list = $stmt->fetchAll();
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $conn = null;
    $block_name ="";
    if (is_login())
    {
        $block_name = substr($_SESSION["fullname"], 0, 5) . "...";
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/variables.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/fonts.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/banner.css">
    <title>Home Header</title>
</head>

<body>
    <header class="header shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <!-- logo -->
                <div class="col-lg-2 col-sm-12 col-12 py-3 text-sm-center">
                    <a href="<?= BASE_URL ?>pages/home_page.php">
                        <img src="<?= BASE_URL ?>assets/img/home/img_logo.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
                    </a>
                </div>

                <!-- menu -->
                <div class="col-lg-8 col-sm-6 col-6">
                    <nav class="navbar navbar-expand-lg p-0">

                        <button class="navbar-toggler" type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#mainNavbar">
                            <i class="bi bi-list fs-2 text-dark"></i>
                        </button>

                        <div class="collapse navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav gap-3 mx-auto">
                            <li class="nav-item py-3 mx-2">
                                <a class="nav-link text-success fw-bold" href="<?= BASE_URL?>pages/home_page.php">Home</a>

                            </li>

                            <li class="nav-item py-3 mx-2">
                                <a class="nav-link" href="<?= BASE_URL?>pages/about.php">About Us</a>
                            </li>

                            <li class="nav-item py-3 mx-2">
                                <a class="nav-link" href="<?= BASE_URL?>pages/gallery.php">Gallery</a>
                            </li>

                            <!-- product dropdown -->
                            <li class="nav-item position-static py-3 mx-2" id="product_menu">
                                <a class="nav-link" href="<?= BASE_URL?>pages/product.php">
                                    Product
                                </a>

                                <div class="nav-item_product w-100 p-3">
                                    <div class="row">
                                        <?php foreach ($category_list as $index_category_id => $items): ?>
                                            <div class="col-4">
                                                <h6 class="fw-bold text-success my-2"><?= htmlspecialchars($items["category_name"]) ?></h6>
                                                <ul class="list-unstyled">
                                                    <?php foreach ($items["product"] as $product_id => $product_title): ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link"
                                                            href="<?= BASE_URL ?>pages/product_detail.php?product=<?= $product_id ?>">
                                                                <?= htmlspecialchars($product_title) ?>
                                                            </a>
                                                        </li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </li>

                            <!-- category -->
                            <li class="nav-item py-3 mx-2 position-relative" id="category_menu">
                                <a class="nav-link" href="<?= BASE_URL?>pages/category.php">
                                    Category
                                </a>
                                <div class="p-2 nav-item_category">
                                    <?php foreach ($category_list as $index_category_id => $items): ?>
                                        <a class="dropdown-item py-2"
                                        href="<?= BASE_URL?>pages/category.php?category=<?= $index_category_id ?>">
                                            <?= htmlspecialchars($items["category_name"]) ?>
                                        </a>
                                    <?php endforeach ?>
                                </div>
                            </li>

                            <!-- brand -->
                            <li class="nav-item py-3 mx-2 position-relative" id="brand_menu">
                                <a class="nav-link" href="<?= BASE_URL?>pages/brand.php" >
                                    Brand
                                </a>
                                <div class=" p-2 nav-item_brand">
                                    <?php foreach ($brand_list as $brand): ?>
                                        <a class="dropdown-item py-2"
                                        href="<?= BASE_URL?>/pages/brand.php?brand=<?= $brand["brand_id"] ?>">
                                            <?= htmlspecialchars($brand["brand_name"]) ?>
                                        </a>
                                    <?php endforeach ?>
                                </div>
                            </li>

                            <li class="nav-item py-3">
                                <a class="nav-link" href="<?= BASE_URL?>pages/contact.php">Contact Us</a>
                            </li>
                        </ul>
                        </div>
                    </nav>
                </div>

                <div class="col-lg-2 col-sm-6 col-6 text-end header_right" style="font-size: 20px;">

                    <a href="../pages/cart.php" class="me-3 fs-4 text-dark text-decoration-none">
                        <i class="bi bi-cart my-3"></i>
                    </a>

                    <!-- account  -->
                    <div class="dropdown d-inline-block position-relative py-3 px-2" id="header_account">
                        <a class="text-dark text-decoration-none fs-5" href="#">
                            <?= htmlspecialchars(isset($_SESSION["fullname"]) ? "Hi, ". $block_name : "") ?>
                            <i class="bi bi-person-circle text-primary"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow header_account_item">

                            <?php if(empty($_SESSION["username"])): ?>

                                <li><a class="dropdown-item py-2" href="<?= BASE_URL?>admin/login.php">Login</a></li>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL?>admin/register.php">Register</a></li>

                            <?php else: ?>
                                <?php if (is_admin()):?>
                                    <li><a class="dropdown-item py-2" href="<?= BASE_URL?>admin/home_admin.php">Admin Page</a></li>
                                <?php endif;?>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL?>pages/account.php">Account</a></li>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL?>pages/order_history.php">Order History</a></li>
                                <li><a class="dropdown-item text-danger py-2" href="<?= BASE_URL?>admin/logout.php">Log Out</a></li>
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
