<?php 
    session_start();
    include("config.php");

    foreach($_SESSION["cart"] as $productId => $productQuantity) {
        $_SESSION["cart"][$productId] = $_POST["product"][$productId]["quantity"]; // เก็บ product เป็น array เพราะมีสินค้าหลายแบบ   
    }

    $_SESSION["message"] = "Cart updated success !";
    header("location: " . $BASE_URL. "/cart.php")
?>