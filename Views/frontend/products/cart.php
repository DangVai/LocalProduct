<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        margin: 0;
        /* Xóa margin mặc định */
        height: 100vh;
        /* Chiều cao toàn màn hình */
        background-color: #f8f8f8;
        position: relative;
        top: -55px;
        overflow: hidden;
        /* Đảm bảo không có thanh cuộn ngoài ý muốn */
    }

    .containers {
        display: flex;
        /* Kích hoạt Flexbox */
        max-width: 1300px;
        margin: 20px auto;
        padding: 20px;
        height: 100%;
        /* Đặt chiều cao tổng của container */
        overflow-y: scroll;
        /* Cho phép cuộn chỉ nội dung của containers */
    }

    .list_products {
        position: relative;
        top: 130px;
        width: 67%;
        padding: 10px;
        background-color: rgb(232, 233, 233);
        overflow-y: auto;
        /* Chỉ phần list_products được cuộn */
        height: 100%;
    }

    .address {
        width: 30%;
        background-color: green;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        position: sticky;
        /* Giữ địa chỉ cố định */
        top: 140px;
        /* Cố định tại đầu container */
        height: fit-content;
        /* Đặt chiều cao vừa đủ nội dung */
        margin-left: 20px;
    }

    form {
        display: flex;
        flex-direction: column;
        /* Sắp xếp các phần tử theo cột */
        padding: 20px;
        background-color: #fff;
        /* Màu nền trắng */
        border-radius: 8px;
        /* Bo góc */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        /* Tạo hiệu ứng đổ bóng */
        gap: 5px;
    }

    form label {
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }

    form input[type="text"],
    form input[type="hidden"] {
        width: 90%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ddd;
        border-radius: 4px;
        outline: none;
        transition: border-color 0.3s;
    }

    form input[type="text"]:focus {
        border-color: #007bff;
        /* Màu viền khi focus */
    }

    .payment-options {
        display: flex;
        gap: 10px;
        /* Khoảng cách giữa các nút */
    }

    .payment-options button {
        flex: 1;
        /* Chia đều kích thước các nút */
        padding: 10px 15px;
        font-size: 14px;
        background-color: #007bff;
        /* Màu xanh cho nút */
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .payment-options button:hover {
        background-color: #0056b3;
        /* Màu tối hơn khi hover */
    }

    form .footers {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    form .footers p {
        font-size: 14px;
        color: #333;
    }

    form .footers .buy-now {
        padding: 12px;
        background-color: #28a745;
        /* Màu xanh lá */
        color: white;
        font-size: 16px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    form .footers .buy-now:hover {
        background-color: #218838;
        /* Màu tối hơn khi hover */
    }

    #error-message {
        font-size: 12px;
        color: red;
    }


    /* Container for the list of cart items */
    .cart-list {
        list-style-type: none;
        padding: 0;
    }

    /* Individual cart item */
    .cart-item {
        display: flex;
        align-items: center;
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    /* Image of the product */
    .cart-item-image {
        width: 80px;
        height: 80px;
        object-fit: cover;
        margin-right: 20px;
    }

    /* Container for item details */
    .cart-item-details {
        flex: 1;
    }

    /* Name of the product */
    .cart-item-title {
        font-size: 1.2em;
        margin: 0;
    }

    /* General text for cart item details */
    .cart-item-text {
        margin: 5px 0;
        color: #555;
    }

    /* Specific styles for price text */
    .cart-item-price {
        display: none;
        /* Ẩn phần tử */
    }

    /* Trash bin icon for removing the item */
    .cart-item-remove {
        cursor: pointer;
        color: #999;
        font-size: 1.5em;
        margin-left: 20px;
    }

    .cart-item-remove:hover {
        color: #000;
    }
</style>

<body>
    <div class="containers">
        <div class="list_products">
            <?php if (!empty($cartItems)): ?>
                <ul class="cart-list">
                    <?php foreach ($cartItems as $item): ?>
                        <!-- <input type="hidden" id="max-quantity" value="<?= $product['quantity'] ?>"> -->
                        <li class="cart-item" id="cart-item-<?= $item['product_id'] ?>" data-id="<?= $item['product_id'] ?>"
                            data-name="<?= htmlspecialchars($item['product_name']) ?>"
                            data-size="<?= htmlspecialchars($item['size']) ?>" data-price="<?= $item['price'] ?>"
                            data-quantity="<?= $item['quantity'] ?>" data-image="<?= htmlspecialchars($item['image_path']) ?>"
                            data-total-price="<?= $item['price'] * $item['quantity'] ?>">

                            <input type="checkbox" name="selected_items[]" value="<?= $item['product_id'] ?>"
                                class="select-item">
                            <img class="cart-item-image" src="/LocalProduct/<?= htmlspecialchars($item['image_path']) ?>"
                                alt="Product Image">
                            <div>
                                <h3 class="cart-item-title"><?= htmlspecialchars($item['product_name']) ?></h3>
                                <p class="cart-item-text cart-item-size">Size: <?= htmlspecialchars($item['size']) ?></p>
                            </div>
                            <p class="cart-item-text cart-item-price" id="price-<?= $item['cart_id'] ?>">Price:
                                <?= number_format($item['price'], 2, ',', '.') ?>$
                            </p>
                            <div class="quantity-selector">
                                <button type="button" class="decrease" data-id="<?= $item['cart_id'] ?>">-</button>
                                <input type="number" name="quantity" class="quantity"
                                    value="<?= htmlspecialchars($item['quantity']) ?>" min="1"
                                    data-id="<?= $item['cart_id'] ?>">
                                <button type="button" class="increase" data-id="<?= $item['cart_id'] ?>">+</button>
                            </div>
                            <p class="cart-item-text" id="total-price-<?= $item['cart_id'] ?>">Total Price:
                                <?= number_format($item['price'] * $item['quantity'], 2, ',', '.') ?>$
                            </p>

                            <div class="cart-actions">
                                <button type="button" class="btn-delete-selected" data-id="<?= $item['cart_id'] ?>">Delete
                                    Selected</button>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else: ?>
                <p>Your cart is empty!</p>
            <?php endif; ?>
        </div>


        <div class="address">
            <form method="POST" action="index.php?controller=checkout&action=storeOrder">

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
                    <p style="color: red;"><span id="shipping-price"></span></p>
                    <p style="color: red;">Total Price: <span id="total-price">0</span>$</p>
                    <input type="hidden" id="hidden-total-price" name="total_price" value="">
                    <button type="submit" class="buy-now">Buy Now</button>
                </div>
            </form>
        </div>
    </div>
</body>
<script src="/LocalProduct/public/js/payment.js"></script>
<script src="/LocalProduct/public/js/check.js">

    // Lấy tất cả các sản phẩm trong giỏ hàng
let orderItems = [];
document.querySelectorAll('.cart-item').forEach(item => {
    const product = {
        product_id: item.dataset.id,
        product_name: item.dataset.name,
        size: item.dataset.size,
        quantity: parseInt(item.querySelector('.quantity').value),
        product_price: parseFloat(item.dataset.price),
        total_price: parseFloat(item.dataset.price) * parseInt(item.querySelector('.quantity').value)
    };
    orderItems.push(product);
});

// Lấy thông tin đơn hàng
const orderData = {
    items: orderItems,
    full_name: document.querySelector('[name="full_name"]').value,
    phone: document.querySelector('[name="phone"]').value,
    location: document.querySelector('[name="location"]').value,
    specific_address: document.querySelector('[name="specific_address"]').value,
    payment_method: document.querySelector('[name="payment_method"]:checked').value,
    user_id: document.querySelector('[name="user_id"]').value,
    name: document.querySelector('[name="name"]').value,
    total_price: document.getElementById('hidden-total-price').value
};

// Gửi yêu cầu tạo đơn hàng
fetch('index.php?controller=checkout&action=storeOrder', {
    method: 'POST',
    body: JSON.stringify(orderData),
    headers: {
        'Content-Type': 'application/json'
    }
})
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Order placed successfully!');
        } else {
            alert('Error placing order');
        }
    })
    .catch(error => console.error('Error:', error));

</script>

</html>