<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!isset($_GET["id"])) 
    {
        header("Location: product.php");
        exit;
    }

    $id = $_GET["id"];

    //connection to database and get product by id
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_PRODUCT_BY_ID);
        $stmt->bindParam(":product_id", $id);
        $stmt->execute();

        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            header("Location: product.php");
            exit;
        }
    }
    catch (PDOException $e) {
        die($e->getMessage());
    }

    $conn = null;

    if (!empty($_POST)) 
    {   
        //get new data
        $product_title       = $_POST["product_title"];
        $product_description = $_POST["product_description"];
        $product_price       = $_POST["product_price"];
        $product_content     = $_POST["product_content"];
        $product_quantity    = $_POST["product_quantity"];
        $product_thumbnail   = $_POST["product_thumbnail"];
        $category_id         = $_POST["category_id"];
        $brand_id            = $_POST["brand_id"];

        //connection to database and update product
        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_UPDATE_PRODUCT);

            $stmt->bindParam(":product_title", $product_title);
            $stmt->bindParam(":product_description", $product_description);
            $stmt->bindParam(":product_price", $product_price);
            $stmt->bindParam(":product_content", $product_content);
            $stmt->bindParam(":product_quantity", $product_quantity);
            $stmt->bindParam(":product_thumbnail", $product_thumbnail);
            $stmt->bindParam(":category_id", $category_id);
            $stmt->bindParam(":brand_id", $brand_id);
            $stmt->bindParam(":id", $id);

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
    <title>Edit Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../assets/css/modules.css">
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
            ["icon" => "bi-pencil-square", "label" => "Edit Product"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php");
    ?>

    <!-- body -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">

                <h2 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Product
                </h2>
                
                <!-- edit form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" class="form-control" name="product_title"
                               value="<?= htmlspecialchars($item["product_title"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="product_description"
                               value="<?= htmlspecialchars($item["product_description"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="product_price"
                               value="<?= htmlspecialchars($item["product_price"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Content</label>
                        <input type="text" class="form-control" name="product_content"
                               value="<?= htmlspecialchars($item["product_content"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="product_quantity"
                               value="<?= htmlspecialchars($item["product_quantity"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="text" class="form-control" name="product_thumbnail"
                               value="<?= htmlspecialchars($item["product_thumbnail"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category ID</label>
                        <input type="text" class="form-control" name="category_id"
                               value="<?= htmlspecialchars($item["category_id"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Brand ID</label>
                        <input type="text" class="form-control" name="brand_id"
                               value="<?= htmlspecialchars($item["brand_id"]) ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="product.php" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
