<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/detail.css">
    <link rel="stylesheet" href="/LocalProduct/public/css/load.css">
    <script src="/LocalProduct/public/js/load.js"></script>
</head>
<style>
</style>

<body>
    <div id="loading" class="loading-overlay">
        <div class="spinner"></div>
        <p>Loading...</p>
    </div>
    <?php
    // Kiểm tra xem có thông báo thành công không
    if (isset($_SESSION['order_success'])) {
        echo '<div class="success-message">' . $_SESSION['order_success'] . '</div>';
        unset($_SESSION['order_success']);
    }

    // Kiểm tra xem có thông báo lỗi không
    if (isset($_SESSION['order_error'])) {
        echo '<div class="error-message">' . $_SESSION['order_error'] . '</div>';
        unset($_SESSION['order_error']);
    }
    ?>
    <?php if (isset($product)): ?>

        <body>
            <div class="container">
                <div class="card">
                    <div class="wrapper">
                        <!-- Hình ảnh sản phẩm và hình thu nhỏ -->
                        <div class="preview col-md-6">
                            <div class="image-gallery">
                                <div class="preview-pic tab-content">
                                    <?php if (!empty($product['images'])): ?>
                                        <!-- Hiển thị hình ảnh đầu tiên từ mảng $product['images'] -->
                                        <div class="tab-pane active" id="pic-1">
                                            <img class="img-responsive"
                                                src="/LocalProduct/<?php echo htmlspecialchars($product['images'][0]); ?>"
                                                alt="Product Image" id="mainImage" width="150">
                                        </div>
                                    <?php else: ?>
                                        <p>No images available for this product.</p>
                                    <?php endif; ?>
                                </div>

                                <div class="preview-thumbnail">
                                    <ul>
                                        <?php if (!empty($product['images'])): ?>
                                            <?php foreach ($product['images'] as $index => $image): ?>
                                                <li class="<?php echo $index === 0 ? 'active' : ''; ?>">
                                                    <a href="#" data-target="#pic-
                                        <?php echo $index + 1; ?>" data-toggle="tab">
                                                        <img src="/LocalProduct/<?php echo $image; ?>" alt="Thumbnail
                                        <?php echo $index + 1; ?>" onclick="changeImage('
                                        <?php echo $image; ?>')">
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <p>No thumbnails available for this product.</p>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="comment-section">

                                <div class="comment">
                                    <div class="comment-header">
                                        <strong>tranquoc204</strong>
                                        <span class="comment-date">2024-10-29 20:05</span>
                                        <span class="category"> Loại sản phẩm: BROWN SOC, TO, 39 nam/nữ</span>
                                    </div>
                                    <div class="rating">
                                        ★★★★★
                                    </div>
                                    <div class="comment-content">
                                        <p><strong>Màu sắc:</strong> Nhạt</p>
                                        <p><strong>Chất liệu:</strong> Mềm</p>
                                        <p><strong>Đúng với mô tả:</strong> Đẹp</p>
                                        <p>Tôi mang size 37, nhưng tôi đã chọn size 40</p>
                                    </div>
                                    <div class="comment-images">
                                        <img src="image1.jpg" alt="Review Image">
                                        <img src="image2.jpg" alt="Review Image">
                                    </div>
                                </div>

                                <div class="comment-input">
                                    <input type="text" placeholder="Write your review">
                                    <button type="button">Submit</button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="detail">
                        <h3 class="product-title"><?php echo $product['name']; ?></h3>
                        <div>
                            <h4 class="price">Current Price: <span
                                    id="price"><?php echo number_format($product['price'], 2, ',', '.'); ?>$</span></h4>
                            <div class="rating">
                                <h4>Rating: ★★★★★</h4>
                            </div>
                            <input type="hidden" id="max-quantity" value="<?= $product['quantity'] ?>">
                            <button class="add-to-cart btn btn-default" id="add-to-cart-btn" type="button"
                                onclick="addToCart('add')">Add to Cart</button>
                            <button class="like btn btn-default" type="button"><span class="fa fa-heart">
                                </span>&#9829;</button>
                        </div>
                        <h3>Details</h3>
                        <p class="product-descriptions"><?php echo $product['description']; ?></p>
                    </div>

                </div>
                <!-- Phần Địa chỉ -->
                <div class="address-section">
                    <?php
                    require 'Views/frontend/products/formPayment.php';
                    ?>
                </div>

                <!-- Chân trang -->
            </div>
        <?php else: ?>
            <p>Product not found!</p>
        <?php endif; ?>
        <div>
            <?php include_once 'listProductbycatelogy.php'; ?>
        </div>
    </body>

</html>
<script src="/LocalProduct/public/js/payment.js"></script>
<script src="/LocalProduct/public/js/detail.js"></script>
<script src="/LocalProduct/public/js/check.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const totalPriceElement = document.getElementById('total-price'); // Phần tử hiển thị tổng giá
        const hiddenTotalPrice = document.getElementById('hidden-total-price'); // Trường ẩn để gửi tổng giá
        const quantityInput = document.querySelector('.quantity'); // Trường nhập số lượng
        const form = document.querySelector('form'); // Biểu mẫu để xử lý

        // Cập nhật giá trị trong trường ẩn
        const updateHiddenTotalPrice = () => {
            hiddenTotalPrice.value = totalPriceElement.textContent.trim(); // Đồng bộ giá trị
        };

        // Khi số lượng thay đổi, cập nhật giá hiển thị và trường ẩn
        quantityInput.addEventListener('input', function () {
            updateHiddenTotalPrice();
        });
    });
    const userId = <?php echo isset($_SESSION['user_id']) ? json_encode($_SESSION['user_id']) : 'null'; ?>;
    const productId = <?php echo json_encode($product['product_id']); ?>;

</script>
