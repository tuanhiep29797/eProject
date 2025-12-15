<?php
  require_once(__DIR__ . "/../database/dbhelper.php");

  // get data product
  if (isset($_GET['slug'])) 
  {
    $product_slug = $_GET['slug'];
    try 
    {
      $conn = getConnection();
      $stmt = $conn->prepare(SQL_GET_PRODUCT_AS_C_AND_B_BY_SLUG);
      $stmt->bindParam(":product_slug", $product_slug);
      $stmt->execute();

      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $product_detail_list = $stmt->fetchAll();

      if ($product_detail_list == null || count($product_detail_list) == 0) {
        echo  '<script>
                  alert("Product detail not found.");
                  window.location.href = "' . BASE_URL . 'product";
              </script>';
      }

      $product_item = $product_detail_list[0];
      $product_id = $product_item["product_id"];
      $is_OOS = boolval($product_item["product_quantity"] == 0);

      $stmt = $conn->prepare(SQL_GET_PRODUCT_IMG_BY_PRODUCT);
      $stmt->bindParam(":product_id", $product_id);
      $stmt->execute();

      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $product_img_list = $stmt->fetchAll();

      $stmt = $conn->prepare(SQL_GET_PRODUCT_AS_CAT_AND_BRAND . 
                "where p.product_id != :product_id and p.product_quantity > 0
                order by rand()
                limit 6
                ");
      $stmt->bindParam(":product_id", $product_id);
      $stmt->execute();

      $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $random_products = $stmt->fetchAll();
    } 
    catch (PDOException $e) 
    {
      echo "<script>
              console.error(" . json_encode($e->getMessage()) . ");
          </script>";
      exit();
    }
    $conn = null;
  } 
  else 
  {
    echo '<script>
            alert("Product detail not found.");
            window.location.href = "' . BASE_URL . 'product";
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
  <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

  <!-- include header -->
  <?php
  require_once(__DIR__ . "/../includes/home_header.php");
  ?>

  <!-- banner -->
  <div class="page-banner">
    <div class="container">
      <h2>Product Detail</h2>

      <div class="banner-breadcrumb">
        <a href="<?= BASE_URL ?>home">Home</a>

        <i class="bi bi-chevron-right"></i>

        <a href="<?= BASE_URL ?>product">Product</a>

        <i class="bi bi-chevron-right"></i>

        <a href="#"><?= htmlspecialchars($product_item["product_title"]) ?></a>

      </div>
    </div>
  </div>


  <!-- <body -->
  <section class="product-detail py-3 py-md-4">
    <div class="container px-3 px-md-4">
      <a href="<?= BASE_URL ?>product" class="back-btn text-decoration-none text-secondary mb-3 mb-md-4 fw-bold d-inline-block">
        <i class="bi bi-chevron-left me-1"></i> Product
      </a>
      <div class="product-card">
        <div class="row g-3 g-md-4">
          <!-- product images -->
          <div class="col-12 col-md-12 col-xl-6">

            <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <?php foreach ($product_img_list as $index => $product_img): ?>
                  <div class="carousel-item <?= $index === 0 ? "active" : "" ?>" data-bs-interval="2000">
                    <img src="<?= BASE_URL . $product_img["url"] ?>" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Product Image">
                  </div>
                <?php endforeach; ?>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>

          </div>

          <!-- product info -->
          <div class="col-12 col-md-12 col-xl-6">
            <div class="product-info">
              <div class="product-meta">
                <span class="meta-item">Brand: <strong><?= $product_item['brand_name'] ?></strong></span>
                <span class="meta-item">Category: <strong><?= $product_item['category_name'] ?></strong></span>
              </div>

              <h1 class="product-title">
                <?= $product_item['product_title'] ?>
              </h1>

              <div class="rating-badge">
                <i class="bi bi-star-fill"></i>
                <span>5.0</span>
                <span class="rating-count">(26 Reviews)</span>
              </div>

              <p class="product-description">
                <?= $product_item['product_description'] ?>
              </p>
              <p class="product-description">
                <?= $product_item['product_content'] ?>
              </p>

              <div class="product-price">
                <?php if(!$is_OOS):?>
                  <h5>In stock: <?= $product_item["product_quantity"] ?></h5>
                  $<?= number_format($product_item['product_price'], 2) ?>
                <?php else: ?>
                  Out of Stock
                <?php endif;?>
              </div>

              <div class="product-actions">
                <a class="btn btn-outline-success btn-cart <?= $is_OOS ? "disabled" : "" ?>" href="<?= BASE_URL ?>modules/cart/add_to_cart.php?id=<?= $product_item['product_id'] ?>">
                    <i class="bi bi-cart-plus"></i>
                    ADD TO CART
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- recommendations section -->
  <section class="recommendations py-4 py-md-5">
    <div class="container px-3 px-md-4">
      <div class="section-header">
        <h2 class="section-title fs-4">Explore our recomendations</h2>
      </div>

      <div class="row g-3 g-md-4">
        <?php for ($i = 0; $i <= 5; $i++):
          $product_item = $random_products[$i];
        ?>
          <div class="col-6 col-md-4 col-xl-2">
            <div class="recommendation-card">
              <a class="text-decoration-none" href="<?= BASE_URL ?>product/<?= $product_item['product_slug'] ?>">
                <div class="card-image">
                  <img src="<?= BASE_URL . $product_item['product_thumbnail'] ?>" alt="<?= $product_item['product_thumbnail'] ?>">
                </div>
                <div class="card-body">
                  <h5 class="card-title"><?= $product_item['product_title'] ?></h5>
                  <div class="card-rating">
                    <i class="bi bi-star-fill"></i>
                    <span>5.0 (26 Reviews)</span>
                  </div>
                  <div class="card-price">$<?= number_format($product_item['product_price'], 2) ?></div>
                  <div class="card-actions text-nowrap">
                    <a href="<?= BASE_URL ?>modules/cart/add_to_cart.php?id=<?= $product_item['product_id'] ?>">
                      <button class="btn btn-sm btn-dark">Add To Cart</button>
                    </a>
                    <a href="<?= BASE_URL ?>product/<?= $product_item['product_slug'] ?>">
                      <button class="btn btn-sm btn-warning">Buy Now</button>
                    </a>
                  </div>
                </div>
              </a>
            </div>
          </div>
        <?php endfor; ?>
      </div>
    </div>
  </section>

  <!-- include footer -->
  <?php
    require_once(__DIR__ . "/../includes/home_footer.php");
  ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>