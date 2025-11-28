<?php
    require_once("../database/dbhelper.php");
    
    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_GET_PRODUCT);
        $stmt -> execute();

        $result = $stmt -> setFetchMode(PDO::FETCH_ASSOC);
        $data_list = $stmt -> fetchAll();
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brand Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
</head>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>Product Manager</h1>
            </div>
            <div class="col">
                <button class="btn btn-success">
                    <i class="bi bi-plus-circle"></i>
                      Add New Product
                </button>
            </div>
        </div>
    </div>

    <table class="table table-borderless">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Content</th>
                <th scope="col">Quantity</th>
                <th scope="col">Thumbnail</th>
                <th scope="col">Category ID</th>
                <th scope="col">Brand ID</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($datalist as $item):?>
                <tr>
                    <th scope="row"><?= $item['product_id'] ?>?></td>
                    <td><?= $item['product_title'] ?>?></td>
                    <td><?= $item['product_description'] ?>?></td>
                    <td><?= $item['product_price'] ?>?></td>
                    <td><?= $item['product_content'] ?>?></td>
                    <td><?= $item['product_quantity'] ?>?></td>
                    <td><?= $item['product_thumbnail'] ?>?></td>
                    <td><?= $item['category_id'] ?>?></td>
                    <td><?= $item['brand_id'] ?>?></td>
                    <td>
                        <div class="d-flex gap-2 mb-3">
                            <a href="edit_product.php?id=<?= $item['product_id'] ?>">
                                <button class="btn btn-primary">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                            </a>
                            <a href="delete_product.php?id=<?= $item['product_id'] ?>">
                                <button class="btn btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </a>
                        </div>                        
                    </td>
                </tr>
            <?php endforeach;?>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>