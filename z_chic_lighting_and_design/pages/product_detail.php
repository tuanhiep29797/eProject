<?php
    require_once(__DIR__ . "/../database/dbhelper.php");

    if (isset($_GET['id'])) {
        $product_id = intval($_GET['id']); 
         try {
            $conn = getConnection();
            $stmt = $conn->prepare("
                SELECT p.*, b.brand_name, c.category_name
                FROM product p
                inner join brand b on b.brand_id =p.brand_id
                inner join category c on c.category_id =p.category_id
                WHERE p.product_id = :product_id");
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $product_detail_list = $stmt->fetchAll();

            if ($product_detail_list == null || count($product_detail_list) == 0) {
            echo '<script>
                    alert("Product detail not found.");
                    window.location.href = "product.php";
                </script>';
            }

            $item = $product_detail_list[0];

            $stmt = $conn->prepare("
                SELECT p.*, b.brand_name, c.category_name
                FROM product p
                LEFT JOIN brand b ON b.brand_id = p.brand_id
                LEFT JOIN category c ON c.category_id = p.category_id
                WHERE p.product_id != :product_id
                ORDER BY RAND()
                LIMIT 5
                ");
            $stmt->bindParam(":product_id", $product_id);
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $random_products = $stmt->fetchAll();


        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null;

    } else {
        echo '<script>
            alert("Product detail not found.");
            window.location.href = "product.php";
        </script>';
        exit();
    }

?>

<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Detail</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/product_detail.css?v=<?= time() ?>">
</head>

<body>

  <!-- include header -->
  <?php
      require_once (__DIR__."/../includes/home_header.php");
  ?>

  <div class="page-banner">
      <div class="container">
          <h2>Product Detail</h2>
          
          <div class="banner-breadcrumb">
              <a href="home_page.php">Home</a>

              <i class="bi bi-chevron-right"></i>
      
              <a href="product.php">Product</a>
              
              <i class="bi bi-chevron-right"></i>
      
              <a href="#"><?= htmlspecialchars($item["product_title"]) ?>?></a>
              
          </div>
      </div>
  </div>

  <!-- Product Detail Section -->
  <section class="product-detail py-4">
    <div class="container">
      <div class="product-card">
        <div class="row g-4">
          <!-- Product Images -->
          <div class="col-lg-5">
            <div id="carouselExampleIndicators" class="carousel slide">
              <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
              </div>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img src="..." class="d-block w-100" alt="Product Image 1">
                </div>
                <div class="carousel-item">
                  <img src="..." class="d-block w-100" alt="Product Image 2">
                </div>
                <div class="carousel-item">
                  <img src="..." class="d-block w-100" alt="Product Image 3">
                </div>
                <div class="carousel-item">
                  <img src="..." class="d-block w-100" alt="Product Image 4">
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
          </div>

          <!-- Product Info -->
          <div class="col-lg-7">
            <?php foreach($product_detail_list as $item): ?>
            <div class="product-info">
              <div class="product-meta">
                <span class="meta-item">Brand: <strong><?= $item['brand_name'] ?></strong></span>
                <span class="meta-item">Category: <strong><?= $item['category_name'] ?></strong></span>
              </div>

              <h1 class="product-title">      
                <?= $item['product_title'] ?>
            </h1>

              <div class="rating-badge">
                <i class="bi bi-star-fill"></i>
                <span>5.0</span>
                <span class="rating-count">(26 Reviews)</span>
              </div>

              <p class="product-description">
                <?= $item['product_description'] ?>
              </p>
              <p class="product-description">
                <?= $item['product_content'] ?>
              </p>

              <div class="product-price">$<?= number_format($item['product_price'])?></div>

              <div class="product-actions">
                <button class="btn btn-outline-dark btn-cart">
                  ADD TO CART
                </button>
                <button class="btn btn-dark btn-buy">
                  BUY NOW
                </button>
              </div>
            </div>
          </div>
            <?php endforeach; ?>
        </div>
      </div>
    </div>
  </section>

  <!-- Recommendations Section -->
  <section class="recommendations py-5">
    <div class="container">
      <div class="section-header">
        <h2 class="section-title">Explore our recomendations</h2>
      </div>

      <div class="row g-4">
        <?php for ($i = 0; $i < 5; $i++): 
            $item = $random_products[$i];
        ?>
        <div class="col-6 col-md-4 col-lg">
        <div class="recommendation-card">
            <div class="card-image">
            <img src="<?= $item['product_thumbnail'] ?>" alt="<?= $item['product_thumbnail'] ?>">
            </div>
            <div class="card-body">
            <h5 class="card-title"><?= $item['product_title'] ?></h5>
            <div class="card-rating">
                <i class="bi bi-star-fill"></i>
                <span>5.0 (26 Reviews)</span>
            </div>
            <div class="card-price">$<?= number_format($item['product_price']) ?></div>
            <div class="card-actions">
                <a href="<?= BASE_URL ?>modules/cart/add_to_cart.php?id=<?= $item['product_id'] ?>">
                    <button class="btn btn-sm btn-dark">Add To Cart</button>
                </a>
                <button class="btn btn-sm btn-warning">Buy Now</button>
            </div>
            </div>
        </div>
        </div>
        <?php endfor; ?>
      </div>
    </div>
  </section>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  
</body>

</html>