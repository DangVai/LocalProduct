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
                                                src="<?php echo htmlspecialchars($product['images'][0]); ?>" alt="Product Image"
                                                id="mainImage" width="150">
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
                                                        <img src="<?php echo $image; ?>" alt="Thumbnail
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
                            <button class="add-to-cart btn btn-default" id="add-to-cart-btn" type="button" onclick="addToCart()">Add to Cart</button>
                            <button class="like btn btn-default" type="button"><span class="fa fa-heart">
                                </span>&#9829;</button>
                        </div>
                        <h3>Details</h3>
                        <p class="product-description"><?php echo $product['description']; ?></p>
                    </div>

                </div>
                <!-- Phần Địa chỉ -->
                <div class="address-section">
                    <form method="POST" action="index.php?controller=product&action=storeOrder">
                        <div class="detail-product">
                            <div class="product">
                                <img class="product-image" src="<?php echo htmlspecialchars($product['images'][0]); ?>" alt="Product Image">

                                <div class="product-details">
                                    <div>
                                        <h3 class="product-description"><?php echo $product['name']; ?></h3>
                                        <p> Price: <span id="product-price"
                                                class="product-price"><?php echo number_format($product['price'], 2, ',', '.'); ?>$
                                            </span></p>
                                    </div>
                                    <select name="size" id="size-selector" class="size-selector"
                                        style="display: inline-block;">
                                        <option value="" disabled selected>Choose Size</option>
                                        <?php if (empty($product['sizes'])): ?>
                                            <option value="" disabled>No sizes available</option>
                                        <?php else: ?>
                                            <?php foreach ($product['sizes'] as $size): ?>
                                                <option value="<?= htmlspecialchars($size) ?>"><?= htmlspecialchars($size) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                                <div class="quantity-selector">
                                    <button type="button" id="decrease">-</button>
                                    <input type="number" name="quantity" class="quantity" value="1" min="1">
                                    <button type="button" id="increase">+</button>
                                </div>
                            </div>
                        </div>

                        <!-- Các trường ẩn để gửi thông tin sản phẩm -->
                        <input type="hidden" name="product_name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                        <p>To place an order, please add your delivery address</p>

                        <label>Full Name</label>
                        <input type="text" name="full_name"
                            value="<?php echo isset($_SESSION['user_name']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>"
                            placeholder="Enter your full name" required>

                        <label>Phone Number</label>
                        <input type="text" name="phone"
                            value="<?php echo isset($_SESSION['user_phone']) ? htmlspecialchars($_SESSION['user_name']) : ''; ?>"
                            placeholder="" required>

                        <label>Province/City, District/County, Ward/Commune</label>
                        <input type="text" name="location" placeholder="Province/City, District/County, Ward/Commune"
                            required>

                        <label>Specific Address</label>
                        <input type="text" name="specific_address" placeholder="" required>

                        <div class="payment-options" style="display: none;">
                            <label>
                                <input type="radio" name="payment_method" class="cod" value="cod" checked> Cash on delivery
                            </label>
                            <label>
                                <input type="radio" name="payment_method" class="momo" value="momo"> Payment via Momo
                            </label>
                        </div>

                        <p>Select payment method</p>
                        <div class="payment-options">
                            <button type="button" class="cod-btn">Cash on Delivery</button>
                            <button type="button" name="payUrl" class="momo-btn">Pay via Momo</button>
                        </div>
                        <input type="hidden" name="user_id"
                            value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">

                        <div class="footer">
                            <p><span id="shipping-price"></span></p>
                            <p>Total Price: <span id="total-price"></span>$</p>
                            <input type="hidden" id="hidden-total-price" name="total_price" value="">
                            <button type="submit" class="buy-now">Buy Now</button>
                        </div>
                    </form>
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
<script src="/LocalProduct/public/js/detail.js"></script>
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


function addToCart() 
{
    const productId = <?php echo json_encode($product['product_id']); ?>;
    const userId = <?php echo json_encode($_SESSION['user_id']); ?>;

    if (!userId) {
        alert('You need to log in to add products to the cart.');
        window.location.href = 'index.php?controller=user&action=login';
        return; // Dừng hàm nếu chưa đăng nhập
    }

    const size = document.getElementById('size-selector')?.value || null;
    const quantity = parseInt(document.querySelector('.quantity')?.value) || null;

    fetch('index.php?controller=product&action=addtocart', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ user_id: userId, product_id: productId, size, quantity }),
    })
        .then(res => res.json())
        .then(({ success, message }) => alert(message))
        .catch(err => console.error('Error:', err));
}

</script>