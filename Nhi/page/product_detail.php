<?php
require_once("../database/config.php");
require_once("../database/dbhelper.php");

// 4 img chinh
$productImages = [
    "../img/product/1/1.png",
    "../img/product/1/2.png",
    "../img/product/1/3.png",
    "../img/product/1/4.png"
];

// Recommend mau
$recommendProducts = [];
for ($i = 1; $i <= 8; $i++) {
    $recommendProducts[] = [
        "title" => "TWS Bujug",
        "price" => 29.90,
        "img" => "../img/product/1/1.png"
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Detail</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/product_detail.css?v=<?= time() ?>" rel="stylesheet">
</head>

<body>

<div class="top-bg"></div>


<div class="container py-5">

    <!-- BACK BUTTON -->
    <a href="./product.php" class="back-btn">
        <span class="arrow-icon">&lt;</span> Product
    </a>

    <!-- PRODUCT WRAPPER -->
    <div class="product-wrapper shadow-lg">

        <!-- LEFT SECTION -->
        <div class="left-box">

            <!-- MAIN IMAGE CAROUSEL -->
            <div id="mainCarousel" class="carousel slide">
                <div class="carousel-inner">

                    <?php foreach ($productImages as $i => $img): ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <img src="<?= $img ?>" class="main-img">
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- Bootstrap mũi tên (GIỮ LẠI) -->
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>

            </div>

            <!-- THUMBNAILS (KHÔNG CÒN MŨI TÊN DƯ) -->
            <div class="thumb-wrapper">

                <div class="thumb-container">
                    <?php foreach ($productImages as $index => $img): ?>
                        <img src="<?= $img ?>"
                             class="thumb-img"
                             data-bs-target="#mainCarousel"
                             data-bs-slide-to="<?= $index ?>">
                    <?php endforeach; ?>
                </div>

            </div>

        </div>

        <!-- RIGHT SECTION -->
        <div class="right-box">

            <div class="p-4">

                <div class="d-flex justify-content-between small text-white-50 mb-3">
                    <span>Brand: Philips</span>
                    <span>Category: Ceiling Lights</span>
                </div>

                <h3 class="fw-bold text-white mb-2">Log Barn vanity lights</h3>

                <p class="text-warning small mb-3">★ 5.0 (1.2k Reviews)</p>

                <p class="desc text-white-50 mb-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    Quae qui sed quasi quod ea ab harum! Placeat molestias quae sint esse temporibus.
                </p>

                <h3 class="fw-bold text-white mb-4">$29.90</h3>

                <div class="qty-box mb-4">
                    <button class="qty-btn">-</button>
                    <span class="qty-num">1</span>
                    <button class="qty-btn">+</button>
                </div>

                <div class="d-flex gap-3">
                    <button class="btn btn-outline-light px-4 py-2">ADD TO CART</button>
                    <button class="btn btn-light text-dark px-4 py-2 fw-bold">BUY NOW</button>
                </div>

            </div>

        </div>

    </div>

    <!-- RECOMMEND TITLE + ARROWS -->
    <div class="rec-header">
        <h2 class="fw-bold">Explore our recommendations</h2>

        <div class="rec-arrows">
            <button class="rec-arrow-btn" data-bs-target="#recCarousel" data-bs-slide="prev">&#8592;</button>
            <button class="rec-arrow-btn" data-bs-target="#recCarousel" data-bs-slide="next">&#8594;</button>
        </div>
    </div>

    <!-- RECOMMEND CONTENT -->
    <div class="rec-section position-relative">

        <div id="recCarousel" class="carousel slide" data-bs-interval="false">
            <div class="carousel-inner">

                <?php
                $chunks = array_chunk($recommendProducts, 4);
                foreach ($chunks as $i => $group):
                ?>
                    <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                        <div class="d-flex justify-content-between gap-3">

                            <?php foreach ($group as $item): ?>
                                <div class="rec-card p-3">

                                    <img src="<?= $item['img'] ?>" class="rec-img mb-2">

                                    <h6 class="fw-semibold"><?= $item['title'] ?></h6>
                                    <p class="small text-muted">5.0 (1.2k Reviews)</p>

                                    <h5 class="fw-bold">$<?= number_format($item['price'], 2) ?></h5>

                                    <button class="btn btn-outline-dark w-100 btn-sm mt-2">Add To Cart</button>
                                    <button class="btn btn-dark w-100 btn-sm mt-2">Buy Now</button>

                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>

    </div>


</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
