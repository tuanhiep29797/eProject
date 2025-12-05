<?php
    require_once __DIR__."/../../database/dbhelper.php";
    if(empty($_GET))
    {
        header("Location: ../home_admin.php");
    }

    $id = $_GET['id'];

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_GET_PRODUCT_BY_ID);
        $stmt -> bindParam(':id', $id);
        $stmt -> execute();

        $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt -> fetchAll();

        $item = $data_list[0];
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;

    if (!empty($_POST))
    {
        $product_title = $_POST['product_title'];
        $product_description = $_POST['product_description'];
        $product_price = $_POST['product_price'];
        $product_content = $_POST['product_content'];
        $product_quantity = $_POST['product_quantity'];
        $product_thumbnail = $_POST['product_thumbnail'];
        $category_id = $_POST['category_id'];
        $brand_id = $_POST['brand_id'];

        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_UPDATE_PRODUCT);
            $stmt -> bindParam(':product_title', $product_title);        
            $stmt -> bindParam(':product_description', $product_description);        
            $stmt -> bindParam(':product_price', $product_price);        
            $stmt -> bindParam(':product_content', $product_content);        
            $stmt -> bindParam(':product_quantity', $product_quantity);        
            $stmt -> bindParam(':product_thumbnail', $product_thumbnail);        
            $stmt -> bindParam(':category_id', $category_id);        
            $stmt -> bindParam(':brand_id', $brand_id);
            $stmt -> bindParam(':id', $id);
            $stmt -> execute();

            header("Location: ../home_admin.php");
        }
        catch (PDOException $e)
        {
            echo $e -> getMessage();
        }

        $conn = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <?php require_once __DIR__."/../../admin/header.php";?>
    <h1>EDIT PRODUCT</h1>
    <a href="../home_admin.php"><button class="btn btn-primary">ADMIN PAGE</button></a>

    <form method="post">
        <div class="mb-3">
            <label for="product_title" class="form-label">Title</label>
            <input type="text" class="form-control" id="product_title" name="product_title" value=<?= $item['product_title'] ?>>
        </div>

        <div class="mb3">
            <label for="product_description" class="form-label">Description</label>
            <input type="text" class="form-control" id="product_description" name="product_description" value=<?= $item['product_description'] ?>>
        </div>

        <div class="mb3">
            <label for="product_price" class="form-label">Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" value=<?= $item['product_price'] ?>>
        </div>

        <div class="mb3">
            <label for="product_content" class="form-label">Content</label>
            <input type="text" class="form-control" id="product_content" name="product_content" value=<?= $item['product_content'] ?>>
        </div>

        <div class="mb3">
            <label for="product_quantity" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="product_quantity" name="product_quantity" value=<?= $item['product_quantity'] ?>>
        </div>

        <div class="mb3">
            <label for="product_thumbnail" class="form-label">Thumbnail</label>
            <input type="text" class="form-control" id="product_thumbnail" name="product_thumbnail" value=<?= $item['product_thumbnail'] ?>>
        </div>

        <div class="mb3">
            <label for="category_id" class="form-label">Category</label>
            <input type="text" class="form-control" id="category_id" name="category_id" value=<?= $item['category_id'] ?>>
        </div>

        <div class="mb3">
            <label for="brand_id" class="form-label">Brand</label>
            <input type="text" class="form-control" id="brand_id" name="brand_id" value=<?= $item['brand_id'] ?>>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>