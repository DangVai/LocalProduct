<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
</head>

<body>
<h1>Danh sách sản phẩm</h1>
<?php if (!empty($productData)): ?>
    <ul>
        <?php foreach ($productData as $product): ?>
            <li>
                <h3><?php echo htmlspecialchars($product['product_name']); ?></h3>
                <p>Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                <p>Loại: <?php echo htmlspecialchars($product['type']); ?></p>
                <p>Mô tả: <?php echo htmlspecialchars($product['description']); ?></p>
                <img src="<?php echo htmlspecialchars($product['product_image']); ?>" alt="Hình sản phẩm" width="150">
                <br>
                <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>">Xem chi tiết</a> <!-- Link xem chi tiết -->
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Không có sản phẩm nào để hiển thị.</p>
<?php endif; ?>

</body>

</html>