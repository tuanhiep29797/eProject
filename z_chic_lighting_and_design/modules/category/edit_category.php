<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!isset($_GET["id"])) 
    {
        header("Location: category.php");
        exit;
    }

    $category_id = $_GET["id"];

    //connection to database and get category by id
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_CATEGORY_BY_ID);
        $stmt->bindParam(":category_id", $category_id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $category_list = $stmt->fetchall();

        if ($category_list == null || count($category_list) == 0) 
        {
            header("Location: brand.php");
            exit;
        }
        else
        {
            $item = $category_list[0];
            if (!empty($_POST)) 
            {   
                //get new data
                $category_name      = $_POST["category_name"];
                $category_thumbnail = $_POST["category_thumbnail"];

                //connection to database and update brand
                try 
                {
                    $conn = getConnection();
                    $stmt = $conn->prepare(SQL_UPDATE_BRAND);

                    $stmt->bindParam(":category_name", $category_name);
                    $stmt->bindParam(":category_thumbnail", $category_thumbnail);
                    $stmt->bindParam(":category_id", $category_id);

                    $stmt->execute();

                    header("Location: category.php");
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
    <title>Edit Category</title>

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
            ["icon" => "bi-house-fill",  "label" => "Admin",              "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-archive",     "label" => "Category Management","url" => "category.php"],
            ["icon" => "bi-pencil-square","label" => "Edit Category"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php");
    ?>

    <!-- body -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-8">

                <h2 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Category
                </h2>

                <!-- edit form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name"
                               value="<?= htmlspecialchars($item["category_name"]) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thumbnail URL</label>
                        <input type="text" class="form-control" name="category_thumbnail"
                               value="<?= htmlspecialchars($item["category_thumbnail"]) ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Category</button>
                    <a href="category.php" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
