<?php
    require_once __DIR__."/../../database/dbhelper.php";
    try
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_CATEGORY);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $category_list = $stmt->fetchall();

        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_BRAND);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $brand_list = $stmt->fetchall();
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    if (!empty($_POST)) 
    {
        // get data from form
        $product_title       = $_POST["product_title"];
        $product_description = $_POST["product_description"];
        $product_price       = $_POST["product_price"];
        $product_content     = $_POST["product_content"];
        $product_quantity    = $_POST["product_quantity"];
        $product_thumbnail   = $_POST["product_thumbnail"];
        $category_id         = $_POST["category_id"];
        $brand_id            = $_POST["brand_id"];

        //connection to database and add product
        try {

            $conn = getConnection();
            $stmt = $conn->prepare(SQL_ADD_PRODUCT);

            $stmt->bindParam(":product_title", $product_title);
            $stmt->bindParam(":product_description", $product_description);
            $stmt->bindParam(":product_price", $product_price);
            $stmt->bindParam(":product_content", $product_content);
            $stmt->bindParam(":product_quantity", $product_quantity);
            $stmt->bindParam(":product_thumbnail", $product_thumbnail);
            $stmt->bindParam(":category_id", $category_id);
            $stmt->bindParam(":brand_id", $brand_id);

            $stmt->execute();

            header("Location: product.php");
            exit;
        }
        catch (PDOException $e) 
        {
            echo $e->getMessage();
        }

        $conn = null;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/modules.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
</head>

<body>

    <!-- include header -->
    <?php 
        require_once (__DIR__."/../../admin/admin_header.php"); 
        ?>

    <!-- breadcrumb -->
    <?php
        $breadcrumb = [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-boxes", "label" => "Product Management", "url" => "product.php"],
            ["icon" => "bi-plus-circle", "label" => "Add Product"]
        ];
        require_once __DIR__."/../../admin/admin_breadcrumb.php";
    ?>

    <!-- body -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">

                <h2 class="page-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add New Product
                </h2>
                
                <!-- add form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">Product Title</label>
                        <input type="text" class="form-control" name="product_title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="product_description"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="product_price" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <textarea class="form-control" name="product_content"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="product_quantity" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thumbnail URL</label>
                        <input type="text" class="form-control" name="product_thumbnail">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select class="form-select" name="category_id">
                            <option value="">--Choose Category--</option>
                            <?php foreach($category_list as $item): ?>
                                <option value="<?= $item["category_id"]?>"?><?= htmlspecialchars($item["category_name"]) ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Brand</label>
                        <select class="form-select" name="brand_id">
                            <option value="">--Choose Brand--</option>
                            <?php foreach($brand_list as $item): ?>
                                <option value="<?= $item["brand_id"]?>"><?= htmlspecialchars($item["brand_name"]) ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Product</button>
                    <a href="product.php" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
