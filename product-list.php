<?php 
    session_start();
    include("config.php");

    // ดึงข้อมูลมาจากฐานข้อมูล
    $sql = "SELECT * FROM products";

    // query หา data
    $query = mysqli_query($connection, $sql);
    $num_rows = mysqli_num_rows($query);
    
     if(!isset($_SESSION["email"])) {
        header("location: auth-page.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
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
        <h4>Product-List</h4>

        <div class="row d-flex justify-content-center">
            <?php if ($num_rows > 0) : ?>
                <?php while($product = mysqli_fetch_assoc($query)): ?>
                    <div class="col-3 mb-3">
                        <div class="card" style="width: 18rem;">
                            <?php if(!empty($product["profile_image"])): ?>
                                <img src="<?php echo $BASE_URL; ?>/upload_image/<?php echo $product["profile_image"]?>" class="card-img-top" alt="Product Image" width="100">
                            <?php else :?>
                                <img src="<?php echo $BASE_URL;?>/assets/images/no-image.jpg" alt="Product Image" class"card-img-top" width="100">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title mb-0"><?php echo $product["product_name"] ?></h5>
                                <p class="card-text text-success fw-semibold"><?php echo $product["price"] ?> $USD</p>
                                <h6 class="card-text text-muted">details: <?php echo nl2br($product["detail"]) ?></h6>
                                <a href="<?php echo $BASE_URL; ?>/cart-add.php?id=<?php echo $product["id"]; ?>" class="btn btn-success w-100 mt-3">
                                    <i class="fa-solid fa-cart-shopping mx-1"></i>Add cart
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <h4 class="text-danger">ไม่มีรายการสินค้า</h4>
                </div>
            <?php endif; ?>

        </div>
        </div>    

        
    </div>
    <script src="<?php echo $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>