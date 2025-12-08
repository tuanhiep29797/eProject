<<<<<<< HEAD
=======
<?php
require_once("../database/config.php");
require_once("../database/dbhelper.php");

// 1. Get Product ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : (isset($_GET['product']) ? intval($_GET['product']) : 0);

$product = null;
$productImages = [];
$recommendProducts = [];
$avgRating = 0;
$totalReview = 0;
$reviews = [];

if ($product_id > 0) {
    try {
        $conn = getConnection();
        
        // 2. Fetch Product Details
        $sql = "SELECT p.*, c.category_name, b.brand_name 
                FROM product p
                LEFT JOIN category c ON p.category_id = c.category_id
                LEFT JOIN brand b ON p.brand_id = b.brand_id
                WHERE p.product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // 3. Fetch Additional Images
            // Add main thumbnail first
            if (!empty($product['product_thumbnail'])) {
                $productImages[] = $product['product_thumbnail'];
            }
            
            // Query table product_img if exists
            try {
                $sql_img = "SELECT url FROM product_img WHERE product_id = :id";
                $stmt_img = $conn->prepare($sql_img);
                $stmt_img->execute([':id' => $product_id]);
                $imgs = $stmt_img->fetchAll(PDO::FETCH_COLUMN);
                foreach ($imgs as $img) {
                    $productImages[] = $img;
                }
            } catch (Exception $e) {
                // Ignore if table doesn't exist or empty
            }
            
            // Fallback if no images
            if (empty($productImages)) {
                $productImages[] = "../assets/img/default.png"; // Placeholder
            }
            
            // 4. Fetch Reviews Stats
            $sql_stats = "SELECT COUNT(*) AS total_review, AVG(rating) AS avg_rating 
                          FROM review WHERE product_id = :id AND is_public = 1";
            $stmt_stats = $conn->prepare($sql_stats);
            $stmt_stats->execute([':id' => $product_id]);
            $stats = $stmt_stats->fetch(PDO::FETCH_ASSOC);
            if ($stats) {
                $totalReview = $stats['total_review'];
                $avgRating = $stats['avg_rating'] ? round($stats['avg_rating'], 1) : 5.0; // Default 5 if no reviews
            }

            // 5. Fetch Reviews List
            $sql_reviews = "SELECT r.*, u.fullname, u.username 
                            FROM review r 
                            JOIN user u ON r.user_id = u.user_id 
                            WHERE r.product_id = :id AND r.is_public = 1 
                            ORDER BY r.created_at DESC";
            $stmt_reviews = $conn->prepare($sql_reviews);
            $stmt_reviews->execute([':id' => $product_id]);
            $reviews = $stmt_reviews->fetchAll(PDO::FETCH_ASSOC);

            // 6. Fetch Recommendations (Same Category)
            $cat_id = $product['category_id'];
            $sql_rec = "SELECT * FROM product 
                        WHERE category_id = :cat_id AND product_id != :pid 
                        LIMIT 8";
            $stmt_rec = $conn->prepare($sql_rec);
            $stmt_rec->execute([':cat_id' => $cat_id, ':pid' => $product_id]);
            $recommendProducts = $stmt_rec->fetchAll(PDO::FETCH_ASSOC);
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Handle Review Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitReview'])) {
    if (!isset($_SESSION['user_id']) && !isset($_SESSION['user'])) { // Check login logic from config/header
        // Redirect to login or show error
        $review_error = "Please login to review.";
    } else {
        // Assume user_id is in session (based on other files, session might have 'user' object or 'user_id')
        // config.php uses $_SESSION["username"], header uses $_SESSION["fullname"].
        // I need to find where user_id is stored. usually in login.
        // Let's assume $_SESSION['user']['user_id'] or query by username.
        // For now, I'll check if I can get user_id. 
        // If not readily available, I might need to query user table by username.
        
        $username = $_SESSION['username'] ?? '';
        $user_id = 0;
        
        if ($username) {
            // Get user_id
            $conn = getConnection();
            $stmt = $conn->prepare("SELECT user_id FROM user WHERE username = :u");
            $stmt->execute([':u' => $username]);
            $u = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($u) $user_id = $u['user_id'];
        }

        if ($user_id > 0) {
            $rating = intval($_POST['rating']);
            $text = trim($_POST['review_text']);
            // Check if user bought the item? Optionally. For now just allow.
            // Check order_id? Schema requires order_id for review?
            // SQL_CREATE_TABLE_REVIEW: order_id INT, user_id INT, product_id INT...
            // It seems order_id is nullable in my memory? Let me check schema.
            // "review_id INT AUTO_INCREMENT PRIMARY KEY, order_id INT, ..." 
            // It doesn't say NOT NULL for order_id.
            
            if ($rating > 0 && !empty($text)) {
                try {
                    $sql_add = "INSERT INTO review (user_id, product_id, rating, review_content, is_public) 
                                VALUES (:uid, :pid, :rating, :text, 1)";
                    $stmt_add = $conn->prepare($sql_add);
                    $stmt_add->execute([
                        ':uid' => $user_id,
                        ':pid' => $product_id,
                        ':rating' => $rating,
                        ':text' => $text
                    ]);
                    // Refresh page
                    header("Location: product_detail.php?id=$product_id");
                    exit;
                } catch (Exception $e) {
                    $review_error = "Error submitting review: " . $e->getMessage();
                }
            }
        } else {
            $review_error = "Please login to review.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? htmlspecialchars($product['product_title']) : 'Product Not Found' ?> - Chic Lighting</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/css/product_detail.css?v=<?= time() ?>" rel="stylesheet">
    
    <!-- Inline styles to match the dark aesthetic from image if css is missing/incomplete -->
    <style>
        body {
            background-color: #fff;
            color: #333;
        }
        .top-bg {
            height: 80px; /* Adjust as needed */
            background-color: #333; /* Header background */
        }
        .product-wrapper {
            background-color: #000;
            color: #fff;
            border-radius: 30px;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            margin-top: 20px;
        }
        .left-box {
            background-color: #fff;
            flex: 1;
            min-width: 300px;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-radius: 30px 0 0 30px;
        }
        .right-box {
            background-color: #000;
            flex: 1;
            min-width: 300px;
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        @media (max-width: 768px) {
            .left-box { border-radius: 30px 30px 0 0; }
            .right-box { border-radius: 0 0 30px 30px; }
        }

        .main-img {
            width: 100%;
            max-width: 400px;
            height: auto;
            object-fit: contain;
        }
        .thumb-wrapper {
            margin-top: 20px;
            width: 100%;
            overflow-x: auto;
        }
        .thumb-container {
            display: flex;
            gap: 10px;
            justify-content: center;
        }
        .thumb-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #ddd;
            cursor: pointer;
            opacity: 0.6;
            transition: 0.3s;
        }
        .thumb-img:hover, .thumb-img.active {
            opacity: 1;
            border-color: #000;
        }
        
        /* Stars */
        .star-rating .star {
            font-size: 2rem;
            cursor: pointer;
            color: #ddd;
        }
        .star-rating .star.selected {
            color: #ffc107;
        }
        
        /* Rec */
        .rec-card {
            background: #f8f9fa;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s;
        }
        .rec-card:hover {
            transform: translateY(-5px);
        }
        .rec-img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            mix-blend-mode: multiply;
        }
        
        .back-btn {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<?php include "../includes/home_header.php"; ?>

<div class="container py-5">

    <!-- Breadcrumb / Back -->
    <a href="product.php" class="back-btn mb-3">
        <i class="bi bi-chevron-left me-1"></i> Product
    </a>

    <?php if ($product): ?>
    <!-- WRAPPER -->
    <div class="product-wrapper shadow-lg">

        <!-- LEFT (Images) -->
        <div class="left-box position-relative">
            <!-- MAIN IMG CAROUSEL -->
            <div id="mainCarousel" class="carousel slide w-100" data-bs-interval="false">
                <div class="carousel-inner">
                    <?php foreach ($productImages as $i => $img): ?>
                        <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                            <div class="d-flex justify-content-center align-items-center" style="height: 400px;">
                                <img src="<?= htmlspecialchars($img) ?>" class="main-img" alt="Product Image">
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                
                <?php if (count($productImages) > 1): ?>
                <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev" style="filter: invert(1);">
                    <span class="carousel-control-prev-icon"></span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next" style="filter: invert(1);">
                    <span class="carousel-control-next-icon"></span>
                </button>
                <?php endif; ?>
            </div>

            <!-- THUMBS -->
            <?php if (count($productImages) > 1): ?>
            <div class="thumb-wrapper">
                <div class="thumb-container">
                    <?php foreach ($productImages as $index => $img): ?>
                        <img src="<?= htmlspecialchars($img) ?>" class="thumb-img" 
                             onclick="document.querySelector('#mainCarousel').querySelector('.carousel-item.active').classList.remove('active'); document.querySelectorAll('#mainCarousel .carousel-item')[<?= $index ?>].classList.add('active');"
                             >
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT (Info) -->
        <div class="right-box">
            <div class="p-2">
                <div class="d-flex justify-content-between small text-white-50 mb-3">
                    <span>Brand: <?= htmlspecialchars($product['brand_name'] ?? 'N/A') ?></span>
                    <span>Category: <?= htmlspecialchars($product['category_name'] ?? 'General') ?></span>
                </div>

                <h2 class="fw-bold text-white mb-2"><?= htmlspecialchars($product['product_title']) ?></h2>

                <p class="text-warning small mb-3">
                    <i class="bi bi-star-fill"></i> <?= $avgRating ?> (<?= $totalReview ?> Reviews)
                </p>

                <div class="desc text-white-50 mb-4" style="max-height: 150px; overflow-y: auto;">
                    <?= nl2br(htmlspecialchars($product['product_description'])) ?>
                </div>
                
                <?php if (!empty($product['product_content'])): ?>
                    <div class="product-specs text-white-50 mb-4 small">
                        <?= $product['product_content'] // Allow HTML for specs ?> 
                    </div>
                <?php endif; ?>

                <h3 class="fw-bold text-white mb-4">$<?= number_format($product['product_price'], 2) ?></h3>

                <div class="d-flex gap-3">
                    <a href="../modules/cart/add_to_card.php?id=<?= $product['product_id'] ?>" class="btn btn-outline-light px-4 py-2">ADD TO CART</a>
                    <a href="../modules/cart/add_to_card.php?id=<?= $product['product_id'] ?>&checkout=true" class="btn btn-light text-dark px-4 py-2 fw-bold">BUY NOW</a>
                </div>
            </div>
        </div>

    </div>

    <!-- RECOMMEND SECTION -->
    <?php if (!empty($recommendProducts)): ?>
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Explore our recommendations</h2>
            
             <div class="rec-arrows">
                <button class="btn btn-outline-dark rounded-circle me-2" data-bs-target="#recCarousel" data-bs-slide="prev"><i class="bi bi-arrow-left"></i></button>
                <button class="btn btn-outline-dark rounded-circle" data-bs-target="#recCarousel" data-bs-slide="next"><i class="bi bi-arrow-right"></i></button>
            </div>
        </div>

        <div id="recCarousel" class="carousel slide" data-bs-interval="false">
            <div class="carousel-inner">
                <?php 
                $chunks = array_chunk($recommendProducts, 4);
                foreach ($chunks as $i => $group): 
                ?>
                <div class="carousel-item <?= $i == 0 ? 'active' : '' ?>">
                    <div class="row g-3">
                        <?php foreach ($group as $item): ?>
                        <div class="col-6 col-md-3">
                            <div class="rec-card p-3 h-100 d-flex flex-column">
                                <a href="product_detail.php?id=<?= $item['product_id'] ?>" class="text-decoration-none text-dark flex-grow-1">
                                    <div class="img-wrapper mb-3" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                        <img src="<?= htmlspecialchars($item['product_thumbnail']) ?>" class="img-fluid" style="max-height: 100%;">
                                    </div>
                                    <h6 class="fw-semibold text-truncate"><?= htmlspecialchars($item['product_title']) ?></h6>
                                    <h5 class="fw-bold mt-auto">$<?= number_format($item['product_price'], 2) ?></h5>
                                </a>
                                <div class="mt-2">
                                     <a href="../modules/cart/add_to_card.php?id=<?= $item['product_id'] ?>" class="btn btn-outline-dark w-100 btn-sm">Add To Cart</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- REVIEWS SECTION -->
    <div class="review-box p-4 bg-white rounded shadow-sm mt-5 border">
        <h4 class="fw-bold mb-4">Customer Reviews</h4>

        <!-- Review Form -->
        <?php if (isset($_SESSION['username'])): ?>
            <form method="POST" class="mb-5 p-3 bg-light rounded">
                <h6 class="fw-bold">Write a review</h6>
                <?php if (isset($review_error)) echo "<div class='alert alert-danger'>$review_error</div>"; ?>
                
                <div class="mb-3">
                    <label class="form-label">Rating</label>
                    <div class="star-rating">
                        <input type="hidden" name="rating" id="rating-value" value="5">
                        <i class="bi bi-star-fill star selected" data-value="1"></i>
                        <i class="bi bi-star-fill star selected" data-value="2"></i>
                        <i class="bi bi-star-fill star selected" data-value="3"></i>
                        <i class="bi bi-star-fill star selected" data-value="4"></i>
                        <i class="bi bi-star-fill star selected" data-value="5"></i>
                    </div>
                </div>

                <div class="mb-3">
                    <textarea class="form-control" name="review_text" rows="3" placeholder="Share your thoughts..." required></textarea>
                </div>

                <button type="submit" name="submitReview" class="btn btn-dark">Submit Review</button>
            </form>
        <?php else: ?>
            <div class="alert alert-info">Please <a href="../admin/login.php">login</a> to write a review.</div>
        <?php endif; ?>

        <!-- Reviews List -->
        <div class="reviews-list">
            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $rv): ?>
                    <div class="border-bottom pb-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong><?= htmlspecialchars($rv['fullname'] ?: $rv['username']) ?></strong>
                            <span class="text-muted small"><?= date('M d, Y', strtotime($rv['created_at'])) ?></span>
                        </div>
                        <div class="text-warning mb-2">
                            <?php for($k=1; $k<=5; $k++) echo $k <= $rv['rating'] ? '<i class="bi bi-star-fill"></i> ' : '<i class="bi bi-star"></i> '; ?>
                        </div>
                        <p class="mb-0 text-secondary"><?= nl2br(htmlspecialchars($rv['review_content'])) ?></p>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-muted">No reviews yet. Be the first to review!</p>
            <?php endif; ?>
        </div>

    </div>

    <?php else: ?>
        <div class="text-center py-5">
            <h2>Product Not Found</h2>
            <p>The product you are looking for does not exist or has been removed.</p>
            <a href="product.php" class="btn btn-dark mt-3">Back to Products</a>
        </div>
    <?php endif; ?>

</div>

<?php include "../includes/home_footer.php"; ?>

<script>
    // Star Rating Logic
    const stars = document.querySelectorAll(".star-rating .star");
    const ratingInput = document.getElementById("rating-value");

    stars.forEach(star => {
        star.addEventListener("click", function () {
            let rating = this.getAttribute("data-value");
            ratingInput.value = rating;

            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.add("selected");
                    s.classList.remove("bi-star");
                    s.classList.add("bi-star-fill");
                } else {
                    s.classList.remove("selected");
                    s.classList.remove("bi-star-fill");
                    s.classList.add("bi-star");
                }
            });
        });
        
        star.addEventListener("mouseover", function() {
             let rating = this.getAttribute("data-value");
             stars.forEach((s, index) => {
                if (index < rating) {
                    s.style.color = "#e0a800";
                }
             });
        });
        
        star.addEventListener("mouseout", function() {
             stars.forEach(s => s.style.color = "");
        });
    });
</script>

</body>
</html>
>>>>>>> e266eb1 (Product-detail)
