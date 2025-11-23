<?php 
    session_start();
    include "config.php";

    if(!empty($_GET["id"])) {
        $sql_query_id = "SELECT * FROM products WHERE id ='{$_POST['id']}'";  
        $query_product = mysqli_query($connection, $sql_query_id);
        $result = mysqli_fetch_assoc($query_product);

        @unlink('upload_image' . $result["profile_image"]);

        $sql_delete = "DELETE FROM products WHERE id = '{$_GET['id']}'";
        $query_delete = mysqli_query($connection, $sql_delete);

        mysqli_close($connection);
        
        if($query_delete) {
            $_SESSION["message"] = "Product has been Deleted !!!";
            header("location: " . $BASE_URL . "/index.php"); 
        } else {
            $_SESSION["message"] = "Product Cannot Deleted";
            header("location:" . $BASE_URL . "/index.php");
        }
    }
?>
