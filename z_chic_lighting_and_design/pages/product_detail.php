<?php
require_once("../database/config.php");
require_once("../database/dbhelper.php");

/* =============== FAKE PRODUCT ID =============== */
$product_id = 1;

/* =============== 4 ẢNH SẢN PHẨM =============== */
$productImages = [
    "../img/product/1/1.png",
    "../img/product/1/2.png",
    "../img/product/1/3.png",
    "../img/product/1/4.png"
];

/* =============== SUBMIT ĐÁNH GIÁ =============== */
if (!empty($_POST["submitReview"])) {

    $rating = intval($_POST["rating"]);
    $review_text = trim($_POST["review_text"]);
    $username = trim($_POST["username"]);

    if ($rating > 0 && !empty($username)) {
        $sql = "INSERT INTO review (product_id, user_name, rating, review_text)
                VALUES (:pid, :uname, :rating, :text)";
        executeNonQuery($sql, [
            ":pid" => $product_id,
            ":uname" => $username,
            ":rating" => $rating,
            ":text" => $review_text
        ]);
    }
}

/* =============== LẤY TRUNG BÌNH SAO =============== */
$reviewStats = executeQuery("
    SELECT COUNT(*) AS total_review, AVG(rating) AS avg_rating
    FROM review WHERE product_id = :pid
", [":pid" => $product_id]);

if (!empty($reviewStats)) {
    $avgRating = round($reviewStats[0]["avg_rating"], 1);
    $totalReview = $reviewStats[0]["total_review"];
} else {
    $avgRating = 0;
    $totalReview = 0;
}

/* =============== LẤY LIST REVIEW =============== */
$reviews = executeQuery("
    SELECT user_name, rating, review_text, created_at
    FROM review
    WHERE product_id = :pid
    ORDER BY created_at DESC
", [":pid" => $product_id]);

/* =============== RECOMMEND SẢN PHẨM =============== */
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

    <!-- BACK -->
    <a href="./product.php" class="back-btn">
        <span class="arrow-icon">&lt;</span> Product
    </a>

    <!-- WRAPPER -->
    <div class="product-wrapper shadow-lg">

        <!-- LEFT -->
        <div class="left-box">

            <!-- MAIN IMG -->
            <div id="mainCarousel" class="carousel slide">
                <div class="carousel-inner">
                    <?php foreach ($productImages as $i => $img): ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <img src="<?= $img ?>" class="main-img">
                        </div>
                    <?php endforeach; ?>
                </div>

                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </button>

                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </button>
            </div>

            <!-- THUMB -->
            <div class="thumb-wrapper">
                <div class="thumb-container">
                    <?php foreach ($productImages as $index => $img): ?>
                        <img src="<?= $img ?>" class="thumb-img"
                             data-bs-target="#mainCarousel"
                             data-bs-slide-to="<?= $index ?>">
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <!-- RIGHT -->
        <div class="right-box">
            <div class="p-4">

                <div class="d-flex justify-content-between small text-white-50 mb-3">
                    <span>Brand: Philips</span>
                    <span>Category: Ceiling Lights</span>
                </div>

                <h3 class="fw-bold text-white mb-2">Log Barn vanity lights</h3>

                <p class="text-warning small mb-3">
                    ★ <?= $avgRating ?> (<?= $totalReview ?> reviews)
                </p>

                <p class="desc text-white-50 mb-4">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.  
                    Quae qui sed quasi quod ea ab harum! Placeat molestias quae sint esse temporibus.  
                    Lorem ipsum dolor sit amet consectetur adipisicing elit.  
                    Tempore, quam ducimus! Amet doloremque recusandae maxime.
                </p>

                <h3 class="fw-bold text-white mb-4">$29.90</h3>

                <div class="d-flex gap-3">
                    <button class="btn btn-outline-light px-4 py-2">ADD TO CART</button>
                    <button class="btn btn-light text-dark px-4 py-2 fw-bold">BUY NOW</button>
                </div>

            </div>
        </div>

    </div>

    <!-- RECOMMEND SECTION -->
    <div class="rec-header">
        <h2 class="fw-bold">Explore our recommendations</h2>

        <div class="rec-arrows">
            <button class="rec-arrow-btn" data-bs-target="#recCarousel" data-bs-slide="prev">←</button>
            <button class="rec-arrow-btn" data-bs-target="#recCarousel" data-bs-slide="next">→</button>
        </div>
    </div>

    <div id="recCarousel" class="carousel slide" data-bs-interval="false">
        <div class="carousel-inner">

            <?php $chunks = array_chunk($recommendProducts, 4);
            foreach ($chunks as $i => $group): ?>

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

    <!-- REVIEW FORM -->
    <div class="review-box p-4 bg-white rounded shadow-sm mt-5">
        <h4 class="fw-bold">Đánh giá sản phẩm</h4>

        <form method="POST" class="mt-3">

            <label class="fw-semibold">Tên của bạn:</label>
            <input type="text" name="username" class="form-control mb-3" required>

            <label class="fw-semibold">Chọn số sao:</label>

            <div class="star-rating mb-3">
                <input type="hidden" name="rating" id="rating-value">
                <span class="star" data-value="1">★</span>
                <span class="star" data-value="2">★</span>
                <span class="star" data-value="3">★</span>
                <span class="star" data-value="4">★</span>
                <span class="star" data-value="5">★</span>
            </div>

            <textarea class="form-control mb-3" name="review_text" placeholder="Nhập đánh giá..." required></textarea>

            <button class="btn btn-dark" name="submitReview">Gửi đánh giá</button>
        </form>

        <h5 class="fw-bold mt-4">Các đánh giá gần đây</h5>

        <?php foreach ($reviews as $rv): ?>
            <div class="border rounded p-3 mb-3 bg-light">
                <strong><?= htmlspecialchars($rv["user_name"]) ?></strong>
                <span class="text-warning"><?= str_repeat("★", $rv["rating"]) ?></span>
                <p><?= nl2br(htmlspecialchars($rv["review_text"])) ?></p>
                <small class="text-muted"><?= $rv["created_at"] ?></small>
            </div>
        <?php endforeach; ?>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JS CLICK SAO -->
<script>
const stars = document.querySelectorAll(".star-rating .star");
const ratingInput = document.getElementById("rating-value");

stars.forEach(star => {
    star.addEventListener("click", function () {
        let rating = this.getAttribute("data-value");
        ratingInput.value = rating;

        stars.forEach(s => s.classList.remove("selected"));
        for (let i = 0; i < rating; i++) stars[i].classList.add("selected");
    });
});
</script>

<?php include "footer.php"; ?>
</body>
</html>
