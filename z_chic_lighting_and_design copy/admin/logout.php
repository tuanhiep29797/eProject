<?php
    session_start();
    session_destroy();
    header("Location: ../pages/home_page.php");
    exit();
?>