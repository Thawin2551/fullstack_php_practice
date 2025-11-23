<table class="table table-bordered border-success">
    <!-- Column name -->
    <thead>
        <tr>
        <tr style="width: 100px;" class="text-center">
            <th style="width: 200px;">Image</th>
            <th>Product Name</th>
            <th style="width: 200px;">Price</th>
            <th style="width: 100px;">Quantity</th>
            <th style="width: 120px;">Total</th>
            <th style="width: 120px;">Action</th>
        </tr>
        </tr>
    </thead>
    <!-- Table Data -->

    <tbody>
        <?php if ($num_rows > 0): ?>
            <!-- While loop query Prodcucts -->
            <?php while ($product = mysqli_fetch_assoc($query)):  ?>
                <tr>
                    <!-- Image -->
                    <td class="text-center">
                        <?php if (!empty($product["profile_image"])): ?>
                            <img
                                src="<?php echo $BASE_URL; ?>/upload_image/<?php echo $product["profile_image"]; ?>" width="100" alt="Product Image">
                        <?php else: ?>
                            <img
                                src="<?php echo $BASE_URL; ?>/assets/images/no-image.jpg" width="100" alt="Product Image">
                        <?php endif; ?>
                    </td>
                    <!-- Product  -->
                    <td>
                        <?php echo $product["product_name"]; ?>
                        <div>
                            <small class="text-muted"><?php echo nl2br($product["detail"]) ?></small> <!-- nl2br = newline to break -->
                        </div>
                    </td>

                    <!-- Price -->
                    <td>
                        <?php echo number_format($product["price"], 2) . " $" . "USD"; ?>
                    </td>

                    <!-- Quantity -->
                    <td>
                        <input type="number" name="product[<?php echo $product['id']; ?>][quantity]" value="<?php echo $_SESSION["cart"][$product["id"]] ?>" class="form-control">
                    </td>

                    <!-- Total -->
                    <td>
                        <?php echo number_format($product["price"] * $_SESSION["cart"][$product["id"]], 2) . " $" . "USD" ?>
                    </td>

                    <!-- Delete  -->
                    <td class="text-center">
                        <a role="button" class="btn btn-danger" onclick="return confirm('Are you sure you want to Delete')" href="<?php echo $BASE_URL; ?>/cart-delete.php?id=<?php echo $product["id"]; ?>">
                            Delete <i class="fa-solid fa-trash-can"></i>
                            </div>
                    </td>
                </tr>
            <?php endwhile; ?>
            <tr>    
                <td colspan="6" class="text-end">
                    <button class="btn btn-md btn-primary" type="submit"><i class="mx-2 fa-solid fa-pen-to-square"></i>Update Cart</button>
                    <a class="btn btn-md btn-success" href="<?php echo $BASE_URL; ?>/checkout.php">
                        <i class="mx-2 fa-regular fa-credit-card"></i>Check out
                    </a>
                </td>
            </tr>
        <?php else: ?>
            <tr>
                <td colspan="6" class="text-center text-danger">
                    <h4>ไม่มีรายการสินค้าในตะกร้า</h4>
                </td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>