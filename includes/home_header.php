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
        {   
            $category_list[$item["category_id"]]["category_name"] = $item["category_name"];
            $category_list[$item["category_id"]]["product"][$item["product_slug"]] = $item["product_title"];
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
    
if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    try {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_SUM_QUANTITY_IN_CART);
        $stmt->bindParam(":user_id", $user_id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $count_cart = $stmt->fetchAll();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    $conn = null;
    $total_quantity = $count_cart[0]['total_quantity'];
} 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/variables.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/fonts.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/header.css?v=<?= time() ?>">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/banner.css?v=<?= time() ?>">
    <title>Home Header</title>
</head>

<body>
    <header class="header shadow-sm">
        <div class="container">
            <div class="row align-items-center">
                <!-- logo -->
                <div class="col-lg-2 col-sm-12 col-12 py-3 text-sm-center">
                    <a href="<?= BASE_URL ?>home">
                        <img src="<?= BASE_URL ?>assets/img/home/img_logo.png" alt="Logo" class="img-fluid" style="max-height: 60px;">
                    </a>
                </div>

                <!-- menu -->
                <div class="col-lg-8 col-md-6 col-6">
                    <nav class="navbar navbar-expand-lg p-0">

                        <button class="navbar-toggler" type="button" id="navbarToggler">
                            <i class="bi bi-list fs-2 text-dark"></i>
                        </button>

                        <div class="navbar-collapse" id="mainNavbar">
                        <ul class="navbar-nav gap-3 mx-auto">
                            <li class="nav-item py-3 mx-2">
                                <a class="nav-link text-success fw-bold" href="<?= BASE_URL ?>home">Home</a>

                            </li>

                            <li class="nav-item py-3 mx-2">
                                <a class="nav-link" href="<?= BASE_URL ?>about-us">About Us</a>
                            </li>

                            <li class="nav-item py-3 mx-2">
                                <a class="nav-link" href="<?= BASE_URL ?>gallery">Gallery</a>
                            </li>

                            <!-- product dropdown -->
                            <li class="nav-item position-static py-3 mx-2" id="product_menu">
                                <a class="nav-link" href="<?= BASE_URL ?>product">
                                    Product
                                </a>

                                <div class="nav-item_product w-100 p-3">
                                    <div class="row">
                                        <?php foreach ($category_list as $index_category_id => $items): ?>
                                            <div class="col-4">
                                                <h6 class="fw-bold text-success my-2"><?= htmlspecialchars($items["category_name"]) ?></h6>
                                                <ul class="list-unstyled">
                                                    <?php foreach ($items["product"] as $product_slug => $product_title): ?>
                                                        <li class="nav-item">
                                                            <a class="nav-link"
                                                            href="<?= BASE_URL ?>product/<?= $product_slug ?>">
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
                                <a class="nav-link" href="<?= BASE_URL?>category">
                                    Category
                                </a>
                                <div class="p-2 nav-item_category">
                                    <?php foreach ($category_list as $index_category_id => $items): ?>
                                        <a class="dropdown-item py-2"
                                        href="<?= BASE_URL?>category?category[]=<?= $index_category_id ?>&action=filter">
                                            <?= htmlspecialchars($items["category_name"]) ?>
                                        </a>
                                    <?php endforeach ?>
                                </div>
                            </li>

                            <!-- brand -->
                            <li class="nav-item py-3 mx-2 position-relative" id="brand_menu">
                                <a class="nav-link" href="<?= BASE_URL?>brand" >
                                    Brand
                                </a>
                                <div class=" p-2 nav-item_brand">
                                    <?php foreach ($brand_list as $brand): ?>
                                        <a class="dropdown-item py-2"
                                        href="<?= BASE_URL?>brand?brand[]=<?= $brand["brand_id"] ?>&action=filter">
                                            <?= htmlspecialchars($brand["brand_name"]) ?>
                                        </a>
                                    <?php endforeach ?>
                                </div>
                            </li>

                            <li class="nav-item py-3">
                                <a class="nav-link" href="<?= BASE_URL ?>contact-us">Contact Us</a>
                            </li>
                        </ul>
                        </div>
                    </nav>
                </div>

                <div class="col-lg-2 col-sm-6 col-6 text-end header_right d-flex justify-content-center align-items-center" style="font-size: 20px;">
                <div class="position-relative me-3">
                    <a href="<?= BASE_URL ?>user/cart" class="fs-4 text-dark text-decoration-none position-relative">
                        <i class="bi bi-cart my-3"></i>

                        <?php if (isset($total_quantity) && $total_quantity > 0): ?>
                            <span class="badge bg-success 
                                        position-absolute 
                                        top-0 start-100 translate-middle
                                        rounded-circle px-2 py-1"
                                style="font-size: 12px;">
                                <?= $total_quantity ?>
                            </span>
                        <?php endif; ?>
                    </a>
                </div>

                    <!-- account  -->
                    <div class="dropdown d-inline-block position-relative py-3 px-2" id="header_account">
                        <a class="text-dark text-decoration-none fs-5 text-truncate w-100" href="#">
                            <?= htmlspecialchars(isset($_SESSION["fullname"]) ? "Hi, ". $_SESSION["fullname"] : "") ?>
                            <i class="bi bi-person-circle text-success"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow header_account_item">

                            <?php if(empty($_SESSION["username"])): ?>

                                <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>login">Login</a></li>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>register">Register</a></li>

                            <?php else: ?>
                                <?php if (is_admin()):?>
                                    <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>admin/dashboard">Admin Page</a></li>
                                <?php endif;?>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>user/infomation">Account</a></li>
                                <li><a class="dropdown-item py-2" href="<?= BASE_URL ?>user/order-history">Order History</a></li>
                                <li><a class="dropdown-item text-danger py-2" href="<?= BASE_URL ?>logout">Log Out</a></li>
                            <?php endif; ?>

                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </header>

     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
     
     <script>
        // Toggle navbar menu on mobile
        document.getElementById('navbarToggler').addEventListener('click', function() {
            const navbar = document.getElementById('mainNavbar');
            navbar.classList.toggle('show');
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(e) {
            const navbar = document.getElementById('mainNavbar');
            const toggler = document.getElementById('navbarToggler');
            
            if (!navbar.contains(e.target) && !toggler.contains(e.target)) {
                navbar.classList.remove('show');
            }
        });
     </script>
</body>
</html>
