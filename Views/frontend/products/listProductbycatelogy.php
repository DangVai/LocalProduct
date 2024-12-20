<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
/* Tổng thể */
body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    padding: 20px;
}

/* Danh sách sản phẩm liên quan */
.related-products-list {
    display: flex;
    flex-wrap: nowrap; /* Không xuống dòng */
    list-style-type: none;
    padding: 0;
    margin: 0;
    overflow-x: auto; /* Cho phép cuộn ngang */
}

.related-product-item {
    flex: 0 0 auto; /* Không co giãn và không xuống dòng */
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    margin-right: 20px; /* Khoảng cách giữa các mục */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.related-product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
}

.product-image {
    width: 120px;
    height: auto;
    border-radius: 8px;
    margin-bottom: 15px;
}

.product-details {
    flex-grow: 1;
    text-align: center;
}

.product-name {
    font-size: 20px;
    font-weight: bold;
    margin: 0 0 10px;
}

.product-price {
    font-size: 18px;
    color: #e63946;
    margin: 5px 0;
}

.product-type, .product-description {
    font-size: 16px;
    color: #555;
    margin: 5px 0;
}

.view-details-link {
    display: inline-block;
    margin-top: 10px;
    padding: 10px 15px;
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.view-details-link:hover {
    background-color: #0056b3;
}

.no-products-message {
    font-size: 18px;
    color: #666;
    text-align: center;
    margin-top: 50px;
}

    </style>
</head>
<body>
<?php if (!empty($relatedProducts)): ?>
    <ul class="related-products-list">
        <?php foreach ($relatedProducts as $relatedProduct): ?>
            <li class="related-product-item">
                <img src="<?php echo htmlspecialchars($relatedProduct['product_image'] ?? '#'); ?>" alt="Hình sản phẩm"
                    class="product-image">
                <div class="product-details">
                    <h4 class="product-name">
                        <?php echo htmlspecialchars($relatedProduct['product_name'] ?? 'Tên sản phẩm không có'); ?></h4>
                    <p class="product-price">Giá: <?php echo number_format($relatedProduct['price'] ?? 0, 0, ',', '.'); ?> VNĐ
                    </p>
                    <p class="product-type">Loại: <?php echo htmlspecialchars($relatedProduct['type'] ?? 'Không có loại'); ?>
                    </p>
                    <p class="product-description">Mô tả:
                        <?php echo htmlspecialchars($relatedProduct['description'] ?? 'Không có mô tả'); ?></p>
                </div>
                <a href="index.php?controller=product&action=detail&id=<?php echo $relatedProduct['product_id']; ?>"
                    class="view-details-link">Xem chi tiết</a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="no-products-message">Không có sản phẩm nào cùng loại.</p>
<?php endif; ?>

</body>
</html>