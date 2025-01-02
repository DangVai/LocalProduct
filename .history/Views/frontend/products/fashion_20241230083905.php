<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="/LocalProduct/public/css/fashion.css"> <!-- Liên kết với file CSS -->

</head>


<body>
    <div class="container">
        <div class="filter-container">
            <h3>Filer sản phẩm</h3>
            <form id="filter-form">
                <label for="price">Lọc theo giá:</label>
                <select name="price" id="price">
                    <option value="">Chọn khoảng giá</option>
                    <option value="0-500000">Dưới 500.000 VNĐ</option>
                    <option value="500000-1000000">500.000 - 1.000.000 VNĐ</option>
                    <option value="1000000-1500000">1.000.000 - 1.500.000 VNĐ</option>
                </select>

                <label for="type">Lọc theo loại:</label>
                <select name="type" id="type">
                    <option value="">Chọn loại</option>
                    <option value="Vân Kiều">Vân Kiều</option>
                    <option value="Pa Cô">Pa Cô</option>
                </select>

                <label for="keyword">Tìm theo tên:</label>
                <input type="text" name="keyword" id="keyword" placeholder="Nhập từ khóa (áo, xấn)" />

                <button type="button" id="apply-filter">Lọc</button>
            </form>

        </div>

        <!-- Phần danh sách sản phẩm -->
        <div class="product-list">
            <?php if (!empty($products)): ?>
                <h1>THỜI TRANG</h1>
                <?php foreach ($products as $product): ?>
                    <div class="product-item" data-price="<?= $product['price'] ?>" data-type="<?= htmlspecialchars($product['type']) ?>" data-name="<?= htmlspecialchars($product['product_name']) ?>">
                        <button class="favourite-btn" id="add-to-favorite-btn" type="button" onclick="addToFavorite('add')">
                            <i class="fas fa-heart"></i>
                        </button>
                        <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                            <img src="/LocalProduct/<?php echo htmlspecialchars($product['product_image']); ?>" alt="Hình sản phẩm" class="product-image" width="150">
                        </a>
                        <div class="detail">
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <h3 class="product-name"><?php echo htmlspecialchars($product['product_name']); ?></h3>
                            </a>
                            <a href="index.php?controller=product&action=detail&id=<?php echo $product['product_id']; ?>" class="product-link">
                                <p class="product-price">Giá: <?php echo number_format($product['price'], 0, ',', '.'); ?> VNĐ</p>
                            </a>
                            <button class="add-to-cart btn btn-default" id="add-to-cart-btn" type="button"
                                onclick="addToCart('add')">Add to Cart</button>
                            <a href="index.php?controller=cart&action=addToCart" class="cart-home">
                                <i class="bi bi-cart-plus"></i>
                            </a>
                        </div>
                    </div>

                <?php endforeach; ?>
            <?php else : ?>
                <p>Không có sản phẩm nào để hiển thị.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="/LocalProduct/public/js/fashion.js"></script>


</body>

</html>