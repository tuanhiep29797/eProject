<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if(!empty($_POST))
    {   
        // get data from form
        $category_name = $_POST['category_name'];
        $category_thumbnail = $_POST['category_thumbnail'];


        //connection to database and add new category
        try 
        {
            $conn = getConnection();
            $stmt = $conn->prepare(SQL_ADD_CATEGORY);

            $stmt->bindParam(':category_name', $category_name);
            $stmt->bindParam(':category_thumbnail', $category_thumbnail);

            $stmt->execute();

            header("Location:" . BASE_URL . "admin/category");
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
    <title>Add Category</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/modules.css?v=<?= time() ?>">
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
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => BASE_URL . "admin/bashboard"],
            ["icon" => "bi-archive", "label" => "Category Management", "url" => BASE_URL . "admin/category"],
            ["icon" => "bi-plus-circle", "label" => "Add Category"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php");
    ?>

    <!-- body -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10">

                <h2 class="page-title">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add New Category
                </h2>

                <!-- add form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thumbnail URL</label>
                        <input type="text" class="form-control" name="category_thumbnail">
                    </div>

                    <button type="submit" class="btn btn-primary">Add Category</button>
                    <a href="<?= BASE_URL ?>admin/category" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
