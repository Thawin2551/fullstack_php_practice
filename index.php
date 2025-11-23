<?php 
    session_start();
    include("config.php");

    // ดึงข้อมูลมาจากฐานข้อมูล
    $sql = "SELECT * FROM products";

    // query หา data
    $query = mysqli_query($connection, $sql);
    $num_rows = mysqli_num_rows($query);

    $result = [
        'id' => '',
        'product_name' => '',
        'price' => '',
        'detail' => '',
        'product_image' => ''
    ];

    if(!empty($_GET["id"])) {
        // query select id from table products (user_db)
        $sql_query_id = "SELECT * FROM products WHERE id ='{$_GET['id']}'";  
        $query_product = mysqli_query($connection, $sql_query_id);
        $num_rows_product_id = mysqli_num_rows($query_product);

        if($num_rows_product_id == 0) {
            header("location: ". $BASE_URL . "/index.php");
        }    

        $result = mysqli_fetch_assoc($query_product); 
    }

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
    <title>Thawin's Shop</title>
    <link href="<?php echo $BASE_URL ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- font and icon -->
    <link href="<?php echo $BASE_URL?>/fontawesome/css/fontawesome.min.css" rel="stylesheet">
    <link href="<?php echo $BASE_URL?>/fontawesome/css/brands.min.css" rel="stylesheet">
    <link href="<?php echo $BASE_URL?>/fontawesome/css/solid.min.css" rel="stylesheet">
</head>
<body class="bg-body-teritary">
    <?php include("include/menu.php") ?>
    
    <div class="container" style="margin-top: 30px;">

    <!-- Product Saved Message Alert -->
        <?php if (!empty($_SESSION["message"])) :?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $_SESSION["message"]; ?>
                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="close"></button>
            </div>
            <?php unset($_SESSION["message"])?>
        <?php endif ?>
        
        <!-- Home Describe -->
        <h4>Home - Management Product</h4>
        <h3>Welcome <?= $_SESSION["name"];  ?></h3>
        <button onclick="window.location.href='logout.php'" class="btn btn-primary my-3">Logout</button>
        
        <!-- Form -->
        <div class="row g-5">
            <div class="col-md-8 col-sm-12">
                <!-- accpet ที่ฟอร์มแล้วจะเด้งไปไฟล์ product-form.php -->
                <form enctype="multipart/form-data" action="<?php echo $BASE_URL; ?>/product-form.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $result["id"] ?>">
                    <div class="row g-3 mb-3">
                        <!-- Product Name -->
                        <div class="col-sm-6">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo $result["product_name"] ?>" required>
                        </div>

                        <!-- Price -->
                        <div class="col-sm-6">
                            <label class="form-label">Price</label>
                            <input type="text" name="price" class="form-control" value="<?php echo $result["price"] ?>" required>
                        </div>  
                        <!-- Image -->
                        <div class="col-sm-6">
                            <?php if(!empty($result["profile_image"])): ?>
                                <img src="<?php echo $BASE_URL; ?>/upload_image/<?php echo $result["profile_image"] ?>" width="100" alt="Product Image">
                            <?php endif; ?>
                            <div class="">
                                <label for="formFile" class="form-label" >Image</label>
                            </div>
                            <input type="file" name="profile_image" class="form-control" accept="image/png, image/jpeg, image/jpg">
                        </div>
                        <!-- Detail -->
                        <div class="col-sm-6">
                            <label class="form-label">Detail</label>
                            <textarea name="detail" class="form-control" rows="3" value="<?php echo $result["detail"] ?>"></textarea>
                        </div>
                        <?php if(empty($result["id"])): ?>
                                <button class="btn btn-success" type="submit"><i class="fa-solid fa-pen-to-square"></i>Create</button>
                        <?php else: ?>
                                <button class="btn btn-primary" type="submit"><i class="mx-1 fa-regular fa-floppy-disk"></i>Update</button>
                        <?php endif ?>

                            <a class="btn btn-secondary" href="<?php echo $BASE_URL ?>/index.php" type="submit"><i class="mx-1 fa-solid fa-rotate-right me-1"></i>Cancel</a>
                            <hr class="my-4">
                    </div>

                </form>
            </div>
            <div class="row">
            <div class="col-12">
                <table class="table table-bordered border-success">
                    <!-- Column name -->
                    <thead>
                        <tr>
                            <tr style="width: 100px;" class="text-center">
                                <th style="width: 200px;">Image</th>
                                <th>Product Name</th>
                                <th style="width: 200px;">Price</th>
                                <th style="width: 200px;">Action</th>
                            </tr>
                        </tr>
                    </thead>
                    <!-- Table Data -->
                     
                    <tbody>
                        <?php if ($num_rows > 0): ?>
                            <!-- While loop query Prodcucts -->
                            <?php while($product = mysqli_fetch_assoc($query)):  ?>
                            <tr>
                                <!-- Image -->
                                <td class="text-center">
                                    <?php if(!empty($product["profile_image"])): ?>
                                        <img 
                                            src="<?php echo $BASE_URL; ?>/upload_image/<?php echo $product["profile_image"]; ?>" width="100" alt="Product Image"
                                        >
                                    <?php else: ?>
                                        <img 
                                            src="<?php echo $BASE_URL; ?>/assets/images/no-image.jpg" width="100" alt="Product Image"
                                        >
                                    <?php endif; ?>
                                </td>
                                <!-- Product  -->
                                <td>
                                    <?php echo $product["product_name"];?>
                                    <div>
                                        <small class="text-muted"><?php echo nl2br($product["detail"]) ?></small> <!-- nl2br = newline to break -->
                                    </div>
                                </td>
                                <!-- Price -->
                                <td>
                                    <?php echo number_format($product["price"] ,2); ?>
                                </td>
                                <!-- Edit & Delete  -->
                                <td class="text-center">
                                        <a role="button" href="<?php echo $BASE_URL ?>/index.php?id=<?php echo $product["id"]; ?>" class="btn btn-outline-success">
                                            Edit <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a  role="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete')" href="<?php echo $BASE_URL; ?>/product-delete.php?id=<?php echo $product["id"]; ?>">
                                            Delete <i class="fa-solid fa-pen-to-square"></i>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                        <tr> 
                            <td colspan="4" class="text-center text-danger">
                                <h4>ไม่มีรายการสินค้า</h4>
                            </td>
                        </tr>
                        <?php endif; ?>
                        
                    </tbody>
                </table>
            </div>
        </div>
        </div>    

        
    </div>
    <script src="<?php echo $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>