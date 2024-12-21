<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="styles.css"> <!-- Liên kết với file CSS -->
</head>
<style>
    /* Toàn bộ trang */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin-top: 80px;
        padding: 0;
    }

    /* Container chính của danh sách sản phẩm */
    .product-container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Tiêu đề trang */
    .product-title {
        font-size: 2rem;
        color: #333;
        text-align: center;
        margin-bottom: 20px;
    }

    /* Danh sách sản phẩm */
    .product-list {
        display: flex;
        flex-wrap: wrap;
        /* Cho phép cuộn xuống dòng nếu không đủ chỗ */
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    /* Mỗi sản phẩm */
    .product-item {
        display: flex;
        flex-direction: column;
        width: 240px;
        /* Đặt chiều rộng cho mỗi sản phẩm */
        margin: 10px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        text-align: center;
        /* Căn giữa các nội dung trong mỗi sản phẩm */
    }

    /* Tên sản phẩm */
    .product-name {
        font-size: 1.5rem;
        color: #333;
        margin: 0;
    }

    /* Giá sản phẩm */
    .product-price {
        color: #e74c3c;
        font-size: 1.2rem;
        margin: 5px 0;
    }

    /* Loại sản phẩm */
    .product-type {
        color: #7f8c8d;
        margin: 5px 0;
    }

    /* Mô tả sản phẩm */
    .product-description {
        font-size: 1rem;
        color: #7f8c8d;
        margin: 5px 0;
    }

    /* Hình ảnh sản phẩm */
    .product-image {
        margin-top: 10px;
        width: 100%;
        height: 200px;
        /* Đảm bảo hình ảnh không bị vượt quá giới hạn của sản phẩm */
    }

    /* Link "Xem chi tiết" */
    .product-detail-link {
        text-decoration: none;
        font-weight: bold;
        color: #3498db;
        margin-top: 10px;
        display: inline-block;
    }

    /* Hover cho link "Xem chi tiết" */
    .product-detail-link:hover {
        color: #2980b9;
    }

    /* Nếu không có sản phẩm */
    .no-products {
        text-align: center;
        font-size: 1.2rem;
        color: #e74c3c;
    }
</style>

<body>
    <div class="product-container">
        <h1 class="product-title">Danh sách sản phẩm</h1>

        <?php if (!empty($productData)): ?>
            <ul class="product-list">
                <?php foreach ($productData as $product): ?>
                    <li class="product-item">
                        <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                        <p class="product-price">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                        <p class="product-type">Loại: <?php echo htmlspecialchars($product['type']); ?></p>
                        <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Hình sản phẩm"
                            class="product-image" width="150">
                        <br>
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>"
                            class="product-detail-link">Xem chi tiết</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-products">Không có sản phẩm nào để hiển thị.</p>
        <?php endif; ?>
    </div>
</body>

</html>