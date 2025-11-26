<?php
    require_once('db.php');

    if (!empty($_POST))
    {
        $name = $_POST['name'];
        $today = date("Y-m-d H-i-s");

        try
        {
            $conn = getConnection();
            $stmt = $conn -> prepare(SQL_ADD_CATEGORY);
            $stmt -> bindParam(':name', $name);
            $stmt -> bindParam(':created_at', $today);
            $stmt -> bindParam(':updated_at', $today);
            $stmt -> execute();

            header('Location: ../../admin.php');
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
    <title>Add Category</title>
</head>
<body>
    <h1>ADD CATEGORY</h1>
    <a href="../../admin.php"><button>ADMIN PAGE</button></a>

    <form method="post">
        <input type="text" name="name" placeholder="Name">
        <button type="submit">Add Category</button>
    </form>
</body>
</html>