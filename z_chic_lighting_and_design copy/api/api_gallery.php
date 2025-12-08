<?php
    try 
    {
        $conn = getConnection();
        for ($i = 1; $i <= 24 ; $i++)
        {
            for ($j = 1; $j <= 4; $j++)
            {
                $url = "assets/img/product/$i/$j.png";
                $stmt = $conn -> prepare(SQL_ADD_GALLERY);
                $stmt -> bindParam(":url", $url);
                $stmt -> execute();
            }
        }
    }
    catch (PDOException $e)
    {
        echo $e -> getMessage();
    }

    $conn = null;
?>