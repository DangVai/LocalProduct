<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocalProduct/public/css/search_results.css"> <!-- Liên kết với file CSS -->
</head>

<body>

    <div class="product-container">
        <h1 class="product-title">
            Kết quả tìm kiếm</h1>
        </h1>

        <div class="product-list">
            <?php if (!empty($products)): ?>

                <?php foreach ($products as $product): ?>
                    <div class="product-item">
                        <button class="favourite-btn">
                            <i class="fas fa-heart"></i> <!-- Biểu tượng yêu thích -->
                        </button>
                        <!-- Ảnh sản phẩm -->
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>"
                                alt="Hình sản phẩm" class="product-image" width="150">
                        </a>

                        <!-- Thông tin chi tiết -->
                        <div class="detail">
                            <!-- Tên sản phẩm -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            </a>

                            <!-- Giá sản phẩm -->
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <p class="product-price">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            </a>

                            <!-- Giỏ hàng -->
                            <a href="#" class="cart-home">
                                <i class="bi bi-cart-plus"></i> <!-- Icon giỏ hàng Bootstrap -->
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>Không có sản phẩm nào để hiển thị.</p>
            <?php endif; ?>
        </div>

        <h2>Related Products</h2>
        <ul>
            <?php
            $relatedProducts = $this->productModel->getRelatedProducts(0); // Adjust logic as needed
            foreach ($relatedProducts as $related) { ?>
                <li class="product-item">
                    <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                    <p class="product-price">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                    <p class="product-type">Loại: <?php echo htmlspecialchars($product['category']); ?></p>
                    <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Hình sản phẩm"
                        class="product-image" width="150">
                    <br>
                    <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>"
                        class="product-detail-link">Xem chi tiết</a>
                </li>
            <?php } ?>
        </ul>
</body>

</html>