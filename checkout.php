<?php 
     session_start();
    include("config.php");

    $productIds = [];

    foreach(($_SESSION["cart"] ?? []) as $cartId => $cartQuantity) {
        array_push($productIds, $cartId);
    }

    $ids = 0;
    if(count($productIds) > 0) {
        $ids = implode(', ', $productIds);
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
    <title>Checkout</title>

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
        <h4>Checkout</h4>
        <form action="<?php echo $BASE_URL;?>/checkout-form.php" method="post">
            <div class="row g-5">
                <div class="col-md-6 col-lg-7">
                    <div class="row g-3">
                        
                        <!-- Fullname -->
                        <div class="col-sm-12">
                            <label class="form-label">Fullname</label>
                            <input type="text" name="fullname" class="form-control" placeholder="" value="" required>
                        </div>
                        <!-- Telephone -->
                        <div class="col-sm-6">
                            <label class="form-label">Telephone</label>
                            <input type="text" name="telephone" class="form-control" placeholder="" value="" required>
                        </div>
                        <!-- Email -->
                        <div class="col-sm-6">
                            <label class="form-label">Email</label>
                            <input type="text" name="email" class="form-control" placeholder="" value="" required>
                        </div>

                    </div>
                    <hr class="my-4">
                    <div class="text-end">
                        <a href="<?php echo $BASE_URL?>/product-list.php" class="btn btn-secondary w-50" role="button">Back to Shop</a>
                        <button class=" my-2 btn btn-success w-50">Continue Checkout </button>
                    </div>
                 
                </div>
                <div class="col-md-6 col-lg-5 order-md-last">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-primary">Your Cart</span>
                        <span class="badge bg-primary rounded-pill mx-1"><?php echo $num_rows ?></span>
                    </h4>
                    <?php if($num_rows > 0): ?>
                    <!-- แสดงสินค้าในตะกร้าก่อนจะกดจ่ายเงิน -->
                    <ul class="list-group mb-3">
                        <?php $grand_total = 0; ?>
                        <?php while($product = mysqli_fetch_assoc($query)): ?>
                             <!-- คำนวณรายการอาหารแต่ละอันก่อนเข้าลูปโดยใช้ตัวแปร $subtotal -->
                            <?php $subtotal = $_SESSION["cart"][$product["id"]] * $product["price"] ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    <h6 class="my-0"><?php echo $product['product_name']; ?> <span class="text-success fw-bold">(<?php echo $_SESSION["cart"][$product["id"]]?>)</span></h6>
                                    <small class="text-body-secondary"><?php echo nl2br($product["detail"]); ?></small>
                                    <input type="hidden" name="product[<?php echo $prodcut["id"]; ?>][price]" value="<?php echo $product["price"] ?>">
                                    <input type="hidden" name="product[<?php echo $product["id"]; ?>[name]" value="<?php echo $product["product_name"] ?>">
                                </div>
                                <span class="text-body-secondary">$<?php echo number_format($subtotal, 2) ?></span>
                            </li>
                            <?php $grand_total += $_SESSION["cart"][$product["id"]] * $product["price"]; ?>
                            <?php endwhile; ?>
                            <li class="list-group-item d-flex justify-content-between bg-body-teritary">
                                <div class="text-success">
                                    <h6 class="my-0">Grand Total</h6>
                                    <small>amount</small>
                                </div>
                                <span class="text-success"><strong>$<?php echo number_format($grand_total, 2) ?></strong></span>
                            </li>
                        </ul>
                        <input type="hidden" name="grand_total" value="<?php echo $grand_total ?>">
                     <?php endif;?>
                </div>
            </div>
        </form>
    </div>
    <script src="<?php echo $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>