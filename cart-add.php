<?php 
    session_start();
    include("config.php");
    
    if(!empty($_GET["id"])) {
        if(empty($_SESSION["cart"][$_GET["id"]])) {
            $_SESSION["cart"][$_GET["id"]] = 1; // ถ้ายังไม่มีสินค้าเลยจะในตะกร้าเก็บค่าไว้ใน array เป็น 1 ก่อน
        } else {
            $_SESSION["cart"][$_GET["id"]] = $_SESSION["cart"][$_GET["id"]] + 1; // แต่ถ้ามีแล้วก็จะให้ + 1 ก่อนแล้วค่อยแสดงสถานะของตะกร้า
        }
        
        $_SESSION["message"] = 'Cart add success';
    }

    header("location:" . $BASE_URL . "/product-list.php");
?>