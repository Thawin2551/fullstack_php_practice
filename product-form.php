<?php 
    session_start();
    include("config.php");

    $product_name = trim($_POST["product_name"]);
    $price = $_POST["price"] ? : 0;
    $detail = trim($_POST["detail"]);
    $image_name = $_FILES["profile_image"]["name"]; // ชื่อรูปภาพ

    $image_temporary = $_FILES["profile_image"]["tmp_name"];
    $folder = "upload_image/";
    $image_location = $folder . $image_name; // upload_image/sdad.png

    $sql_insert = "INSERT INTO products (product_name, price, profile_image, detail) VALUES ('$product_name', '$price', '$image_name', '$detail')";
    $sql_update = "UPDATE products SET product_name='{$product_name}', price='{$price}', profile_image='{$image_name}', detail='{$detail}' WHERE id='{$_POST['id']}'";

    if(empty($_POST["id"])) {
        $query = mysqli_query ($connection, $sql_insert); // การ create ข้อมูล
    } else {
        // เงื่อนไขเวลาเพิ่มรูปกับไม่ได้เพิ่มรูป
        $sql_query_id = "SELECT * FROM products WHERE id ='{$_POST['id']}'";  
        $query_product = mysqli_query($connection, $sql_query_id);
        $result = mysqli_fetch_assoc($query_product);   
        
        if(empty($image_name)) {
            $image_name = $result["profile_image"]; // ถ้าเป็นค่าว่างหรือไม่มีการเพิ่มรูปภาพเข้าไปใหม่ให้ดึงจากฐานข้อมูลมาใช้
        } else {
            @unlink($folder . $result["profile_image"]); // $folder . $result['profile_image'] คือ upload_image/ชื่อรูปภาพ.นามสกุลไฟล์
        }
        
        $query = mysqli_query($connection, $sql_update);
    }

    mysqli_close($connection);

    if($query == true) { // query เจอมั้ย ? true or false
        move_uploaded_file($image_temporary, $image_location); // ย้ายรูปจากที่เก็บไว้ชั่วคราวไปอยู่ในโฟลเดอร์
        
        $_SESSION["message"] = "Uploaded Product Success ! ! !";
        header("location: " . $BASE_URL . "/index.php");
    } else {
        $_SESSION["message"] = "Failed Uploaded";   
        header("location: ". $BASE_URL . "/index.php");
    }

?>