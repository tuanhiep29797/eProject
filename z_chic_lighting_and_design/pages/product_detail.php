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
  <title>Product Page</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/../assets/css/product_detail.css?v=<?= time() ?>">
</head>

<body>

  <div class="container py-3">
    <a href="product.php" class="back-link">
      <i class="bi bi-chevron-left"></i> Product
    </a>
  </div>

  <!-- Product Detail Section -->
  <section class="product-detail py-4">
    <div class="container">
      <div class="product-card">
        <div class="row g-4">
          <!-- Product Images -->
          <div class="col-lg-5">
            <div class="product-gallery">
            <?php foreach($product_detail_list as $item): ?>

              <div class="main-image">
                <img src="<?= $item['product_thumbnail'] ?>" alt="$item[" id="mainImage">
              </div>
              <div class="thumbnail-list">
                <button class="thumbnail active"
                  onclick="changeImage(this, './img/lamp_02_w500.jpeg')">
                  <img src="./img/lamp_01_w100.jpeg" alt="Thumbnail 1">
                </button>
                <button class="thumbnail"
                  onclick="changeImage(this, './img/Lamp_05_w500.jpeg')">
                  <img src="./img/lamp_04_w100.jpeg" alt="Thumbnail 2">
                </button>
                <button class="thumbnail"
                  onclick="changeImage(this, './img/lamp_06_w500.jpeg')">
                  <img src="./img/Lamp_03_w100.jpeg" alt="Thumbnail 3">
                </button>
              </div>
            <?php endforeach; ?>
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
  <script>
    function changeImage(thumbnail, imageUrl) {

      document.getElementById('mainImage').src = imageUrl;


      document.querySelectorAll('.thumbnail').forEach(t => t.classList.remove('active'));
      thumbnail.classList.add('active');
    }
  </script>

</body>

</html>