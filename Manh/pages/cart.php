<?php 
$products = [
    [
        "id" => 1,
        "name" => "EGLO VINTAGE",
        "desc" => "Esse aliquam delectus",
        "price" => 1200000,
        "quantity" => 12,
        "image" => "../img/test_product.png"
    ],
    [
        "id" => 2,
        "name" => "Nordic Hanging Lamp",
        "desc" => "Elegant and modern",
        "price" => 950000,
        "quantity" => 3,
        "image" => "../img/test_product.png"
    ],
    
    [
        "id" => 4,
        "name" => "Classic Chandelier",
        "desc" => "Luxury classic style",
        "price" => 3250000,
        "quantity" => 1,
        "image" => "../img/test_product.png"
    ],
    [
        "id" => 5,
        "name" => "Industrial Metal Lamp",
        "desc" => "Strong industrial look",
        "price" => 780000,
        "quantity" => 7,
        "image" => "../img/test_product.png"
    ],
];
$total = 0;
foreach($products as $item){
    $total += $item['price']*$item['quantity'];
}

if(!empty($_POST))
    {
        $id = $_POST["product_id"];
        $action = $_POST["action"];
        switch ($action):
            case "plus":
                break;
            case "minus":
                break;
    }





?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/style.css?v=<?= time() ?>">
    <title>Cart</title>
</head>

<body>
    <div class="cart">
        <div class="cart-header">
            <?php require_once "../includes/header.php"; ?>
        </div>
        <div class="text-center text-white cart-header-text mt-5">
            <h1 style="font-size:48px">Cart</h1>
            <div class="d-flex justify-content-center align-items-center gap-3 text-center-bottom" style="cursor:pointer">
                <a href="../pages/home.php">
                    <h4 style="color:#26b66a">Home</h4>
                </a>
                <h4>></h4>
                <a href="../pages/cart.php">
                    <h4>Cart</h4>
                </a>
            </div>
        </div>
    </div>
    </div class="container">
        <div class="shopping-cart">
            <div class="shopping-cart-header my-4 text-center">
                <h1>Shopping Cart</h1>
            </div>
            <div class="shopping-cart-search my-4 mb-5">
                <form action="GET">
                    <div class="shopping-cart-search_input">
                        <label for="search_cart"><i class="bi bi-search"></i></label>
                        <input type ="text" placeholder="Search on cart" name="search_cart" id = "search_cart"/>
                        <button type ="submit">Search</button>
                    </div>
                </form>
            </div>
            <div class="shopping-cart-product mt-4">
                <?php foreach ($products as $item): ?>
                <div class="sc-product row align-items-center px-4 mx-5 mt-4">
                    <div class="sc-product-img col-lg-2 ">
                        <img src="<?= $item['image'] ?>" alt=""/>
                    </div>
                    <div class="sc-product-text col-lg-3 text-right">
                        <h5 class="fw-bold"><?= $item['name'] ?></h5>
                        <p class="m-0"><?= $item['desc'] ?></p>
                    </div>
                    <div class="sc-product-price col-lg-2 text-right">
                        <p class="">Price</p>
                        <span class="text-success fw-semibold"> <?= number_format($item['price']) ?>đ</span>
                    </div> 
                    <div class="sc-product-quantity col-lg-2 text-right">
                        <p class="">Quantity</p>
                        <form method="post" class="cart-item-form">
                            <input type="hidden" name="product_id" value="<?= $item['id'] ?>">
                            <div class="sc-product-quantity-edit d-flex align-items-center">
                                <input type="number" min="1" name="quantity" class="me-lg-5 text-right text-success input-qty" 
                                    value="<?= $item['quantity']?>" />
                            </div>
                            <button type="submit" class="btn btn-success btn-confirm mt-1" name="action" value="plus" >+</button>
                            <button type="submit" class="btn btn-success btn-confirm mt-1" name="action" value="minus" >-</button>
                        </form>
                    </div>
                    <div class="sc-product-total col-lg-2 text-right">
                        <p class="">Total</p>
                        <span class="text-success fw-semibold"><?= number_format($item['price'] * $item['quantity']) ?></span>
                    </div>
                    <div class="sc-product-action col-lg-1 d-flex justify-content-start px-0">
                        <button class="btn btn-outline-dark ">Remove</button>
                    </div>
                </div>
                <?php endforeach; ?> 
            </div>
            <div class="shopping-cart-total">
                <div class="row px-4 mx-5 my-5">
                    <div class="sc-total ms-lg-5 ms-sm-0 d-flex align-items-center">
                        <div class="sc-total-text col-lg-2 text-center">
                            <h3 class="fw-bold m-0">Total Amount:</h3>
                        </div>
                        <div class="sc-total-number col-lg-6 text-center">
                            <span class="text-success fw-bold" style="font-size:24px"> <?= number_format($total) ?>đ</span>
                        </div>
                        <div class="sc-total-action col-lg-4">
                            <button class="btn btn-outline-dark ">Remove All</button>
                            <button class="btn btn-outline-dark bg-dra">Check out</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.querySelectorAll('.cart-item-form').forEach(form => {
        const btnConfirm = form.querySelector('.product-quantity-btn');
        const inputQty = form.querySelector('.input-qty');
        
        const showConfirm = () => btnConfirm.classList.add('active');
        inputQty.addEventListener('input', showConfirm);
});
</script>

    
</body>
</html>