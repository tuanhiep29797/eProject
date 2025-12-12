<?php
    require_once (__DIR__."/../config.php");


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/admin.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

    <?php 
        require_once ("admin_header.php"); 
    ?>

    <div class="container py-4">

    <h2 class="text-center fw-bold mb-4">
        <i class="bi bi-house-fill me-2"></i>
        Admin Dashboard
    </h2>

    <div class="row g-4 justify-content-center">

        <div class="col-xl-3 col-md-4 col-10">
            <a href="../modules/user/user.php" class="text-decoration-none text-dark">
                <div class="card p-3 text-center shadow-sm admin-card">
                    <i class="bi bi-people-fill fs-1 text-primary"></i>
                    <h5 class="mt-3 fw-semibold">User Management</h5>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-4 col-10">
            <a href="../modules/order/order.php" class="text-decoration-none text-dark">
                <div class="card p-3 text-center shadow-sm admin-card">
                    <i class="bi bi-cart4 fs-1 text-success"></i>
                    <h5 class="mt-3 fw-semibold">Order Management</h5>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-4 col-10">
            <a href="../modules/feedback/feedback.php" class="text-decoration-none text-dark">
                <div class="card p-3 text-center shadow-sm admin-card">
                    <i class="bi bi-chat-left-text-fill fs-1 text-danger"></i>
                    <h5 class="mt-3 fw-semibold">Feedback Management</h5>
                </div>
            </a>
        </div>

    </div>

    <div class="row g-4 justify-content-center mt-2">

        <div class="col-xl-3 col-md-4 col-10">
            <a href="../modules/category/category.php" class="text-decoration-none text-dark">
                <div class="card p-3 text-center shadow-sm admin-card">
                    <i class="bi bi-archive fs-1 text-primary"></i>
                    <h5 class="mt-3 fw-semibold">Category Management</h5>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-4 col-10">
            <a href="../modules/brand/brand.php" class="text-decoration-none text-dark">
                <div class="card p-3 text-center shadow-sm admin-card">
                    <i class="bi bi-boxes fs-1 text-warning"></i>
                    <h5 class="mt-3 fw-semibold">Brand Management</h5>
                </div>
            </a>
        </div>

        <div class="col-xl-3 col-md-4 col-10">
            <a href="../modules/product/product.php" class="text-decoration-none text-dark">
                <div class="card p-3 text-center shadow-sm admin-card">
                    <i class="bi bi-clipboard-data fs-1 text-info"></i>
                    <h5 class="mt-3 fw-semibold">Product Management</h5>
                </div>
            </a>
        </div>

    </div>

</div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
