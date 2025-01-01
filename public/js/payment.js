
document.querySelector(".cod-btn").addEventListener("click", function () {
    var codRadio = document.querySelector('input[name="payment_method"][value="cod"]');

    // Kiểm tra nếu radio button 'COD' chưa được chọn
    if (!codRadio.checked) {
        // Đánh dấu radio button 'COD' là checked
        codRadio.checked = true;

        // Ẩn nút Momo
        document.querySelector(".momo-btn").style.display = "none";

        // Thay đổi màu sắc của nút COD
        document.querySelector(".cod-btn").style.backgroundColor = "#4CAF50"; // Màu xanh ví dụ
        document.querySelector(".cod-btn").style.color = "white";
    }
    else {
        // Bỏ chọn radio button 'COD'
        codRadio.checked = false;

        // Hiển thị lại nút Momo
        document.querySelector(".momo-btn").style.display = "inline-block"; // Hoặc "block" tùy vào bố cục

        // Đổi lại màu của nút COD về mặc định
        document.querySelector(".cod-btn").style.backgroundColor = ""; // Màu mặc định
        document.querySelector(".cod-btn").style.color = ""; // Màu chữ mặc định
    }
});

// Xử lý nút "Thanh toán qua Momo"
document.querySelector(".momo-btn").addEventListener("click", function () {
    // Kiểm tra nếu radio button 'Momo' chưa được chọn, chọn nó và chuyển hướng
    var momoRadio = document.querySelector('input[name="payment_method"][value="momo"]');
    if (!momoRadio.checked) {
        momoRadio.checked = true;
    }

    // Chuyển hướng đến trang khác (ví dụ: trang Momo)
    window.location.href = "index.php?controller=checkout&action=onlinePayment"; // Thay đổi URL theo nhu cầu
});


document.querySelector('.buy-now').addEventListener('click', function (event) {
    event.preventDefault(); // Ngăn chặn hành vi submit mặc định

    // Lấy danh sách các sản phẩm được chọn
    const selectedItems = document.querySelectorAll('.select-item:checked');
    if (selectedItems.length === 0) {
        alert('Please select at least one product!');
        return;
    }

    // Kiểm tra phương thức thanh toán đã được chọn
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked');
    if (!paymentMethod) {
        alert('Please select a payment method!');
        return;
    }

    // Thu thập thông tin người dùng
    const userInfo = {
        full_name: document.querySelector('[name="full_name"]').value.trim(),
        phone: document.querySelector('[name="phone"]').value.trim(),
        location: document.querySelector('[name="location"]').value.trim(),
        specific_address: document.querySelector('[name="specific_address"]').value.trim(),
        user_id: document.querySelector('[name="user_id"]').value.trim(),
        payment_method: paymentMethod.value // Ghi nhận phương thức thanh toán
    };

    // Kiểm tra thông tin người dùng đã nhập đủ chưa
    if (!userInfo.full_name) {
        alert('Please enter your full name!');
        return;
    }

    if (!userInfo.phone) {
        alert('Please enter your phone number!');
        return;
    }

    if (!userInfo.location) {
        alert('Please select your location!');
        return;
    }

    // Thu thập thông tin các sản phẩm được chọn
    const products = [];
    selectedItems.forEach((item) => {
        const cartItem = item.closest('.cart-item');
        const quantityInput = cartItem.querySelector('.quantity');

        const product = {
            product_id: item.value,
            product_name: cartItem.dataset.name,
            size: cartItem.dataset.size,
            price: parseFloat(cartItem.dataset.price), // Giá đơn vị
            quantity: parseInt(quantityInput.value), // Lấy số lượng người dùng đã thay đổi
            total_price: parseFloat(cartItem.dataset.price) * parseInt(quantityInput.value) // Tính tổng giá
        };
        products.push(product);
    });

    // Gửi dữ liệu qua AJAX (fetch)
    fetch('index.php?controller=checkout&action=storeOrders', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ userInfo, products })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Order placed successfully!');
                // Bạn có thể thêm hành động như chuyển hướng trang hoặc xóa giỏ hàng sau khi đặt hàng thành công
            } else {
                alert('Error placing the order.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('There was an error processing your request.');
        });
});