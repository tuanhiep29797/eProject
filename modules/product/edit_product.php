<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!isset($_GET["id"])) 
    {
        header("Location:" . BASE_URL . "admin/product");
        exit;
    }
    
    $product_id = $_GET["id"];

    //connection to database and get product by id
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_PRODUCT_BY_ID);
        $stmt->bindParam(":product_id", $product_id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $product_list = $stmt->fetch();
        
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_CATEGORY);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $category_list = $stmt->fetchAll();

        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_BRAND);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $brand_list = $stmt->fetchAll();

        if ($product_list == null || count($product_list) == 0) 
        {
            header("Location:" . BASE_URL . "admin/product");
            exit;
        }
        else
        {
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
                    $stmt->bindParam(":product_id", $product_id);

                    $stmt->execute();

                    header("Location:" . BASE_URL . "admin/product");
                    exit;
                }
                catch (PDOException $e) 
                {
                    echo $e->getMessage();
                }
            }
        }
    }
    catch (PDOException $e) 
    {
        echo $e->getMessage();
    }

    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modules.css?v=<?= time() ?>">
    <link rel="website icon" type="png" href="<?= BASE_URL ?>assets/img/home/logo.png?v=<?= time() ?>">
    <script src="<?= BASE_URL ?>modules/js/tinymce/tinymce.min.js"></script>
</head>

<body>

    <!-- include header -->
    <?php 
        require_once (__DIR__."/../../admin/admin_header.php"); 
    ?>

    <!-- breadcrumb -->
    <?php
        $breadcrumb = [
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => BASE_URL . "admin/dashboard"],
            ["icon" => "bi-boxes", "label" => "Product Management", "url" => BASE_URL . "admin/product"],
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
                               value="<?= htmlspecialchars($product_list["product_title"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" name="product_description"
                               value="<?= htmlspecialchars($product_list["product_description"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" name="product_price"
                               value="<?= htmlspecialchars($product_list["product_price"]) ?>">
                    </div>

                        <label class="form-label">Content</label>
                        <textarea 
                            id="product_content"
                            name="product_content"
                            class="form-control"
                            rows="10"
                        ><?= $product_list["product_content"] ?></textarea>

                    <div class="mb-3">
                        <label class="form-label">Quantity</label>
                        <input type="number" class="form-control" name="product_quantity"
                               value="<?= htmlspecialchars($product_list["product_quantity"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thumbnail</label>
                        <input type="text" class="form-control" name="product_thumbnail"
                               value="<?= htmlspecialchars($product_list["product_thumbnail"]) ?>">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category ID</label>
                        <select class="form-select" name="category_id">
                            <?php foreach($category_list as $item): ?>
                                <option value="<?= $item["category_id"]?>" <?= $product_list["category_id"] == $item["category_id"] ? "selected" : "" ?>><?= htmlspecialchars($item["category_name"]) ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Brand ID</label>
                        <select class="form-select" name="brand_id">
                            <?php foreach($brand_list as $item): ?>
                                <option value="<?= $item["brand_id"]?>" <?= $product_list["brand_id"] == $item["brand_id"] ? "selected" : "" ?>><?= htmlspecialchars($item["brand_name"]) ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Product</button>
                    <a href="<?= BASE_URL ?>admin/product" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>
    <script>
    tinymce.init({
        selector: '#product_content',
        license_key: 'gpl',
        height: 400,
        menubar: false,
        plugins: 'lists link image table code',
        toolbar: `
            undo redo |
            bold italic underline |
            alignleft aligncenter alignright |
            bullist numlist |
            link image table |
            code
        `,
        content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>