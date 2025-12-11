<?php
    require_once (__DIR__."/../../database/dbhelper.php");

    if (!isset($_GET["id"])) 
    {
        header("Location: brand.php");
        exit;
    }

    $brand_id = $_GET["id"];

    //connection to database and get brand by id
    try 
    {
        $conn = getConnection();
        $stmt = $conn->prepare(SQL_GET_BRAND_BY_ID);
        $stmt->bindParam(":brand_id", $brand_id);
        $stmt->execute();

        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $brand_list = $stmt->fetchall();

        if ($brand_list == null || count($brand_list) == 0) {
            header("Location: brand.php");
            exit;
        }
        else
        {
            $editing_brand = $banrd_list[0];
            if (!empty($_POST)) 
            {   
                //get new data
                $brand_name      = $_POST["brand_name"];
                $brand_thumbnail = $_POST["brand_thumbnail"];

                //connection to database and update brand
                try 
                {
                    $conn = getConnection();
                    $stmt = $conn->prepare(SQL_UPDATE_BRAND);

                    $stmt->bindParam(":brand_name", $brand_name);
                    $stmt->bindParam(":brand_thumbnail", $brand_thumbnail);
                    $stmt->bindParam(":brand_id", $brand_id);

                    $stmt->execute();

                    header("Location: brand.php");
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
    <title>Edit Brand</title>
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
            ["icon" => "bi-house-fill", "label" => "Admin", "url" => "../../admin/home_admin.php"],
            ["icon" => "bi-tags-fill", "label" => "Brand Management", "url" => "brand.php"],
            ["icon" => "bi-pencil-square", "label" => "Edit Brand"]
        ];
        require_once (__DIR__."/../../admin/admin_breadcrumb.php");
    ?>

    <!-- body -->
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-md-8">

                <h2 class="page-title">
                    <i class="bi bi-pencil-square me-2"></i>
                    Edit Brand
                </h2>

                <!-- edit form -->
                <form method="post" class="card-form">

                    <div class="mb-3">
                        <label class="form-label">Brand Name</label>
                        <input type="text" class="form-control" name="brand_name"
                               value="<?= htmlspecialchars($editing_brand["brand_name"]) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thumbnail URL</label>
                        <input type="text" class="form-control" name="brand_thumbnail"
                               value="<?= htmlspecialchars($editing_brand["brand_thumbnail"]) ?>">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Brand</button>
                    <a href="brand.php" class="btn btn-secondary ms-2">Cancel</a>

                </form>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
