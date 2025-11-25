<?php
    require_once('db.php');
    if(empty($_GET))
    {
        header("Location: ../../admin.php");
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
        $name = $_POST['name'];
        $today = date("Y-m-d H-i-s");

        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_UPDATE_CATEGORY);
            $stmt -> bindParam(':name', $name);
            $stmt -> bindParam(':updated_at', $today);
            $stmt -> bindParam(':id', $id);
            $stmt -> execute();

            header("Location: ../../admin.php");
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
    <a href="../../admin.php"><button>ADMIN PAGE</button></a>

    <form method="post">
        <label for="name">Name: </label>
        <input type="text" name="name" value=<?=$item['name']?>>
        <button type="submit">Update Category</button>
    </form>

</body>
</html>