<?php
    $products =
    [
        ["Philips Luxury Crystal Chandelier", "Elegant design for living room, sparkling light.", 5500000.00, 10, "assets/img/product/1/1.png", 1, 1, "<table border=\"1\"><tr><td>Power:</td><td>60W</td></tr><tr><td>Material:</td><td>K9 Crystal</td></tr></table>"],

        ["ArtDecor Classic Gold Wall Lamp", "European style, suitable for corridors and bedrooms.", 850000.00, 25, "assets/img/product/2/1.png", 2, 5, "<p>Socket: E27. Material: Solid Cast Brass. IP20.</p>"],

        ["Panasonic IP65 Garden Post Light", "Waterproof, durable cast aluminum shell.", 1200000.00, 15, "assets/img/product/3/1.png", 3, 2, "<table border=\"1\"><tr><td>Power</td><td>12W LED</td></tr><tr><td>IP Rating</td><td>IP65</td></tr></table>"],

        ["Hunter Maribel Ceiling Fan Light", "Combines cooling fan and lighting, quiet motor.", 4800000.00, 8, "assets/img/product/4/1.png", 4, 3, "<p>AirMax motor. 5 composite wood blades. Integrated LED.</p>"],

        ["Nordic Corner Floor Lamp", "Minimalist design, artistic curved body.", 1950000.00, 12, "assets/img/product/5/1.png", 5, 5, "<p>Height: 1m6 - 1m8. Material: Powder coated steel.</p>"],

        ["Panasonic Magnetic Track Light", "Track light, 360 degree flexible angle.", 450000.00, 50, "assets/img/product/6/1.png", 6, 2, "<table border=\"1\"><tr><td>Type</td><td>Spotlight</td></tr><tr><td>CRI</td><td>>90</td></tr></table>"],

        ["Rang Dong LED Neon Flex 5M", "Flexible, easy to bend for lettering.", 250000.00, 100, "assets/img/product/7.png", 7, 4, "<p>Safe 12V voltage. Vibrant colors. Gaming room decor.</p>"],

        ["Philips Hue Ambiance Bulb", "Control 16 million colors via phone.", 1650000.00, 20, "assets/img/product/8/1.png", 8, 1, "<ul><li>Connection: Zigbee/Bluetooth</li><li>Compat: Apple HomeKit, Alexa</li></ul>"],

        ["Modern Minimalist Ceiling LED", "Ultra-thin design, perfect for low ceilings.", 1250000.00, 30, "assets/img/product/9/1.png", 1, 2, "<p>Power: 36W. Diameter: 50cm. 3 Color Modes.</p>"],

        ["Industrial Vintage Pendant", "Black iron cage design, retro style.", 450000.00, 45, "assets/img/product/10/1.png", 1, 5, "<p>Material: Iron. Socket: E27. Cable length: 1m adjustable.</p>"],

        ["Outdoor Up-Down Wall Sconce", "Modern waterproof light for exterior walls.", 950000.00, 20, "assets/img/product/11/1.png", 2, 1, "<p>IP65 Waterproof. 2x5W LED. Aluminum body.</p>"],

        ["Reading Bedside Wall Lamp", "Focused reading light with USB port.", 750000.00, 40, "assets/img/product/12/1.png", 2, 4, "<p>Flexible goose-neck. Built-in USB charger.</p>"],

        ["Solar Pathway Light Set (4pcs)", "Eco-friendly solar garden lights.", 680000.00, 60, "assets/img/product/13/1.png", 3, 4, "<p>Auto on/off. No wiring needed. Stainless steel.</p>"],

        ["High Power Floodlight 100W", "Security light for large backyards.", 1500000.00, 15, "assets/img/product/14/1.png", 3, 2, "<p>Brightness: 9000lm. IP66 rating. Cool White.</p>"],

        ["Wooden Blade Ceiling Fan", "Luxury wood finish, silent operation.", 5500000.00, 5, "assets/img/product/15/1.png", 4, 3, "<p>Real wood blades. DC Motor (Energy saving).</p>"],

        ["Compact Bedroom Fan Light", "Small diameter fan for smaller rooms.", 2200000.00, 10, "assets/img/product/16/1.png", 4, 2, "<p>Size: 36 inch. Integrated LED light. Remote.</p>"],

        ["Ceramic Table Lamp Blue", "Handmade ceramic body, fabric shade.", 1200000.00, 12, "assets/img/product/17/1.png", 5, 5, "<p>Height: 45cm. Perfect for living room side tables.</p>"],

        ["Bamboo Tripod Floor Lamp", "Natural bamboo legs, boho style.", 1800000.00, 8, "assets/img/product/18/1.png", 5, 5, "<p>Sustainable material. Warm ambient lighting.</p>"],

        ["Recessed COB Downlight 10W", "Anti-glare deep recessed spotlight.", 180000.00, 100, "assets/img/product/19/1.png", 6, 1, "<p>Beam angle: 36 deg. Cut-out: 90mm.</p>"],

        ["Surface Mounted Tube Light", "Cylindrical spotlight, no hole cutting.", 250000.00, 50, "assets/img/product/20/1.png", 6, 4, "<p>Black/White body housing. Easy installation.</p>"],

        ["RGB Smart Strip Light 10M", "App controlled color changing strip.", 350000.00, 80, "assets/img/product/21.png", 7, 4, "<p>Music sync mode. Wifi connection. 16 million colors.</p>"],

        ["Vintage Edison Bulb Set", "Decorative filament bulbs (Pack of 3).", 200000.00, 40, "assets/img/product/22/1.png", 7, 5, "<p>Warm amber glow. ST64 shape. E27 base.</p>"],

        ["Smart Wifi Ceiling Light", "Adjust brightness/color via phone.", 950000.00, 25, "assets/img/product/23/1.png", 8, 6, "<p>Works with Google Assistant/Alexa. Moonlight mode.</p>"],

        ["Ambient Play Bar Light", "Backlight for TV and Gaming setup.", 1400000.00, 15, "assets/img/product/24/1.png", 8, 1, "<p>Syncs with screen content. Stand or stick to TV back.</p>"]
    ];

    try 
        {
            $conn = getConnection();
            foreach ($products as $item)
            {
                $product_title = $item[0];
                $product_description = $item[1];
                $product_price = $item[2];
                $product_content = $item[3];
                $product_quantity = $item[4];
                $product_thumbnail = $item[7];
                $category_id = $item[5];
                $brand_id = $item[6];

                $stmt = $conn -> prepare(SQL_ADD_PRODUCT);
                $stmt -> bindParam(':product_title', $product_title);        
                $stmt -> bindParam(':product_description', $product_description);        
                $stmt -> bindParam(':product_price', $product_price);        
                $stmt -> bindParam(':product_content', $product_content);        
                $stmt -> bindParam(':product_quantity', $product_quantity);        
                $stmt -> bindParam(':product_thumbnail', $product_thumbnail);        
                $stmt -> bindParam(':category_id', $category_id);        
                $stmt -> bindParam(':brand_id', $brand_id);        
                $stmt -> execute();
            }
        }
        catch (PDOException $e)
        {
            echo $e -> getMessage();
        }

        $conn = null;
?>