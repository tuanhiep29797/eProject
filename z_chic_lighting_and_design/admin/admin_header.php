<?php
     if(!is_admin())
    {
        header("Location: ". BASE_URL ."/pages/home_page.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Header</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/admin.css">

</head>

<body>

<header class="admin-header">
    <div class="container">

        <div class="row align-items-center">

            <div class="col-xl-2 col-md-3 col-12 d-flex justify-content-start mb-2 mb-md-0">
                <a href="<?= BASE_URL ?>admin/home_admin.php">
                    <img src="<?= BASE_URL ?>assets/img/home/img_logo.png" alt="Logo" class="logo-box">
                </a>
            </div>

            <div class="col-xl-10 col-md-9 col-12 d-flex justify-content-xl-end justify-content-md-end justify-content-start gap-3">

                <a href="<?= BASE_URL ?>pages/home_page.php" class="header-btn">
                    <i class="bi bi-house-door-fill"></i> Home
                </a>

                <a href="<?= BASE_URL ?>admin/home_admin.php" class="header-btn text-primary">
                    <i class="bi bi-house-fill"></i> Admin
                </a>

                <a href="<?= BASE_URL ?>admin/logout.php" class="header-btn text-danger">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>

            </div>

        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
