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

    //Ảnh nền chưa có
    <img src="..." class="img-fluid" alt="Ảnh nền chưa có">
    <div class="container">
        <div class="row">
            <div class="col">
                <img src="..." class="rounded mx-auto d-block" alt="...">
                <a href="/category/category.php"><button>Category Manage</button></a>
            </div>
            <div class="col">
                <img src="..." class="rounded mx-auto d-block" alt="...">
                <a href="/brand/brand.php"><button>Brand Manage</button></a>
            </div>
            <div class="col">
                <img src="..." class="rounded mx-auto d-block" alt="...">
                <a href="/product/product.php"><button>Product Manage</button></a>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <img src="..." class="rounded mx-auto d-block" alt="...">
                <a href="/order/order.php"><button>Order Manage</button></a>
            </div>
            <div class="col">
                <img src="..." class="rounded mx-auto d-block" alt="...">
                <a href="/feedback/feedback.php"><button>Feedback Manage</button></a>
            </div>
        </div>
    </div>
</body>
</html>