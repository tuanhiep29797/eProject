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
        $stmt = $conn -> prepare(SQL_GET_CATEGORY);
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
</head>
<body>
    <h1>EDIT CATEGORY</h1>
    <a href="../home_admin.php"><button>ADMIN PAGE</button></a>

    <form method="post">
        <label for="category_name">Category Name </label>
        <input type="text" name="category_name" value=<?=$item['category_name']?>>

        <label for="category_thumbnail">Category Thumbnail </label>
        <input type="text" name="category_thumbnail" value=<?=$item['category_thumbnail']?>>
        
        <button type="submit">Update Category</button>
    </form>

</body>
</html>