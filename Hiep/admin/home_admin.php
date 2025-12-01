<?php
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
</head>
<body>
    <?php include "header.php"?>

    <!-- Ảnh nền chưa có -->
    <img src="..." class="img-fluid" alt="Ảnh nền chưa có">
    <div class="container">
        <div class="row">
            <div class="col card">
                <i class="bi bi-archive text-primary fs-1"></i>
                <a href="/category/category.php"><button>Category Management</button></a>
            </div>
            <div class="col">
                <i class="bi bi-boxes text-primary fs-1"></i>
                <a href="/brand/brand.php"><button>Brand Management</button></a>
            </div>
            <div class="col">
                <i class="bi bi-clipboard-data text-primary fs-1"></i>
                <a href="/product/product.php"><button>Product Management</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <i class="bi bi-people text-primary fs-1"></i>
                <a href="/user/user.php"><button>User Management</button></a>
            </div>
            <div class="col">
                <i class="bi bi-cart4 text-primary fs-1"></i>
                <a href="/order/order.php"><button>Order Management</button></a>
            </div>
            <div class="col">
                <i class="bi bi-chat-left-text text-danger fs-1"></i>
                <a href="/feedback/feedback.php"><button>Feedback Management</button></a>
            </div>
        </div>
    </div>
</body>
</html>