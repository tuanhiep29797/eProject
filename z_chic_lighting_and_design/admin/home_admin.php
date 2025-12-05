<?php
    require_once (__DIR__."/../config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <div class="ratio" style="--bs-aspect-ratio: 50%;">
        <div class="bg-cover bg-darkuuu">
            <?php
                require_once ("admin_header.php");
            ?>
            <div class="container">
                <div class="row">
                    <div class="col-1"></div>
                    <div class="col-3 d-flex flex-column align-items-center border border-dark rounded-2 m-3">
                        <i class="bi bi-people text-success fs-1 p-3"></i>
                        <a href="../modules/user/user.php" class="btn btn-primary mb-2">User Management</a>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center border border-dark rounded-2 m-3">
                        <i class="bi bi-cart4 text-info fs-1 p-3"></i>
                        <a href="../modules/order/order.php" class="btn btn-primary mb-2">Order Management</a>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center border border-dark rounded-2 m-3">
                        <i class="bi bi-chat-left-text text-danger fs-1 p-3"></i>
                        <a href="../modules/feedback/feedback.php" class="btn btn-primary mb-2">Feedback Management</a>
                    </div>
                </div>
                <div class="row">
                    <div class="col-1"></div> 
                    <div class="col-3 d-flex flex-column align-items-center border border-dark rounded-2 m-3">
                        <i class="bi bi-archive text-primary fs-1 p-3"></i>
                        <a href="../modules/category/category.php" class="btn btn-primary mb-2">Category Management</a>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center border border-dark rounded-2 m-3">
                        <i class="bi bi-boxes text-primary fs-1 p-3"></i>
                        <a href="../modules/brand/brand.php" class="btn btn-primary mb-2">Brand Management</a>
                    </div>
                    <div class="col-3 d-flex flex-column align-items-center border border-dark rounded-2 m-3">
                        <i class="bi bi-clipboard-data text-primary fs-1 p-3"></i>
                        <a href="../modules/product/product.php" class="btn btn-primary mb-2">Product Management</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>