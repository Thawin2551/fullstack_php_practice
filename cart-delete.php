<?php 
    session_start();
    include("config.php");

    if (!empty($_GET["id"])) {
        unset($_SESSION["cart"][$_GET["id"]]); // ลบตัวแปร cart ที่ id นั้น ๆ ที่เราส่งไป
        $_SESSION["message"] = "Deleted items in cart success";
    }
    
    header("location: " . $BASE_URL . "/cart.php");
?>