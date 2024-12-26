<form method="POST" action="index.php?controller=checkout&action=storeOrder">
    <div class="detail-product">
        <div class="product">
            <img class="product-image" src="/LocalProduct/<?php echo htmlspecialchars($product['images'][0]); ?>"
                alt="Product Image">

            <div class="product-details">
                <div>
                    <h3 class="product-descriptions"><?php echo $product['name']; ?></h3>
                    <p> Price: <span id="product-price"
                            class="product-price"><?php echo number_format($product['price'], 2, ',', '.'); ?>$
                        </span></p>
                </div>
                <select name="size" id="size-selector" class="size-selector" style="display: inline-block;">
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
        value="<?php echo isset($_SESSION['user_phone']) ? htmlspecialchars($_SESSION['user_phone']) : ''; ?>"
        placeholder="" required>

    <label>Province/City, District/County, Ward/Commune</label>
    <input type="text" name="location" placeholder="Province/City, District/County, Ward/Commune" required>

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
    <button type="button" class="cod-btn" onclick="selectPaymentMethod('cod')">Cash on Delivery</button>
    <button type="button" class="momo-btn" onclick="selectPaymentMethod('momo')">Pay via Momo</button>
</div>

    <input type="hidden" name="user_id"
        value="<?php echo isset($_SESSION['user_id']) ? htmlspecialchars($_SESSION['user_id']) : ''; ?>">
    <div id="error-message" style="color: red;"></div>
    <div class="footers">
        <p><span id="shipping-price"></span></p>
        <p>Total Price: <span id="total-price"></span></p>
        <input type="hidden" id="hidden-total-price" name="total_price" value="">
        <button type="submit" class="buy-now" onclick="return validateForm()">Buy Now</button>
        <div id="error-message" style="color: red;"></div>

    </div>
</form>