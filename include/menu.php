<?php ?>

<header class="d-flex justify-content-center align-items-center py-3 sticky-top bg-light border-bottom shadow-md">
    <ul class="nav nav-pills">
        <li class="nav-item mx-3"><a class="text-dark" style="text-decoration: none" href="<?php echo $BASE_URL?>/index.php">Home</a></li>
        <li class="nav-item mx-3"><a class="text-dark" style="text-decoration: none" href="<?php echo $BASE_URL?>/product-list.php">Product List</a></li>
        <li class="nav-item mx-3"><a class="text-dark" style="text-decoration: none" href="<?php echo $BASE_URL?>/cart.php">Cart
            <span class="text-success fw-semibold">
                (<?php echo count($_SESSION["cart"] ?? []); ?>)  
                <!-- count จำนวน item ทั้งหมดของ array ที่อยู่ใน cart -->
            </span>
        </a></li>
    </ul>
</header>   