<?php 
    session_start();
    include("config.php");
    
    $now = date('Y-m-d H:i:s'); // ดึงเวลาจริง ๆ จาก server มาใช้
    $sql_insert = "INSERT INTO orders (order_date, fullname, email, telephone, grand_total) VALUES ('{$now}', '{$_POST['fullname']}', '{$_POST['email']}', '{$_POST['telephone']}', '{$_POST['grand_total']}' )";

    $query = mysqli_query($connection, $sql_insert);

    if($query) {
        $last_id = mysqli_insert_id($connection); // ดึง id ตัวล่าสุดจาก insert ใน database มา

        // ลูปดึงข้อมูลแล้ว insert ใส่ใน table order_details
        foreach($_SESSION["cart"] as $productId => $productQuantity) {
            
            $product_name = $_POST['product'][$productId]['name'];
            $price = $_POST['product'][$productId]['price'];
            $total = ($price * $productQuantity); // ยอดเงินทั้งหมดของสินค้า 1 อัน = ราคา x จำนวนสินค้า

            $sql_insert = "INSERT INTO order_details (order_id, product_id, product_name, price, quantity, total) 
                            VALUES ('{$last_id}', '{$productId}', '{$product_name}', '{$price}', '{$productQuantity}', '{$total}' )";
        }


        unset($_SESSION["cart"]); // clear ตะกร้าสินค้าทั้งหมดหลังจากจ่ายเงินแล้ว
        $_SESSION["message"] = "Check out success!!!";
        header("location: ". $BASE_URL . "/checkout-success.php");
    } else {
        $_SESSION["message"] = "Cannot Checout";
        header("location: " . $BASE_URL . "/checkout-success.php");
    }

?>