<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
/* Tổng thể */

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

.product-details {
    flex-grow: 1;
    text-align: center;
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
    margin-top: 12px;
    padding: 8px 16px;
    font-size: 14px;
    color: #fff;
    border-radius: 4px;
    text-decoration: none;
    transition: background-color 0.2s ease;
}

.view-details-link:hover {
    text-decoration: none;
}

.no-products-message {
    font-size: 18px;
    color: #666;
    text-align: center;
    margin-top: 50px;
}

.related-product-item {
    background-color: #fff;
    border: 1px solid #ddd;
    border-radius: 8px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    width: 250px;
    text-align: center;
    padding: 16px;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.related-product-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

.product-images {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 4px;
    margin-bottom: 12px;
}

.product-details {
    text-align: left;
}

.product-name {
    font-size: 16px;
    font-weight: bold;
    color: #333;
    margin: 0 0 8px;
}


.product-type, .product-description {
    font-size: 12px;
    color: #666;
    margin: 2px 0;
}

.no-products-message {
    text-align: center;
    font-size: 16px;
    color: #888;
    margin-top: 24px;
}


    </style>
</head>
<body>
<?php if (!empty($relatedProducts)): ?>
    <ul class="related-products-list">
        <?php foreach ($relatedProducts as $relatedProduct): ?>
            <li class="related-product-item">
                <a href="index.php?controller=product&action=detail&id=<?php echo $relatedProduct['product_id']; ?>"
                    class="view-details-link">
                <img src="/LocalProduct/<?php echo htmlspecialchars($relatedProduct['product_image'] ?? '#'); ?>" alt="Hình sản phẩm"
                    class="product-images">
                <div class="product-details">
                    <h4 class="product-name">
                        <?php echo htmlspecialchars($relatedProduct['product_name'] ?? 'Tên sản phẩm không có'); ?></h4>
                    <p class="product-price">Price: <?php echo number_format($relatedProduct['price'] ?? 0, 0, ',', '.'); ?>$
                    </p>
                    <p class="product-type">Type: <?php echo htmlspecialchars($relatedProduct['type'] ?? 'Không có loại'); ?>
                    </p>
                    <p class="product-description">Mô tả:
                        <?php echo htmlspecialchars($relatedProduct['description'] ?? 'Không có mô tả'); ?></p>
                </div>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="no-products-message">Không có sản phẩm nào cùng loại.</p>
<?php endif; ?>

</body>
</html>