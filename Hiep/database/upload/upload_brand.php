<?php
    $brands = 
    [
        ["Philips", "assets/img/brand/philips/brand_philips.png"],
        ["Panasonic", "assets/img/brand/panasonic/brand_panasonic.png"],
        ["Hunter Fans", "assets/img/brand/hunter_fans/brand_hunter_fans.png"],
        ["Ledyi", "assets/img/brand/ledyi/brand_ledyi.php"],
        ["Art Decor", "assets/img/brand/art_decor/brand_art_decor.php"],
        ["Xiaomi","assets/img/brand/xiaomi/brand_xiaomi.php"]
    ];
        try 
        {
            $conn = getConnection();
            foreach ($brands as $item)
            {
                $brand_name = $item[0];
                $brand_thumbnail = $item[1];

                $stmt = $conn -> prepare(SQL_ADD_BRAND);
                $stmt -> bindParam(":brand_name", $brand_name);
                $stmt -> bindParam(":brand_thumbnail", $brand_thumbnail);
                $stmt -> execute();
            }
        }
        catch (PDOException $e)
        {
            echo $e -> getMessage();
        }

        $conn = null;
?>