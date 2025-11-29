<?php
    $categories = 
    [
        ["Ceiling Lights", "assets/img/category/ceciling_lights/category_ceiling_light_1.png"],
        ["Wall Lights", "assets/img/category/wall_lights/category_wall_lights_1.png"],
        ["Outdoor Lights", "assets/img/category/outdoor_lights/category_outdoor_lights_1.png"],
        ["Fans", "assets/img/category/fans/category_fans_1.png"],
        ["Home Accents", "assets/img/category/home_accents/category_home_accents_1.png"],
        ["LED - Spotlights","assets/img/category/led_spotlights/category_led_spotlights_1.png"],
        ["LED - Decorative Lights","assets/img/category/led_decorative_lights/category_led_decorative_lights_1.png"],
        ["LED - Smart Lights","assets/img/category/led_smart_lights/category_led_smart_lights_1.png"]
    ];

        try 
        {
            $conn = getConnection();
            foreach ($categories as $item)
            {
                $category_name = $item[0];
                $category_thumbnail = $item[1];

                $stmt = $conn -> prepare(SQL_ADD_CATEGORY);
                $stmt -> bindParam(':category_name', $category_name);        
                $stmt -> bindParam(':category_thumbnail', $category_thumbnail);        
                $stmt -> execute();
            }
        }
        catch (PDOException $e)
        {
            echo $e -> getMessage();
        }

        $conn = null;
?>