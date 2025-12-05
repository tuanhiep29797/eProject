<?php
session_start();
require_once('./database/dbhelper.php'); 
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery - GS LIGHTING</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Calistoga&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./css/gallery.css"> 


</head>
<body>

    <div class="banner">
        <div class="banner-content">
            <h1>Gallery</h1>
            <div class="banner-breadcrumb">
                <a href="index.php">Home</a>
                <i class="bi bi-chevron-right"></i>
                <span class="active">Gallery</span>
            </div>
        </div>
    </div>

    <div class="gallery-section">
        
        <div class="container">
            <?php
            $characters1 = [
                ['name' => 'Living Room', 'img' => 'https://images.unsplash.com/photo-1567767292278-a4f21aa2d36e?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Modern Lamp', 'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ0MkLVctCofrGdJwr8iXxjQMcwp7xLSAZ-Gw&s'],
                ['name' => 'Cozy Sofa',   'img' => 'https://images.unsplash.com/photo-1493663284031-b7e3aefcae8e?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Wall Art',    'img' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQbsjZbCxrz9V9vWvC_YY3R0XvLLUQESP0l4Q&s'],
                ['name' => 'Minimalist',  'img' => 'https://images.unsplash.com/photo-1484101403633-562f891dc89a?q=80&w=600&auto=format&fit=crop']
            ];

            foreach ($characters1 as $char) {
                echo '<div class="card">';
                echo '   <img src="' . htmlspecialchars($char['img']) . '" alt="' . htmlspecialchars($char['name']) . '">';
                echo '   <div class="card-title">' . htmlspecialchars($char['name']) . '</div>';
                echo '</div>';
            }
            ?>
        </div> 
        <div class="container">
            <?php
            $characters2 = [
                ['name' => 'Bedroom',    'img' => 'https://images.unsplash.com/photo-1616594039964-40891a90b81f?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Kitchen',    'img' => 'https://images.unsplash.com/photo-1556911220-e15b29be8c8f?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Office',     'img' => 'https://images.unsplash.com/photo-1524758631624-e2822e304c36?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Garden',     'img' => 'https://images.unsplash.com/photo-1585320806297-9794b3e4eeae?q=80&w=600&auto=format&fit=crop'],
                ['name' => 'Bathroom',   'img' => 'https://images.unsplash.com/photo-1584622050111-993a426fbf0a?q=80&w=600&auto=format&fit=crop']
            ];

            foreach ($characters2 as $char) {
                echo '<div class="card">';
                echo '   <img src="' . htmlspecialchars($char['img']) . '" alt="' . htmlspecialchars($char['name']) . '">';
                echo '   <div class="card-title">' . htmlspecialchars($char['name']) . '</div>';
                echo '</div>';
            }
            ?>
        </div>
        </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>