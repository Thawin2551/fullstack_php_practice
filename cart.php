<?php 
    session_start();
    include("config.php");

    // ดึงข้อมูลมาจากฐานข้อมูล
    $productIds = [];
    // key = $cart, value = $cartQuantity

    foreach(($_SESSION["cart"] ?? []) as $cartId => $cartQuantity) {
        array_push($productIds, $cartId); // $productIds[] = $cartId
    }

    $ids = 0; // ถ้าไม่มีของในตะกร้าจะไม่เข้าเงื่อนไข count($productIds) > 0 และจะเอาค่า default = 0 มาใส่ใน sql_query_from_cart แทน
    if(count($productIds) > 0) { // เช็คว่ามีสินค้าในตะกร้ารึป่าว
        $ids = implode(', ', $productIds); // implode คือการทำให้ array ทั้งหมดย่อยออกมาแสดงผลเป็นแต่ละตัว
    }

    $sql_query_from_cart = "SELECT * FROM products WHERE id IN ($ids) ";

    // query หา data
    $query = mysqli_query($connection, $sql_query_from_cart);
    $num_rows = mysqli_num_rows($query);
    
?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link href="<?php echo $BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- font and icon -->
    <link href="<?php echo $BASE_URL?>/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $BASE_URL?>/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $BASE_URL?>/fontawesome/css/solid.min.css" rel="stylesheet">
</head>
<body class="bg-body-teritary">
    <?php include("include/menu.php") ?>
    
    <div class="container" style="margin-top: 30px;">

    <!-- Product Add cart Message Alert -->
        <?php if (!empty($_SESSION["message"])) :?>
            <div class="alert alert-success  alert-dismissible fade show" role="alert">
                <?php echo $_SESSION["message"]; ?>
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
            <?php unset($_SESSION["message"])?>
        <?php endif ?>
        
        <!-- Product List Describe -->
        <h4>Cart</h4>
            <div class="row">
               <div class="col=12">
                    <form action="<?php echo $BASE_URL; ?>/cart-update.php" method="post">
                        <!-- table -->
                        <?php include('cart-table.php') ?> 
                    </form>
               </div> 
            </div>
        </div>    

        
    </div>
    <script src="<?php echo $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>