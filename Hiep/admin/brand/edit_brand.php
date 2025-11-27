<?php
    require_once('../database/dbhelper.php');
    if(empty($_GET))
    {
        header("Location: ../home_admin.php");
    }

    $id = $_GET['id'];

    try
    {
        $conn = getConnection();
        $stmt = $conn -> prepare(SQL_GET_BRAND);
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
        $brand_name = $_POST['brand_name'];
        $brand_thumbnail = $_POST['brand_thumbnail'];

        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_UPDATE_BRAND);
            $stmt -> bindParam(':brand_name', $brand_name);
            $stmt -> bindParam(':brand_thumbnail', $brand_thumbnail);
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
    <title>Edit Brand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <h1>EDIT BRAND</h1>
    <a href="../home_admin.php"><button class="btn btn-primary">ADMIN PAGE</button></a>

    <form method="post">
        <div class="mb-3">
            <label for="brand_name" class="form-label">Name </label>
            <input type="text" class="form-control" name="brand_name" value=<?=$item['brand_name']?>>
        </div>

        <div class="mb-3">
            <label for="brand_thumbnail" class="form-label">Thumbnail </label>
            <input type="text" class="form-control" name="brand_thumbnail" value=<?=$item['brand_thumbnail']?>>
        </div>
        
        <button type="submit" class="btn btn-primary">Save Brand</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>