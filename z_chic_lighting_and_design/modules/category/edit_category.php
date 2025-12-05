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
        $stmt = $conn -> prepare(SQL_GET_CATEGORY_BY_ID);
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
        $category_name = $_POST['category_name'];
        $category_thumbnail = $_POST['category_thumbnail'];

        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_UPDATE_CATEGORY);
            $stmt -> bindParam(':category_name', $category_name);
            $stmt -> bindParam(':category_thumbnail', $category_thumbnail);
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
    <h1>EDIT CATEGORY</h1>
    <a href="../home_admin.php"><button class="btn btn-primary">ADMIN PAGE</button></a>

    <form method="post">
        <div class="mb-3">
            <label for="category_name" class="form-label">Name </label>
            <input type="text" class="form-control" name="category_name" value=<?=$item['category_name']?>>
        </div>

        <div class="mb-3">
            <label for="category_thumbnail" class="form-label">Thumbnail </label>
            <input type="text" class="form-control" name="category_thumbnail" value=<?=$item['category_thumbnail']?>>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Category</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>