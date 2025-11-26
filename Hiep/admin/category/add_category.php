<?php
    require_once("../database/dbhelper.php");

    if(!empty($_POST))
    {
        $category_name = $_POST['name'];
        $category_thumbnail = $_POST['thumbnail'];

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
</head>
<body>
    <h1>ADD CATEGORY</h1>
    <a href="../home_admin.php"><button>ADMIN PAGE</button></a>

    <form method="post">
        <label for="name">Category Name</label>
        <input type="text" id="name" name="name" placeholder="Name">

        <label for="thumbnail">Category Thumbnail</label>
        <input type="text" id="thumbnail" name="thumbnail" placeholder="Thumbnail">

        <button type="submit">Add Category</button>
    </form>
</body>
</html>