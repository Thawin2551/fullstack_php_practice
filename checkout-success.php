<?php 
     session_start();
    include("config.php");
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reulst order</title>

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
         <div class="d-flex align-items-center justify-content-center">
             <a type="button" class="btn btn-primary" href="<?php echo $BASE_URL ?>/index.php">Back to Home</a>
        </div>
    </div>
    <script src="<?php echo $BASE_URL ?>/assets/js/bootstrap.min.js"></script>
</body>
</html>