<?php
$product = [
    "Đèn Nội Thất" => ["Lamp ABC XYZ", "Đèn Led 2", "Đèn Treo Trần"],
    "Đèn Ngoại Thất" => [
        "Đèn Năng Lượng Mặt Trời",
        "Đèn Hắt Trần",
        "Đèn Sân Vườn",
        "Đèn Năng Lượng Mặt Trời",
        "Đèn Hắt Trần",
        "Đèn Sân Vườn",
        "Đèn Năng Lượng Mặt Trời",
        "Đèn Hắt Trần",
        "Đèn Sân Vườn",
        "Đèn Led 1",
        "Đèn Led 2",
        "Đèn Treo Trần",
        "Đèn Led 1",
        "Đèn Led 2",
        "Đèn Treo Trần"
    ],
    "Đèn Trang Trí" => ["Đèn Neon", "Đèn Dây LED", "Đèn Cầu Vồng"],
    "Đèn Trang Trí " => ["Đèn Neon", "Đèn Dây LED", "Đèn Cầu Vồng"]
];
$check_user = false;
if(!empty($_SESSION["user"])){
    $check_user = true;
    $user = $_SESSION["user"];
}
$login = $check_user ? "Hi, ".$user["username"] : "Login/Register";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Header</title>
</head>

<body>
    <header class="header">
        <div class="container">
            <div class="row d-flex align-items-center header-index ">
                <!-- header left start -->
                <div class="header_left col-lg-2 p-5 py-3">
                    <a href="header.php">
                        <img src="../img/img_logo1.png" alt="Logo" class="logo-box"/>
                    </a>
                </div>
                <!-- header menu start -->
                <div class="col-lg-8">
                    <div class="header_menu">
                        <nav class="navbar navbar-expand-lg p-0">
                            <ul class="navbar-nav gap-3 mx-auto">
                                <li class="nav-item">
                                    <a class="nav-link text-success fw-bold" id="header_click" href="#">Home</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="header_click">About Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="header_click">Gallery</a>
                                </li>

                                <li class="nav-item position-static" id="product_menu">
                                    <a class="nav-link" href="#" id="header_click">Product</a>
                                    <div class="nav-item_product px-3">
                                        <?php foreach ($product as $category => $items): ?>
                                            <h5 class="h5 text-success"><?= $category ?></h5>
                                            <ul class="nav nav-pills">
                                                <?php foreach ($items as $item): ?>
                                                    <li class="nav-item">
                                                        <a class="nav-link" href="/product.php/product=<?=(strtolower(str_replace(" ", "-", $item)))?>">
                                                            <?= $item ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach ?>
                                            </ul>
                                        <?php endforeach ?>
                                    </div>

                                </li>
                                <li class="nav-item position-relative" id="category_menu">
                                    <a class="nav-link" href="#" id="header_click">Category</a>
                                    <div class="nav-item_brand">
                                        <?php foreach ($product as $category => $items): ?>
                                            <a class="nav-link d-inline-block p-2 m-1" href="/product.php/product=<?=(strtolower(str_replace(" ", "-", $category)))?>">
                                                <?= $category ?>
                                            </a>
                                        <?php endforeach ?>
                                    </div>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" id="header_click">Contact Us</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!-- header right start -->
                <div class="col-lg-2 header_right fs-4 d-flex gap-3 justify-content-end pe-5">
                    <div class="my-3">
                        <a href="../pages/cart.php"><i class="bi bi-cart my-3"></i></a>
                    </div>
                    <div class="header_account_wrap pb-3 mt-3" style="cursor: pointer;">
                        <div class="header_account_login d-flex align-items-center gap-2">
                            <span class="fs-6 header-login-text"><?= htmlspecialchars($login) ?></span>
                            <i class="bi bi-person account_icon"></i>
                        </div>
                        <div class="header_account">
                            <ul class="list-group">
                                <?php if($isLogin):?>
                                <li class="list-group-item border-0"><a href='../account/login.php'>Login</a></li>
                                <li class="list-group-item border-0"><a href='../account/register.php'>Register</a></li>
                                <?php else:?>
                                        
                                <?php endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>