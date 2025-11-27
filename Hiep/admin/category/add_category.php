<?php
    require_once("../database/dbhelper.php");

    if(!empty($_POST))
    {
        $category_name = $_POST['category_name'];
        $category_thumbnail = $_POST['category_thumbnail'];

        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_ADD_CATEGORY);
            $stmt -> bindParam(':category_name', $category_name);        
            $stmt -> bindParam(':category_thumbnail', $category_thumbnail);        
            $stmt -> execute();

            header('Location: ../home_admin.php');
        }
        catch (PDOException $e)
        {
            $e -> getMessage();
        }

        $conn = null;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cateogry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

</head>
<body>
    <h1>ADD NEW CATEGORY</h1>
    <a href="../home_admin.php"><button>ADMIN PAGE</button></a>

    <form method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="category_name">
        </div>

        <div class="mb3">
            <label for="thumbnail" class="form-label">Thumbnail</label>
            <input type="text" class="form-control" id="thumbnail" name="category_thumbnail">
        </div>

        <button type="submit" class="btn btn-primary">Add New Category</button>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>