<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/LocalProduct/public/css/cart.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
</head>

<body>
    <div class="containers">
        <div class="list_products">
            <?php if (!empty($cartItems)): ?>
                <ul class="cart-list">
                    <?php foreach ($cartItems as $item): ?>
                        <li class="cart-item" id="cart-item-<?= $item['product_id'] ?>" data-id="<?= $item['product_id'] ?>"
                            data-name="<?= htmlspecialchars($item['product_name']) ?>"
                            data-size="<?= htmlspecialchars($item['size']) ?>" data-price="<?= $item['price'] ?>"
                            data-quantity="<?= $item['quantity'] ?>" data-image="<?= htmlspecialchars($item['image_path']) ?>"
                            data-total-price="<?= $item['price'] * $item['quantity'] ?>">

                            <input type="checkbox" name="selected_items[]" value="<?= $item['product_id'] ?>"
                                class="select-item">

                            <!-- Bọc ảnh sản phẩm trong thẻ <a> để chuyển hướng -->
                            <a href="index.php?controller=product&action=detail&id=<?= $item['product_id'] ?>">
                                <img class="cart-item-image" src="/LocalProduct/<?= htmlspecialchars($item['image_path']) ?>"
                                    alt="ProductImage">
                            </a>

                            <div>
                                <h3 class="cart-item-title"><?= htmlspecialchars($item['product_name']) ?></h3>
                                <p class="cart-item-size">Size: <?= htmlspecialchars($item['size']) ?></p>
                                <!-- Hiển thị size tại đây -->
                            </div>
                            <p class="cart-item-text cart-item-price" id="price-<?= $item['cart_id'] ?>">Price:
                                <?= number_format($item['price'], 2, ',', '.') ?>$
                            </p>
                            <div class="quantity-selector">
                                <button type="button" class="decrease" data-id="<?= $item['cart_id'] ?>">-</button>
                                <input type="number" type="hidden" name="quantity" class="quantity"
                                    value="<?= htmlspecialchars($item['quantity']) ?>" min="1"
                                    data-id="<?= $item['cart_id'] ?>">
                                <button type="button" class="increase" data-id="<?= $item['cart_id'] ?>">+</button>
                            </div>
                            <p class="cart-item-text" id="total-price-<?= $item['cart_id'] ?>">Total Price:
                                <?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?>$
                            </p>

                            <div class="cart-actions">
                                <button type="button" class="btn-delete-selected" data-id="<?= $item['cart_id'] ?>"><i
                                        class="fa-solid fa-trash"></i></button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

            <?php else: ?>
                <p>Your cart is empty!</p>
            <?php endif; ?>
        </div>


        <div class="address">
            <form class="address-form" method="POST" action="index.php?controller=checkout&action=storeOrder">
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
                    value="<?php echo isset($_SESSION['user_phone']) ? htmlspecialchars($_SESSION['user_phone']) : ''; ?>"
                    placeholder="" required>

                <label>Province/City, District/County, Ward/Commune</label>
                <input type="text" name="location"
                    value="<?php echo isset($_SESSION['user']['user_address']) ? htmlspecialchars($_SESSION['user']['user_address']) : ''; ?>"
                    placeholder="Enter your location" required>

                    <label>Note for Shop</label>
                    <textarea name="specific_address" placeholder="Enter your notes for the shop (e.g., delivery instructions, preferred time)" rows="2"></textarea>
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
                    <button type="button" class="cod-btn" onclick="selectPaymentMethod('cod')">Cash on Delivery</button>
                    <button type="button" class="momo-btn" onclick="selectPaymentMethod('momo')">Pay via Momo</button>
                </div>
                <input type="hidden" name="user_id"
                    value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">
                <div id="error-message" style="color: red;"></div>
                <div class="footers">
                    <!-- <p style="color: red;"><span id="shipping-price"></span></p> -->
                    <p style="color: red;">Total Price: <span id="total-price">0</span>$</p>
                    <input type="hidden" id="hidden-total-price" name="total_price" value="">
                    <button type="submit" class="buy-now">Buy Now</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="/LocalProduct/public/js/payment.js"></script>
<script src="/LocalProduct/public/js/check.js"></script>
<script src="/LocalProduct/public/js/checkcart.js"></script>
</html>