<?php
    require_once("../database/dbhelper.php");
    
    // Seed base data
    require_once("api_category.php");
    require_once("api_brand.php");
    require_once("api_product.php");
    
    // Seed user data
    require_once("api_user_admin.php");
    require_once("api_user_user.php");
    
    // Seed transaction data
    require_once("api_cart.php");
    require_once("api_order.php");
    require_once("api_order_detail.php");
    require_once("api_review.php");
    require_once("api_feedback.php");
    
    echo "\n=== All fake data has been seeded successfully! ===\n";
?>